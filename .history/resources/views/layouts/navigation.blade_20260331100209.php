<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-white/70 bg-white/80 backdrop-blur-xl">
    <div class="page-shell">
        <div class="flex h-16 items-center justify-between gap-4">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900 text-sm font-black text-white shadow-sm">TD</span>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">TaskFlow</p>
                        <p class="text-xs text-slate-500">Organize your day</p>
                    </div>
                </a>

                <div class="hidden items-center gap-2 sm:flex">
                    <a href="{{ route('dashboard') }}"
                       class="{{ request()->routeIs('dashboard') ? 'inline-flex items-center rounded-full bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm' : 'inline-flex items-center rounded-full px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900' }}">
                        Dashboard
                    </a>

                    @can('view-tasks')
                    <a href="{{ route('tasks.index') }}"
                       class="{{ request()->routeIs('tasks.*') ? 'inline-flex items-center rounded-full bg-sky-100 px-3 py-2 text-sm font-semibold text-sky-700' : 'inline-flex items-center rounded-full px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900' }}">
                        Tasks
                    </a>
                    @endcan

                    @can('view-users')
                    <a href="{{ route('users.index') }}"
                       class="{{ request()->routeIs('users.*') ? 'inline-flex items-center rounded-full bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm' : 'inline-flex items-center rounded-full px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900' }}">
                        Users
                    </a>
                    @endcan

                    @can('view-roles')
                    <a href="{{ route('roles.index') }}"
                       class="{{ request()->routeIs('roles.*') ? 'inline-flex items-center rounded-full bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm' : 'inline-flex items-center rounded-full px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900' }}">
                        Roles
                    </a>
                    @endcan

                    @can('view-logs')
                    <a href="{{ route('activity.index') }}"
                       class="{{ request()->routeIs('activity.*') ? 'inline-flex items-center rounded-full bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm' : 'inline-flex items-center rounded-full px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900' }}">
                        Activity Logs
                    </a>
                    @endcan
                </div>
            </div>

            <div class="hidden items-center gap-3 sm:flex">
                <div class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-right">
                    <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-500">{{ Auth::user()->email }}</p>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 shadow-sm transition hover:border-slate-300 hover:text-slate-900 focus:outline-none">
                            <span>Account</span>
                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white p-2 text-slate-600 shadow-sm transition hover:bg-slate-50">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-slate-200 bg-white sm:hidden">
        <div class="page-shell space-y-2 py-4">
            <a href="{{ route('dashboard') }}" class="block rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Dashboard</a>

            @can('view-tasks')
            <a href="{{ route('tasks.index') }}" class="block rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Tasks</a>
            @endcan

            @can('view-users')
            <a href="{{ route('users.index') }}" class="block rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Users</a>
            @endcan

            @can('view-roles')
            <a href="{{ route('roles.index') }}" class="block rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Roles</a>
            @endcan

            @can('view-logs')
            <a href="{{ route('activity.index') }}" class="block rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Activity Logs</a>
            @endcan
        </div>

        <div class="border-t border-slate-200 pb-4 pt-4">
            <div class="page-shell">
                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                    <div class="font-medium text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Profile
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
