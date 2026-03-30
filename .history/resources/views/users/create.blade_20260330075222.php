<x-app-layout>
    <x-slot name="header"><h2 class= "font-semibold text-xl text-gray-800">Create User</h2></x-slot>
    <div class="py-12 max-w-2x1 mx-auto px-4">
        <div class="bg-white shadow rounded p-6">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Name*</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border rounded px-3 py-2">
                    @error('name')<p class="text-black text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Email*</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border rounded px-3 py-2">
                    @error('email')<p class="text-black text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Role</label>
                    <select name="role" class="w-full border rounded px-3 py-2">
                        @forelse($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @empty
                            <option disabled>No roles available</option>
                        @endforelse
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-gray-200 text-black px-6 py-2 rounded">Create</button>
                    <a href="{{ route('users.index') }}"
                        class="bg-gray-200 text-black px-6 py-2 rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>    