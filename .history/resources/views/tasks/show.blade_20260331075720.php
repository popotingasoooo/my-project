<x-app-layout>
    <x-slot name="header">Task Detail</x-slot>
    <div class="row">
        <div class="col-md-8">

            {{-- Task details --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <strong>{{ $task->title }}</strong>
                    @php
                        $priorityClass = match($task->priority) {
                            'high' => 'danger', 'medium' => 'warning', default => 'success'
                        };
                    @endphp
                    <span class="badge bg-{{ $priorityClass }}">{{ ucfirst($task->priority) }}</span>
                </div>
                <div class="card-body">
                    <p>{{ $task->description ?? 'No description.' }}</p>
                    <hr>
                    <div class="row text-sm">
                        <div class="col-md-4">
                            <div class="text-muted small">Status</div>
                            <span class="badge bg-primary">{{ ucfirst(str_replace('_',' ',$task->status)) }}</span>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Assigned to</div>
                            <div>{{ $task->assignee?->name ?? 'Unassigned' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Due date</div>
                            <div class="{{ $task->isOverdue() ? 'text-danger fw-bold' : '' }}">
                                {{ $task->due_date?->format('M d, Y') ?? 'No due date' }}
                                {{ $task->isOverdue() ? '— Overdue!' : '' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex gap-2">
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-secondary">
                        ← Back to Board
                    </a>
                    @can('manage-tasks')
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                          onsubmit="return confirm('Delete this task?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    @endcan
                </div>
            </div>

            {{-- Comments --}}
            <div class="card">
                <div class="card-header">
                    <strong>Comments ({{ $task->comments->count() }})</strong>
                </div>
                <div class="card-body">
                    @forelse($task->comments as $comment)
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <strong>{{ $comment->user->name }}</strong>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-2">{{ $comment->body }}</p>
                        @if(auth()->id() === $comment->user_id || auth()->user()->can('manage-tasks'))
                        <form action="{{ route('tasks.comments.destroy', [$task, $comment]) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete comment?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                        @endif
                    </div>
                    @empty
                    <p class="text-muted">No comments yet.</p>
                    @endforelse

                    {{-- Add comment form --}}
                    <form action="{{ route('tasks.comments.store', $task) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="mb-2">
                            <textarea name="body" rows="3" class="form-control"
                                      placeholder="Add a comment...">{{ old('body') }}</textarea>
                            @error('body')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <button class="btn btn-primary btn-sm">Add Comment</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>