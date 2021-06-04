<?php
session_start();

if (!isset($_SESSION["nim"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["tipe"]) && $_SESSION["tipe"] != 1) {
	header("Location: login.php");
	exit;
}

include('database.php');
require_once "_headeradmin.php";

?>

<div class="container">
	<div class="row">
		<div class="col text-center my-4">
			<h3>Daftar Kelas</h3>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<a href="kelasadmin_tambah.php" class="btn btn-success mb-2">Tambah Data Kelas</a>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>No.</th>
						<th>Kode Kelas</th>
						<th>Kode Mata Kuliah</th>
						<th>Nama Mata Kuliah</th>
						<th>Tahun Ajaran</th>
						<th>Semester</th>
						<th>Sks</th>
						<th>Opsi</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					<?php
					$data = mysqli_query($db, "SELECT * FROM kelas ORDER BY tahun DESC , semester DESC ");
					while ($row = mysqli_fetch_array($data)) {
					?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $row['kode_kelas']; ?></td>
							<td><?php echo $row['kode_matkul']; ?></td>
							<td><?php echo $row['nama_matkul']; ?></td>
							<td><?php echo $row['tahun']; ?></td>
							<td><?php echo $row['semester']; ?></td>
							<td><?php echo $row['sks']; ?></td>

							<td>
								<a href="kelasadmin_edit.php?kelas_id=<?= $row['kelas_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
								<a href="detail_kelas.php?kelas_id=<?= $row['kelas_id']; ?>" class="btn btn-primary btn-sm">Detail</a>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
require_once "_footer.html";
?>