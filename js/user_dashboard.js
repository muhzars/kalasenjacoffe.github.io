document.querySelectorAll('.sidebar-icon').forEach(icon => {
    icon.addEventListener('click', () => {
        const targetSection = icon.getAttribute('data-icon');

        // Reset semua ikon sidebar dan konten
        document.querySelectorAll('.sidebar-icon').forEach(el => {
            el.classList.remove('active');
        });
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });

        // Aktifkan ikon yang diklik dan tampilkan konten yang sesuai
        icon.classList.add('active');
        const sectionToShow = document.getElementById(targetSection);
        if (sectionToShow) {
            sectionToShow.classList.add('active');
        }

        // Tampilkan keranjang hanya di Home (Dashboard) untuk desktop
        const cartPanel = document.querySelector('.cart-panel');
        if (targetSection === 'dashboard') {
            cartPanel.classList.remove('hidden');
        } else {
            cartPanel.classList.add('hidden');
        }
    });
});

// Referensi elemen
const navItems = document.querySelectorAll('.nav-item');
const dishes = document.querySelectorAll('.dish-card');

// Tambahkan event listener ke setiap item navigasi
navItems.forEach(item => {
    item.addEventListener('click', (event) => {
        event.preventDefault(); // Hindari refresh halaman

        // Ambil kategori dari atribut data-category
        const category = item.getAttribute('data-category');

        // Tampilkan/hilangkan dish-card berdasarkan kategori
        dishes.forEach(dish => {
            if (category === 'All' || dish.getAttribute('data-category') === category) {
                dish.style.display = 'block'; // Tampilkan
            } else {
                dish.style.display = 'none'; // Sembunyikan
            }
        });

        // Update tampilan navigasi aktif
        navItems.forEach(nav => nav.classList.remove('active'));
        item.classList.add('active');
    });
});

// Element references
const addCartButtons = document.querySelectorAll('.add-cart-btn');
const cartItemsContainer = document.getElementById('cart-items');
const cartSubtotal = document.getElementById('cart-subtotal');
const customerPaymentInput = document.getElementById('customer-payment');
const changeAmount = document.getElementById('change-amount');
const paymentMethodSelect = document.getElementById('payment-method'); // Tambahan untuk metode pembayaran

// Elemen untuk mobile cart
const mobileCartBtn = document.getElementById('mobile-cart-btn'); // Tombol Cart untuk mobile
const mobileCartPage = document.getElementById('mobile-cart'); // Halaman Cart untuk mobile
const closeMobileCartBtn = document.getElementById('close-mobile-cart-btn'); // Tombol close cart
const mobileCartItemsContainer = document.getElementById('mobile-cart-items');
const mobileCartSubtotal = document.getElementById('mobile-cart-subtotal');

// Fungsi untuk menambahkan item ke cart
addCartButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        const dishCard = event.target.closest('.dish-card');
        const dishName = dishCard.querySelector('h3').textContent;
        const dishPrice = dishCard.querySelector('.price').textContent;
        const dishImg = dishCard.querySelector('.dish-img').src;

        const cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.innerHTML = `
            <img src="${dishImg}" alt="${dishName}">
            <div>
                <h4>${dishName}</h4>
                <p class="price">${dishPrice}</p>
            </div>
            <button class="remove-item-btn">
                <i class="ph ph-trash"></i>
            </button>
        `;
        cartItemsContainer.appendChild(cartItem);

        updateCartSubtotal(dishPrice);

        // Tampilkan tombol "Cart" pada mobile
        showMobileCartButton();

        // Menambahkan event listener untuk tombol hapus
        cartItem.querySelector('.remove-item-btn').addEventListener('click', () => {
            cartItem.remove(); // Hapus item dari cart
            updateCartSubtotalAfterRemoval(dishPrice); // Update subtotal setelah penghapusan
        });
    });
});

// Fungsi untuk mengupdate subtotal setelah item dihapus
function updateCartSubtotalAfterRemoval(price) {
    const currentSubtotal = parseInt(cartSubtotal.textContent.replace('Rp.', '').replace(',', '').trim()) || 0;
    const priceToRemove = parseInt(price.replace('Rp.', '').replace(',', '').trim()) || 0;
    const newSubtotal = currentSubtotal - priceToRemove;

    cartSubtotal.textContent = `Rp. ${newSubtotal.toLocaleString('id-ID')}`;
}

// Fungsi untuk menunjukkan tombol "Cart" pada mobile ketika ada item ditambahkan
function showMobileCartButton() {
    if (cartItemsContainer.children.length > 0) {
        mobileCartBtn.classList.remove('hidden'); // Tampilkan tombol Cart
    }
}

// Update subtotal
function updateCartSubtotal(price) {
    const currentSubtotal = parseInt(cartSubtotal.textContent.replace('Rp.', '').replace(',', '').trim()) || 0;
    const priceToAdd = parseInt(price.replace('Rp.', '').replace(',', '').trim()) || 0;
    const newSubtotal = currentSubtotal + priceToAdd;

    cartSubtotal.textContent = `Rp. ${newSubtotal.toLocaleString('id-ID')}`;
}

// Fungsi untuk menghitung kembalian
customerPaymentInput.addEventListener('input', () => {
    const subtotal = parseInt(cartSubtotal.textContent.replace('Rp.', '').replace(',', '').trim()) || 0;
    const payment = parseInt(customerPaymentInput.value.trim()) || 0;

    // Hitung kembalian
    const change = payment - subtotal;

    // Update tampilan kembalian
    if (change >= 0) {
        changeAmount.textContent = `Rp. ${change.toLocaleString('id-ID')}`;
    } else {
        changeAmount.textContent = 'Rp. 0'; // Tidak ada kembalian jika uang kurang
    }
});

