<?php
include('../php/config.php'); // Koneksi ke database

// Query untuk mengambil data menu dari tabel
$sql = "SELECT * FROM tbl_m_menu"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kala Senja Coffee - Cashier</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        /* Styling untuk tombol Checkout */
        .checkout-btn {
            position: fixed;            /* Tombol tetap di pojok kanan bawah */
            bottom: 20px;               /* Jarak dari bawah */
            right: 20px;                /* Jarak dari kanan */
            width: 60px;                /* Lebar tombol */
            height: 60px;               /* Tinggi tombol */
            background-color: #FF8C00;  /* Warna oranye tombol */
            border: none;
            border-radius: 50%;         /* Membuat tombol menjadi bulat */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Animasi saat hover */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); /* Efek bayangan */
        }

        .checkout-btn:hover {
            background-color: #e57f00;  /* Warna tombol saat hover */
        }

        .checkout-btn i {
            font-size: 24px; /* Ukuran ikon troli */
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-icon active" data-icon="home"><i class="ph ph-house"></i></div>
        <div class="sidebar-icon" data-icon="orders"><i class="ph ph-note"></i></div>
        <div class="sidebar-icon" data-icon="users"><i class="ph ph-user"></i></div>
        <div class="sidebar-icon" data-icon="logout"><i class="ph ph-sign-out"></i></div>
    </aside>

    <!-- Navbar untuk Mobile -->
    <div class="mobile-navbar">
        <div class="mobile-icon active" data-icon="home"><i class="ph ph-house"></i></div>
        <div class="mobile-icon" data-icon="orders"><i class="ph ph-note"></i></div>
        <div class="mobile-icon" data-icon="users"><i class="ph ph-user"></i></div>
        <div class="mobile-icon" data-icon="logout"><i class="ph ph-sign-out"></i></div>
    </div>

    <!-- Dashboard Content -->
    <div class="container">
        <main id="dashboard" class="content-section active">
            <header>
                <div class="top-bar">
                    <div class="kala-senja">
                        <h1>Kala Senja Coffee</h1>
                        <p class="timestamp" id="timestamp"></p>
                    </div>
                    <img src="../images/logo.jpg" alt="Profile" class="profile-img">
                </div>
                <div>
                    <div class="menu-nav">
                        <h2>Choose Menu</h2>
                        <select class="category-select" id="category-select">
                            <option value="all">All</option>
                            <option value="Food">Food</option>
                            <option value="Beverage">Beverage</option>
                        </select>
                    </div>
                </div>
            </header>

            <div class="dishes-grid" id="dishes-container">
                <!-- Dish Cards -->
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='dish-card' data-category='" . $row['categoryMenu_tmm'] . "'>";
                        echo "<img src='" . $row['photo_tmm'] . "' alt='Dish' class='dish-img'>";
                        echo "<h3>" . $row['menu_tmm'] . "</h3>";
                        echo "<p class='price'>Rp. " . number_format($row['price_tmm'], 2) . "</p>";
                        // Tombol Add to Cart
                        echo "<button class='add-cart-btn' onclick='addToCart(" . $row['id_tmm'] . ", \"" . addslashes($row['menu_tmm']) . "\", " . $row['price_tmm'] . ", \"" . $row['photo_tmm'] . "\")'>Add to Cart</button>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No menu available.</p>";
                }
                ?>
            </div>

        </main>
    </div>

    <!-- Tombol Checkout -->
    <a href="../add/add_order.php">
        <button class="checkout-btn" id="checkout-btn">
            <i class="ph ph-shopping-cart"></i>  <!-- Ikon troli dari Phosphor Icons -->
        </button>
    </a>

    <script>
        // Function to add item to cart in localStorage
        function addToCart(id, name, price, photo) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Cek apakah item sudah ada dalam keranjang
            const existingItemIndex = cart.findIndex(item => item.id === id);
            if (existingItemIndex >= 0) {
                // Jika item sudah ada, update kuantitas
                cart[existingItemIndex].quantity += 1;
            } else {
                // Jika item belum ada, tambahkan ke keranjang
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    photo: photo,
                    quantity: 1,  // Set kuantitas default 1
                    note: ''      // Catatan kosong
                });
            }

            // Simpan keranjang ke localStorage
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCheckoutButton();  // Update tombol checkout
            alert(name + " has been added to your cart!");
        }

        // Update checkout button to show the number of items in the cart
        function updateCheckoutButton() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartButton = document.getElementById('checkout-btn');
            const cartItemCount = cart.reduce((total, item) => total + item.quantity, 0);
            if (cartItemCount > 0) {
                cartButton.innerHTML = `<i class="ph ph-shopping-cart"></i> (${cartItemCount})`;  // Show the item count
            } else {
                cartButton.innerHTML = `<i class="ph ph-shopping-cart"></i>`;  // Hide the count if empty
            }
        }

        // Call updateCheckoutButton on page load to initialize the cart count
        window.onload = updateCheckoutButton;
        
        // Filter menu by category (Food or Beverage)
        document.getElementById('category-select').addEventListener('change', function() {
            let selectedCategory = this.value;
            let allDishCards = document.querySelectorAll('.dish-card');
            
            allDishCards.forEach(function(card) {
                if (selectedCategory === 'all' || card.getAttribute('data-category') === selectedCategory) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

<?php
$conn->close(); // Tutup koneksi database setelah selesai
?>
