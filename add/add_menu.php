<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Studio</title>

  <!-- Bootstrap -->
  <link rel="icon" type="image/png" href="../img/favicon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/simplex/bootstrap.min.css"
    integrity="sha384-FYrl2Nk72fpV6+l3Bymt1zZhnQFK75ipDqPXK0sOR0f/zeOSZ45/tKlsKucQyjSp" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    // Format angka ke format Rupiah
    function formatRupiah(value) {
      return 'Rp ' + value.replace(/[^,\d]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Fungsi untuk memperbarui input harga saat mengetik
    function updatePriceInput(event) {
      const input = event.target;
      const rawValue = input.value.replace(/[^0-9]/g, ''); // Hanya angka
      input.value = formatRupiah(rawValue);
    }

    // Fungsi untuk membersihkan format Rupiah sebelum submit
    function cleanPriceValue() {
      const input = document.getElementById('price_per_hour');
      input.value = input.value.replace(/[^0-9]/g, ''); // Simpan hanya angka ke database
    }
  </script>

  <script src="../fungsi/ckeditor/ckeditor.js"></script>

  <style>
    .content {
      margin-left: 220px;
      padding: 20px;
      margin-top: 50px;
    }
  </style>
</head>

<body>
  <?php include '../admin/admin_header.php'; ?>
  <div class="content">
    <h2>Tambah Menu Baru</h2>

    <form action="add_studio.php" method="POST" enctype="multipart/form-data" onsubmit="cleanPriceValue()"
      class="p-4 border rounded">
      <div class="form-group">
        <label for="studio_name">Nama Menu:</label>
        <input type="text" id="studio_name" name="studio_name" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="description">Deskripsi:</label>
        <textarea id="description" name="description" class="form-control" required></textarea>
      </div>

      <!-- Tambahkan skrip CKEditor di sini -->
      <script>
        CKEDITOR.replace('description');
        CKEDITOR.replace('facilities');
      </script>

      <div class="form-group">
        <label for="price_per_hour">Harga:</label>
        <input type="text" id="price_per_hour" name="price_per_hour" class="form-control"
          oninput="updatePriceInput(event)" required>
      </div>

      <div class="form-group">
        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" class="form-control-file" accept="image/*">
      </div>
      <button type="submit" class="btn btn-primary">Tambah Menu</button>
    </form>
  </div>

  <script>
    <?php if (!empty($success)) : ?>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '<?= $success ?>',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = '../list/list_studio.php'; // Redirect setelah klik OK
      });
    <?php elseif (!empty($error)) : ?>
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '<?= $error ?>',
        confirmButtonText: 'OK'
      });
    <?php endif; ?>
  </script>
</body>

</html>