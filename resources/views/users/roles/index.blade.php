<x-app-layout>
    <x-slot name="header"><h2>Roles and Permissions</h2></x-slot>
    <div class="py-12 max-w-5x1 mx-auto px-4">
        <x-flash-message />
        @can('manage-roles')
        <div class="flex gap-3 mb-4">
            <a href="{{ route('roles.create') }}"
                class="bg-gray-200 text-black px-4 py-2 rounded">+ New Role</a>
            <a href="{{ route('roles.assign') }}"
                class="bg-gray-200 text-black px-4 py-2 rounded">Assign Roles</a>
        </div>
        @endcan
        <div class="bg-white shadow rounded p-6">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p3">Role</th>
                        <th class="text-left p3">Permissions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr class="border-t">
                        <td class="p-3 font-medium capitalize">{{ $role->name }}</td>
                        <td class="p-3">
                            @foreach($role->permissions as $perm)
                            <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs mr-1 mb-1">
                                {{ $perm->name }}
                            </span>
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>