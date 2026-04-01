<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Completed Tasks History
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filters --}}
            <form method="GET" action="{{ route('tasks.history') }}"
                  class="bg-white shadow rounded-lg p-4 mb-6">
                <div class="flex flex-wrap gap-3">
                    <input type="text" name="search"
                           value="{{ request('search') }}"
                           placeholder="Search task title..."
                           class="border rounded px-3 py-2 text-sm flex-1">
                    <select name="priority" class="border rounded px-3 py-2 text-sm">
                        <option value="">All Priorities</option>
                        <option value="high" {{ request('priority')=='high'?'selected':'' }}>High</option>
                        <option value="medium" {{ request('priority')=='medium'?'selected':'' }}>Medium</option>
                        <option value="low" {{ request('priority')=='low'?'selected':'' }}>Low</option>
                    </select>
                    @can('manage-tasks')
                    <select name="assignee" class="border rounded px-3 py-2 text-sm">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            {{ request('assignee')==$user->id?'selected':'' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                    @endcan
                    <button class="bg-blue-600 text-white px-4 py-2 rounded text-sm">
                        Filter
                    </button>
                    <a href="{{ route('tasks.history') }}"
                       class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm">
                        Clear
                    </a>
                </div>
            </form>

            {{-- Stats bar --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-500">Total Completed</p>
                    <p class="text-3xl font-bold text-green-600">{{ $tasks->total() }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-500">High Priority Completed</p>
                    <p class="text-3xl font-bold text-red-500">
                        {{ $tasks->getCollection()->where('priority','high')->count() }}
                    </p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-500">With Comments</p>
                    <p class="text-3xl font-bold text-blue-600">
                        {{ $tasks->getCollection()->filter(fn($t) => $t->comments->count() > 0)->count() }}
                    </p>
                </div>
            </div>

            {{-- Task list --}}
            @forelse($tasks as $task)
            @php
                $log = $task->completionLog();
                $completedBy = $log?->causer?->name ?? 'Unknown';
                $completedAt = $log?->created_at;
                $timeTaken = $task->timeToComplete();
                $priorityColor = match($task->priority) {
                    'high'   => 'bg-red-100 text-red-700',
                    'medium' => 'bg-yellow-100 text-yellow-700',
                    'low'    => 'bg-green-100 text-green-700',
                    default  => 'bg-gray-100 text-gray-600',
                };
            @endphp
            <div class="bg-white shadow rounded-lg mb-4 overflow-hidden">
                <div class="p-4 border-b border-gray-100">

                    {{-- Title row --}}
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <a href="{{ route('tasks.show', $task) }}"
                               class="font-semibold text-gray-800 hover:text-blue-600">
                                {{ $task->title }}
                            </a>
                            @if($task->description)
                            <p class="text-sm text-gray-500 mt-1">{{ Str::limit($task->description, 100) }}</p>
                            @endif
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full {{ $priorityColor }} ml-3 shrink-0">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>

                    {{-- Info grid --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Assigned to</p>
                            <p class="font-medium">{{ $task->assignee?->name ?? 'Unassigned' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Completed by</p>
                            <p class="font-medium">{{ $completedBy }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Completed at</p>
                            <p class="font-medium">
                                {{ $completedAt ? $completedAt->format('M d, Y H:i') : 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Time to complete</p>
                            <p class="font-medium text-green-600">{{ $timeTaken ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Comments --}}
                @if($task->comments->count() > 0)
                <div class="px-4 py-3 bg-gray-50">
                    <p class="text-xs text-gray-400 mb-2">
                        {{ $task->comments->count() }} comment(s)
                    </p>
                    @foreach($task->comments->take(2) as $comment)
                    <div class="text-sm text-gray-600 mb-1">
                        <span class="font-medium">{{ $comment->user->name }}:</span>
                        {{ Str::limit($comment->body, 80) }}
                    </div>
                    @endforeach
                    @if($task->comments->count() > 2)
                    <a href="{{ route('tasks.show', $task) }}"
                       class="text-xs text-blue-600 hover:underline">
                        View all {{ $task->comments->count() }} comments →
                    </a>
                    @endif
                </div>
                @endif
            </div>
            @empty
            <div class="bg-white shadow rounded-lg p-8 text-center text-gray-400">
                No completed tasks found.
            </div>
            @endforelse

            <div class="mt-4">{{ $tasks->links() }}</div>

        </div>
    </div>
</x-app-layout>