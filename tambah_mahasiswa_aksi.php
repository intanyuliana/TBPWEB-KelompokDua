<?php
include 'database.php';

$nama = $_POST['nama'];
$nim = $_POST['nim'];
$email = $_POST['email'];
$password = $_POST['password'];
$tipe = $_POST['tipe'];
$getnim = $db->query("SELECT nim FROM mahasiswa WHERE nim = '$nim'");
$ceknim = mysqli_fetch_assoc($getnim);

if ($ceknim == NULL) {
    mysqli_query($db, "INSERT INTO mahasiswa (nama, nim, email, tipe, pass) values ('$nama','$nim','$email','$tipe','$password')");
    header("Location:index_mahasiswa.php");
} else {
    echo "
    <script>
    alert('NIM tersebut sudah dipakai!');
            document.location.href = 'tambah_mahasiswa.php';
    </script>
    ";
}
