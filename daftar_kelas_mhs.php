<?php
if (!isset($_SESSION)) {
	session_start();
	if (!isset($_SESSION["id"]) && !isset($_SESSION["nim"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["tipe"]) && $_SESSION["tipe"] != 2) {
		header("Location: login.php");
		exit;
	}
}

require_once('_headermhs.php');

include 'database.php';
$mahasiswa_id = $_SESSION['id'];
$sql     = "SELECT * FROM krs JOIN kelas USING(kelas_id) WHERE mahasiswa_id = '$mahasiswa_id'";
$query   = $db->query($sql);
?>

<div class="container">
	<div class="row">
		<div class="col text-center my-5">
			<h3>Daftar Kelas yang Diikuti</h3>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Kode Kelas</th>
						<th>Kode Matakuliah</th>
						<th>Matakuliah</th>
						<th>Tahun Ajaran</th>
						<th>Semester</th>
						<th>SKS</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					<?php while ($data = mysqli_fetch_array($query)) { ?>
						<tr>
							<td><?= $data['kode_kelas']; ?></td>
							<td><?= $data['kode_matkul']; ?></td>
							<td><?= $data['nama_matkul']; ?></td>
							<td><?= $data['tahun']; ?></td>
							<td><?= $data['semester']; ?></td>
							<td><?= $data['sks']; ?></td>
							<td>
								<a href="detail_kelas_mhs.php?kelas_id=<?= $data['kelas_id']; ?>" class="btn btn-primary btn-sm">Detail</a>
							</td>
						</tr>
					<?php } ?>
			</table>
		</div>
	</div>
</div>

<?php require_once('_footer.html'); ?>