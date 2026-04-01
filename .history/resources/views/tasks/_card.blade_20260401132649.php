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
        <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-slate-600">
            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            {{ $task->assignee->name }}
        </span>
        @endif

        @if($task->due_date)
        <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 {{ $task->isOverdue() ? 'bg-rose-100 text-rose-700' : 'bg-sky-100 text-sky-700' }}">
            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Due {{ $task->due_date->format('M d, Y') }}{{ $task->isOverdue() ? ' • Overdue' : '' }}
        </span>
        @endif
    </div>

    <div class="mt-4 flex flex-wrap gap-2">
        <a href="{{ route('tasks.show', $task) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-50">
            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            View
        </a>

        @can('update-task-status')
            @if($prevStatus)
            <form action="{{ route('tasks.status', $task) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="{{ $prevStatus }}">
                <button class="inline-flex items-center gap-1 rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back
                </button>
            </form>
            @endif

            @if($nextStatus)
            <form action="{{ route('tasks.status', $task) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="{{ $nextStatus }}">
                <button class="inline-flex items-center gap-1 rounded-lg bg-sky-100 px-3 py-1.5 text-xs font-semibold text-sky-700 transition hover:bg-sky-200">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    Move
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