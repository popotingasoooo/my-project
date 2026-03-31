<x-app-layout>
    @php($selectedPermissions = old('permissions', []))

    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Role builder</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">Create role</h1>
                <p class="mt-2 text-sm text-slate-500">Set up a role and choose exactly which permissions belong to it.</p>
            </div>

            <a href="{{ route('roles.index') }}" class="btn-secondary">Back to roles</a>
        </div>
    </x-slot>

    <div class="page-shell grid gap-6 xl:grid-cols-[1fr_.4fr]">
        <section class="surface-card p-6">
            <form action="{{ route('roles.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="field-label" for="name">Role name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" class="field-input" placeholder="e.g. project-manager">
                    @error('name')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="field-label">Permissions</label>
                    <div class="grid gap-3 sm:grid-cols-2">
                        @foreach($permissions as $permission)
                        <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500" @checked(in_array($permission->name, $selectedPermissions))>
                            <span>{{ $permission->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button type="submit" class="btn-primary">Create Role</button>
                    <a href="{{ route('roles.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </section>

        <aside class="surface-card p-6">
            <h2 class="text-lg font-semibold text-slate-900">Best practice</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Keep role names short and descriptive.</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Grant only the permissions that are actually needed.</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Use assignment tools after saving to give the role to users.</li>
            </ul>
        </aside>
    </div>
</x-app-layout>
