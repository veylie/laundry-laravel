@props(['value' => '',
'disabled' => false,
])

<label
                        class="mb-1.5 block text-sm pt-4 font-medium text-gray-700 dark:text-gray-400"
                      >
                        {{ $label }}
                      </label>
                    
                      <input
                        id="{{ $name }}"
                        type="{{ $type }}"
                        name="{{ $name }}"
                        value="{{ $value }}"
                        {{ $disabled ? 'disabled' : '' }}
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                      />