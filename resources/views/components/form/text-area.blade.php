@props([
    'name',
    'label' => null,
    'value' => '',
    'placeholder' => '',
    'rows' => 4,
    'required' => false,
    'disabled' => false,
    'id' => null,
    'class' => '',
])

<div>
    @if ($label)
        <label for="{{ $id ?? $name }}" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 
               dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent 
               px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 
               focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 
               dark:placeholder:text-white/30 {{ $class }}"
    >{{ old($name, $value) }}</textarea>

    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>