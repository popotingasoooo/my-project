<x-app-layout>
    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">User onboarding</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">Create user</h1>
                <p class="mt-2 text-sm text-slate-500">Add a new team member and assign the right access level from the start.</p>
            </div>

            <a href="{{ route('users.index') }}" class="btn-secondary">Back to users</a>
        </div>
    </x-slot>

    <div class="page-shell grid gap-6 xl:grid-cols-[1fr_.4fr]">
        <section class="surface-card p-6">
            <form action="{{ route('users.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="field-label" for="name">Name*</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" class="field-input" placeholder="e.g. Jane Doe" required>
                    @error('name')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="field-label" for="email">Email*</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="field-input" placeholder="jane@example.com" required>
                    @error('email')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="field-label" for="role">Role</label>
                    <select id="role" name="role" class="field-select">
                        @forelse($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                        @empty
                        <option disabled>No roles available</option>
                        @endforelse
                    </select>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button type="submit" class="btn-primary">Create User</button>
                    <a href="{{ route('users.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </section>

        <aside class="surface-card p-6">
            <h2 class="text-lg font-semibold text-slate-900">Quick note</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                <li class="rounded-2xl bg-slate-50 px-4 py-3">New accounts are created with the default password <code class="font-semibold text-slate-900">password123</code>.</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Choose the correct role now to avoid permission issues later.</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Ask the user to update their password after first login.</li>
            </ul>
        </aside>
    </div>
</x-app-layout>