@php
    $priorityColor = match($task->priority) {
        'high'   => 'bg-red-100 text-red-700',
        'medium' => 'bg-yellow-100 text-yellow-700',
        'low'    => 'bg-green-100 text-green-700',
        default  => 'bg-gray-100 text-gray-600',
    };
    $prevStatus = match($task->status) {
        'in_progress' => 'todo',
        'done'        => 'in_progress',
        default       => null,
    };
    $nextStatus = match($task->status) {
        'todo'        => 'in_progress',
        'in_progress' => 'done',
        default       => null,
    };
@endphp

<div class="border rounded-lg p-3 bg-gray-50 {{ $task->isOverdue() ? 'border-red-400' : 'border-gray-200' }}">

    {{-- Title and priority --}}
    <div class="flex justify-between items-start mb-1">
        <a href="{{ route('tasks.show', $task) }}"
           class="font-semibold text-gray-800 hover:text-blue-600 text-sm">
            {{ $task->title }}
        </a>
        <span class="text-xs px-2 py-1 rounded-full {{ $priorityColor }} ml-2 shrink-0">
            {{ ucfirst($task->priority) }}
        </span>
    </div>

    {{-- Assignee --}}
    @if($task->assignee)
    <div class="text-xs text-gray-500 mb-1">
        Assigned to: {{ $task->assignee->name }}
    </div>
    @endif

    {{-- Due date --}}
    @if($task->due_date)
    <div class="text-xs mb-2 {{ $task->isOverdue() ? 'text-red-600 font-bold' : 'text-gray-400' }}">
        Due: {{ $task->due_date->format('M d, Y') }}
        @if($task->isOverdue()) — Overdue! @endif
    </div>
    @endif

    {{-- Move buttons --}}
    @can('update-task-status')
    <div class="flex gap-1 mt-2">
        @if($prevStatus)
        <form action="{{ route('tasks.status', $task) }}" method="POST">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="{{ $prevStatus }}">
            <button class="text-xs bg-gray-200 hover:bg-gray-300 text-gray-700 px-2 py-1 rounded">
                &larr; Back
            </button>
        </form>
        @endif
        @if($nextStatus)
        <form action="{{ route('tasks.status', $task) }}" method="POST">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="{{ $nextStatus }}">
            <button class="text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 px-2 py-1 rounded">
                Move &rarr;
            </button>
        </form>
        @endif
    </div>
    @endcan

    {{-- Admin actions --}}
    @can('manage-tasks')
    <div class="flex gap-1 mt-2 pt-2 border-t border-gray-200">
        <a href="{{ route('tasks.edit', $task) }}"
           class="text-xs bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded">
            Edit
        </a>
        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
              onsubmit="return confirm('Delete this task?')">
            @csrf @method('DELETE')
            <button class="text-xs bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">
                Delete
            </button>
        </form>
    </div>
    @endcan

</div>