<x-app-layout>
    <x-slot name="header">
        <h2 class= "font-semibold text-xl text-gray-200">Users</h2>
    </x-slot>
    <div class ="py-12 max-w-7x1 mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-gray-200 text-black p-3 rounded mb-4">
            {{ session('success') }}
            </div>
        @endif
        <div class="bg-white shadow rounded-1g p-6">
           <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold">All Users</h3>
                <a href="{{ route('users.create') }}" class="bg-gray-200 text-black px-4 py-2 rounded">+ Create User</a> 
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">Name</th>
                        <th class="text-left p-4">Email</th>
                        <th class="text-left p-4">Role</th>
                        <th class="text-left p-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-t">
                        <td class="p-4">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4 capitalize">{{ $user->role }}</td>
                        <td class="p-4 flex gap-2">
                            @can('manage-users')
                            <a href="{{ route('users.edit', $user) }}"
                            class="bg-gray-200 text-black px-3 py-1 rounded">Edit</a>
                            <form action="{{route('users.destroy', $user)}}"
                                method="POST"
                                onsubmit="return confirm('Delete {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                            <button class="bg-gray-200 text-black px-3 py-1 rounded text-sx">Delete</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>

            <form method="GET" action="{{ route('users.index') }}"
                    class="flex gap-3 mb-4">
                <input type="text" name="search" placeholder="Search by name or email..."
                    value="{{ request('search') }}"
                    class="border rounded px-3 py-2 flex-1 text-sm">
                <select name="role" class="border rounded px3-py-2 text-sm">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
                <button type="submit"
                    class="bg-gray-200 text-black px-4 py-2 rounded text-sm">Filter</button>
                <a href="{{ route('users.index') }}"
                    class="bg-gray-200 text-black px-4 py-5 rounded text-sm">Clear</a>
            </form>

        {{-- Soft deleted users --}}
        @if($trashed && $trashed->count() > 0)
        <div class="bg-white shadow rounded p-6 mt-6">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th colspan="3" class="text-left p-4 text-lg font-semibold">Deleted Users</th>
                    </tr>
                    <tr>
                        <th class="text-left p-4">Name</th>
                        <th class="text-left p-4">Email</th>
                        <th class="text-left p-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($trashed as $user)
                <tr class="border-t">
                    <td class="p-4">{{ $user->name }}</td>
                    <td class="p-4">{{ $user->email }}</td>
                    <td class="p-4">
                        <form action="{{ route('users.restore', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="bg-gray-200 text-black px-3 py-1 rounded text-sx">Restore</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-app-layout>