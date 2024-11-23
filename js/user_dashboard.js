class Application {
    constructor() {
        // Properti utama
        this.cartItems = [];
        this.cartSubtotal = 0;
        this.selectedServiceType = null;
        this.selectedPaymentMethod = null;

        // Elemen DOM
        this.cartItemsContainer = document.getElementById('cart-items');
        this.cartSubtotalElement = document.getElementById('cart-subtotal');
        this.customerPaymentInput = document.getElementById('customer-payment');
        this.changeAmountElement = document.getElementById('change-amount');
        this.paymentMethodSelect = document.getElementById('payment-method');
        this.mobileCartBtn = document.getElementById('mobile-cart-btn');
        this.mobileCartPage = document.getElementById('mobile-cart');
        this.closeMobileCartBtn = document.getElementById('close-mobile-cart-btn');
        this.mobileCartItemsContainer = document.getElementById('mobile-cart-items');
        this.mobileCartSubtotal = document.getElementById('mobile-cart-subtotal');

        // Inisialisasi
        this.init();
    }

    init() {
        this.setupSidebarNavigation();
        this.setupCategoryFilter();
        this.setupCartActions();
        this.setupServiceTypeSelection();
        this.setupPaymentMethodSelection();
        this.setupCheckout();
        this.setupChangeCalculation();
        this.setupMobileCartButton();
        this.updateTimestamp();
        this.loadStatistics();
        this.setupMobileNavbar();
    }

    // Sidebar Navigation
    setupSidebarNavigation() {
        document.querySelectorAll('.sidebar-icon').forEach(icon => {
            icon.addEventListener('click', () => {
                const targetSection = icon.getAttribute('data-icon');

                document.querySelectorAll('.sidebar-icon').forEach(el => el.classList.remove('active'));
                document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));

                icon.classList.add('active');
                const sectionToShow = document.getElementById(targetSection);
                if (sectionToShow) sectionToShow.classList.add('active');

                // Tampilkan/ sembunyikan cart panel
                const cartPanel = document.querySelector('.cart-panel');
                cartPanel.classList.toggle('hidden', targetSection !== 'dashboard');
            });
        });
    }
    // Navbar Mobile
    setupMobileNavbar() {
        document.querySelectorAll('.mobile-icon').forEach(icon => {
            icon.addEventListener('click', () => {
                const targetSection = icon.getAttribute('data-icon');

                // Reset semua mobile ikon dan konten
                document.querySelectorAll('.mobile-icon').forEach(el => el.classList.remove('active'));
                document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));

                // Aktifkan mobile ikon yang dipilih
                icon.classList.add('active');

                // Tampilkan konten yang sesuai
                const sectionToShow = document.getElementById(targetSection);
                if (sectionToShow) sectionToShow.classList.add('active');
            });
        });
    }

    // Filter Kategori
    setupCategoryFilter() {
        const navItems = document.querySelectorAll('.nav-item');
        const dishes = document.querySelectorAll('.dish-card');

        navItems.forEach(item => {
            item.addEventListener('click', (event) => {
                event.preventDefault();
                const category = item.getAttribute('data-category');

                dishes.forEach(dish => {
                    dish.style.display = category === 'All' || dish.getAttribute('data-category') === category ? 'block' : 'none';
                });

                navItems.forEach(nav => nav.classList.remove('active'));
                item.classList.add('active');
            });
        });
    }

    // Keranjang Belanja
    setupCartActions() {
        const addCartButtons = document.querySelectorAll('.add-cart-btn');

        addCartButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const dishCard = event.target.closest('.dish-card');
                const dishName = dishCard.querySelector('h3').textContent;
                const dishPrice = parseInt(dishCard.querySelector('.price').textContent.replace('Rp.', '').replace(',', '').trim());
                const dishImg = dishCard.querySelector('.dish-img').src;

                const item = { name: dishName, price: dishPrice, img: dishImg };
                this.cartItems.push(item);
                this.renderCartItem(this.cartItemsContainer, item);
                this.updateCartSubtotal(dishPrice);

                this.showMobileCartButton();
            });
        });
    }

    renderCartItem(container, item) {
        const cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.innerHTML = `
            <img src="${item.img}" alt="${item.name}">
            <div>
                <h4>${item.name}</h4>
                <p class="price">Rp. ${item.price.toLocaleString('id-ID')}</p>
            </div>
            <button class="remove-item-btn"><i class="ph ph-trash"></i></button>
        `;
        container.appendChild(cartItem);

        cartItem.querySelector('.remove-item-btn').addEventListener('click', () => {
            container.removeChild(cartItem);
            this.removeCartItem(item.price);
        });
    }

    updateCartSubtotal(amount) {
        this.cartSubtotal += amount;
        this.cartSubtotalElement.textContent = `Rp. ${this.cartSubtotal.toLocaleString('id-ID')}`;
        this.mobileCartSubtotal.textContent = this.cartSubtotalElement.textContent;
    }

    removeCartItem(amount) {
        this.cartSubtotal -= amount;
        this.cartSubtotalElement.textContent = `Rp. ${this.cartSubtotal.toLocaleString('id-ID')}`;
        this.mobileCartSubtotal.textContent = this.cartSubtotalElement.textContent;
    }

    // Pilihan Service Type
    setupServiceTypeSelection() {
        document.querySelectorAll('.payment-option[data-type]').forEach(option => {
            option.addEventListener('click', () => {
                const serviceType = option.getAttribute('data-type');
                this.toggleSelection(option, serviceType, 'selectedServiceType');
            });
        });
    }

    // Pilihan Payment Method
    setupPaymentMethodSelection() {
        document.querySelectorAll('.payment-option[data-method]').forEach(option => {
            option.addEventListener('click', () => {
                const paymentMethod = option.getAttribute('data-method');
                this.toggleSelection(option, paymentMethod, 'selectedPaymentMethod');
            });
        });
    }

    toggleSelection(option, value, stateKey) {
        if (this[stateKey] === value) {
            this[stateKey] = null;
            option.classList.remove('active');
        } else {
            this[stateKey] = value;
            document.querySelectorAll(`.payment-option[data-${stateKey === 'selectedServiceType' ? 'type' : 'method'}]`).forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
        }
    }

    // Checkout
    setupCheckout() {
        document.querySelector('.checkout-btn').addEventListener('click', () => {
            const payment = parseInt(this.customerPaymentInput.value.trim()) || 0;

            if (!this.selectedServiceType || !this.selectedPaymentMethod) {
                alert('Please select both Service Type and Payment Method.');
                return;
            }

            if (payment >= this.cartSubtotal) {
                const change = payment - this.cartSubtotal;
                alert(`Checkout successful! Change: Rp. ${change.toLocaleString('id-ID')}`);
                this.resetCart();
            } else {
                alert('Insufficient payment. Please enter the correct amount.');
            }
        });
    }

    // Perhitungan Kembalian
    setupChangeCalculation() {
        this.customerPaymentInput.addEventListener('input', () => {
            const payment = parseInt(this.customerPaymentInput.value.trim()) || 0;
            const change = payment - this.cartSubtotal;

            this.changeAmountElement.textContent = change >= 0 ? `Rp. ${change.toLocaleString('id-ID')}` : 'Rp. 0';
        });
    }

    // Mobile Cart Button
    setupMobileCartButton() {
        this.mobileCartBtn.addEventListener('click', () => {
            this.mobileCartPage.classList.add('active');
        });

        this.closeMobileCartBtn.addEventListener('click', () => {
            this.mobileCartPage.classList.remove('active');
        });
    }

    showMobileCartButton() {
        if (this.cartItemsContainer.children.length > 0) {
            this.mobileCartBtn.classList.remove('hidden');
        } else {
            this.mobileCartBtn.classList.add('hidden');
        }
    }

    resetCart() {
        this.cartItems = [];
        this.cartSubtotal = 0;
        this.cartItemsContainer.innerHTML = '';
        this.cartSubtotalElement.textContent = 'Rp. 0';
        this.mobileCartItemsContainer.innerHTML = '';
        this.mobileCartSubtotal.textContent = 'Rp. 0';
        this.customerPaymentInput.value = '';
        this.changeAmountElement.textContent = 'Rp. 0';
        this.selectedServiceType = null;
        this.selectedPaymentMethod = null;
        document.querySelectorAll('.payment-option').forEach(option => option.classList.remove('active'));
    }

    // Timestamp
    updateTimestamp() {
        const now = new Date();
        const formattedTime = now.toLocaleString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });

        document.querySelectorAll('.timestamp').forEach(element => {
            element.textContent = formattedTime;
        });
    }

    // Statistik
    loadStatistics() {
        this.updateStats({
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
    }

    updateStats(data) {
        const updateStat = (id, value) => {
            document.getElementById(id).textContent = `Rp. ${value.toLocaleString('id-ID')}`;
        };

        updateStat('total-earnings', data.totalEarnings);
        updateStat('weekly-sales', data.weeklySales);
        updateStat('monthly-sales', data.monthlySales);
        updateStat('profit', data.profit);

        const reportBody = document.getElementById('sales-report-body');
        reportBody.innerHTML = '';

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

// Inisialisasi
document.addEventListener('DOMContentLoaded', () => new Application());
