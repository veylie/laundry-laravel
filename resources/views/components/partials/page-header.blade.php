<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
    {{ $title }}
  </h2>

  <nav>
    <ol class="flex items-center gap-1.5">
      {{-- Home --}}
      <li>
        <a
          class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
          href="{{ route($homeRoute) }}"
        >
          Home
          <svg
            class="stroke-current"
            width="17"
            height="16"
            viewBox="0 0 17 16"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366"
              stroke-width="1.2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </a>
      </li>

      {{-- Breadcrumb dinamis --}}
      @foreach ($breadcrumbs as $crumb)
        <li class="flex items-center gap-1.5">
          @if(isset($crumb['route']))
            <a 
              href="{{ route($crumb['route'], $crumb['params'] ?? []) }}" 
              class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
            >
              {{ $crumb['label'] }}
              <svg
                class="stroke-current"
                width="17"
                height="16"
                viewBox="0 0 17 16"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366"
                  stroke-width="1.2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>
          @else
            <span class="text-sm text-gray-800 dark:text-white/90">
              {{ $crumb['label'] }}
            </span>
          @endif
        </li>
      @endforeach
    </ol>
  </nav>
</div>
