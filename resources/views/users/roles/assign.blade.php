<x-app-layout>
    <x-slot name="header"><h2>Assign Role to Users</h2></x-slot>
    <div class="py-12 max-w-xl mx-auto px-4">
        <div class="bg-white shadow rounded p-6">
            <x-flash-message />
            <form action="{{ route('roles.assign.post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Select User</label>
                    <select name="user_id" class="w-full border rounded px-3 py-2">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Assign Role</label>
                    <select name="role" class="w-full border rounded px-3 py-2">
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>  
                <button type="submit"
                    class="bg-purple-600 text-white px-6 py-2 rounded">Assign Role</button>
            </form>
        </div>
    </div>
</x-app-layout>