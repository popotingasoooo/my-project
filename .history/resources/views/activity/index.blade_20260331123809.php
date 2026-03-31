<x-app-layout>
    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Audit trail</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">Activity logs</h1>
                <p class="mt-2 text-sm text-slate-500">Track recent system events, user changes, and important activity in one timeline.</p>
            </div>
        </div>
    </x-slot>

    <div class="page-shell space-y-6">
        <section class="grid gap-4 md:grid-cols-2">
            <div class="surface-card p-5">
                <p class="text-sm text-slate-500">Total log entries</p>
                <p class="mt-2 text-4xl font-bold text-slate-900">{{ $logs->total() }}</p>
            </div>
            <div class="surface-card p-5">
                <p class="text-sm text-slate-500">Showing on this page</p>
                <p class="mt-2 text-4xl font-bold text-sky-600">{{ $logs->count() }}</p>
            </div>
        </section>

        <section class="surface-card overflow-hidden">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Recent activity</h2>
                <p class="text-sm text-slate-500">A readable view of who changed what and when.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Date & time</th>
                            <th class="px-6 py-3 text-left font-semibold">User</th>
                            <th class="px-6 py-3 text-left font-semibold">Action</th>
                            <th class="px-6 py-3 text-left font-semibold">Subject</th>
                            <th class="px-6 py-3 text-left font-semibold">Changes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr class="border-t border-slate-100 align-top">
                            <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                                {{ $log->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $log->causer ? $log->causer->name : 'System' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                                    {{ $log->description }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $log->subject_type ? class_basename($log->subject_type) : '-' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                @if($log->properties->has('attributes'))
                                    <div class="space-y-1">
                                        @foreach($log->properties['attributes'] as $key => $value)
                                        <div class="rounded-lg bg-slate-50 px-3 py-2">
                                            <span class="font-semibold text-slate-700">{{ $key }}</span>:
                                            @if($key === 'due_date' && $value)
                                                {{ \Carbon\Carbon::parse($value)->format('M d, Y') }}
                                            @else
                                                {{ is_array($value) ? json_encode($value) : $value }}
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-slate-400">No attribute snapshot</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-400">No activity logs available.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $logs->links() }}
            </div>
        </section>
    </div>
</x-app-layout>