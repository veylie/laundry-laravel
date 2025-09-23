<x-layouts.app :page="'customers'">


   <x-partials.page-header title="Costumer Management" :breadcrumbs="[
       ['label' => 'Costumers']
   ]
   " />
    
   <div class=" py-2">
    <a
    href="{{ route('customers.create') }}"
    class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600"
    >
    Tambah
    </a>
  </div>
   <x-table :rows="$customers" :routeName="'customers'" actionComponent="row-actions" with-numbering="true">
    
</x-table>

@if(session('success'))
  <x-partials.alert 
      type="success" 
      title="Berhasil!" 
      :message="session('success')" :timeout="5000" />
@endif

@if(session('error'))
  <x-partials.alert 
      type="error" 
      title="Gagal!" 
      :message="session('error')" :timeout="5000" />
@endif

</x-layouts.app>