<?php
session_start();

if (!isset($_SESSION["nim"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["tipe"]) && $_SESSION["tipe"] != 1) {
  header("Location: login.php");
  exit;
}

include "_headeradmin.php";
include "database.php";
?>

<div class="container">
  <div class="row my-4">
    <div class="col text-center">
      <h3>Data Mahasiswa</h3>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <a href="tambah_mahasiswa.php" class="btn btn-success mb-2">Tambah Data Mahasiswa</a>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <table class="table table-striped" id="datatable">
        <thead>
          <tr>
            <th> No </th>
            <th> Nama </th>
            <th> NIM </th>
            <th> Email </th>
            <th> Aksi </th>
          </tr>
        </thead>
        <tbody>
          <?php
          $batas = 10;
          $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
          $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

          $previous = $halaman - 1;
          $next = $halaman + 1;

          $hasil = mysqli_query($db, "SELECT * FROM mahasiswa WHERE tipe = 2");
          $jumlah_data = mysqli_num_rows($hasil);
          $total_halaman = ceil($jumlah_data / $batas);

          $data_pegawai = mysqli_query($db, "select * from mahasiswa WHERE tipe = 2 limit $halaman_awal, $batas");
          $nomor = $halaman_awal + 1;

          $no = 1;
          while ($row = mysqli_fetch_array($data_pegawai)) {
          ?>
            <tr>
              <td width="60px">
                <?= $no++; ?>
              </td>
              <td width="400px"><?= $row['nama']; ?></td>
              <td>
                <?= $row['nim']; ?>
              </td>
              <td>
                <?= $row['email']; ?>
              </td>
              <td>
                <a href="edit_mahasiswa.php?mahasiswa_id=<?= $row['mahasiswa_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="hapus_mahasiswa.php?mahasiswa_id=<?= $row['mahasiswa_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Hapus?')">Hapus</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <nav>
        <ul class="pagination justify-content-center">

          <?php
          for ($x = 1; $x <= $total_halaman; $x++) {
          ?>
            <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
          <?php
          }
          ?>
        </ul>
      </nav>
    </div>
  </div>
</div>

<?php include '_footer.html'; ?>