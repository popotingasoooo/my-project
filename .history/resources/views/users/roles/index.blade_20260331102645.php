<x-app-layout>
    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Access control</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">Roles & permissions</h1>
                <p class="mt-2 text-sm text-slate-500">Define what each role can do and keep permissions clearly organized.</p>
            </div>

            @can('manage-roles')
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('roles.create') }}" class="btn-primary">+ New Role</a>
                <a href="{{ route('roles.assign') }}" class="btn-secondary">Assign Roles</a>
            </div>
            @endcan
        </div>
    </x-slot>

    @php
        $permissionCount = $roles->flatMap(fn ($role) => $role->permissions->pluck('name'))->unique()->count();
    @endphp

    <div class="page-shell space-y-6">
        @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
        @endif

        <section class="grid gap-4 md:grid-cols-2">
            <div class="surface-card p-5">
                <p class="text-sm text-slate-500">Total roles</p>
                <p class="mt-2 text-4xl font-bold text-slate-900">{{ $roles->count() }}</p>
            </div>
            <div class="surface-card p-5">
                <p class="text-sm text-slate-500">Unique permissions</p>
                <p class="mt-2 text-4xl font-bold text-sky-600">{{ $permissionCount }}</p>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-2">
            @forelse($roles as $role)
            <div class="surface-card p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Role</p>
                        <h2 class="mt-1 text-xl font-bold capitalize text-slate-900">{{ $role->name }}</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ $role->permissions->count() }} permission(s) assigned</p>
                    </div>

                    @can('manage-roles')
                    <a href="{{ route('roles.edit', $role) }}" class="btn-secondary">Edit</a>
                    @endcan
                </div>

                <div class="mt-4 flex flex-wrap gap-2">
                    @forelse($role->permissions as $perm)
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ $perm->name }}</span>
                    @empty
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">No permissions attached</span>
                    @endforelse
                </div>
            </div>
            @empty
            <div class="surface-card p-6 text-sm text-slate-400 lg:col-span-2">No roles have been created yet.</div>
            @endforelse
        </section>
    </div>
</x-app-layout>