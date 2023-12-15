-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 26 Okt 2023 pada 03.42
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absen`
--

CREATE TABLE `absen` (
  `id` int(30) NOT NULL,
  `bulan` varchar(100) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Jadwal_Kerja` varchar(50) NOT NULL,
  `Jabatan` varchar(50) NOT NULL,
  `tidak_hadir` int(50) NOT NULL,
  `sthari` int(50) NOT NULL,
  `gaji_pokok` varchar(50) NOT NULL,
  `uang_makan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(15) NOT NULL,
  `nama_admin` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nama_admin`, `email`, `username`, `password`) VALUES
(7, 'Muhammad Riafky Novalyansyah', 'A@Gmail.com', 'Admin', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(30) NOT NULL,
  `nama_jabatan` varchar(30) NOT NULL,
  `gaji_pokok` varchar(50) NOT NULL,
  `uang_makan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`, `gaji_pokok`, `uang_makan`) VALUES
(8, 'Admin', '2800000', '322000'),
(9, 'Supervisor', '2500000', '312000'),
(10, 'Cashier', '1500000', '312000'),
(11, 'Waitress', '1500000', '312000'),
(12, 'Chef', '2000000', '312000'),
(13, 'Helper', '1500000', '312000'),
(14, 'Bar', '2000000', '312000'),
(15, 'test', '1000', '2000'),
(75, 'mencoba', '200000', '50000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(25) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Jabatan` varchar(30) NOT NULL,
  `Jenis_Kelamin` varchar(30) NOT NULL,
  `Jadwal_Kerja` varchar(30) NOT NULL,
  `Tanggal_Masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id`, `Nama`, `Jabatan`, `Jenis_Kelamin`, `Jadwal_Kerja`, `Tanggal_Masuk`) VALUES
(28, 'Muhammad Riafky Novalyans', 'Admin', 'LAKI-LAKI', '06:00 pagi - 15:00 Sore', '2023-10-05'),
(29, 'Reza Ardian', 'Supervisor', 'LAKI-LAKI', '16:00 Sore - 24:00 Malam', '2023-10-05'),
(30, 'Winta', 'Cashier', 'PEREMPUAN', '06:00 pagi - 15:00 Sore', '2023-10-05'),
(33, 'trio', 'Helper', 'LAKI-LAKI', '06:00 pagi - 15:00 Sore', '2023-10-06'),
(34, 'Nabil', 'Supervisor', 'LAKI-LAKI', '06:00 pagi - 15:00 Sore', '2023-10-05'),
(37, 'Ray Bagastian', 'Chef', 'LAKI-LAKI', '16:00 Sore - 24:00 Malam', '2023-10-06'),
(38, 'Yanti', 'Bar', 'PEREMPUAN', '06:00 pagi - 15:00 Sore', '2023-10-06'),
(121, 'Nabil Ferdana', 'Admin', 'LAKI-LAKI', '06:00 pagi - 15:00 Sore', '2023-10-05'),
(123, 'Yanti', 'Cashier', 'PEREMPUAN', '16:00 Sore - 24:00 Malam', '2023-10-06'),
(124, 'Girina', 'mencoba', 'PEREMPUAN', '16:00 Sore - 24:00 Malam', '2023-10-16'),
(191, 'Alip', 'Waitress', 'LAKI-LAKI', '16:00 Sore - 24:00 Malam', '2023-10-25');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absen`
--
ALTER TABLE `absen`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
