<x-app-layout>
    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">User settings</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">Edit user</h1>
                <p class="mt-2 text-sm text-slate-500">Update account details, reset a password, or change the assigned role.</p>
            </div>

            <a href="{{ route('users.index') }}" class="btn-secondary">Back to users</a>
        </div>
    </x-slot>

    <div class="page-shell grid gap-6 xl:grid-cols-[1fr_.4fr]">
        <section class="surface-card p-6">
            <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label class="field-label" for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="field-input">
                    @error('name')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="field-label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="field-input">
                    @error('email')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="field-label" for="password">New password</label>
                        <input id="password" type="password" name="password" class="field-input" placeholder="Leave blank to keep current password">
                    </div>

                    <div>
                        <label class="field-label" for="password_confirmation">Confirm password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="field-input">
                    </div>
                </div>

                <div>
                    <label class="field-label" for="role">Role</label>
                    <select id="role" name="role" class="field-select">
                        @forelse($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role', $user->role) == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                        @empty
                        <option disabled>No roles available</option>
                        @endforelse
                    </select>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button type="submit" class="btn-primary">Update User</button>
                    <a href="{{ route('users.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </section>

        <aside class="surface-card p-6">
            <h2 class="text-lg font-semibold text-slate-900">Editing tips</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Leave the password fields blank if no reset is needed.</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Changing a role updates what the user can see and do.</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Double-check the email before saving important account changes.</li>
            </ul>
        </aside>
    </div>
</x-app-layout>