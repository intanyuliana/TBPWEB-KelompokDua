<?php
session_start();

if (!isset($_SESSION["id"]) && !isset($_SESSION["nim"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["tipe"]) && $_SESSION["tipe"] != 1) {
    header("Location: login.php");
    exit;
}

include 'database.php';
require_once('_headeradmin.php');

$kelas_id = $_GET['kelas_id'];
$pertemuan_id = $_GET['pertemuan_id'];

$sql_data_kelas = $db->prepare("SELECT kode_kelas, nama_matkul FROM kelas 
                            WHERE kelas_id = ?");
$sql_data_kelas->bind_param('i', $kelas_id);
$sql_data_kelas->execute();
$res_data_kelas = $sql_data_kelas->get_result();
$data_kelas = $res_data_kelas->fetch_assoc();

$sql_pertemuan = $db->prepare("SELECT pertemuan_ke FROM pertemuan 
                            WHERE pertemuan_id = ?");
$sql_pertemuan->bind_param('i', $pertemuan_id);
$sql_pertemuan->execute();
$res_pertemuan = $sql_pertemuan->get_result();
$pertemuan_ke = $res_pertemuan->fetch_assoc();

if (isset($_POST["upload"])) {

    $fileName = $_FILES["file"]["tmp_name"];
    $namaFile = $_FILES["file"]["name"];
    $ekstensiValid = 'csv';
    $ekstensiFile = explode('.', $namaFile);
    $ekstensiFile = strtolower(end($ekstensiFile));

    if ($ekstensiFile != $ekstensiValid) {
        $type = "error";
        $message = "File tidak valid. Upload file ekstensi <b>.csv</b>";
    } else {

        if ($_FILES["file"]["size"] > 0) {

            $file = fopen($fileName, "r");
            $skipLines = 7;
            $lineNum = 1;
            while (fgetcsv($file)) {
                if ($lineNum > $skipLines) {
                    break;
                }
                $lineNum++;
            }

            while (($column = fgetcsv($file, 1000, ";")) !== FALSE) {

                if (isset($column[1])) {
                    $coljointime = $column[1];
                    $pcsjointime = preg_split('/[, ]/', $coljointime);
                    $jam_masuk = $pcsjointime[2];
                }

                if (isset($column[2])) {
                    $colleavetime = $column[2];
                    $pcsleavetime = preg_split('/[, ]/', $colleavetime);
                    $jam_keluar = $pcsleavetime[2];
                }

                if (isset($column[4])) {
                    $colemail = $column[4];
                    $nim = substr($colemail, 0, 10);

                    $statement = $db->prepare("SELECT krs.krs_id FROM krs 
                                        JOIN mahasiswa ON krs.mahasiswa_id = mahasiswa.mahasiswa_id 
                                        WHERE krs.kelas_id = ? AND mahasiswa.nim = ?");
                    $statement->bind_param('is', $kelas_id, $nim);
                    $statement->execute();
                    $res = $statement->get_result();
                    $col = $res->fetch_assoc();
                    $krs_id = $col['krs_id'];
                }

                $join = strtotime($jam_masuk);
                $leave = strtotime($jam_keluar);
                $durasi = $leave - $join;

                $sqlInsert = "INSERT INTO absensi (krs_id, pertemuan_id, jam_masuk, jam_keluar, durasi) VALUES (?, ?, ?, ?, ?)";
                $statement = $db->prepare($sqlInsert);
                $statement->bind_param('iissi', $krs_id, $pertemuan_id, $jam_masuk, $jam_keluar, $durasi);
                $statement->execute();

                if ($db->affected_rows > 0) {
                    $type = "success";
                    $message = "Data absensi berhasil diupload";
                } else {
                    $type = "error";
                    $message = "Terjadi masalah dalam upload file (ditemukan mahasiswa yang belum terdaftar di kelas)";
                }
            }
        }
    }
}

$stmt = $db->prepare("SELECT * FROM absensi 
INNER JOIN krs ON absensi.krs_id = krs.krs_id 
INNER JOIN mahasiswa ON krs.mahasiswa_id = mahasiswa.mahasiswa_id
WHERE absensi.pertemuan_id = ? AND krs.kelas_id = ?");
$stmt->bind_param('ii', $pertemuan_id, $kelas_id);
$stmt->execute();
$result = $stmt->get_result();

$stm = $db->prepare("SELECT * FROM absensi
RIGHT JOIN krs ON absensi.krs_id = krs.krs_id 
RIGHT JOIN mahasiswa ON krs.mahasiswa_id = mahasiswa.mahasiswa_id
WHERE krs.kelas_id = ? AND krs.krs_id NOT IN 
(SELECT absensi.krs_id FROM absensi 
JOIN krs ON absensi.krs_id = krs.krs_id 
WHERE absensi.pertemuan_id = ? AND krs.kelas_id = ?)");
$stm->bind_param('iii', $kelas_id, $pertemuan_id, $kelas_id);
$stm->execute();
$rslt = $stm->get_result();

?>

<div class="container">
    <div class="row">
        <div class="col text-center my-4">
            <h3>Daftar Kehadiran</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <a href="detail_kelas.php?kelas_id=<?= $kelas_id; ?>">
                <button type="button" class="btn btn-secondary mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                    </svg>
                </button>
            </a>
            <table width="400px;">
                <tr>
                    <td>Kode Kelas</td>
                    <td>: <?= $data_kelas['kode_kelas']; ?></td>
                </tr>
                <tr>
                    <td>Nama Matakuliah</td>
                    <td>: <?= $data_kelas['nama_matkul']; ?></td>
                </tr>
                <tr>
                    <td>Pertemuan Ke</td>
                    <td>: <?= $pertemuan_ke['pertemuan_ke']; ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            <div id="response" class="<?php if (!empty($type) && $type == "success") {
                                            echo $type . " display-block alert alert-success";
                                        } else if (!empty($type) && $type == "error") {
                                            echo $type . " display-block alert alert-danger";
                                        }
                                        ?>">
                <?php if (!empty($message)) echo $message; ?>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <label for="file" class="form-label mt-3"><i>Pilih file absensi ekstensi .csv</i></label>
        <div class="col-md-5">
            <form action="" method="post" name="formCSVUpload" id="formCSVUpload" enctype="multipart/form-data">
                <input type="file" class="form-control" id="file" name="file" accept=".csv">
        </div>
        <div class="col">
            <button type="submit" id="submit" name="upload" class="btn btn-primary"><i class="bi bi-file-earmark-arrow-up"></i> Upload</button>
            </form>
        </div>

    </div>

    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nama Mahasiswa</th>
                        <th scope="col">Jam Masuk</th>
                        <th scope="col">Jam Keluar</th>
                        <th scope="col">Durasi</th>
                        <th scope="col">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <?php
                        $hours = floor($row['durasi'] / 3600);
                        $minutes = floor(($row['durasi'] / 60) % 60);
                        $seconds = $row['durasi'] % 60;
                        ?>
                        <tr>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['jam_masuk']; ?></td>
                            <td><?= $row['jam_keluar']; ?></td>
                            <td><?php if ($hours != 0) echo $hours . "h " ?>
                                <?php if ($minutes != 0) echo $minutes . "m " ?>
                                <?php if ($seconds != 0) echo $seconds . "s " ?>
                            </td>
                            <td><?= 'Hadir' ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if (mysqli_num_rows($result) > 0) : ?>
                        <?php while ($data = $rslt->fetch_assoc()) : ?>
                            <tr>
                                <td><?= $data['nama']; ?></td>
                                <td><?= $data['jam_masuk']; ?></td>
                                <td><?= $data['jam_keluar']; ?></td>
                                <td><?= $data['durasi']; ?></td>
                                <td><?= 'Tidak Hadir' ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once('_footer.html');
?>