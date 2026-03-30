@php
    $priorityClass = match($task->priority) {
        'high'   => 'danger',
        'medium' => 'warning',
        'low'    => 'success',
        default  => 'secondary',
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

<div class="card border {{ $task->isOverdue() ? 'border-danger' : '' }}">
    <div class="card-body p-3">

        {{-- Title and priority --}}
        <div class="d-flex justify-content-between align-items-start mb-1">
            <a href="{{ route('tasks.show', $task) }}"
               class="fw-semibold text-decoration-none text-dark">
                {{ $task->title }}
            </a>
            <span class="badge bg-{{ $priorityClass }} ms-2">
                {{ ucfirst($task->priority) }}
            </span>
        </div>

        {{-- Assignee --}}
        @if($task->assignee)
        <div class="text-muted small mb-1">
            Assigned to: {{ $task->assignee->name }}
        </div>
        @endif

        {{-- Due date --}}
        @if($task->due_date)
        <div class="small mb-2 {{ $task->isOverdue() ? 'text-danger fw-bold' : 'text-muted' }}">
            Due: {{ $task->due_date->format('M d, Y') }}
            {{ $task->isOverdue() ? '— Overdue!' : '' }}
        </div>
        @endif

        {{-- Move buttons (staff and admin) --}}
        @can('update-task-status')
        <div class="d-flex gap-1 mt-2">
            @if($prevStatus)
            <form action="{{ route('tasks.status', $task) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="{{ $prevStatus }}">
                <button class="btn btn-sm btn-outline-secondary">← Back</button>
            </form>
            @endif
            @if($nextStatus)
            <form action="{{ route('tasks.status', $task) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="{{ $nextStatus }}">
                <button class="btn btn-sm btn-outline-primary">Move →</button>
            </form>
            @endif
        </div>
        @endcan

        {{-- Admin actions --}}
        @can('manage-tasks')
        <div class="d-flex gap-1 mt-2 border-top pt-2">
            <a href="{{ route('tasks.edit', $task) }}"
               class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                  onsubmit="return confirm('Delete this task?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
        </div>
        @endcan

    </div>
</div>