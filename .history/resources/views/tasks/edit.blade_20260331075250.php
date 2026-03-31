<x-app-layout>
    <x-slot name="header">Edit Task</x-slot>
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $task->title) }}">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3"
                                      class="form-control">{{ old('description', $task->description) }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="todo" {{ $task->status=='todo'?'selected':'' }}>To Do</option>
                                    <option value="in_progress" {{ $task->status=='in_progress'?'selected':'' }}>In Progress</option>
                                    <option value="done" {{ $task->status=='done'?'selected':'' }}>Done</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-select">
                                    <option value="low" {{ $task->priority=='low'?'selected':'' }}>Low</option>
                                    <option value="medium" {{ $task->priority=='medium'?'selected':'' }}>Medium</option>
                                    <option value="high" {{ $task->priority=='high'?'selected':'' }}>High</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date"
                                       class="form-control"
                                       value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Assign To</label>
                            <select name="assigned_to" class="form-select">
                                <option value="">-- Unassigned --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary">Update Task</button>
                            <a href="{{ route('tasks.index') }}"
                               class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>