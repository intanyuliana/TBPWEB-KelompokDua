<?php
session_start();

if (!isset($_SESSION["id"]) && !isset($_SESSION["nim"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["tipe"]) && $_SESSION["tipe"] != 2) {
	header("Location: login.php");
	exit;
}

require_once('_headermhs.php');
include 'database.php';
$kelas_id = $_GET['kelas_id'];
$mahasiswa_id = $_SESSION['id'];
$query   = $db->query("SELECT * FROM absensi
					INNER JOIN krs ON absensi.krs_id = krs.krs_id
					INNER JOIN pertemuan ON absensi.pertemuan_id = pertemuan.pertemuan_id
					WHERE krs.kelas_id = '$kelas_id' AND krs.mahasiswa_id = '$mahasiswa_id'");
?>

<div class="container">
	<div class="row">
		<div class="col text-center my-5">
			<h3>Riwayat Kehadiran Kelas</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<a href="daftar_kelas_mhs.php">
				<button type="button" class="btn btn-secondary mb-3">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
						<path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
					</svg>
				</button>
			</a>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Pertemuan Ke-</th>
						<th>Jam Masuk</th>
						<th>Jam Keluar</th>
						<th>Durasi</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($data = mysqli_fetch_assoc($query)) { ?>
						<?php
						$hours = floor($data['durasi'] / 3600);
						$minutes = floor(($data['durasi'] / 60) % 60);
						$seconds = $data['durasi'] % 60;
						?>
						<tr>
							<td><?= $data['pertemuan_ke']; ?></td>
							<td><?= $data['jam_masuk']; ?></td>
							<td><?= $data['jam_keluar']; ?></td>
							<td><?php if ($hours != 0) echo $hours . "h " ?>
								<?php if ($minutes != 0) echo $minutes . "m " ?>
								<?php if ($seconds != 0) echo $seconds . "s " ?></td>
						</tr>
					<?php } ?>
			</table>
		</div>
	</div>
</div>

<?php require_once('_footer.html'); ?>