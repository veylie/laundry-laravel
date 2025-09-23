<script>
     // Isi Data Customer
        function fillCustomerData() {
            let select = document.getElementById("customerId");
            let option = select.options[select.selectedIndex];

            document.getElementById("customerPhone").value = option.getAttribute("data-phone") || "";
            document.getElementById("customerAddress").value = option.getAttribute("data-address") || "";
        };
        
</script>

    <script>
        const prices = @json($services->pluck('price','service_name'));
      let cart = [];
      let transactions =
        JSON.parse(localStorage.getItem("laundryTransactions")) || [];
      let transactionCounter = transactions.length + 1;

      function addService(serviceName, price) {
        document.getElementById("serviceType").value = serviceName;
        document.getElementById("serviceWeight").focus();
      }

      function addToCart() {
        const serviceType = document.getElementById("serviceType").value;
        const weight = parseFloat(
          document.getElementById("serviceWeight").value
        );
        const notes = document.getElementById("notes").value;

        if (!serviceType || !weight || weight <= 0) {
          alert("Mohon lengkapi semua field yang diperlukan!");
          return;
        }

        

        const price = prices[serviceType];
        const subtotal = price * weight;

        const item = {
          id: Date.now(),
          service: serviceType,
          weight: weight,
          price: price,
          subtotal: subtotal,
          notes: notes,
        };

        cart.push(item);
        updateCartDisplay();

        // Clear form
        document.getElementById("serviceType").value = "";
        document.getElementById("serviceWeight").value = "";
        document.getElementById("notes").value = "";
      }

      function updateCartDisplay() {
        const cartItems = document.getElementById("cartItems");
        const cartSection = document.getElementById("cartSection");
        const totalAmount = document.getElementById("totalAmount");

        if (cart.length === 0) {
          cartSection.style.display = "none";
          return;
        }

        cartSection.style.display = "block";

        let html = "";
        let total = 0;

        cart.forEach((item) => {
          html += `
                    <tr>
                        <td>${item.service}</td>
                        <td>${item.weight} ${
            item.service.includes("Sepatu")
              ? "pasang"
              : item.service.includes("Karpet")
              ? "m²"
              : "kg"
          }</td>
                        <td>Rp ${item.price.toLocaleString()}</td>
                        <td>Rp ${item.subtotal.toLocaleString()}</td>
                        <td>
                            <button class="btn btn-danger" onclick="removeFromCart(${
                              item.id
                            })" style="padding: 5px 10px; font-size: 12px;">
                                🗑️
                            </button>
                        </td>
                    </tr>
                `;
          total += item.subtotal;
        });

        cartItems.innerHTML = html;
        totalAmount.textContent = `Rp ${total.toLocaleString()}`;
      }

      function removeFromCart(itemId) {
        cart = cart.filter((item) => item.id !== itemId);
        updateCartDisplay();
      }

      function clearCart() {
        cart = [];
        updateCartDisplay();
        document.getElementById("transactionForm").reset();
      }

      async function processTransaction() {
        
        const customerName = document.getElementById("customerName").value;
        const customerPhone = document.getElementById("customerPhone").value;
        const customerAddress =
          document.getElementById("customerAddress").value;

        if (!customerName || !customerPhone || cart.length === 0) {
          alert(
            "Mohon lengkapi data pelanggan dan pastikan ada item di keranjang!"
          );
          return;
        }

        const total = cart.reduce((sum, item) => sum + item.subtotal, 0);

        const transaction = {
          id: `TRX-${transactionCounter.toString().padStart(3, "0")}`,
          customer: {
            name: customerName,
            phone: customerPhone,
            address: customerAddress,
          },
          items: [...cart],
          total: total,
          date: new Date().toISOString(),
          status: "pending",
        };

        // transactions.push(transaction);
        // localStorage.setItem(
        //   "laundryTransactions",
        //   JSON.stringify(transactions)
        // );

        transactionCounter++;

        // Show receipt
        showReceipt(transaction);

        // Clear form and cart
        clearCart();
        updateTransactionHistory();
        updateStats();

      }


      function showReceipt(transaction) {
        const receiptHtml = `
                <div class="receipt">
                    <div class="receipt-header">
                        <h2>🧺 LAUNDRY RECEIPT</h2>
                        <p>ID: ${transaction.id}</p>
                        <p>Tanggal: ${new Date(transaction.date).toLocaleString(
                          "id-ID"
                        )}</p>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <strong>Pelanggan:</strong><br>
                        ${transaction.customer.name}<br>
                        ${transaction.customer.phone}<br>
                        ${transaction.customer.address}
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <strong>Detail Pesanan:</strong><br>
                        ${transaction.items
                          .map(
                            (item) => `
                            <div class="receipt-item">
                                <span>${item.service} (${item.weight} ${
                              item.service.includes("Sepatu")
                                ? "pasang"
                                : item.service.includes("Karpet")
                                ? "m²"
                                : "kg"
                            })</span>
                                <span>Rp ${item.subtotal.toLocaleString()}</span>
                            </div>
                        `
                          )
                          .join("")}
                    </div>
                    
                    <div class="receipt-total">
                        <div class="receipt-item">
                            <span>TOTAL:</span>
                            <span>Rp ${transaction.total.toLocaleString()}</span>
                        </div>
                    </div>
                    
                    <div style="text-align: center; margin-top: 20px;">
                        <p>Terima kasih atas kepercayaan Anda!</p>
                        <p>Barang akan siap dalam 1-2 hari kerja</p>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 20px;">
                    <button class="btn btn-primary" onclick="printReceipt()">🖨️ Cetak Struk</button>
                    <button class="btn btn-success" onclick="closeModal()">✅ Selesai</button>
                </div>
            `;

        document.getElementById("modalContent").innerHTML = receiptHtml;
        document.getElementById("transactionModal").style.display = "block";
      }

      function printReceipt() {
        window.print();
      }

      function updateTransactionHistory() {
        const historyContainer = document.getElementById("transactionHistory");
        const recentTransactions = transactions.slice(-5).reverse();

        const html = recentTransactions
          .map(
            (transaction) => `
                <div class="transaction-item">
                    <h4>${transaction.id} - ${transaction.customer.name}</h4>
                    <p>📞 ${transaction.customer.phone}</p>
                    <p>🛍️ ${transaction.items
                      .map(
                        (item) =>
                          `${item.service} - ${item.weight}${
                            item.service.includes("Sepatu")
                              ? "pasang"
                              : item.service.includes("Karpet")
                              ? "m²"
                              : "kg"
                          }`
                      )
                      .join(", ")}</p>
                    <p>💰 Rp ${transaction.total.toLocaleString()}</p>
                    <p>📅 ${new Date(transaction.date).toLocaleString(
                      "id-ID"
                    )}</p>
                    <span class="status-badge status-${
                      transaction.status
                    }">${getStatusText(transaction.status)}</span>
                </div>
            `
          )
          .join("");

        historyContainer.innerHTML = html || "<p>Belum ada transaksi</p>";
      }

      function getStatusText(status) {
        const statusMap = {
          pending: "Menunggu",
          process: "Proses",
          ready: "Siap",
          delivered: "Selesai",
        };
        return statusMap[status] || status;
      }

      function updateStats() {
        const totalTransactions = transactions.length;
        const totalRevenue = transactions.reduce((sum, t) => sum + t.total, 0);
        const activeOrders = transactions.filter(
          (t) => t.status !== "delivered"
        ).length;
        const completedOrders = transactions.filter(
          (t) => t.status === "delivered"
        ).length;

        document.getElementById("totalTransactions").textContent =
          totalTransactions;
        document.getElementById(
          "totalRevenue"
        ).textContent = `Rp ${totalRevenue.toLocaleString()}`;
        document.getElementById("activeOrders").textContent = activeOrders;
        document.getElementById("completedOrders").textContent =
          completedOrders;
      }

      function showAllTransactions() {
        const allTransactionsHtml = `
                <h2>📋 Semua Transaksi</h2>
                <div style="max-height: 400px; overflow-y: auto;">
                    ${transactions
                      .map(
                        (transaction) => `
                        <div class="transaction-item">
                            <h4>${transaction.id} - ${
                          transaction.customer.name
                        }</h4>
                            <p>📞 ${transaction.customer.phone}</p>
                            <p>🛍️ ${transaction.items
                              .map(
                                (item) =>
                                  `${item.service} - ${item.weight}${
                                    item.service.includes("Sepatu")
                                      ? "pasang"
                                      : item.service.includes("Karpet")
                                      ? "m²"
                                      : "kg"
                                  }`
                              )
                              .join(", ")}</p>
                            <p>💰 Rp ${transaction.total.toLocaleString()}</p>
                            <p>📅 ${new Date(transaction.date).toLocaleString(
                              "id-ID"
                            )}</p>
                            <span class="status-badge status-${
                              transaction.status
                            }">${getStatusText(transaction.status)}</span>
                            <button class="btn btn-primary" onclick="updateTransactionStatus('${
                              transaction.id
                            }')" style="margin-top: 10px; padding: 5px 15px; font-size: 12px;">
                                📝 Update Status
                            </button>
                        </div>
                    `
                      )
                      .join("")}
                </div>
            `;

        document.getElementById("modalContent").innerHTML = allTransactionsHtml;
        document.getElementById("transactionModal").style.display = "block";
      }

      function showReports() {
        const today = new Date();
        const thisMonth = today.getMonth();
        const thisYear = today.getFullYear();

        const monthlyTransactions = transactions.filter((t) => {
          const tDate = new Date(t.date);
          return (
            tDate.getMonth() === thisMonth && tDate.getFullYear() === thisYear
          );
        });

        const monthlyRevenue = monthlyTransactions.reduce(
          (sum, t) => sum + t.total,
          0
        );

        const serviceStats = {};
        transactions.forEach((t) => {
          t.items.forEach((item) => {
            if (!serviceStats[item.service]) {
              serviceStats[item.service] = { count: 0, revenue: 0 };
            }
            serviceStats[item.service].count++;
            serviceStats[item.service].revenue += item.subtotal;
          });
        });

        const reportsHtml = `
                <h2>📈 Laporan Penjualan</h2>
                
                <div class="stats-grid" style="margin-bottom: 20px;">
                    <div class="stat-card">
                        <h3>${transactions.length}</h3>
                        <p>Total Transaksi</p>
                    </div>
                    <div class="stat-card">
                        <h3>${monthlyTransactions.length}</h3>
                        <p>Transaksi Bulan Ini</p>
                    </div>
                    <div class="stat-card">
                        <h3>Rp ${monthlyRevenue.toLocaleString()}</h3>
                        <p>Pendapatan Bulan Ini</p>
                    </div>
                </div>
                
                <h3>📊 Statistik Layanan</h3>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Jumlah Order</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${Object.entries(serviceStats)
                          .map(
                            ([service, stats]) => `
                            <tr>
                                <td>${service}</td>
                                <td>${stats.count}</td>
                                <td>Rp ${stats.revenue.toLocaleString()}</td>
                            </tr>
                        `
                          )
                          .join("")}
                    </tbody>
                </table>
            `;

        document.getElementById("modalContent").innerHTML = reportsHtml;
        document.getElementById("transactionModal").style.display = "block";
      }

      function manageServices() {
        const servicesHtml = `
                <h2>⚙️ Kelola Layanan</h2>
                <p>Fitur ini memungkinkan Anda mengelola jenis layanan dan harga.</p>
                
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Harga</th>
                            <th>Satuan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cuci Kering</td>
                            <td>Rp 5.000</td>
                            <td>per kg</td>
                            <td><span class="status-badge status-ready">Aktif</span></td>
                        </tr>
                        <tr>
                            <td>Cuci Setrika</td>
                            <td>Rp 7.000</td>
                            <td>per kg</td>
                            <td><span class="status-badge status-ready">Aktif</span></td>
                        </tr>
                        <tr>
                            <td>Setrika Saja</td>
                            <td>Rp 3.000</td>
                            <td>per kg</td>
                            <td><span class="status-badge status-ready">Aktif</span></td>
                        </tr>
                        <tr>
                            <td>Dry Clean</td>
                            <td>Rp 15.000</td>
                            <td>per kg</td>
                            <td><span class="status-badge status-ready">Aktif</span></td>
                        </tr>
                        <tr>
                            <td>Cuci Sepatu</td>
                            <td>Rp 25.000</td>
                            <td>per pasang</td>
                            <td><span class="status-badge status-ready">Aktif</span></td>
                        </tr>
                        <tr>
                            <td>Cuci Karpet</td>
                            <td>Rp 20.000</td>
                            <td>per m²</td>
                            <td><span class="status-badge status-ready">Aktif</span></td>
                        </tr>
                    </tbody>
                </table>
                
                <div style="text-align: center; margin-top: 20px;">
                    <button class="btn btn-primary" onclick="alert('Fitur akan segera tersedia!')">
                        ➕ Tambah Layanan Baru
                    </button>
                </div>
            `;

        document.getElementById("modalContent").innerHTML = servicesHtml;
        document.getElementById("transactionModal").style.display = "block";
      }

      function updateTransactionStatus(transactionId) {
        const transaction = transactions.find((t) => t.id === transactionId);
        if (!transaction) return;

        const statusOptions = [
          { value: "pending", text: "Menunggu" },
          { value: "process", text: "Sedang Proses" },
          { value: "ready", text: "Siap Diambil" },
          { value: "delivered", text: "Selesai" },
        ];

        const statusHtml = `
                <h2>📝 Update Status Transaksi</h2>
                <h3>${transaction.id} - ${transaction.customer.name}</h3>
                <p>Status saat ini: <span class="status-badge status-${
                  transaction.status
                }">${getStatusText(transaction.status)}</span></p>
                
                <div class="form-group">
                    <label>Pilih Status Baru:</label>
                    <select id="newStatus" style="width: 100%; padding: 10px; margin: 10px 0;">
                        ${statusOptions
                          .map(
                            (option) => `
                            <option value="${option.value}" ${
                              transaction.status === option.value
                                ? "selected"
                                : ""
                            }>
                                ${option.text}
                            </option>
                        `
                          )
                          .join("")}
                    </select>
                </div>
                
                <div style="text-align: center; margin-top: 20px;">
                    <button class="btn btn-success" onclick="saveStatusUpdate('${transactionId}')">
                        ✅ Simpan Update
                    </button>
                    <button class="btn btn-danger" onclick="closeModal()" style="margin-left: 10px;">
                        ❌ Batal
                    </button>
                </div>
            `;

        document.getElementById("modalContent").innerHTML = statusHtml;
        document.getElementById("transactionModal").style.display = "block";
      }

      function saveStatusUpdate(transactionId) {
        const newStatus = document.getElementById("newStatus").value;
        const transactionIndex = transactions.findIndex(
          (t) => t.id === transactionId
        );

        if (transactionIndex !== -1) {
          transactions[transactionIndex].status = newStatus;
          localStorage.setItem(
            "laundryTransactions",
            JSON.stringify(transactions)
          );
          updateTransactionHistory();
          updateStats();
          closeModal();
          alert("Status berhasil diupdate!");
        }
      }

      function closeModal() {
        document.getElementById("transactionModal").style.display = "none";
      }

      function formatNumber(input) {
        // Replace comma with dot for decimal separator
        let value = input.value.replace(",", ".");

        // Ensure only valid decimal number
        if (!/^\d*\.?\d*$/.test(value)) {
          value = value.slice(0, -1);
        }

        // Update input value
        input.value = value;
      }

      function parseDecimal(value) {
        // Handle both comma and dot as decimal separator
        return parseFloat(value.toString().replace(",", ".")) || 0;
      }

      // Initialize the application
      document.addEventListener("DOMContentLoaded", function () {
        updateTransactionHistory();
        updateStats();

        // Add event listener for weight input to handle decimal with comma
        const weightInput = document.getElementById("serviceWeight");
        weightInput.addEventListener("input", function () {
          formatNumber(this);
        });

        // Close modal when clicking outside
        window.onclick = function (event) {
          const modal = document.getElementById("transactionModal");
          if (event.target === modal) {
            closeModal();
          }
        };
      });

      // Update addToCart function to handle decimal with comma
      function addToCart() {
        const serviceType = document.getElementById("serviceType").value;
        const weightValue = document.getElementById("serviceWeight").value;
        const weight = parseDecimal(weightValue);
        const notes = document.getElementById("notes").value;

        if (!serviceType || !weightValue || weight <= 0) {
          alert("Mohon lengkapi semua field yang diperlukan!");
          return;
        }


        const price = prices[serviceType];
        const subtotal = price * weight;

        const item = {
          id: Date.now(),
          service: serviceType,
          weight: weight,
          price: price,
          subtotal: subtotal,
          notes: notes,
        };

        cart.push(item);
        updateCartDisplay();

        // Clear form
        document.getElementById("serviceType").value = "";
        document.getElementById("serviceWeight").value = "";
        document.getElementById("notes").value = "";
      }

      // Update cart display to show decimal properly
      function updateCartDisplay() {
        const cartItems = document.getElementById("cartItems");
        const cartSection = document.getElementById("cartSection");
        const totalAmount = document.getElementById("totalAmount");

        if (cart.length === 0) {
          cartSection.style.display = "none";
          return;
        }

        cartSection.style.display = "block";

        let html = "";
        let total = 0;

        cart.forEach((item) => {
          const unit = item.service.includes("Sepatu")
            ? "pasang"
            : item.service.includes("Karpet")
            ? "m²"
            : "kg";

          // Format weight to show decimal properly
          const formattedWeight =
            item.weight % 1 === 0
              ? item.weight.toString()
              : item.weight.toFixed(1).replace(".", ",");

          html += `
                    <tr>
                        <td>${item.service}</td>
                        <td>${formattedWeight} ${unit}</td>
                        <td>Rp ${item.price.toLocaleString()}</td>
                        <td>Rp ${item.subtotal.toLocaleString()}</td>
                        <td>
                            <button class="btn btn-danger" onclick="removeFromCart(${
                              item.id
                            })" style="padding: 5px 10px; font-size: 12px;">
                                🗑️
                            </button>
                        </td>
                    </tr>
                `;
          total += item.subtotal;
        });

        cartItems.innerHTML = html;
        totalAmount.textContent = `Rp ${total.toLocaleString()}`;
      }

      // Add some sample data for demonstration
      function addSampleData() {
        const sampleTransactions = [
          {
            id: "TRX-001",
            customer: {
              name: "John Doe",
              phone: "0812-3456-7890",
              address: "Jl. Merdeka 123",
            },
            items: [
              {
                service: "Cuci Setrika",
                weight: 2.5,
                price: 7000,
                subtotal: 17500,
              },
            ],
            total: 17500,
            date: new Date().toISOString(),
            status: "process",
          },
          {
            id: "TRX-002",
            customer: {
              name: "Jane Smith",
              phone: "0813-7654-3210",
              address: "Jl. Sudirman 456",
            },
            items: [
              {
                service: "Cuci Kering",
                weight: 3,
                price: 5000,
                subtotal: 15000,
              },
            ],
            total: 15000,
            date: new Date(Date.now() - 3600000).toISOString(),
            status: "ready",
          },
        ];

        if (transactions.length === 0) {
          transactions = sampleTransactions;
          localStorage.setItem(
            "laundryTransactions",
            JSON.stringify(transactions)
          );
          transactionCounter = transactions.length + 1;
        }
      }

      // Initialize with sample data
    //   addSampleData();
    </script>