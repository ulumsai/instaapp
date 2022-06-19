-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Jun 2022 pada 09.34
-- Versi server: 10.4.13-MariaDB
-- Versi PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instaapp`
--
CREATE DATABASE IF NOT EXISTS `instaapp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `instaapp`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_status` int(11) DEFAULT NULL,
  `nourut` int(11) DEFAULT NULL,
  `komen` text DEFAULT NULL,
  `pengomen` varchar(100) DEFAULT NULL,
  `dikomen` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `like`
--

CREATE TABLE `like` (
  `id_like` int(11) NOT NULL,
  `penyuka` varchar(100) DEFAULT NULL,
  `disuka` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `like`
--

INSERT INTO `like` (`id_like`, `penyuka`, `disuka`, `timestamp`, `id_status`) VALUES
(6, 'sai', 'sai', '2022-06-19 01:02:54', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE `status` (
  `id_status` int(11) NOT NULL,
  `status` varchar(250) NOT NULL,
  `tgl_status` date NOT NULL,
  `jam_status` time NOT NULL,
  `username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`id_status`, `status`, `tgl_status`, `jam_status`, `username`) VALUES
(3, 'kutipan hari ini', '2022-06-18', '18:35:45', 'sai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tambah_teman`
--

CREATE TABLE `tambah_teman` (
  `username_1` varchar(30) NOT NULL,
  `username_2` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `nama_depan` varchar(30) NOT NULL,
  `nama_belakang` varchar(30) NOT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`nama_depan`, `nama_belakang`, `jenis_kelamin`, `email`, `username`, `password`) VALUES
('saiful', 'ulum', 'L', 'saifululum@gmail.com', 'sai', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`);

--
-- Indeks untuk tabel `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`id_like`);

--
-- Indeks untuk tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`),
  ADD KEY `username` (`username`);

--
-- Indeks untuk tabel `tambah_teman`
--
ALTER TABLE `tambah_teman`
  ADD UNIQUE KEY `username_1` (`username_1`,`username_2`),
  ADD KEY `username_2` (`username_2`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `like`
--
ALTER TABLE `like`
  MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `status`
--
ALTER TABLE `status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Ketidakleluasaan untuk tabel `tambah_teman`
--
ALTER TABLE `tambah_teman`
  ADD CONSTRAINT `tambah_teman_ibfk_1` FOREIGN KEY (`username_1`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `tambah_teman_ibfk_2` FOREIGN KEY (`username_2`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
