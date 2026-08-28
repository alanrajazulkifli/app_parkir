
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dasboard lulapin</title>
   <link rel="icon" href="../aset/gambar/image.png" type="image/icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  
</head>
<body>
    <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
    .sidebar {
      min-height: 100vh;
      background-color: #343a40;
      color: white;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 10px 15px;
    }
    .sidebar a:hover {
      background-color: #495057;   
    }
    .content {
      padding: 20px;
    }
  </style>

<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 col-lg-2 sidebar p-0">
      <br>
      <h4 style='text-align: center;'>Lulapin Admin</h4>
      <div class="nav-links">
        <a href="?page=kendaraan">Kendaraan </a>  
        <a href="?page=pembayaran">Pembayaran</a>
       
        <hr>
        <a href="?page=logout" class="logout-btn">Sign Out</a>
      </div>
    </nav>

    <main class="col-md-10 col-lg-10 content">
      <div class="card">
        <div class="card-body">
          <?php
            // Logika PHP tetap dipertahankan
            $page = isset($_GET['page']) ? $_GET['page'] : 'home';
            switch($page) {
              
              // halaman admin utama
              case 'kendaraan':
                include"modul/kendaraan.php";
              break;
              case 'pembayaran':
                include"modul/pembayaran.php";
              break;
               
              case 'logout':
                 include"modul/logout.php";
              break;
              
                
                // edit dan delete untuk kategori, produk, dan best seller

              case 'editkat':
                include'modul/del.up/edit.kat.php';
                break;
                case 'delkat':
                include'modul/del.up/del.kat.php';
                break;
                case 'editpro':
                include'modul/del.up/edit.pro.php';
                break;
                case 'delpro':
                include'modul/del.up/del.pro.php';
                break;
               


              case 'laporan':
                echo "<h3>Laporan Penjualan</h3><p>Analisa performa toko Anda melalui data statistik.</p>";
                break;
              default:
                echo "<h3>Overview Dashboard</h3><p>Selamat datang kembali. Silakan pilih menu di panel sebelah kiri untuk mengelola data operasional toko perhiasan Anda.</p>";
            }
          ?>
        </div>
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
