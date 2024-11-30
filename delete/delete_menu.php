<?php
include('../php/config.php');

// Cek apakah ID diterima dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus menu berdasarkan ID
    $sql = "DELETE FROM tbl_m_menu WHERE id_tmm = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Menu deleted successfully'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error deleting menu: " . $conn->error;
    }
}

$conn->close();
?>