// Fungsi checkout
document.querySelector('.checkout-btn').addEventListener('click', () => {
    const subtotal = parseInt(cartSubtotal.textContent.replace('Rp.', '').replace(',', '').trim());
    const payment = parseInt(customerPaymentInput.value.trim());
    const selectedPaymentMethod = paymentMethodSelect.value;

    if (!selectedPaymentMethod) {
        alert('Please select a payment method.');
        return;
    }

    if (payment >= subtotal) {
        alert(`Checkout successful using ${selectedPaymentMethod.toUpperCase()}! Change: ` + 
              `Rp. ${(payment - subtotal).toLocaleString('id-ID')}`);
        
        // Reset cart
        cartItemsContainer.innerHTML = '';
        cartSubtotal.textContent = 'Rp. 0';
        customerPaymentInput.value = '';
        changeAmount.textContent = 'Rp. 0';
        paymentMethodSelect.value = ''; // Reset metode pembayaran
    } else {
        alert('Insufficient payment. Please enter the correct amount.');
    }
});

// Fungsi untuk menunjukkan tombol "Cart" pada mobile ketika ada item ditambahkan
function showMobileCartButton() {
    if (cartItemsContainer.children.length > 0) {
        mobileCartBtn.classList.remove('hidden'); // Tampilkan tombol
    }
}

// Fungsi untuk menampilkan halaman Cart mobile
function updateMobileCart() {
    // Salin item dari cartItemsContainer ke mobileCartItemsContainer
    mobileCartItemsContainer.innerHTML = cartItemsContainer.innerHTML;
    mobileCartSubtotal.textContent = cartSubtotal.textContent;

    // Tambahkan event listener untuk tombol hapus di mobile cart
    const mobileRemoveButtons = mobileCartItemsContainer.querySelectorAll('.remove-item-btn');
    mobileRemoveButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const cartItem = event.target.closest('.cart-item');
            const dishPrice = cartItem.querySelector('.price').textContent;
            cartItem.remove(); // Hapus item dari mobile cart
            updateCartSubtotalAfterRemoval(dishPrice); // Update subtotal setelah penghapusan
        });
    });
}

// Tampilkan halaman Cart mobile ketika tombol "Cart" ditekan
mobileCartBtn.addEventListener('click', () => {
    updateMobileCart(); // Update cart mobile
    mobileCartPage.classList.add('active'); // Tampilkan halaman Cart
});

// Tutup halaman Cart mobile ketika tombol close ditekan
closeMobileCartBtn.addEventListener('click', () => {
    mobileCartPage.classList.remove('active'); // Sembunyikan halaman Cart
});

// Menambahkan event listener untuk perubahan status
const statusSelects = document.querySelectorAll('.status-select');

// Mengatur event listener untuk setiap select status
statusSelects.forEach(select => {
    select.addEventListener('change', (event) => {
        const selectedStatus = event.target.value;
        // Menampilkan status yang dipilih (optional, untuk debugging)
        console.log(`Status changed to: ${selectedStatus}`);
        
        // Jika Anda ingin melakukan sesuatu lebih lanjut dengan status yang dipilih (misalnya, mengirimnya ke server), lakukan di sini
        // Misalnya, mengupdate status di database atau API jika perlu.
    });
});

// Fungsi untuk mendapatkan waktu saat ini
function updateTimestamp() {
    const now = new Date();
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const formattedTime = now.toLocaleString('en-US', options);

    // Menampilkan waktu ke semua elemen dengan kelas "timestamp"
    const timestampElements = document.querySelectorAll('.timestamp');
    timestampElements.forEach((element) => {
        element.textContent = formattedTime;
    });
}

// Panggil fungsi saat halaman dimuat
updateTimestamp();

// Fungsi untuk memperbarui tampilan statistik dengan data yang diberikan
function updateStats(data) {
    if (data.totalEarnings) {
        document.getElementById('total-earnings').textContent = `Rp. ${data.totalEarnings.toLocaleString('id-ID')}`;
    }
    if (data.weeklySales) {
        document.getElementById('weekly-sales').textContent = `Rp. ${data.weeklySales.toLocaleString('id-ID')}`;
    }
    if (data.monthlySales) {
        document.getElementById('monthly-sales').textContent = `Rp. ${data.monthlySales.toLocaleString('id-ID')}`;
    }
    if (data.profit) {
        document.getElementById('profit').textContent = `Rp. ${data.profit.toLocaleString('id-ID')}`;
    }

    // Memperbarui laporan penjualan
    const reportBody = document.getElementById('sales-report-body');
    reportBody.innerHTML = '';

    if (data.salesReport && Array.isArray(data.salesReport)) {
        data.salesReport.forEach(report => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${report.date}</td>
                <td>Rp. ${report.sales.toLocaleString('id-ID')}</td>
                <td>Rp. ${report.profit.toLocaleString('id-ID')}</td>
            `;
            reportBody.appendChild(row);
        });
    }
}

// Panggil fungsi untuk memperbarui statistik setelah data diambil (misalnya dari API)
updateStats({
    totalEarnings: 5000000, 
    weeklySales: 1200000,
    monthlySales: 4500000,
    profit: 2000000,
    salesReport: [
        { date: '2024-11-01', sales: 500000, profit: 200000 },
        { date: '2024-11-02', sales: 450000, profit: 180000 },
        { date: '2024-11-03', sales: 300000, profit: 100000 },
        { date: '2024-11-04', sales: 700000, profit: 350000 },
    ]
});
