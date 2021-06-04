<?php
session_start();

if (!isset($_SESSION["nim"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["tipe"]) && $_SESSION["tipe"] != 1) {
    header("Location: login.php");
    exit;
}

include "database.php";

$mahasiswa_id = $_GET["mahasiswa_id"];
mysqli_query($db, "DELETE FROM mahasiswa where mahasiswa_id=" . $mahasiswa_id);
header("location:index_mahasiswa.php");
