<?php
session_start();

if (!isset($_SESSION["id"]) && !isset($_SESSION["nim"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["tipe"]) && $_SESSION["tipe"] != 1) {
    header("Location: login.php");
    exit;
}

include "_headeradmin.php";
include "database.php";

$klsid = $_REQUEST['kelas_id'];

$hasil = $db->query("SELECT * FROM kelas WHERE kelas_id='$klsid'");
$hasil2 = $db->query("SELECT * FROM pertemuan WHERE kelas_id='$klsid'");
$hasil1 = $db->query("SELECT mahasiswa.nim, mahasiswa.nama, mahasiswa.email, mahasiswa.mahasiswa_id FROM mahasiswa, krs, kelas WHERE mahasiswa.mahasiswa_id=krs.mahasiswa_id AND 
kelas.kelas_id=krs.kelas_id AND kelas.kelas_id='$klsid' GROUP BY mahasiswa.nim ");
$no = 1;


?>

<div class="container-md">
    <div class="row">
        <div class="col text-center my-4">
            <h3>Detail Kelas</h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="kelasadmin.php">
                <button type="button" class="btn btn-secondary mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                    </svg>
                </button>
            </a>
        </div>
    </div>
    <?php
    while ($row1 = mysqli_fetch_assoc($hasil)) {
    ?>
        <div style="margin:15px;padding:1%;width:50%;float:left;">
            <table cellpadding="7">
                <tbody>
                    <tr>
                        <td> <?php echo "Kode Kelas " ?></td>
                        <td> : </td>
                        <td><?php echo $row1['kode_kelas'] ?> </td>
                    </tr>
                    <tr>
                        <td> <?php echo "Kode Matakuliah    " ?></td>
                        <td> : </td>
                        <td><?php echo $row1['kode_matkul'] ?> </td>
                    </tr>
                    <tr>
                        <td> <?php echo "Nama Matakuliah    " ?></td>
                        <td> : </td>
                        <td><?php echo $row1['nama_matkul'] ?> </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin:15px;padding:1%;width:20%;float:right;">
            <table cellpadding="7">
                <tbody>
                    <tr>
                        <td> <?php echo "Tahun    " ?></td>
                        <td> : </td>
                        <td><?php echo $row1['tahun'] ?> </td>
                    </tr>
                    <tr>
                        <td> <?php echo "Semester    " ?></td>
                        <td> : </td>
                        <td><?php echo $row1['semester'] ?> </td>
                    </tr>
                    <tr>
                        <td> <?php echo "SKS    " ?></td>
                        <td> : </td>
                        <td><?php echo $row1['sks'] ?> </td>
                    </tr>
                </tbody>
            </table>
        </div>

    <?php
    }
    ?>

</div>
<div class="border border-2 rounded-3" style="padding:5px;width:49%;float:left;margin-left:10px;">
    <a href="tambah_mhs.php?kelas_id=<?php echo $klsid; ?>">
        <button type="button" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-plus" viewBox="0 0 16 16">
                <path d="M8.5 6a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V10a.5.5 0 0 0 1 0V8.5H10a.5.5 0 0 0 0-1H8.5V6z" />
                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z" />
            </svg> Tambah Mahasiswa</button>
    </a>
    <br> <br>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">NIM</th>
                <th scope="col">Nama</th>
                <th scope="col">E-mail</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($hasil1)) {
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $row['nim'] ?></td>
                    <td><?php echo $row['nama'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td>
                        <a href="hapus_mhs.php?kelas_id=<?php echo $klsid; ?>&mhs_id=<?php echo $row['mahasiswa_id']; ?>"><button class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">Hapus</button></a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

</div>
<div class="border border-2 rounded-3" style="padding:5px;width:49%;float:right;margin-right:10px;">
    <a href="tambah_pertemuan.php?kelas_id=<?= $klsid; ?>">
        <button type="button" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-plus" viewBox="0 0 16 16">
                <path d="M8.5 6a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V10a.5.5 0 0 0 1 0V8.5H10a.5.5 0 0 0 0-1H8.5V6z" />
                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z" />
            </svg> Tambah Pertemuan</button>
    </a>
    <br> <br>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Pertemuan ke-</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Materi</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row2 = mysqli_fetch_assoc($hasil2)) {
            ?>
                <tr>
                    <td align="right"><?php echo $row2['pertemuan_ke'] ?></td>
                    <td><?php echo $row2['tanggal'] ?></td>
                    <td><?php echo $row2['materi'] ?></td>
                    <td>
                        <a href="detail_pertemuan.php?pertemuan_id=<?php echo $row2['pertemuan_id']; ?>&kelas_id=<?php echo $klsid; ?>"><button class="btn btn-primary btn-sm">Detail</button></a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include "_footer.html";
?>