<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/recycle-bin.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[radial-gradient(circle_at_top_left,_rgba(14,165,233,0.18),_transparent_0,_transparent_35%),radial-gradient(circle_at_bottom_right,_rgba(16,185,129,0.18),_transparent_0,_transparent_30%),linear-gradient(to_bottom_right,_#f8fbff,_#eef6ff,_#f8fafc)] px-4 py-8">
            <div class="grid w-full max-w-5xl overflow-hidden rounded-[32px] border border-white/70 bg-white/90 shadow-2xl shadow-slate-900/10 backdrop-blur lg:grid-cols-[1.05fr_.95fr]">
                <div class="hidden flex-col justify-between bg-gradient-to-br from-slate-900 via-sky-800 to-cyan-500 p-10 text-white lg:flex">
                    <div>
                        <a href="/" class="flex items-center gap-3">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-lg font-black">TD</span>
                            <div>
                                <p class="text-xl font-semibold">TaskFlow</p>
                                <p class="text-sm text-sky-100/80">Simple team to-do management</p>
                            </div>
                        </a>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-sky-100/80">Stay organized</p>
                        <h1 class="mt-3 text-4xl font-bold leading-tight">Plan it, track it, finish it.</h1>
                        <p class="mt-4 text-sm leading-6 text-sky-50/90">A calm, focused space for managing tasks, assigning work, and keeping due dates visible.</p>
                    </div>

                    <div class="space-y-3 text-sm text-sky-50/90">
                        <div class="rounded-2xl bg-white/10 px-4 py-3">✔ Clean board for To Do, In Progress, and Done</div>
                        <div class="rounded-2xl bg-white/10 px-4 py-3">✔ Fast task updates and team comments</div>
                        <div class="rounded-2xl bg-white/10 px-4 py-3">✔ One place for deadlines and activity</div>
                    </div>
                </div>

                <div class="px-6 py-8 sm:px-10 sm:py-10">
                    <a href="/" class="mb-6 flex items-center gap-3 lg:hidden">
                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900 text-sm font-black text-white">TD</span>
                        <div>
                            <p class="text-base font-semibold text-slate-900">TaskFlow</p>
                            <p class="text-xs text-slate-500">Simple team to-do management</p>
                        </div>
                    </a>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
