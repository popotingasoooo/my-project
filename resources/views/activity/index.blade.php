<x-app-layout>
  <x-slot name="header"><h2>Activity Logs</h2></x-slot>
  <div class="py-12 max-w-6xl mx-auto px-4">
    <div class="bg-white shadow rounded p-6">
      <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[600px]">
          <thead class="bg-gray-100">
            <tr>
              <th class="text-left p-3">Date & Time</th>
              <th class="text-left p-3">User</th>
              <th class="text-left p-3">Action</th>
              <th class="text-left p-3">Subject</th>
              <th class="text-left p-3">Changes</th>
            </tr>
          </thead>
          <tbody>
            @foreach($logs as $log)
            <tr class="border-t hover:bg-gray-50">
              <td class="p-3 text-gray-500 whitespace-nowrap">
                {{ $log->created_at->format('M d, Y H:i') }}
              </td>
              <td class="p-3">
                {{ $log->causer ? $log->causer->name : 'System' }}
              </td>
              <td class="p-3">
                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                  {{ $log->description }}
                </span>
              </td>
              <td class="p-3 capitalize">
                {{ $log->subject_type ? class_basename($log->subject_type) : '-' }}
              </td>
              <td class="p-3 text-xs text-gray-500">
                @if($log->properties->has('attributes'))
                  @foreach($log->properties['attributes'] as $key => $value)
                    <span class="block"><b>{{ $key }}</b>: {{ $value }}</span>
                  @endforeach
                @else - @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="mt-4">{{ $logs->links() }}</div>
    </div>
  </div>
</x-app-layout>