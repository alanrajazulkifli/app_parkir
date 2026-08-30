<h3 class="mb-4">Data Kendaraan</h3>

<!-- Form Input Kendaraan -->
<div class="card mb-4">
  <div class="card-header bg-primary text-white">Tambah kendaraan</div>
  <div class="card-body">
    <form method="POST">
      <div class="row g-3">
            
        <div class="col-md-3">
          <label class="form-label">Jenis Kendaraan</label>
          <select class="form-control" name="jenis_kendaraan" required>
            <option value="">Pilih Jenis Kendaraan</option>
            <option value="Motor">Motor</option>
            <option value="Mobil">Mobil</option>
            <option value="Truk">Truk</option>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Plat Nomor</label>
          <input type="text" class="form-control" name="plat_nomor" placeholder="Masukkan plat nomor" required>
        </div> 

        <div class="col-md-3">
          <label class="form-label">Waktu Masuk</label>
          <input type="datetime-local" class="form-control" name="waktu_masuk" value="<?= date('Y-m-d\TH:i') ?>" required>
        </div>

        <div class="col-md-2">
          <label class="form-label">Status</label>
          <select class="form-control" name="status" required>
            <option value="Masuk">Masuk</option>
          </select>
        </div>

        <div class="col-md-1 d-flex align-items-end">
          <button type="submit" name="btn" class="btn btn-success w-100">Tambah kendaraan</button>
        </div>

      </div>
    </form>

    <?php
    if (isset($_POST['btn'])) {
      $jenis_kendaraan = $_POST['jenis_kendaraan'];
      $plat_nomor       = $_POST['plat_nomor'];
      $waktu_masuk      = $_POST['waktu_masuk'];
      $status           = $_POST['status'];

      $sql = $conn->query("INSERT INTO kendaraan (jenis_kendaraan, plat_nomor, waktu_masuk, status) 
                           VALUES ('$jenis_kendaraan', '$plat_nomor', '$waktu_masuk', '$status')");

      if ($sql == true) {
        echo "<div class='alert alert-success mt-3'>Data Kendaraan Berhasil Di Input...</div>";
      } else {
        echo "<div class='alert alert-danger mt-3'><b>Error..</b>" . $conn->error . "</div>";
      }
    }
    ?>
  </div>
</div>

<!-- Tabel Kendaraan -->
<div class="card">
  <div class="card-header bg-dark text-white">Daftar kendaraan</div>
  <div class="card-body">
    <table class="table table-bordered table-hover">
      <thead class="table-secondary">
        <tr>
          <th>No</th>
          <th>Jenis Kendaraan</th>
          <th>Plat Nomor</th>
          <th>Waktu Masuk</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $sql = $conn->query("SELECT * FROM kendaraan ORDER BY id_kendaraan DESC");
        foreach ($sql as $data) {
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $data['jenis_kendaraan'] ?></td>
          <td><?= $data['plat_nomor'] ?></td>
          <td><?= $data['waktu_masuk'] ?></td>
          <td><?= $data['status'] ?></td>
        </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</div>