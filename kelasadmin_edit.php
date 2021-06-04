<?php
session_start();

if (!isset($_SESSION["nim"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["tipe"]) && $_SESSION["tipe"] != 1) {
	header("Location: login.php");
	exit;
}

include('database.php');
require_once "_headeradmin.php";

$query = mysqli_query($db, "SELECT * FROM kelas WHERE kelas_id='" . $_GET['kelas_id'] . "' ");
$data = mysqli_fetch_array($query);

?>

<div class="container">
	<div class="row">
		<div class="col text-center my-4">
			<h3>Edit Data Kelas</h3>
		</div>
	</div>

	<div class="row justify-content-center">
		<div class="col-md-6">
			<a href="kelasadmin.php">
				<button type="button" class="btn btn-secondary mb-3">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
						<path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
					</svg>
				</button>
			</a>
			<form action="" method="POST">
				<label for="kelas_id" class="form-label">Id Kelas</label>
				<div class="mb-3">
					<a><input type="text" class="form-control" name="kelas_id" value="<?php echo $data['kelas_id'] ?>" readonly></a>
				</div>

				<label for="kode_kelas" class="form-label">Kode Kelas</label>
				<div class="mb-3">
					<a><input class="form-control" type="text" name="kode_kelas" value="<?php echo $data['kode_kelas'] ?>" required=""></a>
				</div>


				<label for="kode_matkul" class="form-label">Kode Mata Kuliah</label>
				<div class="mb-3">
					<a><input type="text" class="form-control" name="kode_matkul" value="<?php echo $data['kode_matkul'] ?>" required></a>
				</div>


				<label for="nama_matkul" class="form-label">Nama Mata Kuliah</label>
				<div class="mb-3">
					<a><input type="text" class="form-control" name="nama_matkul" value="<?php echo $data['nama_matkul'] ?>" required></a>
				</div>


				<label for="tahun" class="form-label">Tahun</label>
				<div class="mb-3">
					<a><input type="text" class="form-control" name="tahun" value="<?php echo $data['tahun'] ?>" required></a>
				</div>

				<label for="semester" class="form-label">Semester</label>
				<div class="mb-3">
					<select class="form-select" name="semester" required>
						<option value="<?php echo $data['semester'] ?>"><?php echo $data['semester'] ?></option>
						<option value="1">1</option>
						<option value="2">2</option>
					</select>
					<div id="semesterhelp" class="form-text" style="font-style: italic;">*1 = ganjil.</div>
					<div id="semesterhelp" class="form-text" style="font-style: italic;">*2 = genap.</div>
				</div>

				<label for="sks" class="form-label">Sks</label>
				<div class="mb-3">
					<a><input type="text" class="form-control" name="sks" value="<?php echo $data['sks'] ?>" required></a>
				</div>

				<div class="mb-3">
					<a><button class="btn btn-success form-control mt-3" type="submit" name="ubah">Simpan Perubahan</button></a>
				</div>

			</form>
		</div>
	</div>
</div>

<?php require_once "_footer.html"; ?>

<?php
if (isset($_POST['ubah'])) {

	$kelas_id = $_POST['kelas_id'];
	$kode_kelas = $_POST['kode_kelas'];
	$kode_matkul = $_POST['kode_matkul'];
	$nama_matkul = $_POST['nama_matkul'];
	$tahun = $_POST['tahun'];
	$semester = $_POST['semester'];
	$sks = $_POST['sks'];

	$query2 = "UPDATE kelas SET 
	kelas_id = '$kelas_id',
	kode_kelas = '$kode_kelas',
	kode_matkul = '$kode_matkul',
	nama_matkul = '$nama_matkul',
	tahun = '$tahun',
	semester = '$semester',
	sks = '$sks'
	WHERE kelas_id = '$kelas_id' ";

	$result = mysqli_query($db, $query2) or die(mysqli_error($db));

	if ($result > 0) {
		echo "
		<script>
		alert('Data berhasil Diubah!');
		document.location.href = 'kelasadmin.php';
		</script>
		";
	} else {
		echo "
		<script>
		alert('Data gagal Diubah!');
		document.location.href = 'kelasadmin.php';
		</script>
		";
	}
}
?>