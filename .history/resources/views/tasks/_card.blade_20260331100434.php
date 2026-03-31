@php
    $priorityColor = match($task->priority) {
        'high'   => 'bg-rose-100 text-rose-700',
        'medium' => 'bg-amber-100 text-amber-700',
        'low'    => 'bg-emerald-100 text-emerald-700',
        default  => 'bg-slate-100 text-slate-600',
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
    $statusLabel = match($task->status) {
        'todo' => 'To Do',
        'in_progress' => 'In Progress',
        'done' => 'Done',
        default => ucfirst(str_replace('_', ' ', $task->status)),
    };
@endphp

<div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm shadow-slate-900/5 transition hover:-translate-y-0.5 hover:shadow-md {{ $task->isOverdue() ? 'ring-1 ring-rose-200' : '' }}">
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">{{ $statusLabel }}</p>
            <a href="{{ route('tasks.show', $task) }}" class="mt-1 block text-sm font-semibold text-slate-900 transition hover:text-sky-600">
                {{ $task->title }}
            </a>
        </div>

        <span class="shrink-0 rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $priorityColor }}">
            {{ ucfirst($task->priority) }}
        </span>
    </div>

    <p class="mt-2 text-sm text-slate-600">
        {{ $task->description ? \Illuminate\Support\Str::limit($task->description, 88) : 'No details added yet.' }}
    </p>

    <div class="mt-3 flex flex-wrap gap-2 text-xs">
        @if($task->assignee)
        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-slate-600">Assigned to {{ $task->assignee->name }}</span>
        @endif

        @if($task->due_date)
        <span class="rounded-full px-2.5 py-1 {{ $task->isOverdue() ? 'bg-rose-100 text-rose-700' : 'bg-sky-100 text-sky-700' }}">
            Due {{ $task->due_date->format('M d, Y') }}{{ $task->isOverdue() ? ' • Overdue' : '' }}
        </span>
        @endif
    </div>

    <div class="mt-4 flex flex-wrap gap-2">
        <a href="{{ route('tasks.show', $task) }}" class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-50">View</a>

        @can('update-task-status')
            @if($prevStatus)
            <form action="{{ route('tasks.status', $task) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="{{ $prevStatus }}">
                <button class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                    ← Back
                </button>
            </form>
            @endif

            @if($nextStatus)
            <form action="{{ route('tasks.status', $task) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="{{ $nextStatus }}">
                <button class="rounded-lg bg-sky-100 px-3 py-1.5 text-xs font-semibold text-sky-700 transition hover:bg-sky-200">
                    Move →
                </button>
            </form>
            @endif
        @endcan
    </div>

    @can('manage-tasks')
    <div class="mt-3 flex gap-2 border-t border-slate-100 pt-3">
        <a href="{{ route('tasks.edit', $task) }}" class="rounded-lg bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 transition hover:bg-amber-200">
            Edit
        </a>
        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
            @csrf @method('DELETE')
            <button class="rounded-lg bg-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-200">
                Delete
            </button>
        </form>
    </div>
    @endcan
</div>