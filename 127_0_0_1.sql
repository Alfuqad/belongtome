
-- Database: `pln_db`
--
CREATE DATABASE IF NOT EXISTS `pln_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pln_db`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Struktur dari tabel `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `folder` varchar(255) NOT NULL,
  `filetype` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `files`
--

INSERT INTO `files` (`id`, `filename`, `filepath`, `uploaded_at`, `folder`, `filetype`) VALUES
(1, 'ininyobaup.xlsx', '', '2025-03-13 03:45:48', 'nama_folder/', 'xlsx'),
(2, 'ininyobaup.xlsx', '', '2025-03-13 03:48:30', 'nama_folder/', 'xlsx'),
(3, 'ininyobaup.xlsx', '', '2025-03-13 03:48:42', 'nama_folder/', 'xlsx'),
(4, 'ininyobaup.xlsx', '', '2025-03-13 03:49:03', 'nama_folder/', 'xlsx'),
(5, 'ininyobaup.xlsx', '', '2025-03-13 03:53:16', 'nama_folder/', 'xlsx'),
(6, 'ininyobaup.xlsx', '', '2025-03-13 04:21:43', 'nama_folder/', 'xlsx'),
(7, 'ininyobaup.xlsx', '', '2025-03-13 04:22:52', 'nama_folder/', 'xlsx'),
(8, 'ininyobaup.xlsx', '', '2025-03-13 04:24:22', 'nama_folder/', 'xlsx'),
(9, 'ininyobaup.xlsx', '', '2025-03-13 04:26:20', 'nama_folder/', 'xlsx'),
(10, 'ininyobaup.xlsx', '', '2025-03-13 04:36:54', 'nama_folder/', 'xlsx');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ininyobaup`
--

