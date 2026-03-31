<x-app-layout>
    @php
        $priorityClass = match($task->priority) {
            'high' => 'bg-rose-100 text-rose-700',
            'medium' => 'bg-amber-100 text-amber-700',
            default => 'bg-emerald-100 text-emerald-700',
        };

        $statusClass = match($task->status) {
            'todo' => 'bg-slate-100 text-slate-700',
            'in_progress' => 'bg-sky-100 text-sky-700',
            'done' => 'bg-emerald-100 text-emerald-700',
            default => 'bg-slate-100 text-slate-700',
        };
    @endphp

    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Task details</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">{{ $task->title }}</h1>
                <p class="mt-2 text-sm text-slate-500">Review the task, update progress, and keep the conversation in one place.</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $priorityClass }}">{{ ucfirst($task->priority) }} priority</span>
                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
            </div>
        </div>
    </x-slot>

    <div class="page-shell grid gap-6 xl:grid-cols-[1.15fr_.85fr]">
        <div class="space-y-6">
            <section class="surface-card p-6">
                <h2 class="text-lg font-semibold text-slate-900">Task summary</h2>
                <p class="mt-3 text-sm leading-7 text-slate-600">{!! nl2br(e($task->description ?? 'No description has been added for this task yet.')) !!}</p>

                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    <div class="surface-muted p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Status</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</p>
                    </div>
                    <div class="surface-muted p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Assigned to</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">{{ $task->assignee?->name ?? 'Unassigned' }}</p>
                    </div>
                    <div class="surface-muted p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Due date</p>
                        <p class="mt-2 text-sm font-semibold {{ $task->isOverdue() ? 'text-rose-600' : 'text-slate-900' }}">
                            {{ $task->due_date?->format('M d, Y') ?? 'No due date' }}
                            @if($task->isOverdue())
                                <span class="block text-xs font-medium text-rose-500">Overdue</span>
                            @endif
                        </p>
                    </div>
                </div>
            </section>

            <section class="surface-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Comments</h2>
                        <p class="text-sm text-slate-500">{{ $task->comments->count() }} conversation item(s) on this task.</p>
                    </div>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse($task->comments as $comment)
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $comment->user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>

                            @if(auth()->id() === $comment->user_id || auth()->user()->can('manage-tasks'))
                            <form action="{{ route('tasks.comments.destroy', [$task, $comment]) }}" method="POST" onsubmit="return confirm('Delete comment?')">
                                @csrf @method('DELETE')
                                <button class="rounded-lg bg-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-200">Delete</button>
                            </form>
                            @endif
                        </div>

                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $comment->body }}</p>
                    </div>
                    @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-400">No comments yet. Start the conversation below.</div>
                    @endforelse
                </div>

                <form action="{{ route('tasks.comments.store', $task) }}" method="POST" class="mt-5 space-y-3">
                    @csrf
                    <div>
                        <label for="body" class="field-label">Add a comment</label>
                        <textarea id="body" name="body" rows="4" class="field-input" placeholder="Share an update, blocker, or note...">{{ old('body') }}</textarea>
                        @error('body')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <button class="btn-primary">Add Comment</button>
                </form>
            </section>
        </div>

        <aside class="space-y-6">
            <section class="surface-card p-6">
                <h2 class="text-lg font-semibold text-slate-900">Actions</h2>
                <p class="mt-1 text-sm text-slate-500">Keep the task updated and the board organized.</p>

                <div class="mt-4 flex flex-col gap-3">
                    <a href="{{ route('tasks.index') }}" class="btn-secondary">← Back to Board</a>

                    @can('manage-tasks')
                    <a href="{{ route('tasks.edit', $task) }}" class="btn-primary">Edit Task</a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                        @csrf @method('DELETE')
                        <button class="btn-danger w-full">Delete Task</button>
                    </form>
                    @endcan
                </div>
            </section>

            <section class="surface-card p-6">
                <h2 class="text-lg font-semibold text-slate-900">At a glance</h2>
                <div class="mt-4 space-y-3 text-sm text-slate-600">
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span>Priority</span>
                        <span class="font-semibold text-slate-900">{{ ucfirst($task->priority) }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span>Status</span>
                        <span class="font-semibold text-slate-900">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span>Assignee</span>
                        <span class="font-semibold text-slate-900">{{ $task->assignee?->name ?? 'Unassigned' }}</span>
                    </div>
                </div>
            </section>
        </aside>
    </div>
</x-app-layout>