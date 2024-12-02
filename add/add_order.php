<?php
// Anda bisa menambahkan header atau koneksi database sesuai kebutuhan
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Kala Senja Coffee</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        /* Styling untuk halaman keranjang dengan tema warna gelap */
        body {
            background-color: #22242f;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .cart-container {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #2a2d3a;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }

        .cart-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: bold;
            color: #ff6347;
        }

        .cart-items {
            margin-bottom: 20px;
            padding-bottom: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.5rem;
            background-color: #33353f;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .cart-item img {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 15px;
        }

        .cart-item-details {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .cart-item h4 {
            margin: 0;
            font-size: 1rem;
            color: #fff;
        }

        .cart-item p {
            margin: 5px 0;
            font-size: 0.9rem;
            color: #bbb;
        }

        .cart-item input[type="number"] {
            width: 60px;
            padding: 5px;
            text-align: center;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #2a2d3a;
            color: #fff;
        }

        .cart-item textarea {
            width: 100%;
            padding: 5px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #2a2d3a;
            color: #fff;
            resize: vertical;
            margin-top: 5px;
        }

        .cart-item-total {
            font-size: 1rem;
            font-weight: bold;
            color: #ff6347;
        }

        .checkout-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #444;
        }

        .checkout-btn {
            background-color: #ff6347;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .checkout-btn:hover {
            background-color: #ff4500;
        }

        .cart-total {
            font-size: 1.2rem;
            font-weight: bold;
            color: #fff;
        }

        .cart-empty {
            text-align: center;
            font-size: 1.5rem;
            color: #bbb;
        }

    </style>
</head>
<body>
    <div class="cart-container">
        <div class="cart-header">
            <h2>Your Cart</h2>
        </div>

        <div class="cart-items" id="cart-items-container">
            <!-- Cart items will be dynamically added here -->
        </div>

        <div class="checkout-container">
            <div class="cart-total">
                <span>Total: Rp. <span id="cart-total">0</span></span>
            </div>
            <a href="../add/add_bayar_order.php">
            <button class="checkout-btn" id="checkout-btn">Proceed to Checkout</button>
            </a>
        </div>
    </div>

    <script>
        // Function to load cart items from localStorage
        function loadCart() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartItemsContainer = document.getElementById('cart-items-container');
            let total = 0;

            // Clear the cart items container
            cartItemsContainer.innerHTML = '';

            if (cart.length === 0) {
                cartItemsContainer.innerHTML = '<p class="cart-empty">Your cart is empty.</p>';
                document.getElementById('cart-total').textContent = '0';
                return;
            }

            cart.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;

                const cartItem = document.createElement('div');
                cartItem.classList.add('cart-item');
                cartItem.innerHTML = `
                    <img src="${item.photo}" alt="${item.name}">
                    <div class="cart-item-details">
                        <h4>${item.name}</h4>
                        <p>Price: Rp. ${item.price.toFixed(2)}</p>
                        <input type="number" value="${item.quantity}" min="1" class="quantity-input" data-index="${index}">
                        <textarea placeholder="Add a note" class="note-input" data-index="${index}">${item.note || ''}</textarea>
                    </div>
                    <div class="cart-item-total">Rp. ${itemTotal.toFixed(2)}</div>
                `;

                cartItemsContainer.appendChild(cartItem);
            });

            // Update the total price
            document.getElementById('cart-total').textContent = total.toFixed(2);
        }

        // Function to handle quantity change and note change
        function updateCart(index, quantity, note) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (index >= 0 && index < cart.length) {
                cart[index].quantity = quantity;
                cart[index].note = note;
                localStorage.setItem('cart', JSON.stringify(cart));
                loadCart(); // Re-load the cart
            }
        }

        // Event listeners for quantity and note changes
        document.addEventListener('input', function(event) {
            if (event.target.classList.contains('quantity-input')) {
                const index = event.target.getAttribute('data-index');
                const quantity = parseInt(event.target.value);
                const note = document.querySelector(`.note-input[data-index="${index}"]`).value;
                updateCart(index, quantity, note);
            }

            if (event.target.classList.contains('note-input')) {
                const index = event.target.getAttribute('data-index');
                const note = event.target.value;
                const quantity = parseInt(document.querySelector(`.quantity-input[data-index="${index}"]`).value);
                updateCart(index, quantity, note);
            }
        });

        // Handle checkout
        document.getElementById('checkout-btn').addEventListener('click', function() {
            window.location.href = 'add_order.php'; // Redirect to checkout page
        });

        // Load cart when the page is loaded
        loadCart();
    </script>
</body>
</html>
