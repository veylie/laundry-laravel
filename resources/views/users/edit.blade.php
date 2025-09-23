<x-layouts.app >
<x-partials.page-header title="Edit User" :breadcrumbs="[
       ['label' => 'Users', 'route' => 'users.index'],
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
                      Tambah User
                    </h3>
</div>
<div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800" >
    <form action="{{ route('users.update', $user->id) }}" method="post">
         @csrf
         @method('PUT')
         <x-form.input name="name" label="Name" :value="$user->name" />
         <x-form.input name="email" label="Email" type="email" :value="$user->email" />
         <x-form.input name="password" label="Password" type="password" :value="$user->password" />
          <p class="text-sm text-gray-500 dark:text-gray-400">* Isi password apabila ingin merubah password</p>
         <x-form.select name="id_level" label="Select Level" :name_column="'level_name'" :options="$levels" :selected="$user->id_level" />
        <input class="inline-flex items-center gap-2 px-4 py-3 mt-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600" type="submit"></input>
    </form>
</div>
</div>

</x-layouts.app>