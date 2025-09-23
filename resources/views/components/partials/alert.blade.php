@props([
    'type' => 'success',  {{-- success | error | warning | info --}}
    'title' => null,
    'message' => null,
    'timeout' => 3000,
])

@php
    $styles = [
        'success' => [
            'border' => 'border-success-500',
            'bg' => 'bg-success-50 dark:bg-success-500/15',
            'iconColor' => 'text-success-500',
            'icon' => '
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.7 12c0-4.58 3.72-8.3 8.3-8.3s8.3 3.72 8.3 8.3-3.72 8.3-8.3 8.3-8.3-3.72-8.3-8.3ZM12 1.9A10.1 10.1 0 1 0 22.1 12 10.11 10.11 0 0 0 12 1.9Zm3.62 8.84a.75.75 0 0 0-1.06-1.06l-3.17 3.16-1.54-1.54a.75.75 0 0 0-1.06 1.06l2.17 2.17a.75.75 0 0 0 1.06 0l3.6-3.6Z" />',
        ],
        'error' => [
            'border' => 'border-error-500',
            'bg' => 'bg-error-50 dark:bg-error-500/15',
            'iconColor' => 'text-error-500',
            'icon' => '
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M20.35 12c0 4.61-3.74 8.35-8.35 8.35S3.65 16.61 3.65 12 7.39 3.65 12 3.65 20.35 7.39 20.35 12ZM12 22.15c5.61 0 10.15-4.54 10.15-10.15S17.61 1.85 12 1.85 1.85 6.39 1.85 12 6.39 22.15 12 22.15Zm1  -5.67c0-.55-.45-1-1-1s-1 .45-1 1 .45 1 1 1 1-.45 1-1ZM12.75 7.38v5.68a.75.75 0 0 1-1.5 0V7.38a.75.75 0 0 1 1.5 0Z" fill="#F04438" />',
        ],
        'warning' => [
            'border' => 'border-yellow-500',
            'bg' => 'bg-yellow-50 dark:bg-yellow-500/15',
            'iconColor' => 'text-yellow-500',
            'icon' => '
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm.75 14.5h-1.5v-1.5h1.5v1.5Zm0-3h-1.5v-6h1.5v6Z" />',
        ],
        'info' => [
            'border' => 'border-blue-500',
            'bg' => 'bg-blue-50 dark:bg-blue-500/15',
            'iconColor' => 'text-blue-500',
            'icon' => '
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm.75 14.5h-1.5v-6h1.5v6Zm0-8h-1.5V7h1.5v1.5Z" />',
        ],
    ];

    $style = $styles[$type] ?? $styles['success'];
@endphp

<div
    x-data="{ show: true }" 
    x-show="show" 
    x-transition 
    x-init="setTimeout(() => show = false, {{ $timeout }})"
    class="rounded-xl border {{ $style['border'] }} {{ $style['bg'] }} p-4 mt-2">
<div class="flex items-start gap-3">
    {{-- Icon --}}
    <div class="-mt-0.5 {{ $style['iconColor'] }}">
      <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
           xmlns="http://www.w3.org/2000/svg">
        {!! $style['icon'] !!}
      </svg>
    </div>

    {{-- Content --}}
    <div>
      @if($title)
        <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
          {{ $title }}
        </h4>
      @endif

      @if($message)
        <p class="text-sm text-gray-500 dark:text-gray-400">
          {{ $message }}
        </p>
      @endif
    </div>
  </div>
</div>
