<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pesanan</title>
    <!-- Link Bootstrap untuk tampilan yang lebih baik -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .content {
            margin-top: 30px;
        }
        table th, table td {
            vertical-align: middle;
        }
        .btn-confirm {
            font-size: 16px;
        }
        .order-summary {
            margin-top: 20px;
        }
        .order-summary td {
            font-weight: bold;
        }
        .order-summary td:last-child {
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <div class="container content">
        <h2>Detail Pembayaran Pesanan</h2>
        <hr class="bg-dark">
        
        <div class="mb-3">
            <button onclick="window.history.back();" class="btn btn-info">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
        </div>

        <!-- Data Pesanan -->
        <table class="table table-bordered">
            <tr>
                <th>Nama Pelanggan</th>
                <td id="customer-name">John Doe</td>
            </tr>
            <tr>
                <th>Nomor Pesanan</th>
                <td id="order-id">#ORD12345</td>
            </tr>
            <tr>
                <th>Daftar Item</th>
                <td id="order-items">
                    <ul>
                        <li>Espresso (x2)</li>
                        <li>Cappuccino (x1)</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <th>Total Harga</th>
                <td id="total-price">Rp 120,000</td>
            </tr>
            <tr>
                <th>Status Pesanan</th>
                <td id="order-status">OPEN</td>
            </tr>
            <tr>
                <th>Pilih Metode Pembayaran</th>
                <td>
                    <select name="payment_method" id="payment-method" required>
                        <option value="qris">QRIS</option>
                        <option value="bca">BCA</option>
                        <option value="tunai">Tunai</option>
                    </select>
                </td>
            </tr>
        </table>

        <!-- Tombol Konfirmasi Pembayaran -->
        <div class="text-center">
            <button type="submit" class="btn btn-success btn-confirm">
                <i class="fa fa-check"></i> Oke, Konfirmasi Pembayaran
            </button>
        </div>

    </div>

    <!-- JavaScript -->
    <script>
        document.querySelector('.btn-confirm').addEventListener('click', function(event) {
            event.preventDefault();  // Mencegah pengiriman form langsung

            // Ambil data dari form dan tabel
            const paymentMethod = document.getElementById('payment-method').value;
            const customerName = document.getElementById('customer-name').textContent;
            const orderId = document.getElementById('order-id').textContent;
            const totalPrice = document.getElementById('total-price').textContent;

            // Menampilkan konfirmasi pembayaran
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Pesanan untuk ${customerName} (Nomor Pesanan: ${orderId}) dengan total harga ${totalPrice} akan dibayar menggunakan ${paymentMethod}.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan!',
                cancelButtonText: 'Tidak, periksa lagi',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, tampilkan pesan sukses
                    Swal.fire('Pembayaran Berhasil!', 'Pesanan Anda telah diproses.', 'success');
                } else {
                    // Jika batal
                    Swal.fire('Dibatalkan', 'Silakan periksa kembali data pesanan Anda.', 'info');
                }
            });
        });
    </script>

</body>
</html>
