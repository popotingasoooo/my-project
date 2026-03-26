@if(session('success'))
<div class="bg-green-100 border border-green-300 text-green-800
            px-4 py-3 rounded mb-4 flex justify-between items-center">
  <span>{{ session('success') }}</span>
  <button onclick="this.parentElement.remove()"
          class="text-green-500 font-bold text-lg leading-none">×</button>
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-300 text-red-800
            px-4 py-3 rounded mb-4 flex justify-between items-center">
  <span>{{ session('error') }}</span>
  <button onclick="this.parentElement.remove()"
          class="text-red-500 font-bold text-lg leading-none">×</button>
</div>
@endif

@if($errors->any())
<div class="bg-red-100 border border-red-300 text-red-800
            px-4 py-3 rounded mb-4">
  <ul class="list-disc list-inside text-sm">
    @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif