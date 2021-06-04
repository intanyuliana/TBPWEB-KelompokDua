<?php
include 'database.php';

$mahasiswa_id = $_GET['mahasiswa_id'];
$nama = $_POST['nama'];
$nim = $_POST['nim'];
$email = $_POST['email'];
$password = $_POST['password'];
$tipe = $_POST['tipe'];

mysqli_query($db, "UPDATE mahasiswa SET nama='$nama', nim='$nim', email='$email', pass='$password', tipe='$tipe' WHERE mahasiswa_id=" . $mahasiswa_id);

header("Location:index_mahasiswa.php");
