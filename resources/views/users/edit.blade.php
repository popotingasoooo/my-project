<x-app-layout>
    <x-slot name="header"><h2>Edit User</h2></x-slot>
    <div class="py-12 max-w-2x1 mx-auto px-4">
        <div class="bg-white shadow rounded p-6">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" name="name"
                        value="{{ old('name', $user->name) }}"
                        class="w-full border rounded px-3 py-2">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full border rounded px-3 py-2">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        New Password <span class="text-gray-400 text-xs">(leave blank to keep current)</span>
                    </label>
                    <input type="password" name="password"
                        class="w-full border rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border rounded px-3 py-2">
                </div>
                <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Role</label>
                <select name="role" class="w-full border rounded px-3 py-2">
                    <option value="staff" {{$user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="admin" {{$user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded">Update</button>
                    <a href="{{ route('users.index') }}"
                        class="bg-gray-200 px-6 py-2 rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>    