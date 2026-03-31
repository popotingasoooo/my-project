<x-guest-layout>
    <div class="mb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Welcome back</p>
        <h1 class="mt-2 text-3xl font-bold text-slate-900">Sign in to your ToDo workspace</h1>
        <p class="mt-2 text-sm text-slate-500">Stay on top of tasks, due dates, and team progress with a cleaner dashboard.</p>
    </div>

    <x-auth-session-status class="mb-4 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="field-label" />
            <x-text-input id="email" class="field-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="field-label" />
            <x-text-input id="password" class="field-input" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-sky-600 shadow-sm focus:ring-sky-500" name="remember" @checked(old('remember'))>
                <span>{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-sky-600 transition hover:text-sky-700" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="btn-primary w-full justify-center">
            {{ __('Log in') }}
        </button>
    </form>
</x-guest-layout>
