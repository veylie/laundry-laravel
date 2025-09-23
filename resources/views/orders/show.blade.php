<x-layouts.app :page="'orders'">
    <x-partials.page-header title="Detail Order" :breadcrumbs="[
        ['label' => 'Order', 'route' => 'orders.index'],
        ['label' => 'Detail Order']
    ]
    " />
    <div class=" py-2">
        <a
        href="{{ route('orders.index') }}"
        class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600"
        >
        Kembali
        </a>
      </div>

      <div class="overflow-hidden rounded-xl p-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="d-flex justify-content-between">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Detail Order {{ $order->order_code }}</h3>
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90"> Status : {{ $order->order_status == 1 ? 'pickup' : 'proses' }}</h3>
        </div>
        <div class="d-flex justify-content-between">
            <div class="kri">

                <p class="text-sm text-brand-600"> {{ $customer->customer_name }} </p>
                <p class="text-sm text-gray-800 dark:text-white/90"> {{ $customer->phone }} </p>
                <p class="text-sm text-gray-800 dark:text-white/90"> {{ $customer->address }} </p>
            </div>
            <div class="kanan">
               <p>Tanggal Order : {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</p>
                <p>Tanggal Selesai : {{ \Carbon\Carbon::parse($order->order_end_date)->format('d/m/Y') }}</p>
            </div>
        </div>
    <x-table :rows="$orderDetail" :routeName="'orders'"  >
    </x-table>
    <form action="{{ route('orders.complete', $order->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <div 
        x-data="{
            total: {{ $order->total }},
            pay: 0,
            formattedPay: '',
            get change() {
                return this.pay >= this.total ? this.pay - this.total : 0;
            },
            formatPay(e) {
                let raw = e.target.value.replace(/[^\d]/g, '');
                this.pay = Number(raw);
                this.formattedPay = raw 
                    ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(this.pay) 
                    : '';
            }
        }"
        class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6"
    >
        {{-- Ringkasan Pembayaran --}}
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 dark:bg-white/[0.05] dark:border-gray-700">
            <h4 class="text-lg font-semibold mb-4">Ringkasan Pembayaran</h4>

            {{-- Total --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-white">Total Harga</label>
                <div class="mt-1 text-lg font-bold text-brand-600">
                    Rp. {{ number_format($order->total, 0, ',', '.') }}
                </div>
            </div>

            @if($order->order_status == 0)
                {{-- Input Uang Bayar --}}
                <div class="mb-4">
                    <label for="order_pay_display" class="block text-sm font-medium text-gray-700 dark:text-white">Uang Bayar</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input
                            type="text"
                            x-model="formattedPay"
                            @input="formatPay($event)"
                            id="order_pay_display"
                            inputmode="numeric"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            placeholder="Rp. 0"
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                    </div>

                    {{-- Hidden input for submission --}}
                    <input type="hidden" name="order_pay" :value="pay">
                </div>

                {{-- Output Kembalian --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">Kembalian</label>
                    <div class="form-input block w-full sm:text-sm border border-gray-300 rounded-md text-end bg-gray-100 px-4 py-2.5">
                        <span x-text="pay >= total ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(change) : '-'"></span>
                    </div>
                </div>
            @else
                {{-- Jika sudah dibayar --}}
                <div class="mb-2 flex justify-between">
                    <span class="text-sm font-medium text-gray-700 dark:text-white">Dibayar</span>
                    <span class="text-sm font-bold text-green-600">Rp. {{ number_format($order->order_pay, 0, ',', '.') }}</span>
                </div>
                <div class="mb-2 flex justify-between">
                    <span class="text-sm font-medium text-gray-700 dark:text-white">Kembalian</span>
                    <span class="text-sm text-gray-500">Rp. {{ number_format($order->order_change, 0, ',', '.') }}</span>
                </div>
            @endif
        </div>

        {{-- Tombol Aksi --}}
         {{-- && (auth()->user()->isAdmin() || auth()->user()->isOperator()) --}}
        @if ($order->order_status == 0)
            <div class="flex items-end justify-end">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                    <i class="bi bi-check-circle-fill me-1"></i> Selesaikan Transaksi
                </button>
            </div>
        @endif
    </div>
</form>



</div>
{{-- @dd($order) --}}
{{-- @dd($orderDetail) --}}

</x-layouts.app>