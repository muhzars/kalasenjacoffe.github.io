<?php
include('../php/config.php'); // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu = $_POST['menu'];
    $price = $_POST['price'];
    $desc = $_POST['desc'];
    $categoryMenu = $_POST['categoryMenu'];

    // Periksa apakah file foto diupload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        // Tentukan direktori untuk menyimpan gambar
        $upload_dir = "../uploads/"; // Folder untuk menyimpan gambar
        $file_name = $_FILES['photo']['name'];
        $file_tmp = $_FILES['photo']['tmp_name'];
        $file_path = $upload_dir . basename($file_name); // Path lengkap untuk menyimpan file

        // Cek ekstensi file
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_extensions)) {
            // Pindahkan file ke direktori yang ditentukan
            if (move_uploaded_file($file_tmp, $file_path)) {
                // Simpan path gambar di database (relative path)
                $sql = "INSERT INTO tbl_m_menu (menu_tmm, price_tmm, desc_tmm, photo_tmm, categoryMenu_tmm) 
                        VALUES (?, ?, ?, ?, ?)";

                if ($stmt = $conn->prepare($sql)) {
                    // Bind parameter
                    $stmt->bind_param("ssdss", $menu, $price, $desc, $file_path, $categoryMenu);

                    // Eksekusi query
                    if ($stmt->execute()) {
                        // Redirect setelah berhasil
                        header('Location: ../admin/admin_home.php');
                        exit;
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Failed to upload image.";
            }
        } else {
            echo "Only JPG, JPEG, and PNG files are allowed.";
        }
    } else {
        echo "No file uploaded.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Add New Menu</h2>
    <form action="add_menu.php" method="POST" enctype="multipart/form-data">
        <label for="menu">Menu Name:</label>
        <input type="text" name="menu" id="menu" required><br><br>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" required><br><br>

        <label for="desc">Description:</label>
        <textarea name="desc" id="desc" rows="4" required></textarea><br><br>

        <label for="categoryMenu">Category:</label>
        <select name="categoryMenu" id="categoryMenu" required>
            <option value="Food">Food</option>
            <option value="Beverage">Beverage</option>
        </select><br><br>

        <label for="photo">Upload Photo:</label>
        <input type="file" name="photo" id="photo" accept="image/*"><br><br>

        <button type="submit">Add Menu</button>
    </form>
</body>
</html>
