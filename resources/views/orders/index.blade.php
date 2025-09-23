<x-layouts.app :page="'orders'">
     <x-partials.page-header title="Orders" :breadcrumbs="[
       ['label' => 'Order']
   ]
   " />
   <div class=" py-2">
    <a
    href="{{ route('orders.create') }}"
    class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600"
    >
    Tambah Order
    </a>
  </div>
   <x-table :rows="$orders" :routeName="'orders'" actionComponent="row-actions" with-numbering="true">
    
</x-table>
</x-layouts.app>