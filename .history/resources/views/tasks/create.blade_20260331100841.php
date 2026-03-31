<x-app-layout>
    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Task planner</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">Create a new task</h1>
                <p class="mt-2 text-sm text-slate-500">Add a clear title, set a due date, and assign the right person in seconds.</p>
            </div>

            <a href="{{ route('tasks.index') }}" class="btn-secondary">Back to board</a>
        </div>
    </x-slot>

    <div class="page-shell grid gap-6 xl:grid-cols-[1fr_.4fr]">
        <section class="surface-card p-6">
            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="title" class="field-label">Title</label>
                    <input id="title" type="text" name="title" class="field-input" value="{{ old('title') }}" placeholder="e.g. Finish homepage redesign">
                    @error('title')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="description" class="field-label">Description</label>
                    <textarea id="description" name="description" rows="5" class="field-input" placeholder="Add notes, acceptance criteria, or next steps...">{{ old('description') }}</textarea>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="priority" class="field-label">Priority</label>
                        <select id="priority" name="priority" class="field-select">
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <div>
                        <label for="due_date" class="field-label">Due date</label>
                        <input id="due_date" type="date" name="due_date" class="field-input" value="{{ old('due_date') }}">
                    </div>
                </div>

                <div>
                    <label for="assigned_to" class="field-label">Assign to</label>
                    <select id="assigned_to" name="assigned_to" class="field-select">
                        <option value="">-- Unassigned --</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button class="btn-primary">Create Task</button>
                    <a href="{{ route('tasks.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </section>

        <aside class="surface-card p-6">
            <h2 class="text-lg font-semibold text-slate-900">Tips for a great task</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Use a specific title so the next action is obvious.</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Set a realistic due date to keep your board meaningful.</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Assign ownership early to avoid work getting stuck.</li>
            </ul>
        </aside>
    </div>
</x-app-layout>