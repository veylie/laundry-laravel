<x-layouts.app :page="'users'">
<x-partials.page-header title="Tambah User" :breadcrumbs="[
       ['label' => 'Users', 'route' => 'users.index'],
       ['label' => 'Tambah']
   ]
   " />
<div
    class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
>
<div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3
                      class="text-base font-medium text-gray-800 dark:text-white/90"
                    >
                      Tambah User
                    </h3>
</div>
<div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800" >
    <form action="{{ route('users.store') }}" method="post">
         @csrf
         <x-form.input name="name" label="Name" />
         <x-form.input name="email" label="Email" type="email" />
         <x-form.input name="password" label="Password" type="password" />
         <x-form.select name="id_level" label="Select Level" :name_column="'level_name'" :options="$levels" :selected="old('id_level')"  />
        <input class="inline-flex items-center gap-2 px-4 py-3 mt-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600" type="submit"></input>
    </form>
</div>
</div>

</x-layouts.app>