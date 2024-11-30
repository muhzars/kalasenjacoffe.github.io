<?php
include('../php/config.php');

// Query untuk mengambil data menu dari tabel
$sql = "SELECT * FROM tbl_m_menu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kala Senja Coffee</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-icon active" data-icon="home"><i class="ph ph-house"></i></div>
        <div class="sidebar-icon" data-icon="report"><i class="ph ph-chart-line-up"></i></div>
        <div class="sidebar-icon" data-icon="payments"><i class="ph ph-credit-card"></i></div>
        <div class="sidebar-icon" data-icon="users"><i class="ph ph-users"></i></div>
        <div class="sidebar-icon" data-icon="logout"><i class="ph ph-sign-out"></i></div>
    </aside>

    <!-- Navbar untuk Mobile -->
    <div class="mobile-navbar">
        <div class="mobile-icon active" data-icon="home"><i class="ph ph-house"></i></div>
        <div class="mobile-icon" data-icon="report"><i class="ph ph-chart-line-up"></i></div>
        <div class="mobile-icon" data-icon="payments"><i class="ph ph-credit-card"></i></div>
        <div class="mobile-icon" data-icon="users"><i class="ph ph-users"></i></div>
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
                        <nav class="container-nav-item">
                            <a href="#" class="nav-item active" data-category="All">All</a>
                            <a href="#" class="nav-item" data-category="Food">Food</a>
                            <a href="#" class="nav-item" data-category="Beverage">Beverage</a>
                        </nav>
                        <div style="flex-basis:30rem"></div>
                    </div>
                    <h2>Choose Dishes</h2>
                    <div class="add-menu-btn-container">
                        <a href="../add/add_menu.php"><button class="add-menu-btn">Add Menu</button></a>
                    </div>
                </div>
            </header>
            <div class="dishes-grid" id="dishes-container">
                <!-- Dish Cards -->
                <?php
                if ($result->num_rows > 0) {
                    // Loop melalui hasil dan tampilkan dalam kartu
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='dish-card' data-category='" . $row['menu_tmm'] . "'>";
                        echo "<img src='data:image/jpeg;base64," . base64_encode($row['photo_tmm']) . "' alt='Dish' class='dish-img'>";
                        echo "<h3>" . $row['menu_tmm'] . "</h3>";
                        echo "<p class='price'>Rp. " . number_format($row['price_tmm'], 2) . "</p>";
                        echo "<p>" . $row['desc_tmm'] . "</p>";
                        echo "<button class='add-cart-btn'>Add to Cart</button>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No menu available.</p>";
                }
                ?>
            </div>
        </main>
    </div>

</body>
</html>

<?php
$conn->close(); // Tutup koneksi database setelah selesai
?>
