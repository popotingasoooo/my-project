<x-app-layout>
    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">{{ $view === 'board' ? 'Kanban board' : 'Task History' }}</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">My ToDo workspace</h1>
                <p class="mt-2 text-sm text-slate-500">{{ $view === 'board' ? 'A focused board for planning, tracking progress, and celebrating completed work.' : 'Review and analyze completed tasks with detailed history and metrics.' }}</p>
            </div>

            @can('manage-tasks')
            <a href="{{ route('tasks.create') }}" class="btn-primary">+ New Task</a>
            @endcan
        </div>
    </x-slot>

    <div class="page-shell space-y-6">
        {{-- Tabs --}}
        <div class="surface-card p-1">
            <div class="flex">
                <a href="{{ route('tasks.index', ['view' => 'board']) }}"
                   class="flex-1 text-center px-4 py-3 text-sm font-medium rounded-2xl transition {{ $view === 'board' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:text-slate-900' }}">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Board
                    </div>
                </a>
                <a href="{{ route('tasks.index', ['view' => 'history']) }}"
                   class="flex-1 text-center px-4 py-3 text-sm font-medium rounded-2xl transition {{ $view === 'history' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:text-slate-900' }}">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        History
                    </div>
                </a>
            </div>
        </div>

        @if($view === 'board')
            <div class="flex flex-wrap gap-3">
                <span class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-3 py-1 text-sm font-semibold text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ $todo->count() }} To Do
                </span>
                <span class="inline-flex items-center gap-2 rounded-full bg-sky-100 px-3 py-1 text-sm font-semibold text-sky-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    {{ $inProgress->count() }} In Progress
                </span>
                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $done->count() }} Done
                </span>
            </div>
        @endif

        <div class="grid gap-6 xl:grid-cols-3">
            <section class="surface-card overflow-hidden">
                <div class="flex items-center justify-between border-b border-slate-200 bg-slate-900 px-4 py-4 text-white">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold">To Do</h3>
                            <p class="text-xs text-slate-300">Planned work ready to start</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-bold">{{ $todo->count() }}</span>
                </div>
                <div class="min-h-[24rem] space-y-3 bg-slate-50/70 p-4">
                    @forelse($todo as $task)
                        @include('tasks._card', ['task' => $task])
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-white/70 p-4 text-sm text-slate-400">No tasks here yet.</div>
                    @endforelse
                </div>
            </section>

            <section class="surface-card overflow-hidden">
                <div class="flex items-center justify-between border-b border-sky-100 bg-sky-600 px-4 py-4 text-white">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold">In Progress</h3>
                            <p class="text-xs text-sky-100">Currently being worked on</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-bold">{{ $inProgress->count() }}</span>
                </div>
                <div class="min-h-[24rem] space-y-3 bg-sky-50/60 p-4">
                    @forelse($inProgress as $task)
                        @include('tasks._card', ['task' => $task])
                    @empty
                        <div class="rounded-2xl border border-dashed border-sky-200 bg-white/70 p-4 text-sm text-slate-400">No active tasks right now.</div>
                    @endforelse
                </div>
            </section>

            <section class="surface-card overflow-hidden">
                <div class="flex items-center justify-between border-b border-emerald-100 bg-emerald-600 px-4 py-4 text-white">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold">Done</h3>
                            <p class="text-xs text-emerald-100">Finished and cleared</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-bold">{{ $done->count() }}</span>
                </div>
                <div class="min-h-[24rem] space-y-3 bg-emerald-50/60 p-4">
                    @forelse($done as $task)
                        @include('tasks._card', ['task' => $task])
                    @empty
                        <div class="rounded-2xl border border-dashed border-emerald-200 bg-white/70 p-4 text-sm text-slate-400">Completed items will appear here.</div>
                    @endforelse
                </div>
            </section>
        </div>
        @else
        {{-- History View --}}
        {{-- Filters --}}
        <form method="GET" action="{{ route('tasks.index', ['view' => 'history']) }}" class="surface-card p-6">
            <div class="flex flex-wrap gap-3">
                <div class="flex-1">
                    <label class="field-label">Search Tasks</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search task title..." class="field-input">
                </div>
                <div>
                    <label class="field-label">Priority</label>
                    <select name="priority" class="field-select">
                        <option value="">All Priorities</option>
                        <option value="high" {{ request('priority')=='high'?'selected':'' }}>High</option>
                        <option value="medium" {{ request('priority')=='medium'?'selected':'' }}>Medium</option>
                        <option value="low" {{ request('priority')=='low'?'selected':'' }}>Low</option>
                    </select>
                </div>
                @can('manage-tasks')
                <div>
                    <label class="field-label">Assignee</label>
                    <select name="assignee" class="field-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('assignee')==$user->id?'selected':'' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endcan
                <div class="flex items-end gap-2">
                    <button class="btn-primary">Filter</button>
                    <a href="{{ route('tasks.index', ['view' => 'history']) }}" class="btn-secondary">Clear</a>
                </div>
            </div>
        </form>

        {{-- Stats bar --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="surface-card p-6 text-center">
                <p class="text-sm text-slate-500 mb-2">Total Completed</p>
                <p class="text-3xl font-bold text-emerald-600">{{ $tasks->total() }}</p>
            </div>
            <div class="surface-card p-6 text-center">
                <p class="text-sm text-slate-500 mb-2">High Priority Completed</p>
                <p class="text-3xl font-bold text-rose-500">
                    {{ $tasks->getCollection()->where('priority','high')->count() }}
                </p>
            </div>
            <div class="surface-card p-6 text-center">
                <p class="text-sm text-slate-500 mb-2">With Comments</p>
                <p class="text-3xl font-bold text-sky-600">
                    {{ $tasks->getCollection()->filter(fn($t) => $t->comments->count() > 0)->count() }}
                </p>
            </div>
        </div>

        {{-- Task list --}}
        <div class="space-y-4">
            @forelse($tasks as $task)
            @php
                $log = $task->completionLog();
                $completedBy = $log?->causer?->name ?? 'Unknown';
                $completedAt = $log?->created_at;
                $timeTaken = $task->timeToComplete();
                $priorityColor = match($task->priority) {
                    'high'   => 'bg-rose-100 text-rose-700',
                    'medium' => 'bg-amber-100 text-amber-700',
                    'low'    => 'bg-emerald-100 text-emerald-700',
                    default  => 'bg-slate-100 text-slate-600',
                };
            @endphp
            <div class="surface-card overflow-hidden">
                <div class="p-6 border-b border-slate-200">
                    {{-- Title row --}}
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <a href="{{ route('tasks.show', $task) }}" class="text-lg font-semibold text-slate-900 hover:text-sky-600 transition">
                                {{ $task->title }}
                            </a>
                            @if($task->description)
                            <p class="text-sm text-slate-500 mt-2">{{ Str::limit($task->description, 120) }}</p>
                            @endif
                        </div>
                        <span class="text-xs px-3 py-1 rounded-full {{ $priorityColor }} ml-4 shrink-0 font-semibold">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>

                    {{-- Info grid --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-slate-400 mb-1 uppercase tracking-wide">Assigned to</p>
                            <p class="font-medium text-slate-900">{{ $task->assignee?->name ?? 'Unassigned' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-1 uppercase tracking-wide">Completed by</p>
                            <p class="font-medium text-slate-900">{{ $completedBy }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-1 uppercase tracking-wide">Completed at</p>
                            <p class="font-medium text-slate-900">
                                {{ $completedAt ? $completedAt->format('M d, Y H:i') : 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-1 uppercase tracking-wide">Time to complete</p>
                            <p class="font-medium text-emerald-600">{{ $timeTaken ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Comments --}}
                @if($task->comments->count() > 0)
                <div class="px-6 py-4 bg-slate-50">
                    <p class="text-xs text-slate-400 mb-3 uppercase tracking-wide">
                        {{ $task->comments->count() }} comment(s)
                    </p>
                    @foreach($task->comments->take(2) as $comment)
                    <div class="text-sm text-slate-600 mb-2">
                        <span class="font-medium text-slate-900">{{ $comment->user->name }}:</span>
                        {{ Str::limit($comment->body, 80) }}
                    </div>
                    @endforeach
                    @if($task->comments->count() > 2)
                    <a href="{{ route('tasks.show', $task) }}" class="text-sm text-sky-600 hover:text-sky-700 font-medium">
                        View all {{ $task->comments->count() }} comments →
                    </a>
                    @endif
                </div>
                @endif
            </div>
            @empty
            <div class="surface-card p-12 text-center">
                <div class="text-slate-400">
                    <svg class="mx-auto h-12 w-12 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-lg font-medium">No completed tasks found.</p>
                    <p class="text-sm mt-1">Tasks will appear here once they're marked as done.</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="flex justify-center">{{ $tasks->links() }}</div>
        
    </div>
</x-app-layout>