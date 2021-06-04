<?php
session_start();

if (!isset($_SESSION["nim"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["tipe"]) && $_SESSION["tipe"] != 1) {
    header("Location: login.php");
    exit;
}

include "_headeradmin.php";
include "database.php";

if (isset($_POST['tambah'])) {
    $idkls = $_POST['kls'];
    $id = $_POST['mhs'];
    $hasil1 = $db->prepare("INSERT INTO krs(mahasiswa_id, kelas_id) VALUES (?, ?)");
    $hasil1->bind_param('ii', $id, $idkls);
    $hasil1->execute();

    if ($db->affected_rows > 0) {
        echo "<script>alert('Data Berhasil Disimpan');
        document.location.href = 'detail_kelas.php?kelas_id=$idkls';
        </script>";
    } else {
        echo "<script>alert('Data gagal Disimpan');
        document.location.href = 'tambah_mhs.php?kelas_id=$idkls'; </script>";
    }
}


?>

<br>
<div class="container-md">
    <div class="row">
        <div class="col text-center my-4">
            <h3>Tambah Mahasiswa ke Kelas</h3>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="detail_kelas.php?kelas_id=<?php echo $_GET['kelas_id']; ?>">
                <button type="button" class="btn btn-secondary mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                    </svg>
                </button>
            </a>
            <form action="tambah_mhs.php" method="POST">
                <div class="mb-3">
                    <label for="mhs" class="form-label">Mahasiswa</label>
                    <select id="mhs" name="mhs" class="form-select">
                        <option disabled selected> </option>
                        <?php
                        $klsid = $_GET['kelas_id'];
                        $hasil = $db->query("SELECT mahasiswa_id, nim, nama from mahasiswa where tipe = 2 AND mahasiswa_id NOT IN (SELECT mahasiswa_id from krs where kelas_id='$klsid')");
                        while ($mhs = mysqli_fetch_assoc($hasil)) {
                            echo '<option value="' . $mhs['mahasiswa_id'] . '">' . $mhs['nim'] . " - " . $mhs['nama'] . '</option>';
                        }
                        ?>
                    </select>
                    <input type="hidden" name="kls" value="<?php echo $_GET['kelas_id']; ?>">
                </div>
                <input type="submit" name="tambah" class="btn btn-primary" value='Tambah'>
                <button type="reset" class="btn btn-danger">Reset</button>
            </form>
        </div>
    </div>
</div>

<?php
include "_footer.html";
?>