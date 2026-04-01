<x-app-layout>
    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Workspace overview</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">Your productivity dashboard</h1>
                <p class="mt-2 text-sm text-slate-500">A cleaner home base for tracking work, deadlines, and recent team activity.</p>
            </div>

            @can('view-tasks')
            <a href="{{ route('tasks.index') }}" class="btn-primary">Open task board</a>
            @endcan
        </div>
    </x-slot>

    @php
        $totalUsers = \App\Models\User::count();
        $totalRoles = \Spatie\Permission\Models\Role::count();
        $activityCount = \Spatie\Activitylog\Models\Activity::count();
        $openTasks = \App\Models\Task::where('status', '!=', 'done')->count();
        $completedTasks = \App\Models\Task::where('status', 'done')->count();
    @endphp

    <div class="page-shell space-y-6">
        <section class="grid gap-6 lg:grid-cols-[1.35fr_.65fr]">
            <div class="surface-card overflow-hidden">
                <div class="bg-gradient-to-r from-slate-900 via-sky-800 to-cyan-600 px-6 py-6 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-100/80">Today’s focus</p>
                    <h2 class="mt-2 text-3xl font-bold">Keep every task moving.</h2>
                    <p class="mt-2 max-w-2xl text-sm text-sky-100">Plan what matters, monitor what is in progress, and close work with confidence from one organized space.</p>
                </div>
                <div class="grid gap-4 p-6 sm:grid-cols-2">
                    <div class="surface-muted p-4">
                        <p class="text-sm text-slate-500">Open tasks</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $openTasks }}</p>
                        <p class="mt-1 text-xs text-slate-500">Still waiting for action or completion.</p>
                    </div>
                    <div class="surface-muted p-4">
                        <p class="text-sm text-slate-500">Completed tasks</p>
                        <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $completedTasks }}</p>
                        <p class="mt-1 text-xs text-slate-500">Finished and ready to review.</p>
                    </div>
                </div>
            </div>

            <aside class="surface-card p-6">
                <h3 class="text-lg font-semibold text-slate-900">Quick actions</h3>
                <p class="mt-1 text-sm text-slate-500">Jump straight into the work that matters most.</p>

                <div class="mt-4 space-y-3">
                    @can('view-tasks')
                    <a href="{{ route('tasks.index') }}" class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:bg-sky-50 hover:text-sky-700">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span>Review task board</span>
                        </div>
                        <span>→</span>
                    </a>
                    @endcan

                    @can('manage-tasks')
                    <a href="{{ route('tasks.create') }}" class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Create a new task</span>
                        </div>
                        <span>＋</span>
                    </a>
                    @endcan

                    @can('view-logs')
                    <a href="{{ route('activity.index') }}" class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-violet-200 hover:bg-violet-50 hover:text-violet-700">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span>View activity logs</span>
                        </div>
                        <span>↗</span>
                    </a>
                    @endcan
                </div>
            </aside>
        </section>

        <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="surface-card p-5">
                <p class="text-sm text-slate-500">Total Users</p>
                <p class="mt-2 text-4xl font-bold text-slate-900">{{ $totalUsers }}</p>
            </div>
            <div class="surface-card p-5">
                <p class="text-sm text-slate-500">Total Roles</p>
                <p class="mt-2 text-4xl font-bold text-slate-900">{{ $totalRoles }}</p>
            </div>
            <div class="surface-card p-5">
                <p class="text-sm text-slate-500">Activity Logs</p>
                <p class="mt-2 text-4xl font-bold text-slate-900">{{ $activityCount }}</p>
            </div>
            <div class="surface-card p-5">
                <p class="text-sm text-slate-500">Open Tasks</p>
                <p class="mt-2 text-4xl font-bold text-amber-500">{{ $openTasks }}</p>
            </div>
        </section>

        @can('view-logs')
        <section class="surface-card overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Recent activity</h3>
                    <p class="text-sm text-slate-500">A quick snapshot of the latest changes across the workspace.</p>
                </div>
                <a href="{{ route('activity.index') }}" class="text-sm font-semibold text-sky-600 hover:text-sky-700">View all</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Time</th>
                            <th class="px-6 py-3 text-left font-semibold">User</th>
                            <th class="px-6 py-3 text-left font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\Spatie\Activitylog\Models\Activity::with('causer')->latest()->take(5)->get() as $log)
                        <tr class="border-t border-slate-100">
                            <td class="px-6 py-4 text-slate-500">{{ $log->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $log->causer?->name ?? 'System' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $log->description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        @endcan
    </div>
</x-app-layout>