@props([
    'name' => 'phone', // Nama input akhir yang akan digabung dan disimpan di controller
    'label' => 'Phone Number',
    'prefixName' => 'phone_prefix',
    'numberName' => 'phone_number',
    'placeholder' => '81234567890',
    'required' => true,
    'prefixes' => [
        '+62' => '🇮🇩 ID',
        '+1' => '🇺🇸 US',
        '+44' => '🇬🇧 GB',
        '+60' => '🇲🇾 MY',
        '+65' => '🇸🇬 SG',
    ],
    'value' => null, // Nilai gabungan dari database, contoh: "+6281234567890"
])

@php
    $requiredAttr = $required ? 'required' : '';

    // Default values
    $defaultPrefix = '';
    $defaultNumber = '';

    // Parse 'value' jika diberikan, misalnya "+6281234567890"
    if ($value) {
        foreach ($prefixes as $prefix => $country) {
            if (str_starts_with($value, $prefix)) {
                $defaultPrefix = $prefix;
                $defaultNumber = substr($value, strlen($prefix));
                break;
            }
        }
    }

    // Final values for the form (prioritize old() input)
    $selectedPrefix = old($prefixName, $defaultPrefix);
    $enteredNumber = old($numberName, $defaultNumber);
@endphp

<div>
    @if ($label)
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>
    @endif

    <div class="flex">
        <!-- Select Prefix -->
        <select
            name="{{ $prefixName }}"
            class="rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm text-gray-700"
            {{ $requiredAttr }}
        >
            @foreach($prefixes as $code => $country)
                <option value="{{ $code }}" @selected($selectedPrefix === $code)>
                    {{ $country }} {{ $code }}
                </option>
            @endforeach
        </select>

        <!-- Phone Number -->
        <input
            type="tel"
            name="{{ $numberName }}"
            placeholder="{{ $placeholder }}"
            class="rounded-r-md border border-gray-300 w-full px-3 py-2 text-sm"
            {{ $requiredAttr }}
            value="{{ $enteredNumber }}"
        >
    </div>

    <small class="text-gray-500">Masukkan nomor tanpa angka 0 di depan (misal: 81234567890)</small>
</div>