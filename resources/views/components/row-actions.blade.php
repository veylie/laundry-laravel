@props([
  'row',
  'routeName',
  'type' => 'master' 
])

{{-- EDIT (hanya untuk master) --}}
@if ($type === 'master')
  <a href="{{ route($routeName.'.edit', $row['id']) }}">
    <span class="text-blue-light-500 hover:underline mr-2">
      Edit
    </span>
  </a>
@endif



{{-- TAMBAHAN untuk ORDER --}}
@if ($type === 'orders')
  <form 
        method="POST" 
        class="inline ml-2">
    @csrf
    <button type="submit" class="text-brand-500 mr-2 hover:underline">
      Pickup
    </button>
  </form>

  <a " 
     target="_blank" 
     class="text-gray-600 dark:text-gray-400 hover:underline mr-2 ml-2">
    Print
  </a>
@endif

{{-- DELETE (selalu ada) --}}
<form action="{{ route($routeName.'.destroy', $row['id']) }}" 
      method="POST" 
      class="inline" 
      onsubmit="return confirm('Yakin hapus?')">
  @csrf
  @method('DELETE')
  <button type="submit" class="text-error-600 mr-2 hover:underline">
    Hapus
  </button>
</form>