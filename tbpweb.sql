-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Jun 2021 pada 13.39
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tbpweb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `absensi_id` int(11) NOT NULL,
  `krs_id` int(11) NOT NULL,
  `pertemuan_id` int(11) DEFAULT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `durasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`absensi_id`, `krs_id`, `pertemuan_id`, `jam_masuk`, `jam_keluar`, `durasi`) VALUES
(18, 65, 14, '01:32:13', '02:57:52', 5139),
(19, 65, 15, '01:32:13', '02:57:52', 5139),
(24, 62, 1, '01:32:13', '02:57:52', 5139),
(25, 66, 1, '01:32:23', '02:57:42', 5119);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `kelas_id` int(11) NOT NULL,
  `kode_kelas` varchar(50) NOT NULL,
  `kode_matkul` varchar(50) NOT NULL,
  `nama_matkul` varchar(50) NOT NULL,
  `tahun` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `sks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`kelas_id`, `kode_kelas`, `kode_matkul`, `nama_matkul`, `tahun`, `semester`, `sks`) VALUES
(1, 'TSI202A', 'TSI202', 'Pemrograman Web', 2021, 2, 3),
(2, 'TSI202B', 'TSI202', 'Pemrograman Web', 2021, 2, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `krs`
--

CREATE TABLE `krs` (
  `krs_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `krs`
--

INSERT INTO `krs` (`krs_id`, `kelas_id`, `mahasiswa_id`) VALUES
(62, 1, 1),
(64, 2, 2),
(65, 2, 1),
(66, 1, 3),
(68, 1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `mahasiswa_id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `nim` varchar(18) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `tipe` int(11) DEFAULT NULL,
  `pass` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`mahasiswa_id`, `nama`, `nim`, `email`, `tipe`, `pass`) VALUES
(1, 'Nadya Gusdita', '1911521001', '1911521001_nadya@student.unand.ac.id', 2, 15082001),
(2, 'Na Jaemin', '1911521002', '1911521002_jaemin@student.unand.ac.id', 2, 13082000),
(3, 'Intan Yuliana Putri', '1911522007', '1911522007_intan@student.unand.ac.id', 2, 1234),
(4, 'Park Jisung', '1911521006', 'pjisung@gmail.com', 2, 123),
(6, 'M Hadef Petriza', '1911521007', '1911521007_hadef@student.unand.ac.id', 2, 123),
(8, 'Pak Dadidu', '1111111111', 'dadidu@gmail.com', 1, 1234),
(9, 'Immalatunil Khaira Affi', '1911522017', '1911522017_imma@student.unand.ac.id', 2, 1234),
(10, 'Dwiky Rahmat Fadhila', '1911529001', '1911529001_dwiky@student.unand.ac.id', 2, 1234);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pertemuan`
--

CREATE TABLE `pertemuan` (
  `pertemuan_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `pertemuan_ke` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `materi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pertemuan`
--

INSERT INTO `pertemuan` (`pertemuan_id`, `kelas_id`, `pertemuan_ke`, `tanggal`, `materi`) VALUES
(1, 1, 1, '2021-05-23', 'Create, Read, Update, Delete OOP PHP'),
(2, 1, 2, '2021-05-30', 'Object Oriented Programming'),
(3, 1, 3, '2021-06-06', 'Pengenalan Web'),
(14, 2, 1, '2021-06-13', 'PHP Framework'),
(15, 2, 2, '2021-06-20', 'OOP');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`absensi_id`),
  ADD KEY `krs_id` (`krs_id`),
  ADD KEY `pertemuan_id` (`pertemuan_id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kelas_id`);

--
-- Indeks untuk tabel `krs`
--
ALTER TABLE `krs`
  ADD PRIMARY KEY (`krs_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `id` (`mahasiswa_id`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`mahasiswa_id`);

--
-- Indeks untuk tabel `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD PRIMARY KEY (`pertemuan_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `absensi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `krs`
--
ALTER TABLE `krs`
  MODIFY `krs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `mahasiswa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pertemuan`
--
ALTER TABLE `pertemuan`
  MODIFY `pertemuan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`pertemuan_id`) REFERENCES `pertemuan` (`pertemuan_id`),
  ADD CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`krs_id`) REFERENCES `krs` (`krs_id`);

--
-- Ketidakleluasaan untuk tabel `krs`
--
ALTER TABLE `krs`
  ADD CONSTRAINT `krs_ibfk_1` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`mahasiswa_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `krs_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`);

--
-- Ketidakleluasaan untuk tabel `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD CONSTRAINT `pertemuan_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
