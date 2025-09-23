<x-layouts.app :page="'orders'">
<x-partials.page-header title="Tambah Orders" :breadcrumbs="[
       ['label' => 'Order', 'route' => 'orders.index'],
       ['label' => 'Tambah Order']
   ]" />
    <form action="{{ route('orders.store') }}" method="post" x-data="orderForm()" @submit.prevent="submitForm">
      @csrf
   <div class="flex flex-wrap">
    <div class="w-full lg:w-1/2  p-4">
        <!-- Konten kiri -->
        <x-form.input name="order_code" label="Nomor Pesanan" :disabled="true" :value="$code" />
        <x-form.select name="id_customer" :name_column="'customer_name'" label="Customer" :options="$customers" />
        <x-form.select name="id_service" :name_column="'service_name'" label="Jenis Service" :extra="['name' => 'price', 'field' => 'price']" :options="$services" x-model="selectedService" />
    </div>
    <div class="w-full lg:w-1/2  p-4">
        <!-- Konten kanan -->
        <x-form.date-picker name="order_date" label="Tanggal Pesanan" />
        <x-form.date-picker name="due_date" label="Tanggal Selesai" />
        <x-form.text-area name="notes" label="Catatan" x-model="note" />
    </div>
   </div>

    
    <div class="px-4">
      <button type="button" 
          class="mb-4 px-4 py-2 text-brand-500 dark:text-white rounded" 
          @click="addRow">
          Tambah Service
      </button>

      <!-- Table pakai style komponen table -->
      <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="px-5 py-3 sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">No</p>
                </th>
                <th class="px-5 py-3 sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Service</p>
                </th>
                <th class="px-5 py-3 sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Qty</p>
                </th>
                <th class="px-5 py-3 sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Price</p>
                </th>
                <th class="px-5 py-3 sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Subtotal</p>
                </th>
                <th class="px-5 py-3 sm:px-6">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Action</p>
                </th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
              <template x-for="(item, index) in items" :key="index">
                <tr>
                  <td class="px-5 py-4 sm:px-6 text-center">
                    <p class="text-gray-800 dark:text-white/90" x-text="index + 1"></p>
                  </td>
                  <td class="px-5 py-4 sm:px-6">
                    <p class="text-gray-800 dark:text-white/90" x-text="item.name"></p>
                    <input type="hidden" :name="'id_service[]'" :value="item.id">
                    <input type="hidden" :name="'notes[]'" :value="item.note">
                  </td>
                  <td class="px-5 py-4 sm:px-6 text-center">
                    <input type="number" 
                           class="w-20 border rounded px-2 py-1 dark:bg-dark-900 dark:text-white/90"
                           min="1" step="1" x-model.number="item.qty"
                           @input="updateSubtotal(index)">
                  </td>
                  <td class="px-5 py-4 sm:px-6 text-center">
                    <p class="text-gray-800 dark:text-white/90">Rp <span x-text="formatPrice(item.price)"></span></p>
                  </td>
                  <td class="px-5 py-4 sm:px-6 text-center">
                    <p class="text-gray-800 dark:text-white/90">Rp <span x-text="formatPrice(item.subtotal)"></span></p>
                    <input type="hidden" :name="'subtotal[]'" :value="item.subtotal">
                  </td>
                  <td class="px-5 py-4 sm:px-6 text-center">
                    <button type="button" 
                        class="px-2 py-1 bg-red-600 text-white rounded"
                        @click="removeRow(index)">Hapus</button>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </div>

      <p class="mt-4 font-semibold text-gray-800 dark:text-white/90">
        Total: Rp <span x-text="formatPrice(total)"></span>
      </p>
      <input type="hidden" name="total" :value="total">
    </div>

    <div class="px-4 mt-4 flex gap-2">
      <button type="submit" class="px-4 py-2  !text-[#2d09f9]  dark:text-white rounded">Simpan</button>
      <button class="text-blue-400">lele</button>
    </div>
  </form>


  <script>
    function orderForm() {
      return {
        selectedService: '',
        note: '',
        items: [],
        total: 0,

        addRow() {
          if (!this.selectedService) {
            alert('Pilih service dulu!');
            return;
          }
          const option = document.querySelector(`#id_service option[value="${this.selectedService}"]`);
          const price = parseInt(option.dataset.price);
          const name = option.textContent;

          this.items.push({
            id: this.selectedService,
            name: name,
            qty: 1,
            price: price,
            subtotal: price,
            note: this.note
          });

          this.selectedService = '';
          this.note = '';
          this.updateTotal();
        },

        removeRow(index) {
          this.items.splice(index, 1);
          this.updateTotal();
        },

        updateSubtotal(index) {
          let item = this.items[index];
          item.subtotal = item.qty * item.price;
          this.updateTotal();
        },

        updateTotal() {
          this.total = this.items.reduce((sum, i) => sum + i.subtotal, 0);
        },

        formatPrice(value) {
          return new Intl.NumberFormat('id-ID').format(value);
        },

        submitForm(e) {
          e.target.submit();
        }
      }
    }
  </script>

</x-layouts.app>