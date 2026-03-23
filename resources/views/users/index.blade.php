<x-app-layout>
    <x-slot name="header">
        <h2 class= "font-semibold text-xl text-gray-800">Users</h2>
    </x-slot>
    <div class ="py-12 max-w-7x1 mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
            </div>
        @endif
        <div class="bg-white shadow rounded-1g p-6">
           <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold">All Users</h3>
                <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+Create User</a> 
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
                            class="bg-yellow-400 text-white px-3 py-1 rounded">Edit</a>
                            <form action="{{route('users.destroy', $user)}}"
                                method="POST"
                                onsubmit="return confirm('Delete {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sx">Delete</button>
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

        {{-- Soft deleted users --}}
        @if($trashed->count() > 0)
        <div class="big-white shadow rounded p-6 mt-6">
            <h3 class="text-red-600 mb-4">Deleted Users</h3>
            <table class="w-full text-sm">
                @foreach ($trashed as $user)
                <tr class="border-t">
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td clasas="p-3">
                        <form action="{{ route('users.restore', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="bg-green-500 text-white px-3 py-1 rounded text-sx">Restore</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        @endif
    </div>
</x-app-layout>