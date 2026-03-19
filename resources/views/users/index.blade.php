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
                            <a href="{{ route('users.edit', $user) }}"
                            class="bg-yellow-400 text-white px-3 py-1 rounded">Edit</a>
        