CREATE TABLE `ininyobaup` (
  `id` int(11) NOT NULL,
  `IDPEL` text DEFAULT NULL,
  `NAMA` text DEFAULT NULL,
  `TARIP` text DEFAULT NULL,
  `DAYA` text DEFAULT NULL,
  `KDSWITCHING` text DEFAULT NULL,
  `KDBANK` text DEFAULT NULL,
  `BULAN` text DEFAULT NULL,
  `TGLBAYAR` text DEFAULT NULL,
  `UNITUP` text DEFAULT NULL,
  `NAMAUP` text DEFAULT NULL,
  `UNITAP` text DEFAULT NULL,
  `NAMAAP` text DEFAULT NULL,
  `PEMKWH` text DEFAULT NULL,
  `RPPTL` text DEFAULT NULL,
  `RPPPN` text DEFAULT NULL,
  `RPPPJ` text DEFAULT NULL,
  `RPANGS` text DEFAULT NULL,
  `RPMAT` text DEFAULT NULL,
  `RPPENJ` text DEFAULT NULL,
  `NAMAGARDU` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ininyobaup`
--

INSERT INTO `ininyobaup` (`id`, `IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
(1, '511404298220', 'IDA ERNAWATI', 'R1  ', '1300', '011CA01', '0110000', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '64.1', '92592', '0', '7408', '0', '0', '100000', 'BB202'),
(2, '511401846265', 'PERUMAHAN UKA            ', 'R1  ', '1300', '200CA01', '2000001', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '32.1', '46296', '0', '3704', '0', '0', '50000', 'BB029'),
(3, '511403825647', 'PATMIN', 'R1M ', '900', '117CA01', '1170010', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '137', '185185', '0', '14815', '0', '0', '200000', 'BB563'),
(4, '511402422610', 'SUTARI                   ', 'R1  ', '1300', '014CA01', '0140009', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '32.1', '46296', '0', '3704', '0', '0', '50000', 'BB1070'),
(5, '511403981200', 'H.LUTHFI A. ROCHIM', 'B2  ', '10600', '011CA01', '0110000', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '66', '95238', '0', '4762', '0', '0', '100000', 'BB1025'),
(6, '511403821719', 'SRI INDAH YANI', 'R1M ', '900', '117CA01', '1170010', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '68.5', '92592', '0', '7408', '0', '0', '100000', 'BB1054'),
(7, '511404131384', 'INDRA ACHMAD PRANATA (2)', 'R1  ', '1300', '200CA01', '2000001', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '12.9', '18518', '0', '1482', '0', '0', '20000', 'BB186'),
(8, '511404142310', 'HADI BAGUS SANTOSO 2', 'R1  ', '2200', '200CA01', '2000001', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '32.1', '46296', '0', '3704', '0', '0', '50000', 'BB353'),
(9, '511404266086', 'SALSABILA', 'R1M ', '900', '200CA01', '2000001', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '13.7', '18518', '0', '1482', '0', '0', '20000', 'BB135'),
(10, '511404017707', 'YUNIKE AGUSTIN', 'R1M ', '900', '117CA01', '1170010', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '34.3', '46296', '0', '3704', '0', '0', '50000', 'BB037'),
(11, '511403585137', 'PT GRAHA ANDALAN PERMAI', 'R1  ', '1300', '014CA01', '0140009', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '12.9', '18518', '0', '1482', '0', '0', '20000', 'BB740'),
(12, '511403680755', 'BAGUS SETIAWAN', 'R1M ', '900', '200CA01', '2000001', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '137', '185185', '0', '14815', '0', '0', '200000', 'BB1203'),
(13, '511401184582', 'PT DARMO GRANDE          ', 'R2  ', '3500', '200CA01', '2000001', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '544.9', '925925', '0', '74075', '0', '0', '1000000', 'BB011'),
(14, '511404325920', 'HENNY PERMATA', 'R1M ', '900', '200CA01', '2000001', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '13.7', '18518', '0', '1482', '0', '0', '20000', 'BB189'),
(15, '511403650447', 'SUTRIS', 'R1  ', '1300', '011CA01', '0110000', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '12.9', '18518', '0', '1482', '0', '0', '20000', 'BB402'),
(16, '511400784215', 'HASJIM                   ', 'R1  ', '1300', '200CA01', '2000001', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '128.2', '185185', '0', '14815', '0', '0', '200000', 'BB030'),
(17, '511403554161', 'MOCH ALWI', 'R1M ', '900', '028CA01', '0280011', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '34.3', '46296', '0', '3704', '0', '0', '50000', 'BB069'),
(18, '511403774938', 'RATIH SETIAWATI', 'B1  ', '450', '200CA01', '2000001', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '35.7', '19047', '0', '953', '0', '0', '20000', 'BB252'),
(19, '511404245788', 'HENDRY SETIONO CUSSOY', 'B1  ', '3500', '200CA01', '2000001', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '173.2', '190476', '0', '9524', '0', '0', '200000', 'BB1402'),
(20, '511403806355', 'SUKARNI', 'R1M ', '900', '200CA01', '2000001', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '68.5', '92592', '0', '7408', '0', '0', '100000', 'BB463'),
(21, '511403568591', 'DUL WASID', ' R1M', '900', '008CA01', '0080017', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '34.3', '46296', '0', '3704', '0', '0', '50000', 'BB112'),
(22, '511403977517', 'AAN HARTANTO', ' R1M', '900', '008CA01', '0080017', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '68.5', '92592', '0', '7408', '0', '0', '100000', 'BB792'),
(23, '511403996898', 'AGUNG INDRA MAWAN', 'R1  ', '2200', '008CA01', '0080017', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '64.1', '92592', '0', '7408', '0', '0', '100000', 'BB810'),
(24, '511403928468', 'ZAINI', 'R1M ', '900', '117CA01', '1170010', '202401', '20240101', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', '13.7', '18518', '0', '1482', '0', '0', '20000', 'BB1054');

--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ininyobaup`
--
ALTER TABLE `ininyobaup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `ininyobaup`
--
ALTER TABLE `ininyobaup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29652;
--
-- Database: `pln_db2024`
--
CREATE DATABASE IF NOT EXISTS `pln_db2024` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pln_db2024`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_agustus2024`
--

CREATE TABLE `lpb_agustus2024` (
  `IDPEL` varchar(100) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_agustus2024`
--

INSERT INTO `lpb_agustus2024` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_agustus2024', 'R1  ', 1300, '011CA01', '110000', 202408, '2024-08-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_april2024`
--

CREATE TABLE `lpb_april2024` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_april2024`
--

INSERT INTO `lpb_april2024` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_april2024', 'R1  ', 1300, '011CA01', '110000', 202404, '2024-04-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_desember2024`
--

CREATE TABLE `lpb_desember2024` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_desember2024`
--

INSERT INTO `lpb_desember2024` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_desember2024', 'R1  ', 1300, '011CA01', '110000', 202412, '2024-12-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_februari2024`
--

CREATE TABLE `lpb_februari2024` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_februari2024`
--

INSERT INTO `lpb_februari2024` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_februari2024', 'R1  ', 1300, '011CA01', '110000', 202402, '2024-02-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_januari2024`
--

CREATE TABLE `lpb_januari2024` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_januari2024`
--

INSERT INTO `lpb_januari2024` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_januari2024', 'R1  ', 1300, '011CA01', '110000', 202401, '2024-01-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_juli2024`
--

CREATE TABLE `lpb_juli2024` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_juli2024`
--

INSERT INTO `lpb_juli2024` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_juli2024', 'R1  ', 1300, '011CA01', '110000', 202407, '2024-07-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_juni2024`
--

CREATE TABLE `lpb_juni2024` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_juni2024`
--

INSERT INTO `lpb_juni2024` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_juni2024', 'R1  ', 1300, '011CA01', '110000', 202406, '2024-06-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_maret2024`
--

CREATE TABLE `lpb_maret2024` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_maret2024`
--

INSERT INTO `lpb_maret2024` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_maret2024', 'R1  ', 1300, '011CA01', '110000', 202403, '2024-03-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_mei2024`
--

CREATE TABLE `lpb_mei2024` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_mei2024`
--

INSERT INTO `lpb_mei2024` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_mei2024', 'R1  ', 1300, '011CA01', '110000', 202405, '2024-05-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_november2024`
--

CREATE TABLE `lpb_november2024` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_november2024`
--

INSERT INTO `lpb_november2024` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_november2024', 'R1  ', 1300, '011CA01', '110000', 202411, '2024-11-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_oktober2024`
--

CREATE TABLE `lpb_oktober2024` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_oktober2024`
--

INSERT INTO `lpb_oktober2024` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_oktober2024', 'R1  ', 1300, '011CA01', '110000', 202410, '2024-10-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_september2024`
--

CREATE TABLE `lpb_september2024` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_september2024`
--

INSERT INTO `lpb_september2024` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_september2024', 'R1  ', 1300, '011CA01', '110000', 202409, '2024-09-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

--


ALTER TABLE `lpb_januari2024` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_januari2024` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_januari2024` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_februari2024` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_februari2024` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_februari2024` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_maret2024` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_maret2024` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_maret2024` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_april2024` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_april2024` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_april2024` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_mei2024` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_mei2024` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_mei2024` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_juni2024` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_juni2024` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_juni2024` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_juli2024` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_juli2024` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_juli2024` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_agustus2024` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_agustus2024` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_agustus2024` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_september2024` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_september2024` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_september2024` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_oktober2024` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_oktober2024` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_oktober2024` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_november2024` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_november2024` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_november2024` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_desember2024` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_desember2024` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_desember2024` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;
--
-- Database: `pln_db2025`
--
CREATE DATABASE IF NOT EXISTS `pln_db2025` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pln_db2025`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_agustus2025`
--

CREATE TABLE `lpb_agustus2025` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_agustus2025`
--

INSERT INTO `lpb_agustus2025` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_agustus2025', 'R1  ', 1300, '011CA01', '110000', 202508, '2025-08-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_april2025`
--

CREATE TABLE `lpb_april2025` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_april2025`
--

INSERT INTO `lpb_april2025` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_april2025', 'R1  ', 1300, '011CA01', '110000', 202504, '2025-04-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_desember2025`
--

CREATE TABLE `lpb_desember2025` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_desember2025`
--

INSERT INTO `lpb_desember2025` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_desember2025', 'R1  ', 1300, '011CA01', '110000', 202512, '2025-12-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_februari2025`
--

CREATE TABLE `lpb_februari2025` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_februari2025`
--

INSERT INTO `lpb_februari2025` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_februari2025', 'R1  ', 1300, '011CA01', '110000', 202502, '2025-02-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_januari2025`
--

CREATE TABLE `lpb_januari2025` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_januari2025`
--

INSERT INTO `lpb_januari2025` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_januari2025', 'R1  ', 1300, '011CA01', '110000', 202501, '2025-01-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_juli2025`
--

CREATE TABLE `lpb_juli2025` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_juli2025`
--

INSERT INTO `lpb_juli2025` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_juli2025', 'R1  ', 1300, '011CA01', '110000', 202507, '2025-07-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_juni2025`
--

CREATE TABLE `lpb_juni2025` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_juni2025`
--

INSERT INTO `lpb_juni2025` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_juni2025', 'R1  ', 1300, '011CA01', '110000', 202506, '2025-06-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_maret2025`
--

CREATE TABLE `lpb_maret2025` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_maret2025`
--

INSERT INTO `lpb_maret2025` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_maret2025', 'R1  ', 1300, '011CA01', '110000', 202503, '2025-03-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_mei2025`
--

CREATE TABLE `lpb_mei2025` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_mei2025`
--

INSERT INTO `lpb_mei2025` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_mei2025', 'R1  ', 1300, '011CA01', '110000', 202505, '2025-05-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_november2025`
--

CREATE TABLE `lpb_november2025` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_november2025`
--

INSERT INTO `lpb_november2025` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_november2025', 'R1  ', 1300, '011CA01', '110000', 202511, '2025-11-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_oktober2025`
--

CREATE TABLE `lpb_oktober2025` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_oktober2025`
--

INSERT INTO `lpb_oktober2025` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_oktober2025', 'R1  ', 1300, '011CA01', '110000', 202510, '2025-10-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lpb_september2025`
--

CREATE TABLE `lpb_september2025` (
  `IDPEL` varchar(20) NOT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TARIP` varchar(10) DEFAULT NULL,
  `DAYA` int(11) DEFAULT NULL,
  `KDSWITCHING` varchar(20) DEFAULT NULL,
  `KDBANK` varchar(20) DEFAULT NULL,
  `BULAN` int(11) DEFAULT NULL,
  `TGLBAYAR` date DEFAULT NULL,
  `UNITUP` varchar(10) DEFAULT NULL,
  `NAMAUP` varchar(50) DEFAULT NULL,
  `UNITAP` varchar(10) DEFAULT NULL,
  `NAMAAP` varchar(50) DEFAULT NULL,
  `PEMKWH` float DEFAULT NULL,
  `RPPTL` int(11) DEFAULT NULL,
  `RPPPN` int(11) DEFAULT NULL,
  `RPPPJ` int(11) DEFAULT NULL,
  `RPANGS` int(11) DEFAULT NULL,
  `RPMAT` int(11) DEFAULT NULL,
  `RPPENJ` int(11) DEFAULT NULL,
  `NAMAGARDU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lpb_september2025`
--

INSERT INTO `lpb_september2025` (`IDPEL`, `NAMA`, `TARIP`, `DAYA`, `KDSWITCHING`, `KDBANK`, `BULAN`, `TGLBAYAR`, `UNITUP`, `NAMAUP`, `UNITAP`, `NAMAAP`, `PEMKWH`, `RPPTL`, `RPPPN`, `RPPPJ`, `RPANGS`, `RPMAT`, `RPPENJ`, `NAMAGARDU`) VALUES
('511404298220', 'lpb_september2025', 'R1  ', 1300, '011CA01', '110000', 202509, '2025-09-01', '51140', '51140-DARMO PERMAI', '51SBS', '51SBS-SURABAYA SELATAN', 64.1, 92592, 0, 7408, 0, 0, 100000, 'BB202');

--
-- Indexes for dumped tables
--

ALTER TABLE `lpb_januari2025` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_januari2025` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_januari2025` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_februari2025` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_februari2025` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_februari2025` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_maret2025` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_maret2025` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_maret2025` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_april2025` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_april2025` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_april2025` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_mei2025` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_mei2025` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_mei2025` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_juni2025` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_juni2025` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_juni2025` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_juli2025` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_juli2025` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_juli2025` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_agustus2025` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_agustus2025` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_agustus2025` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_september2025` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_september2025` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_september2025` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_oktober2025` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_oktober2025` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_oktober2025` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_november2025` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_november2025` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_november2025` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lpb_desember2025` ADD COLUMN `id` INT(20) NOT NULL FIRST;
ALTER TABLE `lpb_desember2025` ADD PRIMARY KEY (`id`);
ALTER TABLE `lpb_desember2025` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;


--
