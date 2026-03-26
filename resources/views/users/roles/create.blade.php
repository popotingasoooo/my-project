<x-app-layout>
    <x-slot name="header"><h2>Create Role</h2></x-slot>
    <div class="py-12 max-w-2x1 mx-auto px-4">
        <div class="bg-white shadow rounded p-6">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Role Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border rounded px-3 py-2">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Permissions</label>
                    @foreach($permissions as $permission)
                    <label class="flex  items-center gap-2 mb-2">
                        <input type="checkbox" name="permissions[]"
                            value="{{ $permission->name }}"> {{ $permission->name }}
                    </label>
                    @endforeach
                </div>
                <button type="submit"
                        class="ml-3 bg-gray-200 px-6 py-1.5 rounded">Create Role</button>
                <a href="{{ route('roles.index') }}"
                    class="ml-3 bg-gray-200 px-6 py-2 rounded">Cancel</a>
            </form>
        </div>
    </div>
</x-app-layout>
