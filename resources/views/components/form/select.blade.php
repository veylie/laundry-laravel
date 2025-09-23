@props(['name', 'label' => null, 'name_column' => 'name', 'options' => [], 'selected' => null, 'extra' => null])

<div>
    @if($label)
        <label
            for="{{ $name }}"
            class="mb-1.5 block text-sm pt-4 font-medium text-gray-700 dark:text-gray-400"
        >
            {{ $label }}
        </label>
    @endif

    <div
        x-data="{ isOptionSelected: {{ $selected ? 'true' : 'false' }} }"
        class="relative z-20 bg-transparent"
    >
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $attributes }}
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 
                   dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border 
                   border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 
                   placeholder:text-gray-400 focus:ring-3 focus:outline-hidden 
                   dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
            @change="isOptionSelected = true"
        >
            <option value="">Select Option</option>

            @foreach($options as $option)
                <option
                    value="{{ $option->id }}"

                    @if($extra && isset($option->{$extra['field']})) data-{{ $extra['name'] }}="{{ $option->{$extra['field']} }}" @endif
                    @selected($selected == $option->id)
                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                >
                    {{ $option->{$name_column} }}
                </option>
            @endforeach
        </select>

        <span
            class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400"
        >
            <svg
                class="stroke-current"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </span>
    </div>
</div>