<x-app-layout>
    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Kanban board</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">My ToDo workspace</h1>
                <p class="mt-2 text-sm text-slate-500">A focused board for planning, tracking progress, and celebrating completed work.</p>
            </div>

            @can('manage-tasks')
            <a href="{{ route('tasks.create') }}" class="btn-primary">+ New Task</a>
            @endcan
        </div>
    </x-slot>

    <div class="page-shell space-y-6">
        <div class="flex flex-wrap gap-3">
            <span class="rounded-full bg-slate-900 px-3 py-1 text-sm font-semibold text-white">{{ $todo->count() }} To Do</span>
            <span class="rounded-full bg-sky-100 px-3 py-1 text-sm font-semibold text-sky-700">{{ $inProgress->count() }} In Progress</span>
            <span class="rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">{{ $done->count() }} Done</span>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <section class="surface-card overflow-hidden">
                <div class="flex items-center justify-between border-b border-slate-200 bg-slate-900 px-4 py-4 text-white">
                    <div>
                        <h3 class="font-semibold">To Do</h3>
                        <p class="text-xs text-slate-300">Planned work ready to start</p>
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
                    <div>
                        <h3 class="font-semibold">In Progress</h3>
                        <p class="text-xs text-sky-100">Currently being worked on</p>
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
                    <div>
                        <h3 class="font-semibold">Done</h3>
                        <p class="text-xs text-emerald-100">Finished and cleared</p>
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
    </div>
</x-app-layout>