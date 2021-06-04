<?php
session_start();

if (!isset($_SESSION["nim"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["tipe"]) && $_SESSION["tipe"] != 1) {
    header("Location: login.php");
    exit;
}

include 'database.php';
require_once('_headeradmin.php');

$kelas_id = $_GET['kelas_id'];

if (isset($_POST['tambah'])) {
    $pertemuan_ke = $_POST['pertemuan_ke'];
    $tanggal = $_POST['tanggal'];
    $materi = htmlspecialchars($_POST['materi']);

    $sql = "INSERT INTO pertemuan (kelas_id, pertemuan_ke, tanggal, materi) VALUES (?, ?, ?, ?)";
    $statement = $db->prepare($sql);
    $statement->bind_param('iiss', $kelas_id, $pertemuan_ke, $tanggal, $materi);
    $statement->execute();

    if ($db->affected_rows > 0) {
        $error = true;
    } else {
        $error = false;
    }
}

?>

<div class="container">
    <div class="row">
        <div class="col text-center my-4">
            <h3>Tambah Pertemuan Kelas</h3>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="detail_kelas.php?kelas_id=<?= $kelas_id; ?>">
                <button type="button" class="btn btn-secondary mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                    </svg>
                </button>
            </a>

            <?php if (isset($error) && $error == true) : ?>
                <div class="alert alert-success" role="alert">
                    Pertemuan berhasil ditambahkan!
                </div>
            <?php elseif (isset($error) && $error == false) : ?>
                <div class="alert alert-danger" role="alert">
                    Pertemuan gagal ditambahkan!
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="mb-3">
                    <input type="number" class="form-control" id="pertemuan_ke" name="pertemuan_ke" placeholder="Pertemuan Ke-" required>
                </div>
                <div class="mb-3">
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" id="materi" name="materi" rows="3" placeholder="Materi" required></textarea>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary form-control mt-3" name="tambah">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('_footer.html'); ?>