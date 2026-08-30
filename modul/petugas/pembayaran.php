<h3 class="mb-4">Transaksi Pembayaran Parkir</h3>

<!-- Form Transaksi Pembayaran -->
<div class="card mb-4">
  <div class="card-header bg-primary text-white">Proses Pembayaran Kendaraan</div>
  <div class="card-body">
    <form method="POST">
      <div class="row g-3">
        
        <div class="col-md-4">
          <label class="form-label">Pilih Kendaraan (Plat Nomor)</label>
          <select class="form-control" name="id_kendaraan" required>
            <option value="">Pilih Kendaraan Masuk</option>
            <?php
            // Mengambil kendaraan yang statusnya masih 'Masuk'
            $sqlKendaraan = $conn->query("SELECT * FROM kendaraan WHERE status='Masuk'");
            foreach ($sqlKendaraan as $row) {
            ?>
              <option value="<?= $row['id_kendaraan'] ?>">
                <?= $row['plat_nomor'] ?> (<?= $row['jenis_kendaraan'] ?>) - <?= $row['waktu_masuk'] ?>
              </option>
            <?php
            }
            ?>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Metode Pembayaran</label>
          <select class="form-control" name="metode_bayar" required>
            <option value="Tunai">Tunai</option>
            <option value="QRIS">QRIS</option>
            <option value="Transfer">Transfer</option>
          </select>
        </div> 

        <div class="col-md-3">
          <label class="form-label">Tarif Per Jam (Rp)</label>
          <input type="number" class="form-control" name="tarif_per_jam" value="5000" required>
        </div>

        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" name="btn_bayar" class="btn btn-success w-100">Bayar & Keluar</button>
        </div>

      </div>
    </form>

    <?php
    if (isset($_POST['btn_bayar'])) {
      $id_kendaraan  = $_POST['id_kendaraan'];
      $metode_bayar  = $_POST['metode_bayar'];
      $tarif_per_jam = $_POST['tarif_per_jam'];
      $waktu_keluar  = date('Y-m-d H:i:s');

      // 1. Ambil data waktu masuk kendaraan
      $getKendaraan = $conn->query("SELECT waktu_masuk FROM kendaraan WHERE id_kendaraan='$id_kendaraan'");
      $data = $getKendaraan->fetch_assoc();
      $waktu_masuk = $data['waktu_masuk'];

      // 2. Hitung durasi jam (minimal 1 jam)
      $selisih = strtotime($waktu_keluar) - strtotime($waktu_masuk);
      $durasi_jam = ceil($selisih / 3600); 
      if ($durasi_jam <= 0) { $durasi_jam = 1; }

      // 3. Hitung total bayar
      $total_bayar = $durasi_jam * $tarif_per_jam;

      // 4. Simpan ke tabel pembayaran
      $sqlBayar = $conn->query("INSERT INTO pembayaran (id_kendaraan, waktu_keluar, durasi_jam, total_bayar, metode_bayar) 
                                VALUES ('$id_kendaraan', '$waktu_keluar', '$durasi_jam', '$total_bayar', '$metode_bayar')");

      // 5. Update status kendaraan di tabel kendaraan menjadi 'Selesai'
      $sqlUpdate = $conn->query("UPDATE kendaraan SET status='Selesai' WHERE id_kendaraan='$id_kendaraan'");

      if ($sqlBayar && $sqlUpdate) {
        echo "<div class='alert alert-success mt-3'>Pembayaran Berhasil! Total: <b>Rp. " . number_format($total_bayar) . "</b> (Durasi: $durasi_jam jam)</div>";
      } else {
        echo "<div class='alert alert-danger mt-3'><b>Error..</b>" . $conn->error . "</div>";
      }
    }
    ?>
  </div>
</div>

<!-- Tabel Riwayat Pembayaran -->
<div class="card">
  <div class="card-header bg-dark text-white">Riwayat Pembayaran</div>
  <div class="card-body">
    <table class="table table-bordered table-hover">
      <thead class="table-secondary">
        <tr>
          <th>No</th>
          <th>Plat Nomor</th>
          <th>Jenis</th>
          <th>Waktu Masuk</th>
          <th>Waktu Keluar</th>
          <th>Durasi</th>
          <th>Total Bayar</th>
          <th>Metode</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        // Query menggabungkan tabel pembayaran dan kendaraan
        $sql = $conn->query("SELECT pembayaran.*, kendaraan.plat_nomor, kendaraan.jenis_kendaraan, kendaraan.waktu_masuk 
                             FROM pembayaran 
                             INNER JOIN kendaraan ON pembayaran.id_kendaraan = kendaraan.id_kendaraan 
                             ORDER BY pembayaran.id_pembayaran DESC");
        foreach ($sql as $data) {
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><b><?= $data['plat_nomor'] ?></b></td>
          <td><?= $data['jenis_kendaraan'] ?></td>
          <td><?= $data['waktu_masuk'] ?></td>
          <td><?= $data['waktu_keluar'] ?></td>
          <td><?= $data['durasi_jam'] ?> Jam</td>
          <td>Rp. <?= number_format($data['total_bayar']) ?></td>
          <td><?= $data['metode_bayar'] ?></td>
        </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</div>