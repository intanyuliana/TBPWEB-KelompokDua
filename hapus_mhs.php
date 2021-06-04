<?php
session_start();

if (!isset($_SESSION["nim"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["tipe"]) && $_SESSION["tipe"] != 1) {
    header("Location: login.php");
    exit;
}

include "database.php";

$id = $_GET['mhs_id'];
$klsid = $_GET['kelas_id'];
$krs = $db->query("SELECT krs_id FROM krs WHERE mahasiswa_id='$id' AND kelas_id='$klsid'");

$statement1 = $db->prepare("DELETE from absensi WHERE krs_id=? ");
$statement1->bind_param('i', $krs);
$statement1->execute();

$statement = $db->prepare("DELETE from krs WHERE mahasiswa_id=? AND kelas_id=?");
$statement->bind_param('ii', $id, $klsid);
$statement->execute();

if ($statement > 0) {
    echo "<script>alert('Data Berhasil Dihapus');
            document.location.href = 'detail_kelas.php?kelas_id=$klsid';
            </script>";
} else {
    echo "<script>alert('Data gagal Dihapus');
            document.location.href = 'detail_kelas.php?kelas_id=$klsid'; </script>";
}
