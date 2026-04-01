<x-app-layout>
    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Task History</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">Completed Tasks</h1>
                <p class="mt-2 text-sm text-slate-500">Review and analyze completed tasks with detailed history and metrics.</p>
            </div>
        </div>
    </x-slot>

    <div class="page-shell space-y-6">
        {{-- Filters --}}
        <form method="GET" action="{{ route('tasks.history') }}" class="surface-card p-6">
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
                    <a href="{{ route('tasks.history') }}" class="btn-secondary">Clear</a>
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