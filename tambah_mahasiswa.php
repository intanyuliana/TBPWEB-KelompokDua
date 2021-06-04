<?php
session_start();

if (!isset($_SESSION["nim"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["tipe"]) && $_SESSION["tipe"] != 1) {
  header("Location: login.php");
  exit;
}

include "_headeradmin.php";
include "database.php";
?>

<div class="container">
  <div class="row">
    <div class="col text-center my-4">
      <h3>Tambah Data Mahasiswa</h3>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-6">
      <a href="index_mahasiswa.php">
        <button type="button" class="btn btn-secondary mb-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
          </svg>
        </button>
      </a>
      <form action="tambah_mahasiswa_aksi.php" method="post">
        <div class="mb-3">
          <label for="nama" class="form-label">Nama</label>
          <input type="text" class="form-control" name="nama" placeholder="Nama" required>
        </div>
        <div class="mb-3">
          <label for="nim" class="form-label">NIM</label>
          <input type="text" class="form-control" name="nim" placeholder="NIM" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <div class="mb-3">
          <label for="tipe" class="form-label">Tipe</label>
          <select name="tipe" id="tipe" required class="form-select">
            <option disabled selected>-Pilih Tipe-</option>
            <option value="1">Admin</option>
            <option value="2">Mahasiswa</option>
          </select>
        </div>
        <div class="mb-3">
          <button type="submit" class="form-control btn btn-success mt-3">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <?php include '_footer.html'; ?>