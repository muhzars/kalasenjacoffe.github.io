<?php
$host = 'localhost';  // Host database, menggunakan localhost karena Laragon berjalan di lokal
$user = 'root';       // Username default untuk MySQL di Laragon
$password = '';       // Password default kosong
$dbname = 'coffee_shop'; // Nama database yang Anda buat

// Koneksi ke MySQL
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database successfully.";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
