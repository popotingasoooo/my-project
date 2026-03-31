<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl">Dashboard</h2></x-slot>
  <div class="py-12">
    <div class="max-w-7xl mx-auto px-4">

      {{-- Stats Grid --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded p-6">
          <p class="text-sm text-gray-500">Total Users</p>
          <p class="text-4xl font-bold text-black">
            {{ \App\Models\User::count() }}
          </p>
        </div>
        <div class="bg-white shadow rounded p-6">
          <p class="text-sm text-gray-500">Total Roles</p>
          <p class="text-4xl font-bold text-black">
            {{ \Spatie\Permission\Models\Role::count() }}
          </p>
        </div>
        <div class="bg-white shadow rounded p-6">
          <p class="text-sm text-gray-500">Activity Logs</p>
          <p class="text-4xl font-bold text-black">
            {{ \Spatie\Activitylog\Models\Activity::count() }}
          </p>
        </div>
      </div>

      {{-- Recent Activity --}}
      @can('view-logs')
      <div class="bg-white shadow rounded p-6">
        <div class="flex justify-between mb-4">
          <h3 class="font-semibold text-lg">Recent Activity</h3>
          <a href="{{ route('activity.index') }}"
             class="text-sm text-black hover:underline">View all</a>
        </div>
        <table class="w-full text-sm">
          <thead class="bg-gray-50">
            <tr>
              <th class="text-left p-2">Time</th>
              <th class="text-left p-2">User</th>
              <th class="text-left p-2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach(\Spatie\Activitylog\Models\Activity::with('causer')
                        ->latest()->take(5)->get() as $log)
            <tr class="border-t">
              <td class="p-2 text-gray-400">
                {{ $log->created_at->diffForHumans() }}
              </td>
              <td class="p-2">{{ $log->causer?->name ?? 'System' }}</td>
              <td class="p-2">{{ $log->description }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endcan

    </div>
  </div>
</x-app-layout>