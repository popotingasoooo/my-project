<x-app-layout>
    <x-slot name="header">
        <div class="surface-card flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Task editor</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">Update task</h1>
                <p class="mt-2 text-sm text-slate-500">Refine the details, adjust the status, and keep the board accurate.</p>
            </div>

            <a href="{{ route('tasks.show', $task) }}" class="btn-secondary">View task</a>
        </div>
    </x-slot>

    <div class="page-shell grid gap-6 xl:grid-cols-[1fr_.4fr]">
        <section class="surface-card p-6">
            <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label for="title" class="field-label">Title</label>
                    <input id="title" type="text" name="title" class="field-input" value="{{ old('title', $task->title) }}">
                    @error('title')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="description" class="field-label">Description</label>
                    <textarea id="description" name="description" rows="5" class="field-input">{{ old('description', $task->description) }}</textarea>
                </div>

                <div class="grid gap-5 md:grid-cols-3">
                    <div>
                        <label for="status" class="field-label">Status</label>
                        <select id="status" name="status" class="field-select">
                            <option value="todo" {{ old('status', $task->status) == 'todo' ? 'selected' : '' }}>To Do</option>
                            <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>

                    <div>
                        <label for="priority" class="field-label">Priority</label>
                        <select id="priority" name="priority" class="field-select">
                            <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <div>
                        <label for="due_date" class="field-label">Due date</label>
                        <input id="due_date" type="date" name="due_date" class="field-input" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                    </div>
                </div>

                <div>
                    <label for="assigned_to" class="field-label">Assign to</label>
                    <select id="assigned_to" name="assigned_to" class="field-select">
                        <option value="">-- Unassigned --</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button class="btn-primary">Update Task</button>
                    <a href="{{ route('tasks.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </section>

        <aside class="surface-card p-6">
            <h2 class="text-lg font-semibold text-slate-900">Editing checklist</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Move the status when work progresses to keep the board honest.</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Update the assignee if ownership changes.</li>
                <li class="rounded-2xl bg-slate-50 px-4 py-3">Keep the description current with blockers or new requirements.</li>
            </ul>
        </aside>
    </div>
</x-app-layout>