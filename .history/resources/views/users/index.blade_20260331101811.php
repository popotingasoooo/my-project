<x-app-layout>
    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Team management</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">Users</h1>
                <p class="mt-2 text-sm text-slate-500">Manage accounts, roles, and archived members from one organized admin workspace.</p>
            </div>

            @can('manage-users')
            <a href="{{ route('users.create') }}" class="btn-primary">+ Create User</a>
            @endcan
        </div>
    </x-slot>

    @php
        $roleOptions = \Spatie\Permission\Models\Role::pluck('name');
        $filtersApplied = request()->filled('search') || request()->filled('role');
    @endphp

    <div class="page-shell space-y-6">
        @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
        @endif

        <section class="grid gap-4 md:grid-cols-3">
            <div class="surface-card p-5">
                <p class="text-sm text-slate-500">Visible users</p>
                <p class="mt-2 text-4xl font-bold text-slate-900">{{ $users->total() }}</p>
            </div>
            <div class="surface-card p-5">
                <p class="text-sm text-slate-500">Archived users</p>
                <p class="mt-2 text-4xl font-bold text-amber-500">{{ $trashed->count() }}</p>
            </div>
            <div class="surface-card p-5">
                <p class="text-sm text-slate-500">Filters</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $filtersApplied ? 'Active' : 'None' }}</p>
            </div>
        </section>

        <section class="surface-card p-6">
            <div class="mb-4">
                <h2 class="text-lg font-semibold text-slate-900">Find a user</h2>
                <p class="text-sm text-slate-500">Search by name or email, or narrow the list by role.</p>
            </div>

            <form method="GET" action="{{ route('users.index') }}" class="grid gap-3 md:grid-cols-[1fr_.7fr_auto_auto]">
                <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}" class="field-input">

                <select name="role" class="field-select">
                    <option value="">All Roles</option>
                    @foreach($roleOptions as $roleName)
                    <option value="{{ $roleName }}" {{ request('role') == $roleName ? 'selected' : '' }}>
                        {{ ucfirst($roleName) }}
                    </option>
                    @endforeach
                </select>

                <button type="submit" class="btn-primary">Filter</button>
                <a href="{{ route('users.index') }}" class="btn-secondary">Clear</a>
            </form>
        </section>

        <section class="surface-card overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">All users</h2>
                    <p class="text-sm text-slate-500">Review active accounts and their assigned roles.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Name</th>
                            <th class="px-6 py-3 text-left font-semibold">Email</th>
                            <th class="px-6 py-3 text-left font-semibold">Role</th>
                            <th class="px-6 py-3 text-left font-semibold">Status</th>
                            <th class="px-6 py-3 text-left font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="border-t border-slate-100">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-900">{{ $user->name }}</div>
                                <div class="text-xs text-slate-500">Member account</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700 capitalize">
                                    {{ $user->role ?? 'user' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Active</span>
                            </td>
                            <td class="px-6 py-4">
                                @can('manage-users')
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('users.edit', $user) }}" class="rounded-lg bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 transition hover:bg-amber-200">Edit</a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete {{ $user->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg bg-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-200">Delete</button>
                                    </form>
                                </div>
                                @else
                                <span class="text-slate-400">—</span>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-400">No users matched your filters.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $users->links() }}
            </div>
        </section>

        @if($trashed->count() > 0)
        <section class="surface-card overflow-hidden">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Archived users</h2>
                <p class="text-sm text-slate-500">Restore users that were previously soft-deleted.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Name</th>
                            <th class="px-6 py-3 text-left font-semibold">Email</th>
                            <th class="px-6 py-3 text-left font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trashed as $user)
                        <tr class="border-t border-slate-100">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @can('manage-users')
                                <form action="{{ route('users.restore', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="rounded-lg bg-emerald-100 px-3 py-1.5 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-200">Restore</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        @endif
    </div>
</x-app-layout>