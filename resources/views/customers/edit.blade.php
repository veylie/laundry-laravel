<x-layouts.app :page="'customers'">
<x-partials.page-header title="Edit Service" :breadcrumbs="[
       ['label' => 'Services', 'route' => 'customers.index'],
       ['label' => 'Edit']
   ]
   " />
<div
    class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
>
<div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3
                      class="text-base font-medium text-gray-800 dark:text-white/90"
                    >
                      Edit Customer
                    </h3>
</div>
<div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800" >
    <form action="{{ route('customers.update', $customer->id) }}" method="post">
         @csrf
         @method('PUT')
        <x-form.input name="customer_name" label="Name Customer" :value="$customer->customer_name" />
        <x-form.phone-input name="phone" prefiix-name="phone_prefix" number-name="phone_number" :value="$customer->phone" />
        <x-form.text-area name="address" label="Address" :value="$customer->address" ></x-form.text-area>
        <input class="inline-flex items-center gap-2 px-4 py-3 mt-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600" type="submit"></input>
    </form>
</div>
</div>

</x-layouts.app>