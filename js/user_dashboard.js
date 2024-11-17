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

        // Tampilkan keranjang hanya di Home (Dashboard)
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

// Tambahkan item ke keranjang
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
        `;
        cartItemsContainer.appendChild(cartItem);

        updateCartSubtotal(dishPrice);
    });
});

// Update subtotal
function updateCartSubtotal(price) {
    const currentSubtotal = parseInt(cartSubtotal.textContent.replace('Rp.', '').replace(',', '').trim()) || 0;
    const priceToAdd = parseInt(price.replace('Rp.', '').replace(',', '').trim()) || 0;
    const newSubtotal = currentSubtotal + priceToAdd;

    cartSubtotal.textContent = `Rp. ${newSubtotal.toLocaleString('id-ID')}`;
}
