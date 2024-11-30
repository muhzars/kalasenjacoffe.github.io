<?php include('../php/config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kala Senja Coffee</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery CDN (untuk AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-icon" data-icon="home"><i class="ph ph-house"></i></div>
        <div class="sidebar-icon" data-icon="report"><i class="ph ph-chart-line-up"></i></div>
        <div class="sidebar-icon" data-icon="payments"><i class="ph ph-credit-card"></i></div>
        <div class="sidebar-icon active" data-icon="users"><i class="ph ph-users"></i></div>
        <div class="sidebar-icon" data-icon="logout"><i class="ph ph-sign-out"></i></div>
    </aside>

    <!-- Navbar untuk Mobile -->
    <div class="mobile-navbar">
        <div class="mobile-icon active" data-icon="home"><i class="ph ph-house"></i></div>
        <div class="mobile-icon" data-icon="report"><i class="ph ph-chart-line-up"></i></div>
        <div class="mobile-icon" data-icon="payments"><i class="ph ph-credit-card"></i></div>
        <div class="mobile-icon active" data-icon="users"><i class="ph ph-users"></i></div>
        <div class="mobile-icon" data-icon="logout"><i class="ph ph-sign-out"></i></div>
    </div>

    <!-- Dashboard Content -->
    <div class="container">
        <main id="users" class="content-section active">
            <header>
                <div class="top-bar-users">
                    <div class="users-header">
                        <h1>User Management</h1>
                    </div>
                    <img src="../images/logo.jpg" alt="Profile" class="profile-img">
                </div>
                <hr class="divider">
            </header>
            <!-- Profile Section -->
            <section class="user-list">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query untuk mengambil data pengguna dari database
                        $sql = "SELECT * FROM tbl_m_user"; // Mengambil data dari tabel tbl_m_user
                        $result = $conn->query($sql);
                        
                        // Mengecek apakah ada hasil
                        if ($result->num_rows > 0) {
                            // Menampilkan data pengguna
                            while($row = $result->fetch_assoc()) {
                                echo "<tr id='user-{$row["id_tmu"]}'>";
                                echo "<td>" . $row["id_tmu"] . "</td>";
                                echo "<td>" . $row["name_tmu"] . "</td>";
                                echo "<td>" . $row["email_tmu"] . "</td>";
                                echo "<td>" . $row["role_tmu"] . "</td>";
                                echo "<td>
                                    <a href='../update/update_user.php?id=" . $row["id_tmu"] . "'><button class='btn-edit'>Edit</button></a>
                                    <button class='btn-delete' data-id='{$row["id_tmu"]}'>Delete</button>
                                  </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No users found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script>
        // Menampilkan SweetAlert konfirmasi sebelum menghapus data
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to delete this user?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user memilih "Yes", kirimkan AJAX request untuk menghapus user
                        $.ajax({
                            url: '../delete/delete_user.php',
                            type: 'POST',
                            data: { delete_id: userId },
                            success: function(response) {
                                if (response === 'success') {
                                    // Hapus baris user yang dihapus dari tabel
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'The user has been deleted.',
                                        icon: 'success'
                                    }).then(function() {
                                        $('#user-' + userId).remove(); // Hapus baris dari tabel
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'There was an error deleting the user.',
                                        icon: 'error'
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>
