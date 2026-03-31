<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Task Board</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @can('manage-tasks')
            <div class="mb-4">
                <a href="{{ route('tasks.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + New Task
                </a>
            </div>
            @endcan

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- TO DO --}}
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="bg-gray-500 text-white font-bold px-4 py-3 flex justify-between">
                        <span>To Do</span>
                        <span class="bg-white text-gray-700 text-xs px-2 py-1 rounded-full">
                            {{ $todo->count() }}
                        </span>
                    </div>
                    <div class="p-3 flex flex-col gap-3">
                        @forelse($todo as $task)
                            @include('tasks._card', ['task' => $task])
                        @empty
                            <p class="text-gray-400 text-sm">No tasks here.</p>
                        @endforelse
                    </div>
                </div>

                {{-- IN PROGRESS --}}
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="bg-blue-600 text-white font-bold px-4 py-3 flex justify-between">
                        <span>In Progress</span>
                        <span class="bg-white text-blue-700 text-xs px-2 py-1 rounded-full">
                            {{ $inProgress->count() }}
                        </span>
                    </div>
                    <div class="p-3 flex flex-col gap-3">
                        @forelse($inProgress as $task)
                            @include('tasks._card', ['task' => $task])
                        @empty
                            <p class="text-gray-400 text-sm">No tasks here.</p>
                        @endforelse
                    </div>
                </div>

                {{-- DONE --}}
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="bg-green-600 text-white font-bold px-4 py-3 flex justify-between">
                        <span>Done</span>
                        <span class="bg-white text-green-700 text-xs px-2 py-1 rounded-full">
                            {{ $done->count() }}
                        </span>
                    </div>
                    <div class="p-3 flex flex-col gap-3">
                        @forelse($done as $task)
                            @include('tasks._card', ['task' => $task])
                        @empty
                            <p class="text-gray-400 text-sm">No tasks here.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>