<x-app-layout>
    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Role assignment</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">Assign roles to users</h1>
                <p class="mt-2 text-sm text-slate-500">Quickly match people with the access level they need.</p>
            </div>

            <a href="{{ route('roles.index') }}" class="btn-secondary">Back to roles</a>
        </div>
    </x-slot>

    <div class="page-shell grid gap-6 xl:grid-cols-[1fr_.4fr]">
        <section class="surface-card p-6">
            @if(session('success'))
            <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('roles.assign.post') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="field-label" for="user_id">Select user</label>
                    <select id="user_id" name="user_id" class="field-select">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="field-label" for="role">Assign role</label>
                    <select id="role" name="role" class="field-select">
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-primary">Assign Role</button>
            </form>
        </section>

        <aside class="surface-card p-6">
            <h2 class="text-lg font-semibold text-slate-900">Reminder</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Assigning a new role replaces the user’s previous role setup.</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Use clear role names so admins can pick the right access fast.</li>
            </ul>
        </aside>
    </div>
</x-app-layout>