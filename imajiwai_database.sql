-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 20 Okt 2025 pada 21.26
-- Versi server: 10.6.22-MariaDB-cll-lve
-- Versi PHP: 8.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imajiwai_database`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absent_requests`
--

CREATE TABLE `absent_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `director_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `director_approved_at` timestamp NULL DEFAULT NULL,
  `supervisor_approved_at` timestamp NULL DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type_absent` varchar(255) DEFAULT NULL,
  `hrd_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hrd_approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `absent_requests`
--

INSERT INTO `absent_requests` (`id`, `employee_id`, `start_date`, `end_date`, `notes`, `file_path`, `file_url`, `director_id`, `supervisor_id`, `director_approved_at`, `supervisor_approved_at`, `is_approved`, `created_at`, `updated_at`, `type_absent`, `hrd_id`, `hrd_approved_at`) VALUES
(1, 100000027, '2024-12-13', '2024-12-15', 'izin cuti 13 -15 desember, Jumat - minggu, senin 16 desember masuk', NULL, NULL, 100000033, 100000057, NULL, NULL, 0, '2024-09-25 12:12:05', '2024-09-25 12:12:05', NULL, NULL, NULL),
(5, 100000050, '2024-11-22', '2024-11-27', 'pulang', NULL, NULL, 100000019, 100000014, '2024-11-21 14:55:12', NULL, 0, '2024-11-20 13:00:38', '2024-11-21 14:55:12', 'izin', 100000022, NULL),
(7, 100000050, '2025-02-17', '2025-02-21', 'Lomba Kampus', NULL, NULL, 100000019, 100000014, NULL, NULL, 0, '2025-02-16 12:24:40', '2025-02-16 12:24:40', 'izin', 100000022, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `announcements_recipients`
--

CREATE TABLE `announcements_recipients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `announcement_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `machine_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attendance_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `site_id` bigint(20) UNSIGNED DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendance_methods`
--

CREATE TABLE `attendance_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `attendance_methods`
--

INSERT INTO `attendance_methods` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Access Control', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendance_temps`
--

CREATE TABLE `attendance_temps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `machine_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attendance_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `site_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `category_inventories`
--

CREATE TABLE `category_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `category_inventories`
--

INSERT INTO `category_inventories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(17, 'Electronic', 'electronic', 'Epson Printing L3250', '2024-10-02 09:55:52', '2024-10-02 09:55:52'),
(18, 'CABLE', 'cable', 'NETLINE', '2024-10-11 10:47:46', '2024-10-11 10:47:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `category_projects`
--

CREATE TABLE `category_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Nama kategori proyek',
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `daily_reports`
--

CREATE TABLE `daily_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `day` int(10) UNSIGNED DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `daily_report_comments`
--

CREATE TABLE `daily_report_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `daily_report_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `seen_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `daily_report_reads`
--

CREATE TABLE `daily_report_reads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `daily_report_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `daily_report_recipients`
--

CREATE TABLE `daily_report_recipients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `daily_report_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `site_id` bigint(20) UNSIGNED NOT NULL,
  `supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `director_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `departments`
--

INSERT INTO `departments` (`id`, `name`, `site_id`, `supervisor_id`, `created_at`, `updated_at`, `director_id`) VALUES
(1, 'THE MAIN COMMISSIONER', 1, NULL, NULL, NULL, NULL),
(2, 'COMMISSIONER', 1, NULL, NULL, NULL, NULL),
(3, 'PRESIDENT DIRECTOR', 1, NULL, NULL, NULL, NULL),
(4, 'HRD', 1, NULL, NULL, NULL, NULL),
(5, 'PROJECT', 1, NULL, NULL, '2024-09-23 11:40:58', 100000012),
(6, 'FINANCE', 1, NULL, NULL, '2024-09-23 11:41:10', 100000002),
(7, 'TECHNICAL', 1, 100000014, NULL, '2024-09-23 11:42:04', 100000019),
(8, 'CREATIVE DESIGN TEAM', 1, 100000010, NULL, '2024-09-23 11:45:22', 100000033),
(9, 'CREATIVE TEAM', 1, 100000057, '2024-09-23 11:46:38', '2024-09-23 11:46:38', 100000033);

-- --------------------------------------------------------

--
-- Struktur dari tabel `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `email_templates`
--

INSERT INTO `email_templates` (`id`, `slug`, `name`, `subject`, `body`, `created_at`, `updated_at`) VALUES
(1, 'new-account-register-edit', 'new account register edit', 'Informasi Akun Imajiwa', '<p>Dear {{ $user-&gt;name }},</p><p>Berikut adalah informasi akun yang telah dibuat untuk Anda guna mengakses sistem di database.imajiwa.id:</p><p>Detail Akun:</p><p>Nama: {{ $user-&gt;username }}</p><p>Email: {{ $user-&gt;email }}</p><p>Password: {{ $user-&gt;password_string }}</p><p>Harap pastikan untuk menyimpan informasi ini dengan aman. Anda dapat menggunakan email dan password yang tercantum di atas untuk mengakses pada sistem.</p><p>Terima kasih atas perhatian dan kerjasamanya.</p>', '2024-09-03 08:43:40', '2024-09-30 08:52:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `citizen_id` varchar(255) DEFAULT NULL,
  `leave_remaining` int(11) NOT NULL DEFAULT 0,
  `join_date` date DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `position_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `personal_information` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `citizen_id`, `leave_remaining`, `join_date`, `birth_date`, `place_of_birth`, `gender`, `marital_status`, `religion`, `position_id`, `created_at`, `updated_at`, `personal_information`) VALUES
(17, 20, '3174072903780001', 0, '2018-01-02', '1978-03-29', 'MISSOURI.AS', 'male', 'married', 'katholik', 1, '2024-09-03 08:32:38', '2024-09-03 08:32:38', NULL),
(100000002, 14, '3604056905780105', 12, '2018-01-02', '1978-05-29', 'CILEGON', 'female', 'married', 'islam', 9, '2024-09-03 08:32:38', '2024-09-03 08:32:38', NULL),
(100000003, 12, '3174054604940003', 12, '2021-09-12', '1994-04-06', 'JAKARTA', 'female', 'married', 'islam', 11, '2024-09-03 08:32:38', '2024-09-03 08:32:38', NULL),
(100000004, 174, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-23 10:32:04', NULL, NULL),
(100000005, 41, '3577024910000001', 12, '2022-01-31', '2000-10-09', 'MADIUN', 'female', 'single', 'islam', 10, '2024-09-03 08:32:41', '2024-09-03 08:32:41', NULL),
(100000006, 173, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-23 10:31:55', NULL, NULL),
(100000007, 179, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-23 10:34:05', NULL, NULL),
(100000008, 34, '3507262302980001', 12, '2022-05-17', '1998-02-23', 'MALANG', 'male', 'single', 'islam', 14, '2024-09-03 08:32:40', '2024-09-03 08:32:40', NULL),
(100000009, 177, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-23 10:32:15', NULL, NULL),
(100000010, 35, '3174051307760007', 12, '2022-09-05', '1976-07-13', 'JAKARTA', 'male', 'married', 'islam', 16, '2024-09-03 08:32:40', '2024-09-03 08:32:40', NULL),
(100000011, 172, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-23 10:31:47', NULL, NULL),
(100000012, 5, '3507182907890007', 12, '2018-01-02', '1989-07-29', 'MALANG', 'male', 'married', 'islam', 5, '2024-09-03 08:32:37', '2024-09-03 08:32:37', NULL),
(100000014, 13, '3374111503890001', 0, '2020-03-01', '1989-03-15', 'YOGYAKARTA', 'male', 'married', 'islam', 13, '2024-09-03 08:32:38', '2024-09-10 15:30:15', 'Suca pelak ook, nang noi nang noi nang noi'),
(100000015, 25, '3521022608960002', 12, '2021-04-01', '1996-08-26', 'NGAWI', 'male', 'single', 'islam', 17, '2024-09-03 08:32:39', '2024-09-03 08:32:39', NULL),
(100000016, 23, '3205100305970004', 12, '2021-05-19', '1997-06-03', 'GARUT', 'male', 'married', 'islam', 19, '2024-09-03 08:32:39', '2024-09-03 08:32:39', NULL),
(100000018, 18, '3315162601910004', 12, '2022-01-07', '1991-01-26', 'GROBOGAN', 'male', 'married', 'islam', 7, '2024-09-03 08:32:38', '2024-09-05 13:59:22', NULL),
(100000019, 10, '3577030111780002', 12, '2018-01-02', '1978-11-01', 'MADIUN', 'male', 'married', 'islam', 12, '2024-09-03 08:32:38', '2024-09-03 08:32:38', NULL),
(100000020, 30, '1806200208870002', 12, '2022-09-12', '1987-08-02', 'GISTING', 'male', 'married', 'islam', 14, '2024-09-03 08:32:39', '2024-09-03 08:32:39', NULL),
(100000021, 178, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-23 10:34:00', NULL, NULL),
(100000022, 36, '3174070112710007', 12, '2024-03-01', '1971-12-01', 'JAKARTA', 'male', 'married', 'islam', 4, '2024-09-03 08:32:40', '2024-10-03 11:06:59', NULL),
(100000023, 175, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-23 10:32:09', NULL, NULL),
(100000024, 21, '1805222610990001', 12, '2022-05-17', '1999-10-26', 'GEDUNG JAYA', 'male', 'single', 'islam', 14, '2024-09-03 08:32:39', '2024-09-03 08:32:39', NULL),
(100000025, 37, '3521140605950001', 12, '2018-01-02', '1995-05-06', 'NGAWI', 'male', 'single', 'islam', 20, '2024-09-03 08:32:40', '2024-09-03 08:32:40', NULL),
(100000026, 15, '3275060710940009', 12, '2022-07-01', '1994-10-07', 'JAYAPURA', 'male', 'married', 'islam', 21, '2024-09-03 08:32:38', '2024-09-09 12:33:15', '2D & 3D Motion Designer Imajiwa'),
(100000027, 8, '3507132710000002', 12, '2022-03-01', '2000-10-27', 'MALANG', 'male', 'single', 'islam', 21, '2024-09-03 08:32:37', '2024-09-03 08:32:37', NULL),
(100000028, 4, '3171070203961002', 12, '2021-04-01', '1996-03-02', 'KARAWANG', 'male', 'single', 'islam', 21, '2024-09-03 08:32:37', '2024-09-03 08:32:37', NULL),
(100000030, 19, '3521020704880002', 12, '2021-09-01', '1988-04-07', 'NGAWI', 'male', 'single', 'islam', 7, '2024-09-03 08:32:38', '2024-09-05 13:54:12', NULL),
(100000031, 11, '3520111611910001', 12, '2022-01-10', '1991-11-16', 'MAGETAN', 'male', 'married', 'islam', 14, '2024-09-03 08:32:38', '2024-09-03 08:32:38', NULL),
(100000033, 38, '3577022705890001', 12, '2018-01-02', '1989-05-27', 'MADIUN', 'male', 'single', 'kristen', 15, '2024-09-03 08:32:40', '2024-09-23 11:51:00', NULL),
(100000043, 17, '3674011707010002', 12, '2023-03-08', '2001-07-17', 'TANGERANG', 'male', 'single', 'islam', 21, '2024-09-03 08:32:38', '2024-09-03 08:32:38', NULL),
(100000044, 40, '1307080201900001', 12, '2023-03-08', '1990-01-02', 'KOTO TINGGI', 'male', 'single', 'islam', 21, '2024-09-03 08:32:40', '2024-11-05 10:45:05', '.................................................'),
(100000045, 28, '3201300602000007', 12, '2023-03-08', '2000-02-06', 'BOGOR', 'male', 'single', 'islam', 21, '2024-09-03 08:32:39', '2024-09-03 08:32:39', NULL),
(100000046, 6, '3201302010920004', 12, '2023-03-08', '1992-10-20', 'BOGOR', 'male', 'married', 'islam', 21, '2024-09-03 08:32:37', '2024-09-03 08:32:37', NULL),
(100000047, 176, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-23 10:32:12', NULL, NULL),
(100000048, 22, '3276030401980005', 12, '2023-07-01', '1998-01-04', 'JAKARTA', 'male', 'single', 'kristen', 21, '2024-09-03 08:32:39', '2024-09-03 08:32:39', NULL),
(100000049, 29, '3276031402970003', 12, '2023-07-10', '1997-02-14', 'BOGOR', 'male', 'single', 'islam', 7, '2024-09-03 08:32:39', '2024-09-05 13:54:39', NULL),
(100000050, 31, '3577030302060001', 12, '2023-07-27', '2006-02-03', 'KOTA MADIUN', 'male', 'single', 'islam', 14, '2024-09-03 08:32:40', '2024-09-03 08:32:40', NULL),
(100000055, 180, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-20 12:26:43', NULL, NULL),
(100000057, 27, '3513140109870003', 12, '2023-01-18', '1987-09-01', 'PROBOLINGGO', 'male', 'married', 'islam', 18, '2024-09-03 08:32:39', '2024-09-03 08:32:39', NULL),
(100000058, 171, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-23 10:31:16', NULL, NULL),
(100000059, 33, '3277020412980007', 12, '2024-01-02', '1998-12-04', 'BANDUNG', 'male', 'single', 'islam', 8, '2024-09-03 08:32:40', '2024-09-03 08:32:40', NULL),
(100000061, 24, '7326015510000001', 12, '2024-01-08', '2000-10-15', 'RANTEPAO', 'male', 'single', 'kristen', 6, '2024-09-03 08:32:39', '2024-09-03 08:32:39', NULL),
(100000062, 9, '3519111011920001', 12, '2023-10-29', '1992-11-10', 'MADIUN', 'male', 'married', 'islam', 17, '2024-09-03 08:32:37', '2024-09-03 08:32:37', NULL),
(100000063, 26, '3519025105960003', 12, '2023-10-29', '1996-05-11', 'MADIUN', 'female', 'married', 'islam', 17, '2024-09-03 08:32:39', '2024-09-09 15:28:27', ''),
(100000064, 7, '3275011107970012', 12, '2024-05-06', '1997-07-11', 'JAKARTA', 'male', 'single', 'islam', 21, '2024-09-03 08:32:37', '2024-09-03 08:32:37', NULL),
(100000065, 39, '3508050109960002', 12, '2024-05-27', '1996-09-01', 'LUMAJANG', 'male', 'married', 'islam', 17, '2024-09-03 08:32:40', '2024-12-16 11:08:43', ''),
(100000071, 32, '3327112806900005', 12, '2024-08-12', '1990-06-28', 'BANDUNG', 'male', 'single', 'islam', 21, '2024-09-03 08:32:40', '2024-09-09 11:51:08', NULL),
(100000072, 16, '3172066601920003', 12, '2024-08-12', '1992-01-26', 'JAKARTA', 'female', 'single', 'katholik', 16, '2024-09-03 08:32:38', '2025-03-18 10:30:44', NULL),
(100000075, 182, '3507181908990001', 12, '2025-03-03', '1999-08-19', 'MALANG', 'male', 'single', 'islam', 14, '2025-03-26 09:21:27', '2025-03-26 09:32:43', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees_positions`
--

CREATE TABLE `employees_positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `position_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_inventories`
--

CREATE TABLE `employee_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `returned_at` timestamp NULL DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `employee_inventories`
--

INSERT INTO `employee_inventories` (`id`, `employee_id`, `inventory_id`, `status_id`, `assigned_at`, `returned_at`, `notes`, `created_at`, `updated_at`) VALUES
(1, 100000057, 3, 2, '2024-12-31 17:00:00', '2025-01-21 17:00:00', 'RUSAK', '2024-12-16 08:08:54', '2025-01-22 10:32:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `financial_requests`
--

CREATE TABLE `financial_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `receipt_image_path` text DEFAULT NULL,
  `receipt_image_url` text DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_inventory_id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `qr_code_url` varchar(255) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `director_id` bigint(20) UNSIGNED DEFAULT NULL,
  `commissioner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `director_approved_at` timestamp NULL DEFAULT NULL,
  `commissioner_approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `inventories`
--

INSERT INTO `inventories` (`id`, `request_id`, `category_inventory_id`, `status_id`, `name`, `slug`, `description`, `serial_number`, `image_path`, `image_url`, `qr_code_path`, `qr_code_url`, `purchase_date`, `price`, `created_at`, `updated_at`, `model`, `qty`, `director_id`, `commissioner_id`, `director_approved_at`, `commissioner_approved_at`) VALUES
(2, NULL, 17, NULL, 'Epson Printing L3250', 'epson-printing-l3250', '-', 'X8JXL56355', '[\"inventory-images\\/dQ9BeEiuJLNBTtZv25vliki8xspoQ7E0lbixqRmT.jpg\"]', NULL, '1siG', NULL, NULL, NULL, '2024-10-02 09:56:16', '2025-01-22 10:39:55', 'C634H', 1, NULL, 20, '2024-10-02 09:56:16', '2024-10-02 09:56:16'),
(3, NULL, 17, NULL, 'Oculus VR Headset', 'oculus-vr-headset', '-', 'KW49CM', '[\"inventory-images\\/Xpv5swb514Ts84kO4EohfRuOSf0Kk9qdXJA1MlPd.jpg\"]', NULL, 'LSVg', NULL, NULL, NULL, '2024-10-02 09:57:50', '2025-01-22 10:38:02', 'IWMHHA41081383', 1, NULL, 20, '2024-10-02 09:57:50', '2024-10-02 09:57:50'),
(4, NULL, 17, NULL, 'Microsoft Azure Kinect DK', 'microsoft-azure-kinect-dk', '-', '000134922712', '[\"inventory-images\\/eUV9sPf8fKBiIdmosCMlCMVYuOyv5hw6aYkODiYh.jpg\"]', NULL, 'ChLs', NULL, NULL, NULL, '2024-10-02 10:03:35', '2025-01-22 10:34:35', '1880', 1, NULL, 20, '2024-10-02 10:03:35', '2024-10-02 10:03:35'),
(5, NULL, 17, NULL, 'Samsung Galaxy S23 Ultra', 'samsung-galaxy-s23-ultra', '-', 'RRCW201BZ7L', '[\"inventory-images\\/ytqP6Ejt6oGv3jnY60wej0hiiPF40VqdFpqce2VM.webp\"]', NULL, 'Vzzt', NULL, NULL, NULL, '2024-10-02 10:24:22', '2025-01-22 10:40:46', 'SM-5918B/DS', 1, NULL, 20, '2024-10-02 10:24:22', '2024-10-02 10:24:22'),
(6, NULL, 17, NULL, 'Tp-Link Ax3000 , dual Band , Gigabit wi-fi 6 Router', 'tp-link-ax3000-dual-band-gigabit-wi-fi-6-router', '-', '221C485003275', '[\"inventory-images\\/Jtsg50aEtuzxoyRUqV188Z1CKz1xbzELTW7E9cLj.jpg\"]', NULL, 'mv0U', NULL, NULL, NULL, '2024-10-02 11:00:22', '2025-01-22 10:45:52', 'Archer AX50 (US)', 1, NULL, 20, '2024-10-02 11:00:22', '2024-10-02 11:00:22'),
(7, NULL, 17, NULL, 'M-tech 2in1 Quality Trust Audio Receiver/Transmitter', 'm-tech-2in1-quality-trust-audio-receivertransmitter', '-', '-', '[]', NULL, 'L56w', NULL, NULL, NULL, '2024-10-02 11:56:23', '2025-01-22 11:45:13', 'BT30', 1, NULL, 20, '2024-10-02 11:56:23', '2024-10-02 11:56:23'),
(8, NULL, 17, NULL, 'RUIZU MP3', 'ruizu-mp3', '-', '0755.85270948', NULL, NULL, 'HL2T', NULL, NULL, NULL, '2024-10-02 11:57:18', '2024-12-20 13:44:35', 'X20', 1, NULL, 20, '2024-10-02 11:57:18', '2024-10-02 11:57:18'),
(9, NULL, 17, NULL, 'dbe acoustics comfortable Bluetooth Headphone ', 'dbe-acoustics-comfortable-bluetooth-headphone', '-', '-', NULL, NULL, 'SECw', NULL, NULL, NULL, '2024-10-02 11:58:34', '2024-12-20 13:44:35', 'HBT 80', 1, NULL, 20, '2024-10-02 11:58:34', '2024-10-02 11:58:34'),
(10, NULL, 17, NULL, 'Black Magic design Ultra Studio Mini Recorder', 'black-magic-design-ultra-studio-mini-recorder', '1', '9338716001846', NULL, NULL, 'tEYl', NULL, NULL, NULL, '2024-10-02 12:00:23', '2024-12-20 13:44:35', 'BDLKULSDZMINREC', 1, NULL, 20, '2024-10-02 12:00:23', '2024-10-02 12:00:23'),
(11, NULL, 17, NULL, 'Black Magic Design Micro Converter Bidi Rectional SDI/HDMI 3G', 'black-magic-design-micro-converter-bidi-rectional-sdihdmi-3g', '-', '9338716006995,9338716007053', '[\"inventory-images\\/mjnSubwFpRToD86CNpqMcQ79W8IYEpXn2UylxzeU.webp\"]', NULL, 'hnrz', NULL, NULL, NULL, '2024-10-03 10:01:24', '2025-01-22 11:46:09', 'CONVBDC/SDI/HDMI 03G/P', 2, NULL, 20, '2024-10-03 10:01:24', '2024-10-03 10:01:24'),
(12, NULL, 17, NULL, 'Bardi IP Camera', 'bardi-ip-camera', '-', 'SZJSFD077DFD84954B7,SZJSAC8A712B030C7714,SZJS075503EB60B9C59D,SZJSCD32FAABC59BFD57,SZJS075503EB60B9C59D', NULL, NULL, 'phnj', NULL, NULL, NULL, '2024-10-03 10:04:54', '2024-12-20 13:44:35', 'outdoor PTZ TPD ', 5, NULL, 20, '2024-10-03 10:04:54', '2024-10-03 10:04:54'),
(13, NULL, 17, NULL, 'Black Magic design Intensity Pro 4k', 'black-magic-design-intensity-pro-4k', '-', '9338716003062', NULL, NULL, 'wCKP', NULL, NULL, NULL, '2024-10-03 10:07:07', '2024-12-20 13:44:35', 'BINTSP1204K', 1, NULL, 20, '2024-10-03 10:07:07', '2024-10-03 10:07:07'),
(14, NULL, 17, NULL, 'Siminics Lidar', 'siminics-lidar', '-', 'S23812005,S23812002,S23812014 ( ADIDAS ),S2381200E,S23812015,S23812003,S2381200B,S23812000,S2381200D,S23812011 ( ERROR )', NULL, NULL, 'r2fo', NULL, NULL, NULL, '2024-10-03 10:28:55', '2024-12-20 13:44:35', 'PAVO SIMO-LS-20H', 10, NULL, 20, '2024-10-03 10:28:55', '2024-10-03 10:28:55'),
(15, NULL, 17, NULL, '8A WISDOM FAST CHARGER', '8a-wisdom-fast-charger', '-', '-', NULL, NULL, 'fM4T', NULL, NULL, NULL, '2024-10-03 10:30:00', '2024-12-20 13:44:35', 'YC-CDA19Q', 2, NULL, 20, '2024-10-03 10:30:00', '2024-10-03 10:30:00'),
(16, NULL, 17, NULL, 'WLN ( HT ) Professional FM Transceiver', 'wln-ht-professional-fm-transceiver', '-', '2304 A0 5428,2304 A0 5400,2304 A0 5363,2304 A0 5401,2304 A0 5439,2304 A0 5431,2304 A0 5409,2304 A0 5369,2304 A0 5366,2304 A0 5438', NULL, NULL, 'jIOA', NULL, NULL, NULL, '2024-10-11 10:46:58', '2024-12-20 13:44:35', 'KD-C1', 10, NULL, 20, '2024-10-11 10:46:58', '2024-10-11 10:46:58'),
(17, NULL, 18, NULL, 'Netline ', 'netline', '-', '-', NULL, NULL, 'gHs8', NULL, NULL, NULL, '2024-10-11 10:49:01', '2024-12-20 13:44:36', ' USB 3.0 Active Extension Cable 20M', 1, NULL, 20, '2024-10-11 10:49:01', '2024-10-11 10:49:01'),
(18, NULL, 17, NULL, 'Arctic ( Kipas Angin PC )', 'arctic-kipas-angin-pc', '-', '-', NULL, NULL, 'fpOb', NULL, NULL, NULL, '2024-10-11 10:50:04', '2024-12-20 13:44:36', 'F14 PWM PST', 4, NULL, 20, '2024-10-11 10:50:04', '2024-10-11 10:50:04'),
(19, NULL, 17, NULL, 'AJA Video System GEN 10', 'aja-video-system-gen-10', '-', '8 92448 00041 0', NULL, NULL, '1JV1', NULL, NULL, NULL, '2024-10-11 10:51:04', '2024-12-20 13:44:36', '180 Litton Drive , Grass Valley . CA 95945', 1, NULL, 20, '2024-10-11 10:51:04', '2024-10-11 10:51:04'),
(20, NULL, 17, NULL, 'Deskstop Barcode Reader', 'deskstop-barcode-reader', '-', 'T97240306012 ', NULL, NULL, 'htoZ', NULL, NULL, NULL, '2024-10-11 10:52:28', '2024-12-20 13:44:36', 'T97-white ( USB )', 4, NULL, 20, '2024-10-11 10:52:28', '2024-10-11 10:52:28'),
(21, NULL, 17, NULL, 'UltraLeap ( Leap Motion )', 'ultraleap-leap-motion', '-', '-', NULL, NULL, 'Fzqm', NULL, NULL, NULL, '2024-10-11 10:53:20', '2024-12-20 13:44:36', 'UltraLeap ( Leap Motion )', 2, NULL, 20, '2024-10-11 10:53:20', '2024-10-11 10:53:20'),
(22, NULL, 17, NULL, 'Ultraleap2 ( Motion Controller )', 'ultraleap2-motion-controller', '-', '-', NULL, NULL, 'yCuu', NULL, NULL, NULL, '2024-10-11 10:54:32', '2024-12-20 13:44:36', 'USB 3 Type-C to Type-C Cable', 2, NULL, 20, '2024-10-11 10:54:32', '2024-10-11 10:54:32'),
(23, NULL, 17, NULL, 'Ultraleap2 ( Motion Controller )', 'ultraleap2-motion-controller', '1', 'LE610000200000AAF2,LE540000200000A91B', NULL, NULL, 'BTrg', NULL, NULL, NULL, '2024-10-11 10:56:31', '2024-12-20 13:44:36', 'XR Headset Mount', 2, NULL, 20, '2024-10-11 10:56:31', '2024-10-11 10:56:31'),
(24, NULL, 17, NULL, 'FEELWORLD MASTER ( Field Monitor )', 'feelworld-master-field-monitor', '-', 'MA51901796', NULL, NULL, 'QmHR', NULL, NULL, NULL, '2024-10-11 10:57:34', '2024-12-20 13:44:36', 'MA5', 1, NULL, 20, '2024-10-11 10:57:34', '2024-10-11 10:57:34'),
(25, NULL, 17, NULL, 'RealSense', 'realsense', '-', '-1', NULL, NULL, 'lZyn', NULL, NULL, NULL, '2024-10-11 10:58:02', '2024-12-20 13:44:36', '-', 1, NULL, 20, '2024-10-11 10:58:02', '2024-10-11 10:58:02'),
(26, NULL, 17, NULL, 'KIWI design Off-Ear Audio strap ', 'kiwi-design-off-ear-audio-strap', '-', 'X0038VU92D', NULL, NULL, 'OM1r', NULL, NULL, NULL, '2024-10-11 11:00:56', '2024-12-20 13:44:36', 'KW-QA01-US', 1, NULL, 20, '2024-10-11 11:00:56', '2024-10-11 11:00:56'),
(27, NULL, 17, NULL, 'Desview Telepromter TP150', 'desview-telepromter-tp150', '-', '-', NULL, NULL, 'DkwY', NULL, NULL, NULL, '2024-10-11 11:03:18', '2024-12-20 13:44:36', 'M0CUTE-052F', 1, NULL, 20, '2024-10-11 11:03:18', '2024-10-11 11:03:18'),
(28, NULL, 17, NULL, 'Tp-link 8-port Gigabit. Desktop Switch', 'tp-link-8-port-gigabit-desktop-switch', '-', '2228319007339,22253Q6004382', NULL, NULL, 'xXEt', NULL, NULL, NULL, '2024-10-11 11:04:00', '2024-12-20 13:44:36', 'TL-SG1008D ( UN )', 2, NULL, 20, '2024-10-11 11:04:00', '2024-10-11 11:04:00'),
(29, NULL, 17, NULL, 'MI 4K Laser Projector 150\"', 'mi-4k-laser-projector-150', '-', '28179/40001298,28179/40001147,28179/40001475,28179/40001477', NULL, NULL, 'ZelK', NULL, NULL, NULL, '2024-10-11 11:06:16', '2024-12-20 13:44:36', 'XMJGTYDS01FM', 4, NULL, 20, '2024-10-11 11:06:16', '2024-10-11 11:06:16'),
(30, NULL, 17, NULL, 'Tenda 24GE=2SFP Ethernet Switch with 24 Port PoE ( LAN Cable )', 'tenda-24ge2sfp-ethernet-switch-with-24-port-poe-lan-cable', '-', 'EB171110240000031,EB171110241000121', NULL, NULL, 'DzA7', NULL, NULL, NULL, '2024-10-11 11:08:36', '2024-12-20 13:44:36', 'TEG1126P-24-410W', 2, NULL, 20, '2024-10-11 11:08:36', '2024-10-11 11:08:36'),
(31, NULL, 17, NULL, 'Seagate Expansion HDD 4TB', 'seagate-expansion-hdd-4tb', '-', 'NT170AT0', NULL, NULL, 'yic8', NULL, NULL, NULL, '2024-10-11 11:13:12', '2024-12-20 13:44:36', 'SRD0NF2', 1, NULL, 20, '2024-10-11 11:13:12', '2024-10-11 11:13:12'),
(32, NULL, 17, NULL, 'BenQ Digital Projector', 'benq-digital-projector', '-', 'PD42E02996000S', NULL, NULL, 'ph3A', NULL, NULL, NULL, '2024-10-21 09:46:54', '2024-12-20 13:44:36', 'MS521P', 1, NULL, 20, '2024-10-21 09:46:54', '2024-10-21 09:46:54'),
(33, NULL, 17, NULL, 'Starlink ', 'starlink', '-', 'KIT303949514', NULL, NULL, 'nLzF', NULL, NULL, NULL, '2024-10-23 10:49:57', '2024-12-20 13:44:36', '-', 1, NULL, 20, '2024-10-23 10:49:57', '2024-10-23 10:49:57'),
(34, NULL, 17, NULL, 'Starlink Ethernet Adapter', 'starlink-ethernet-adapter', '-', '01519231-502', NULL, NULL, 'G97R', NULL, NULL, NULL, '2024-10-23 10:51:12', '2024-12-20 13:44:36', 'HONSUW-1-A-231005', 1, NULL, 20, '2024-10-23 10:51:12', '2024-10-23 10:51:12'),
(35, NULL, 17, NULL, 'Label Printer', 'label-printer', '-', '-', NULL, NULL, '00AG', NULL, NULL, NULL, '2024-10-23 10:58:21', '2024-12-20 13:44:36', 'PT - H110', 1, NULL, 20, '2024-10-23 10:58:21', '2024-10-23 10:58:21'),
(36, NULL, 17, NULL, 'Logitech Pebble 2 M350s Mouse Wireless', 'logitech-pebble-2-m350s-mouse-wireless', '-', '-', NULL, NULL, '9N9v', NULL, NULL, NULL, '2024-10-23 10:59:23', '2024-12-20 13:44:36', '-', 1, NULL, 20, '2024-10-23 10:59:23', '2024-10-23 10:59:23'),
(37, NULL, 17, NULL, 'Monitor LED Digital Alliance Bezelless 24\" inch  IPS 75HZ HDMI VGA - AGP', 'monitor-led-digital-alliance-bezelless-24-inch-ips-75hz-hdmi-vga-agp', '-', '-', NULL, NULL, 'nTuH', NULL, NULL, NULL, '2024-10-23 10:59:58', '2024-12-20 13:44:36', '-', 1, NULL, 20, '2024-10-23 10:59:58', '2024-10-23 10:59:58'),
(38, NULL, 17, NULL, 'Apple Pencil Gen2', 'apple-pencil-gen2', '-', 'H9DMQ5L3JKM9,H9DMQS1PJKM9,H9DMQZVUJKM9', NULL, NULL, 'lfBW', NULL, NULL, NULL, '2024-10-23 11:02:54', '2024-12-20 13:44:36', 'A2051', 3, NULL, 20, '2024-10-23 11:02:54', '2024-10-23 11:02:54'),
(39, NULL, 17, NULL, 'iPad Pro 11\" Gen4 128GB Silver', 'ipad-pro-11-gen4-128gb-silver', '-', 'ND9LRXW7JF', NULL, NULL, 'CmF3', NULL, NULL, NULL, '2024-10-23 11:09:12', '2024-12-20 13:44:36', '-', 1, NULL, 20, '2024-10-23 11:09:12', '2024-10-23 11:09:12'),
(40, NULL, 17, NULL, 'iPad Pro 12.9\"  GEN4 256GB Silver', 'ipad-pro-129-gen4-256gb-silver', '-', 'KD220JP45C,LMJ46J0HKK', NULL, NULL, 'QRCi', NULL, NULL, NULL, '2024-10-23 11:09:57', '2024-12-20 13:44:36', '-', 2, NULL, 20, '2024-10-23 11:09:57', '2024-10-23 11:09:57'),
(41, NULL, 17, NULL, 'iPad Smart Keyboard ', 'ipad-smart-keyboard', '-', 'FTPF407TMJ66', NULL, NULL, '4JhX', NULL, NULL, NULL, '2024-10-23 11:13:18', '2024-12-20 13:44:36', 'MXNK2LL/A ', 1, NULL, 20, '2024-10-23 11:13:18', '2024-10-23 11:13:18'),
(42, NULL, 18, NULL, 'USB TYPE C 3.1 HUB CONVERTER 6 IN 1', 'usb-type-c-31-hub-converter-6-in-1', '-', '-', NULL, NULL, 'lql3', NULL, NULL, NULL, '2024-10-23 11:14:02', '2024-12-20 13:44:36', 'UCH16', 4, NULL, 20, '2024-10-23 11:14:02', '2024-10-23 11:14:02'),
(43, NULL, 17, NULL, 'Lexae SSD Portable 1TB', 'lexae-ssd-portable-1tb', '-', '0824R2026560589', NULL, NULL, 'Imcx', NULL, NULL, NULL, '2024-10-23 11:14:50', '2024-12-20 13:44:36', 'SL600', 1, NULL, 20, '2024-10-23 11:14:50', '2024-10-23 11:14:50'),
(44, NULL, 17, NULL, 'MSI VECTOR A14VHG 16 I9 14900HX RTX4080 16GB 1TB', 'msi-vector-a14vhg-16-i9-14900hx-rtx4080-16gb-1tb', 'Visual Lab', 'K2407N0137766', NULL, NULL, 'lv0g', NULL, NULL, NULL, '2024-10-23 11:16:31', '2024-12-20 13:44:36', 'Vector 17', 1, NULL, 20, '2024-10-23 11:16:31', '2024-10-23 11:16:31'),
(45, NULL, 17, NULL, 'Seagate Hardisk 6TB', 'seagate-hardisk-6tb', 'BARU 11/11/2024', 'NAE81JDN', NULL, NULL, 'z5ZO', NULL, NULL, NULL, '2024-11-11 08:45:37', '2024-12-20 13:44:36', 'STLC60000400', 1, NULL, 20, '2024-11-11 08:45:37', '2024-11-11 08:45:37'),
(46, NULL, 17, NULL, 'Logitech Lightsync Gaming Mouse G102', 'logitech-lightsync-gaming-mouse-g102', 'Warna Hitam\nJeson , Fikri ', '2440APRDAX39,2440AP7DAXV9', NULL, NULL, 'fuhX', NULL, NULL, NULL, '2024-11-25 07:41:54', '2024-12-20 13:44:36', 'G102 LIGHTSYNC', 2, NULL, 20, '2024-11-25 07:41:54', '2024-11-25 07:41:54'),
(47, NULL, 17, NULL, 'Logitech Lightsync Gaming Mouse G102', 'logitech-lightsync-gaming-mouse-g102', 'Warna Putih \nMajazul Haq', '2440APA3F089', NULL, NULL, 'BEqv', NULL, NULL, NULL, '2024-11-25 07:43:51', '2024-12-20 13:44:36', 'G102 LIGHTSYNC', 1, NULL, 20, '2024-11-25 07:43:51', '2024-11-25 07:43:51'),
(48, NULL, 17, NULL, 'FANTECH PRO WIRELESS GAMING MOUSE ', 'fantech-pro-wireless-gaming-mouse', 'WARNA HITAM', '4241010200916', NULL, NULL, 'M2GL', NULL, NULL, NULL, '2024-11-25 08:36:06', '2024-12-20 13:44:36', 'HELIOS GO XD5', 1, NULL, 20, '2024-11-25 08:36:06', '2024-11-25 08:36:06'),
(50, 1, 17, NULL, 'test request item 1', 'test-request-item-1', 'test request item', NULL, NULL, NULL, 'VbJO', NULL, '2024-11-25', 1000.00, '2024-11-25 11:01:40', '2024-12-20 13:44:36', NULL, 1, NULL, 20, NULL, NULL),
(51, 2, 18, NULL, 'test', 'test', 'tset', NULL, NULL, NULL, 'XaEP', NULL, '2024-11-25', 120000.00, '2024-11-25 11:13:38', '2024-12-20 13:44:36', NULL, 1, NULL, 20, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `current_total_leave` int(10) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `total_leave_after_request` int(10) UNSIGNED NOT NULL,
  `director_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `director_approved_at` timestamp NULL DEFAULT NULL,
  `supervisor_approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_days` int(10) UNSIGNED DEFAULT NULL,
  `hrd_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hrd_approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `employee_id`, `start_date`, `end_date`, `current_total_leave`, `notes`, `total_leave_after_request`, `director_id`, `supervisor_id`, `director_approved_at`, `supervisor_approved_at`, `created_at`, `updated_at`, `total_days`, `hrd_id`, `hrd_approved_at`) VALUES
(5, 100000031, '2025-03-13', '2025-03-14', 12, 'Urusan Keluarga', 10, 100000019, 100000014, NULL, '2025-03-11 16:38:43', '2025-03-11 16:36:53', '2025-03-11 16:38:43', 2, 100000022, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `machines`
--

CREATE TABLE `machines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `port` varchar(255) DEFAULT NULL,
  `comkey` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_active` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `machines`
--

INSERT INTO `machines` (`id`, `name`, `ip_address`, `port`, `comkey`, `password`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 'mesin', '192.168.88.40', '80', '1', 'password', '1', '2024-09-10 11:53:41', '2025-08-08 12:38:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2018_08_08_100000_create_telescope_entries_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_07_29_023429_create_permission_tables', 1),
(7, '2024_07_29_040131_create_sites_table', 1),
(8, '2024_07_29_040329_create_machines_table', 1),
(9, '2024_07_29_062419_create_visit_categories_table', 1),
(10, '2024_07_29_062909_create_attendance_methods_table', 1),
(11, '2024_07_29_063115_create_employees_table', 1),
(12, '2024_07_29_063116_create_departments_table', 1),
(13, '2024_07_29_063117_create_positions_table', 1),
(14, '2024_07_29_063231_create_announcements_table', 1),
(15, '2024_07_29_063232_create_announcements_recipients_table', 1),
(16, '2024_07_29_063248_create_daily_reports_table', 1),
(17, '2024_07_29_063415_create_daily_report_recipients_table', 1),
(18, '2024_07_29_063508_create_daily_report_reads_table', 1),
(19, '2024_07_29_063522_create_daily_report_comments_table', 1),
(20, '2024_07_29_063529_create_attendances_table', 1),
(21, '2024_07_29_063549_create_financial_requests_table', 1),
(22, '2024_07_29_063652_create_leave_requests_table', 1),
(23, '2024_07_29_063734_create_absent_requests_table', 1),
(24, '2024_07_29_063810_create_visits_table', 1),
(25, '2024_07_29_081455_create_request_reads_table', 1),
(26, '2024_07_29_081500_create_request_validates_table', 1),
(27, '2024_07_29_081512_create_request_recipients_table', 1),
(28, '2024_07_29_084901_employees_positions', 1),
(29, '2024_07_29_154816_create_attendance_temps_table', 1),
(30, '2024_07_31_141354_create_activity_log_table', 1),
(31, '2024_07_31_141355_add_event_column_to_activity_log_table', 1),
(32, '2024_07_31_141356_add_batch_uuid_column_to_activity_log_table', 1),
(33, '2024_08_13_021925_create_jobs_table', 1),
(34, '2024_08_22_180114_create_projects_table', 1),
(35, '2024_08_22_180848_projects_employees', 1),
(36, '2024_08_27_014732_create_email_templates_table', 1),
(37, '2024_09_02_180522_create_status_inventories_table', 1),
(38, '2024_09_02_181640_create_category_inventories_table', 1),
(39, '2024_09_02_181651_create_inventories_table', 1),
(40, '2024_09_02_182007_create_employee_inventories_table', 1),
(41, '2024_09_04_192820_add_personal_to_employees_table', 2),
(42, '2024_09_06_203937_add_columns_to_inventories_table', 3),
(43, '2024_09_11_173508_project_additional_managers', 3),
(44, '2024_09_13_174503_add_request_id_to_inventories_table', 4),
(45, '2024_09_13_175053_create_requests_table', 4),
(46, '2024_09_16_220527_add_director_id_to_departments_table', 4),
(61, '2024_09_17_020422_add_type_absent_to_absent_requests_table', 5),
(62, '2024_09_17_052159_add_total_days_to_leave_requests_table', 5),
(63, '2024_09_18_193107_create_notifications_table', 5),
(64, '2024_09_19_202203_modify_inventories_table', 5),
(65, '2024_09_19_202210_create_request_items_table', 6),
(66, '2025_01_14_165409_create_clients_table', 7),
(67, '2025_01_14_165639_create_category_projects_table', 7),
(68, '2025_01_14_165942_add_new_to_projects_table', 7),
(69, '2025_03_10_032735_create_social_accounts_table', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 41),
(4, 'App\\Models\\User', 36),
(5, 'App\\Models\\User', 20),
(5, 'App\\Models\\User', 44),
(5, 'App\\Models\\User', 45),
(5, 'App\\Models\\User', 46),
(5, 'App\\Models\\User', 47),
(5, 'App\\Models\\User', 48),
(5, 'App\\Models\\User', 49),
(5, 'App\\Models\\User', 50),
(5, 'App\\Models\\User', 51),
(5, 'App\\Models\\User', 52),
(5, 'App\\Models\\User', 53),
(5, 'App\\Models\\User', 54),
(5, 'App\\Models\\User', 55),
(5, 'App\\Models\\User', 56),
(5, 'App\\Models\\User', 57),
(5, 'App\\Models\\User', 58),
(5, 'App\\Models\\User', 59),
(5, 'App\\Models\\User', 60),
(5, 'App\\Models\\User', 61),
(5, 'App\\Models\\User', 62),
(5, 'App\\Models\\User', 63),
(5, 'App\\Models\\User', 64),
(5, 'App\\Models\\User', 65),
(5, 'App\\Models\\User', 66),
(5, 'App\\Models\\User', 67),
(5, 'App\\Models\\User', 68),
(5, 'App\\Models\\User', 69),
(5, 'App\\Models\\User', 70),
(5, 'App\\Models\\User', 71),
(5, 'App\\Models\\User', 72),
(5, 'App\\Models\\User', 73),
(5, 'App\\Models\\User', 74),
(5, 'App\\Models\\User', 75),
(5, 'App\\Models\\User', 76),
(5, 'App\\Models\\User', 77),
(5, 'App\\Models\\User', 78),
(5, 'App\\Models\\User', 79),
(5, 'App\\Models\\User', 80),
(5, 'App\\Models\\User', 81),
(5, 'App\\Models\\User', 82),
(5, 'App\\Models\\User', 83),
(5, 'App\\Models\\User', 84),
(5, 'App\\Models\\User', 85),
(5, 'App\\Models\\User', 86),
(5, 'App\\Models\\User', 87),
(5, 'App\\Models\\User', 88),
(5, 'App\\Models\\User', 89),
(5, 'App\\Models\\User', 90),
(5, 'App\\Models\\User', 91),
(5, 'App\\Models\\User', 92),
(5, 'App\\Models\\User', 93),
(5, 'App\\Models\\User', 94),
(5, 'App\\Models\\User', 95),
(5, 'App\\Models\\User', 96),
(5, 'App\\Models\\User', 97),
(5, 'App\\Models\\User', 98),
(5, 'App\\Models\\User', 99),
(5, 'App\\Models\\User', 100),
(5, 'App\\Models\\User', 101),
(5, 'App\\Models\\User', 102),
(5, 'App\\Models\\User', 103),
(5, 'App\\Models\\User', 104),
(5, 'App\\Models\\User', 105),
(5, 'App\\Models\\User', 106),
(5, 'App\\Models\\User', 107),
(5, 'App\\Models\\User', 108),
(5, 'App\\Models\\User', 109),
(5, 'App\\Models\\User', 110),
(5, 'App\\Models\\User', 111),
(5, 'App\\Models\\User', 112),
(5, 'App\\Models\\User', 113),
(5, 'App\\Models\\User', 114),
(5, 'App\\Models\\User', 115),
(5, 'App\\Models\\User', 116),
(5, 'App\\Models\\User', 117),
(5, 'App\\Models\\User', 118),
(5, 'App\\Models\\User', 119),
(5, 'App\\Models\\User', 120),
(5, 'App\\Models\\User', 121),
(5, 'App\\Models\\User', 122),
(5, 'App\\Models\\User', 123),
(5, 'App\\Models\\User', 124),
(5, 'App\\Models\\User', 125),
(5, 'App\\Models\\User', 126),
(5, 'App\\Models\\User', 127),
(5, 'App\\Models\\User', 128),
(5, 'App\\Models\\User', 129),
(5, 'App\\Models\\User', 130),
(5, 'App\\Models\\User', 131),
(5, 'App\\Models\\User', 132),
(5, 'App\\Models\\User', 133),
(5, 'App\\Models\\User', 134),
(5, 'App\\Models\\User', 135),
(5, 'App\\Models\\User', 136),
(5, 'App\\Models\\User', 137),
(5, 'App\\Models\\User', 138),
(5, 'App\\Models\\User', 139),
(5, 'App\\Models\\User', 140),
(5, 'App\\Models\\User', 141),
(5, 'App\\Models\\User', 142),
(5, 'App\\Models\\User', 143),
(5, 'App\\Models\\User', 144),
(5, 'App\\Models\\User', 145),
(5, 'App\\Models\\User', 146),
(5, 'App\\Models\\User', 147),
(5, 'App\\Models\\User', 148),
(5, 'App\\Models\\User', 149),
(5, 'App\\Models\\User', 150),
(5, 'App\\Models\\User', 151),
(5, 'App\\Models\\User', 152),
(5, 'App\\Models\\User', 153),
(5, 'App\\Models\\User', 154),
(5, 'App\\Models\\User', 155),
(5, 'App\\Models\\User', 156),
(5, 'App\\Models\\User', 157),
(5, 'App\\Models\\User', 158),
(5, 'App\\Models\\User', 159),
(5, 'App\\Models\\User', 160),
(5, 'App\\Models\\User', 161),
(5, 'App\\Models\\User', 162),
(5, 'App\\Models\\User', 163),
(5, 'App\\Models\\User', 164),
(5, 'App\\Models\\User', 165),
(5, 'App\\Models\\User', 166),
(5, 'App\\Models\\User', 167),
(5, 'App\\Models\\User', 168),
(5, 'App\\Models\\User', 169),
(5, 'App\\Models\\User', 170),
(6, 'App\\Models\\User', 4),
(6, 'App\\Models\\User', 5),
(6, 'App\\Models\\User', 6),
(6, 'App\\Models\\User', 7),
(6, 'App\\Models\\User', 8),
(6, 'App\\Models\\User', 9),
(6, 'App\\Models\\User', 10),
(6, 'App\\Models\\User', 11),
(6, 'App\\Models\\User', 12),
(6, 'App\\Models\\User', 13),
(6, 'App\\Models\\User', 14),
(6, 'App\\Models\\User', 15),
(6, 'App\\Models\\User', 16),
(6, 'App\\Models\\User', 17),
(6, 'App\\Models\\User', 18),
(6, 'App\\Models\\User', 19),
(6, 'App\\Models\\User', 21),
(6, 'App\\Models\\User', 22),
(6, 'App\\Models\\User', 23),
(6, 'App\\Models\\User', 24),
(6, 'App\\Models\\User', 25),
(6, 'App\\Models\\User', 26),
(6, 'App\\Models\\User', 27),
(6, 'App\\Models\\User', 28),
(6, 'App\\Models\\User', 29),
(6, 'App\\Models\\User', 30),
(6, 'App\\Models\\User', 31),
(6, 'App\\Models\\User', 32),
(6, 'App\\Models\\User', 33),
(6, 'App\\Models\\User', 34),
(6, 'App\\Models\\User', 35),
(6, 'App\\Models\\User', 36),
(6, 'App\\Models\\User', 37),
(6, 'App\\Models\\User', 38),
(6, 'App\\Models\\User', 39),
(6, 'App\\Models\\User', 40),
(6, 'App\\Models\\User', 41),
(6, 'App\\Models\\User', 42),
(6, 'App\\Models\\User', 43),
(6, 'App\\Models\\User', 171),
(6, 'App\\Models\\User', 172),
(6, 'App\\Models\\User', 173),
(6, 'App\\Models\\User', 174),
(6, 'App\\Models\\User', 175),
(6, 'App\\Models\\User', 176),
(6, 'App\\Models\\User', 177),
(6, 'App\\Models\\User', 178),
(6, 'App\\Models\\User', 179),
(6, 'App\\Models\\User', 180),
(6, 'App\\Models\\User', 181),
(6, 'App\\Models\\User', 182),
(6, 'App\\Models\\User', 183),
(7, 'App\\Models\\User', 5),
(7, 'App\\Models\\User', 18),
(7, 'App\\Models\\User', 19),
(7, 'App\\Models\\User', 24),
(7, 'App\\Models\\User', 29),
(7, 'App\\Models\\User', 33);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view:dashboard', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(2, 'view:import_master_data', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(3, 'view:export_master_data', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(4, 'view:user', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(5, 'create:user', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(6, 'update:user', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(7, 'delete:user', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(8, 'view:employee', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(9, 'create:employee', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(10, 'update:employee', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(11, 'delete:employee', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(12, 'view:position', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(13, 'create:position', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(14, 'update:position', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(15, 'delete:position', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(16, 'view:department', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(17, 'create:department', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(18, 'update:department', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(19, 'delete:department', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(20, 'view:site', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(21, 'create:site', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(22, 'update:site', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(23, 'delete:site', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(24, 'view:visit-all', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(25, 'view:visit', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(26, 'create:visit', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(27, 'update:visit', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(28, 'delete:visit', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(29, 'view:visit-category', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(30, 'create:visit-category', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(31, 'update:visit-category', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(32, 'delete:visit-category', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(33, 'view:email-template', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(34, 'create:email-template', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(35, 'update:email-template', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(36, 'delete:email-template', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(37, 'view:machine', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(38, 'create:machine', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(39, 'update:machine', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(40, 'delete:machine', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(41, 'view:attendance-all', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(42, 'view:attendance', 'web', '2024-09-03 08:29:47', '2024-09-03 08:29:47'),
(43, 'create:attendance', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(44, 'update:attendance', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(45, 'delete:attendance', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(46, 'view:attendance-temp-all', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(47, 'view:attendance-temp', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(48, 'create:attendance-temp', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(49, 'update:attendance-temp', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(50, 'delete:attendance-temp', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(51, 'approve:attendance-temp', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(52, 'view:role', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(53, 'create:role', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(54, 'update:role', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(55, 'delete:role', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(56, 'view:permission', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(57, 'create:permission', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(58, 'update:permission', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(59, 'delete:permission', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(60, 'view:setting', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(61, 'create:setting', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(62, 'update:setting', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(63, 'delete:setting', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(64, 'view:daily-report-all', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(65, 'view:daily-report', 'web', '2024-09-03 08:29:48', '2024-09-03 08:29:48'),
(66, 'create:daily-report', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(67, 'update:daily-report', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(68, 'delete:daily-report', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(69, 'view:announcement', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(70, 'create:announcement', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(71, 'update:announcement', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(72, 'delete:announcement', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(73, 'view:financial-request-all', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(74, 'view:financial-request', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(75, 'create:financial-request', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(76, 'update:financial-request', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(77, 'delete:financial-request', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(78, 'approve:financial-request', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(79, 'view:absent-request-all', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(80, 'view:absent-request', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(81, 'create:absent-request', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(82, 'update:absent-request', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(83, 'delete:absent-request', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(84, 'approve:absent-request', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(85, 'view:leave-request-all', 'web', '2024-09-03 08:29:49', '2024-09-03 08:29:49'),
(86, 'view:leave-request', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(87, 'create:leave-request', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(88, 'update:leave-request', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(89, 'delete:leave-request', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(90, 'approve:leave-request', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(91, 'view:report-attendance', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(92, 'view:report-daily-report', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(93, 'view:report-financial-request', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(94, 'view:report-absent-request', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(95, 'view:report-leave-request', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(96, 'view:report-visit', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(97, 'view:project-all', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(98, 'view:project', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(99, 'create:project', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(100, 'update:project', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(101, 'delete:project', 'web', '2024-09-03 08:29:50', '2024-09-03 08:29:50'),
(102, 'view:profile', 'web', '2024-09-03 08:29:51', '2024-09-03 08:29:51'),
(103, 'update:profile', 'web', '2024-09-03 08:29:51', '2024-09-03 08:29:51'),
(104, 'view:category-inventory-all', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(105, 'view:category-inventory', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(106, 'create:category-inventory', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(107, 'update:category-inventory', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(108, 'delete:category-inventory', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(109, 'view:inventory-all', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(110, 'view:inventory', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(111, 'create:inventory', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(112, 'update:inventory', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(113, 'delete:inventory', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(114, 'view:item-request-all', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(115, 'view:item-request', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(116, 'create:item-request', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(117, 'update:item-request', 'web', '2024-09-09 08:15:55', '2024-09-09 08:15:55'),
(118, 'delete:item-request', 'web', '2024-09-09 08:15:56', '2024-09-09 08:15:56'),
(119, 'approve:item-request', 'web', '2024-09-09 08:15:56', '2024-09-09 08:15:56'),
(120, 'export:project', 'web', '2024-09-09 10:42:26', '2024-09-09 10:42:26'),
(121, 'permission:employee', 'web', '2024-09-25 17:04:10', '2024-09-25 17:04:10'),
(122, 'view:employee-inventory', 'web', '2024-12-16 08:06:04', '2024-12-16 08:06:04'),
(123, 'create:employee-inventory', 'web', '2024-12-16 08:06:05', '2024-12-16 08:06:05'),
(124, 'update:employee-inventory', 'web', '2024-12-16 08:06:05', '2024-12-16 08:06:05'),
(125, 'delete:employee-inventory', 'web', '2024-12-16 08:06:05', '2024-12-16 08:06:05'),
(126, 'view:status-inventory', 'web', '2024-12-16 08:06:05', '2024-12-16 08:06:05'),
(127, 'create:status-inventory', 'web', '2024-12-16 08:06:05', '2024-12-16 08:06:05'),
(128, 'update:status-inventory', 'web', '2024-12-16 08:06:05', '2024-12-16 08:06:05'),
(129, 'delete:status-inventory', 'web', '2024-12-16 08:06:05', '2024-12-16 08:06:05'),
(130, 'view:report', 'web', '2025-01-07 10:21:54', '2025-01-07 10:21:54'),
(131, 'view:client', 'web', '2025-01-14 13:20:09', '2025-01-14 13:20:09'),
(132, 'create:client', 'web', '2025-01-14 13:20:09', '2025-01-14 13:20:09'),
(133, 'update:client', 'web', '2025-01-14 13:20:09', '2025-01-14 13:20:09'),
(134, 'delete:client', 'web', '2025-01-14 13:20:09', '2025-01-14 13:20:09'),
(135, 'view:category-project', 'web', '2025-01-14 13:20:09', '2025-01-14 13:20:09'),
(136, 'create:category-project', 'web', '2025-01-14 13:20:09', '2025-01-14 13:20:09'),
(137, 'update:category-project', 'web', '2025-01-14 13:20:09', '2025-01-14 13:20:09'),
(138, 'delete:category-project', 'web', '2025-01-14 13:20:10', '2025-01-14 13:20:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `positions`
--

INSERT INTO `positions` (`id`, `name`, `description`, `department_id`, `created_at`, `updated_at`) VALUES
(1, 'CHIEF COMMISSIONER', NULL, 1, NULL, NULL),
(2, 'COMMISSIONER', NULL, 2, NULL, NULL),
(3, 'PRESIDENT DIRECTOR', NULL, 3, NULL, NULL),
(4, 'HUMAN RESOURCES MANAGER', NULL, 4, NULL, NULL),
(5, 'PROJECT DIRECTOR', NULL, 5, NULL, NULL),
(6, 'ACCOUNT EXECUTIVE', NULL, 5, NULL, NULL),
(7, 'CREATIVE DESIGN TEAM', NULL, 5, NULL, NULL),
(8, 'MARKETING', NULL, 5, NULL, NULL),
(9, 'FINANCE DIRECTOR', NULL, 6, NULL, NULL),
(10, 'ADMINISTRATOR', NULL, 6, NULL, NULL),
(11, 'FINANCE OFFICER', NULL, 6, NULL, NULL),
(12, 'TECHNICAL DIRECTOR', NULL, 7, NULL, NULL),
(13, 'VISUAL LAB HEAD', NULL, 7, NULL, NULL),
(14, 'VISUAL LAB TEAM', NULL, 7, NULL, NULL),
(15, 'CREATIVE DIRECTOR', NULL, 8, NULL, NULL),
(16, 'CREATIVE PLANNER', NULL, 8, NULL, NULL),
(17, 'CREATIVE DESIGN TEAM', NULL, 8, NULL, NULL),
(18, 'CREATIVE HEAD', NULL, 9, NULL, '2024-09-23 11:52:38'),
(19, 'TECHNICAL LEAD', NULL, 9, NULL, '2024-09-23 11:52:54'),
(20, 'MOTION LEAD', NULL, 9, NULL, '2024-09-23 11:53:07'),
(21, 'CREATIVE TEAM', NULL, 9, NULL, '2024-09-23 11:53:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('not_started','in_progress','completed','on_hold','cancelled') NOT NULL DEFAULT 'not_started',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `projects`
--

INSERT INTO `projects` (`id`, `employee_id`, `name`, `code`, `description`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`, `category_id`, `client_id`, `image`) VALUES
(1, 100000012, 'Sensorial Game Frestea', NULL, 'Sensorial Game Frestea', '2024-02-10', '2024-02-11', 'completed', '2024-09-03 08:47:37', '2024-09-06 14:32:54', NULL, NULL, NULL),
(2, 100000018, 'Telkom Click', NULL, 'Telkom Click Launching', '2024-01-13', '2024-01-13', 'completed', '2024-09-03 11:19:35', '2024-09-06 04:28:24', NULL, NULL, NULL),
(3, 100000059, 'MC AI - PLN Award', NULL, 'Developing a character to use for MC combining with a suit for motion capture', '2024-02-22', '2024-03-20', 'completed', '2024-09-05 12:05:13', '2024-09-05 12:11:15', NULL, NULL, NULL),
(4, 100000030, 'Multimedia Weichai', NULL, 'Weichai Event', '2024-01-18', '2024-01-18', 'completed', '2024-09-05 12:06:13', '2024-09-05 12:08:14', NULL, NULL, NULL),
(5, 100000059, 'Video Mapping - LPS Monas Half Marathon', NULL, 'Developing a motion to use when race pack collection at the dome SPARK', '2024-06-24', '2024-06-29', 'completed', '2024-09-05 12:10:50', '2024-09-05 12:10:50', NULL, NULL, NULL),
(6, 100000030, 'Iqos Remake/Resize Content for DWP/Remake', NULL, 'Remake content', '2024-02-02', '2024-02-02', 'completed', '2024-09-05 12:12:59', '2024-09-05 12:12:59', NULL, NULL, NULL),
(7, 100000030, 'Video Opening Show BAC (Bayern Annual Conference)', NULL, 'Video Opening', '2024-03-04', '2024-03-04', 'completed', '2024-09-05 12:19:40', '2024-09-05 12:19:40', NULL, NULL, NULL),
(8, 100000030, 'Magnum Hammersonic 2024', NULL, 'Video Brand Momment', '2024-05-04', '2024-05-04', 'completed', '2024-09-05 12:22:29', '2024-09-05 12:22:29', NULL, NULL, NULL),
(9, 100000030, 'Greeting PT Bank Mandiri Tbk', NULL, 'Video Greetings', '2024-02-20', '2024-02-20', 'completed', '2024-09-05 12:27:48', '2024-09-05 12:27:48', NULL, NULL, NULL),
(10, 100000030, 'Samsung B6Q6', NULL, 'Pagination ', '2024-07-11', '2024-07-11', 'completed', '2024-09-05 12:32:50', '2024-09-05 12:32:50', NULL, NULL, NULL),
(11, 100000030, 'Sampoerna', NULL, 'Meta Human', '2024-08-27', '2024-08-27', 'completed', '2024-09-05 12:34:58', '2024-09-05 12:34:58', NULL, NULL, NULL),
(12, 100000030, 'Iqos new stay Curious Neon Device', NULL, 'video vertical n horisontal', '2024-06-25', '2024-06-25', 'completed', '2024-09-05 12:41:23', '2024-09-05 12:41:23', NULL, NULL, NULL),
(13, 100000061, 'Video Lunch New Packaging GS Astra x Darbotz', NULL, 'Video Lunch New Packaging GS Astra x Darbotz - PT Astra Otoparts Tbk', '2024-06-19', '2024-07-11', 'completed', '2024-09-05 13:54:30', '2024-09-09 13:00:09', NULL, NULL, NULL),
(14, 100000049, 'Watchparty Samsung S24', NULL, 'Launch Samsung S24', '2024-01-18', '2024-01-18', 'completed', '2024-09-05 13:57:41', '2024-09-05 13:57:41', NULL, NULL, NULL),
(15, 100000049, 'Pagination Samsung S24', NULL, 'Launched Samsung S24', '2024-02-01', '2024-02-01', 'completed', '2024-09-05 13:59:06', '2024-09-05 13:59:06', NULL, NULL, NULL),
(16, 100000061, 'Multimedia BGLF & BEA (BRI)', NULL, 'Visual content of the opening of BRI Group Leadership Forum (BGLF) 2024', '2024-07-02', '2024-07-26', 'completed', '2024-09-05 14:07:20', '2024-09-06 01:57:43', NULL, NULL, NULL),
(17, 100000049, 'Multimedia Fashion Show Modinity', NULL, 'Modinity Group PT Alia Kreasi Mandiri', '2024-02-17', '2024-03-09', 'completed', '2024-09-05 14:10:28', '2024-09-05 14:10:28', NULL, NULL, NULL),
(19, 100000049, 'Allianz - AAPN 2024 virtual foyer & multimedia performance', NULL, 'PT Trimar Musik\n', '2024-05-07', '2024-05-07', 'completed', '2024-09-05 14:11:55', '2024-09-05 14:11:55', NULL, NULL, NULL),
(20, 100000049, 'Multimedia Culture Summit 2024', NULL, 'PT Kreasi Lima Perdana\n', '2024-06-13', '2024-06-14', 'completed', '2024-09-05 14:16:57', '2024-09-05 14:16:57', NULL, NULL, NULL),
(21, 100000049, 'PIEP Iraq PERTAMINA', NULL, 'Launching PIEP Irak Package Design KV & Multimedia\n\n\n', '2024-07-03', '2024-07-03', 'completed', '2024-09-05 14:18:30', '2024-09-05 14:18:30', NULL, NULL, NULL),
(22, 100000049, 'Multimedia Fashion Show Chromatics (Maisonmet)', NULL, 'Kontent Visual', '2024-08-09', '2024-08-09', 'completed', '2024-09-05 14:20:43', '2024-09-05 14:20:43', NULL, NULL, NULL),
(23, 100000049, 'Mandiri Harpelnas', NULL, 'SHOOT VIDIO HARPELNAS', '2024-09-04', '2024-09-04', 'completed', '2024-09-05 16:06:12', '2024-09-05 16:06:12', NULL, NULL, NULL),
(24, 100000049, 'Central Park 15th ANNIVERSARY', NULL, 'Visual Performance, Bumper & Live Cam', '2024-09-05', '2024-09-05', 'completed', '2024-09-05 16:07:47', '2024-09-16 16:10:59', NULL, NULL, NULL),
(25, 100000049, 'CDC 2024', NULL, 'KV\nVid Teaser\nBumper Speakers ', '2024-08-28', '2024-08-28', 'in_progress', '2024-09-05 16:09:34', '2025-01-06 10:28:48', NULL, NULL, NULL),
(26, 100000018, 'Multimedia Annual Awards Day & Conference Sequis Life', NULL, 'Multimedia Annual Awards Day & Conference Sequis Life', '2024-03-16', '2024-03-17', 'completed', '2024-09-06 04:34:03', '2024-09-06 04:34:03', NULL, NULL, NULL),
(27, 100000018, 'Multimedia Interactive 27th Frank & Co', NULL, 'Multimedia Interactive 27th Frank & Co', '2024-05-17', '2024-05-26', 'completed', '2024-09-06 04:40:19', '2024-09-06 04:40:19', NULL, NULL, NULL),
(28, 100000018, 'Multimedia Telkomsel Award 2024', NULL, 'Multimedia Telkomsel Award 2024', '2024-07-17', '2024-07-17', 'completed', '2024-09-06 04:47:12', '2024-09-06 04:47:12', NULL, NULL, NULL),
(29, 100000012, 'Video Mapping 2 Match Fun Futsal Gemoy Cup', NULL, 'Video Mapping 2 Match Fun Futsal Gemoy Cup', '2024-02-23', '2024-02-25', 'completed', '2024-09-06 14:30:52', '2024-09-06 14:34:36', NULL, NULL, NULL),
(30, 100000012, 'Multimedia Rokan PHE', NULL, 'Multimedia Rokan PHE', '2024-03-07', '2024-03-07', 'completed', '2024-09-06 14:38:11', '2024-09-06 14:38:11', NULL, NULL, NULL),
(31, 100000012, 'Video Unveiling Design Indonesia Pavilion', NULL, 'Video Unveiling Design Indonesia Pavilion', '2024-01-02', '2024-01-30', 'completed', '2024-09-06 14:41:10', '2024-09-10 08:41:50', NULL, NULL, NULL),
(32, 100000012, 'Unveiling Logo Indonesia Pavilion', NULL, 'Unveiling Logo Indonesia Pavilion', '2024-04-06', '2024-04-06', 'completed', '2024-09-06 14:42:42', '2024-09-06 14:42:42', NULL, NULL, NULL),
(33, 100000012, 'Video Mapping - WWF Gala Dinner GWK', NULL, 'Video Mapping - WWF Gala Dinner GWK', '2024-04-20', '2024-04-21', 'completed', '2024-09-06 14:46:45', '2024-09-06 14:46:45', NULL, NULL, NULL),
(34, 100000012, 'E Card New Year Bank Mandiri', NULL, 'E Card New Year Bank Mandiri', '2024-05-01', '2024-05-01', 'completed', '2024-09-06 14:48:04', '2024-09-06 14:48:04', NULL, NULL, NULL),
(35, 100000012, 'E Card Nyepi Bank Mandiri ', NULL, 'E Card Nyepi Bank Mandiri', '2024-05-16', '2024-05-16', 'completed', '2024-09-06 14:49:18', '2024-09-06 14:49:18', NULL, NULL, NULL),
(36, 100000012, 'Video After Movie Samsung', NULL, 'Video After Movie Samsung', '2024-05-30', '2024-05-31', 'completed', '2024-09-06 14:51:05', '2024-09-06 14:51:05', NULL, NULL, NULL),
(37, 100000012, '3D Modelling & Composing', NULL, '3D Modelling & Composing', '2024-06-06', '2024-06-07', 'completed', '2024-09-06 14:52:22', '2024-09-06 14:52:22', NULL, NULL, NULL),
(38, 100000012, 'Video Promo Indonesia Pavillian Osaka 2025', NULL, 'Video Promo Indonesia Pavillian Osaka 2025', '2024-06-11', '2024-06-13', 'completed', '2024-09-06 14:54:38', '2024-09-06 14:54:38', NULL, NULL, NULL),
(39, 100000012, 'Bumper THE H Jakarta 2023', NULL, 'Bumper THE H Jakarta & Makassar 2023 - 2024', '2024-07-13', '2024-07-14', 'completed', '2024-09-06 14:56:07', '2024-09-10 15:01:08', NULL, NULL, NULL),
(41, 100000012, 'Multimedia Gala Dinner HLF & IAF', NULL, 'Multimedia Gala Dinner HLF & IAF', '2024-07-02', '2024-07-02', 'completed', '2024-09-06 15:00:06', '2024-09-06 15:00:06', NULL, NULL, NULL),
(42, 100000012, 'Sensorial Game Freshtea', NULL, 'Sensorial Game Freshtea', '2024-02-10', '2024-02-11', 'completed', '2024-09-06 15:06:25', '2024-09-06 15:06:25', NULL, NULL, NULL),
(43, 100000018, 'TARO VID OOH & CGI', NULL, 'TARO VID OOH & CGI', '2024-07-01', '2024-09-30', 'completed', '2024-09-09 09:56:11', '2024-10-01 14:16:20', NULL, NULL, NULL),
(44, 100000018, 'Multimedia Sinar Mas Digital Day', NULL, 'Multimedia Sinar Mas Digital Day', '2024-08-26', '2024-09-28', 'completed', '2024-09-09 09:58:15', '2024-10-01 14:12:46', NULL, NULL, NULL),
(45, 100000012, 'IAF 2024', NULL, 'Gala Dinner IAF', '2024-08-01', '2024-09-02', 'completed', '2024-09-09 12:34:25', '2024-09-09 12:34:25', NULL, NULL, NULL),
(46, 100000012, 'Gudang Garam Instalation', NULL, 'Gudang Garam Interactive Instalation', '2024-07-01', '2024-08-31', 'completed', '2024-09-10 14:28:14', '2024-09-10 14:28:14', NULL, NULL, NULL),
(47, 100000012, 'Adidas AR fit EUro 2024', NULL, 'Adidas AR fit EUro 2024', '2024-07-01', '2024-07-25', 'completed', '2024-09-11 16:22:20', '2024-09-11 16:22:20', NULL, NULL, NULL),
(48, 100000012, 'Anniversary GBI Intercon', NULL, 'Anniversary GBI Intercon', '2024-09-08', '2024-09-15', 'completed', '2024-09-17 18:18:57', '2024-09-17 18:18:57', NULL, NULL, NULL),
(49, 100000012, 'Pertamina Algeria ', NULL, 'Pertamina Algeria ', '2024-09-08', '2024-10-18', 'completed', '2024-09-17 18:21:04', '2025-01-14 09:22:54', NULL, NULL, NULL),
(51, 100000049, 'NOMADS Festival 2024', NULL, 'Mapping Project \nBumper Performance \nInteractive Content', '2024-09-16', '2024-09-16', 'completed', '2024-09-22 15:52:38', '2024-10-22 09:57:26', NULL, NULL, NULL),
(52, 100000061, 'Galaxy FEstival (Samsung Galaxy S24 FE)', NULL, 'Create pagination and bumper content', '2024-09-26', '2024-09-26', 'completed', '2024-10-15 09:30:22', '2024-10-15 09:40:57', NULL, NULL, NULL),
(53, 100000030, 'Pekan Paralimpik Nasional', NULL, 'Pekan Paralimpik Nasional 2024', '2024-10-06', '2024-10-14', 'completed', '2024-10-30 11:58:22', '2024-10-30 11:58:22', NULL, NULL, NULL),
(54, 100000059, 'Gala Cityvision 2024', NULL, 'Digital Receiptionist , Laser Mapping', '2024-09-11', '2024-11-07', 'completed', '2024-11-04 15:02:12', '2024-11-12 09:20:29', NULL, NULL, NULL),
(55, 100000059, 'Cityvision LED 360 BSD', NULL, 'Create a character for LED in BSD', '2024-09-11', '2024-11-13', 'completed', '2024-11-12 09:18:30', '2024-12-05 10:28:13', NULL, NULL, NULL),
(56, 100000059, 'HUT 67 Pertamina', NULL, 'Develope 1 video content for Past Installation', '2024-11-18', '2024-11-30', 'completed', '2024-11-20 11:23:52', '2024-12-05 10:27:24', NULL, NULL, NULL),
(57, 100000059, 'BI Qris Art & Cullinary', NULL, 'Interactive Wall & Digital Guestbook', '2024-11-28', '2024-12-08', 'completed', '2024-12-05 10:31:30', '2024-12-08 10:34:09', NULL, NULL, NULL),
(58, 100000018, 'Video Company Profile NFR Pertamina Patraniaga', NULL, 'Video Company Profile NFR Pertamina Patraniaga', '2024-11-13', '2024-12-27', 'in_progress', '2024-12-13 03:35:06', '2024-12-13 03:35:06', NULL, NULL, NULL),
(59, 100000018, 'Video Company Profile Pertagas', NULL, 'Video Company Profile Pertagas', '2024-11-11', '2024-12-23', 'in_progress', '2024-12-13 03:41:07', '2024-12-13 03:41:07', NULL, NULL, NULL),
(60, 100000049, 'Perayaan Natal Nasional 2024', NULL, 'Visual Background Ibadah ', '2024-12-28', '2024-12-28', 'completed', '2025-01-06 10:32:14', '2025-01-06 10:32:14', NULL, NULL, NULL),
(61, 100000012, 'Video Production 360 Immersive', NULL, 'shooting kamera 360', '2024-12-11', '2024-12-25', 'completed', '2025-01-14 09:24:07', '2025-01-14 09:24:07', NULL, NULL, NULL),
(62, 100000012, 'Mastercard Dome', NULL, 'Multimedia Dome', '2024-11-30', '2024-11-30', 'completed', '2025-01-14 11:16:38', '2025-01-14 11:16:38', NULL, NULL, NULL),
(63, 100000012, 'PHM Bekapai', NULL, 'Design KV 50th Bekapai', '2024-12-01', '2024-12-10', 'completed', '2025-01-14 11:31:15', '2025-01-14 11:31:15', NULL, NULL, NULL),
(64, 100000049, 'Entertainment Week Lagos 2024', NULL, 'visual led', '2024-12-10', '2024-12-28', 'completed', '2025-01-14 11:43:12', '2025-01-14 11:43:12', NULL, NULL, NULL),
(65, 100000061, 'OPPO Reno 13 Launch Event', NULL, 'OPPO Reno 13 Launch Event', '2025-01-16', '2025-01-16', 'completed', '2025-01-17 09:23:24', '2025-01-17 09:23:24', NULL, NULL, NULL),
(66, 100000049, 'ISCA SINGAPORE 2024', NULL, 'VISUAL & BUMPER ', '2024-11-19', '2024-11-19', 'completed', '2025-01-21 09:07:17', '2025-01-21 09:07:17', NULL, NULL, NULL),
(67, 100000030, 'The Journey Room PERTAMINA', NULL, 'Pertamina Hulu Rokan', '2024-12-10', '2025-02-07', 'in_progress', '2025-01-21 09:39:53', '2025-01-21 09:39:53', NULL, NULL, NULL),
(68, 100000012, 'HAri PLN Nasional', NULL, 'Video mapping Hari PLN Naasional', '2024-12-01', '2024-12-04', 'completed', '2025-01-21 12:12:13', '2025-01-21 12:12:13', NULL, NULL, NULL),
(69, 100000049, 'Launch Samsung Galaxy S25 Series ', NULL, 'Vidio Opening \nPagination 3 pax ', '2025-01-23', '2025-01-23', 'completed', '2025-01-23 09:56:20', '2025-01-23 09:56:20', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `projects_employees`
--

CREATE TABLE `projects_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `projects_employees`
--

INSERT INTO `projects_employees` (`id`, `project_id`, `employee_id`, `created_at`, `updated_at`) VALUES
(6, 3, 100000014, NULL, NULL),
(7, 3, 100000020, NULL, NULL),
(8, 3, 100000044, NULL, NULL),
(9, 4, 100000028, NULL, NULL),
(10, 4, 100000046, NULL, NULL),
(11, 4, 100000027, NULL, NULL),
(12, 4, 100000062, NULL, NULL),
(13, 4, 100000026, NULL, NULL),
(14, 4, 100000015, NULL, NULL),
(15, 5, 100000046, NULL, NULL),
(16, 5, 100000015, NULL, NULL),
(17, 5, 100000010, NULL, NULL),
(18, 6, 100000027, NULL, NULL),
(19, 6, 100000043, NULL, NULL),
(20, 6, 100000016, NULL, NULL),
(21, 6, 100000057, NULL, NULL),
(23, 7, 100000026, NULL, NULL),
(24, 7, 100000043, NULL, NULL),
(25, 7, 100000045, NULL, NULL),
(26, 7, 100000044, NULL, NULL),
(27, 8, 100000028, NULL, NULL),
(28, 8, 100000027, NULL, NULL),
(29, 8, 100000026, NULL, NULL),
(30, 8, 100000015, NULL, NULL),
(31, 8, 100000010, NULL, NULL),
(32, 9, 100000028, NULL, NULL),
(33, 9, 100000046, NULL, NULL),
(34, 9, 100000062, NULL, NULL),
(35, 9, 100000031, NULL, NULL),
(36, 9, 100000014, NULL, NULL),
(37, 9, 100000026, NULL, NULL),
(38, 9, 100000024, NULL, NULL),
(39, 9, 100000045, NULL, NULL),
(40, 9, 100000008, NULL, NULL),
(41, 9, 100000010, NULL, NULL),
(42, 9, 100000025, NULL, NULL),
(43, 9, 100000044, NULL, NULL),
(44, 10, 100000028, NULL, NULL),
(45, 10, 100000025, NULL, NULL),
(46, 11, 100000014, NULL, NULL),
(47, 11, 100000044, NULL, NULL),
(48, 12, 100000027, NULL, NULL),
(49, 12, 100000026, NULL, NULL),
(50, 12, 100000016, NULL, NULL),
(51, 12, 100000045, NULL, NULL),
(52, 13, 100000064, NULL, NULL),
(53, 13, 100000062, NULL, NULL),
(54, 13, 100000043, NULL, NULL),
(55, 13, 100000048, NULL, NULL),
(56, 13, 100000016, NULL, NULL),
(57, 13, 100000015, NULL, NULL),
(58, 13, 100000063, NULL, NULL),
(59, 13, 100000057, NULL, NULL),
(60, 13, 100000045, NULL, NULL),
(61, 13, 100000010, NULL, NULL),
(62, 13, 100000065, NULL, NULL),
(63, 13, 100000044, NULL, NULL),
(64, 14, 100000031, NULL, NULL),
(65, 14, 100000025, NULL, NULL),
(66, 15, 100000028, NULL, NULL),
(67, 15, 100000031, NULL, NULL),
(68, 15, 100000025, NULL, NULL),
(69, 16, 100000028, NULL, NULL),
(70, 16, 100000027, NULL, NULL),
(71, 16, 100000062, NULL, NULL),
(72, 16, 100000026, NULL, NULL),
(73, 16, 100000016, NULL, NULL),
(74, 16, 100000063, NULL, NULL),
(75, 16, 100000057, NULL, NULL),
(76, 16, 100000010, NULL, NULL),
(77, 16, 100000044, NULL, NULL),
(78, 17, 100000027, NULL, NULL),
(79, 17, 100000031, NULL, NULL),
(80, 17, 100000026, NULL, NULL),
(81, 17, 100000048, NULL, NULL),
(82, 17, 100000016, NULL, NULL),
(83, 17, 100000057, NULL, NULL),
(86, 19, 100000057, NULL, NULL),
(87, 19, 100000050, NULL, NULL),
(88, 20, 100000028, NULL, NULL),
(89, 20, 100000064, NULL, NULL),
(90, 20, 100000031, NULL, NULL),
(91, 20, 100000014, NULL, NULL),
(92, 20, 100000026, NULL, NULL),
(94, 20, 100000024, NULL, NULL),
(95, 20, 100000015, NULL, NULL),
(96, 20, 100000063, NULL, NULL),
(97, 20, 100000008, NULL, NULL),
(98, 20, 100000010, NULL, NULL),
(99, 20, 100000025, NULL, NULL),
(100, 21, 100000028, NULL, NULL),
(101, 21, 100000063, NULL, NULL),
(102, 21, 100000057, NULL, NULL),
(103, 21, 100000010, NULL, NULL),
(104, 22, 100000028, NULL, NULL),
(105, 22, 100000046, NULL, NULL),
(106, 22, 100000064, NULL, NULL),
(107, 22, 100000043, NULL, NULL),
(108, 22, 100000025, NULL, NULL),
(109, 23, 100000062, NULL, NULL),
(110, 23, 100000031, NULL, NULL),
(111, 23, 100000014, NULL, NULL),
(112, 23, 100000072, NULL, NULL),
(113, 23, 100000024, NULL, NULL),
(114, 23, 100000048, NULL, NULL),
(115, 23, 100000057, NULL, NULL),
(116, 23, 100000008, NULL, NULL),
(117, 23, 100000010, NULL, NULL),
(118, 23, 100000065, NULL, NULL),
(119, 24, 100000016, NULL, NULL),
(120, 24, 100000057, NULL, NULL),
(121, 24, 100000065, NULL, NULL),
(123, 25, 100000031, NULL, NULL),
(124, 25, 100000063, NULL, NULL),
(125, 2, 100000028, NULL, NULL),
(126, 2, 100000046, NULL, NULL),
(127, 2, 100000027, NULL, NULL),
(128, 2, 100000026, NULL, NULL),
(130, 2, 100000048, NULL, NULL),
(131, 2, 100000016, NULL, NULL),
(132, 2, 100000044, NULL, NULL),
(133, 26, 100000028, NULL, NULL),
(134, 26, 100000046, NULL, NULL),
(135, 26, 100000027, NULL, NULL),
(136, 26, 100000062, NULL, NULL),
(137, 26, 100000043, NULL, NULL),
(139, 26, 100000048, NULL, NULL),
(140, 26, 100000015, NULL, NULL),
(141, 26, 100000063, NULL, NULL),
(142, 26, 100000045, NULL, NULL),
(143, 26, 100000025, NULL, NULL),
(144, 26, 100000044, NULL, NULL),
(145, 27, 100000064, NULL, NULL),
(146, 27, 100000062, NULL, NULL),
(147, 27, 100000019, NULL, NULL),
(148, 27, 100000031, NULL, NULL),
(151, 27, 100000015, NULL, NULL),
(152, 27, 100000063, NULL, NULL),
(153, 27, 100000045, NULL, NULL),
(154, 27, 100000020, NULL, NULL),
(155, 27, 100000050, NULL, NULL),
(156, 27, 100000010, NULL, NULL),
(157, 28, 100000046, NULL, NULL),
(158, 28, 100000064, NULL, NULL),
(159, 28, 100000027, NULL, NULL),
(160, 28, 100000031, NULL, NULL),
(161, 28, 100000014, NULL, NULL),
(162, 28, 100000026, NULL, NULL),
(163, 28, 100000043, NULL, NULL),
(164, 28, 100000024, NULL, NULL),
(165, 28, 100000048, NULL, NULL),
(166, 28, 100000016, NULL, NULL),
(167, 28, 100000015, NULL, NULL),
(168, 28, 100000045, NULL, NULL),
(169, 28, 100000008, NULL, NULL),
(170, 28, 100000033, NULL, NULL),
(172, 29, 100000025, NULL, NULL),
(173, 1, 100000019, NULL, NULL),
(174, 1, 100000020, NULL, NULL),
(175, 1, 100000050, NULL, NULL),
(176, 30, 100000027, NULL, NULL),
(177, 30, 100000062, NULL, NULL),
(178, 30, 100000048, NULL, NULL),
(179, 30, 100000015, NULL, NULL),
(180, 30, 100000063, NULL, NULL),
(181, 30, 100000057, NULL, NULL),
(182, 30, 100000020, NULL, NULL),
(183, 30, 100000050, NULL, NULL),
(184, 31, 100000028, NULL, NULL),
(185, 31, 100000031, NULL, NULL),
(186, 31, 100000014, NULL, NULL),
(187, 31, 100000026, NULL, NULL),
(188, 31, 100000016, NULL, NULL),
(189, 31, 100000057, NULL, NULL),
(190, 31, 100000033, NULL, NULL),
(191, 31, 100000044, NULL, NULL),
(192, 32, 100000046, NULL, NULL),
(193, 32, 100000027, NULL, NULL),
(194, 32, 100000048, NULL, NULL),
(195, 32, 100000025, NULL, NULL),
(196, 33, 100000028, NULL, NULL),
(197, 33, 100000046, NULL, NULL),
(198, 33, 100000027, NULL, NULL),
(199, 33, 100000031, NULL, NULL),
(200, 33, 100000026, NULL, NULL),
(201, 33, 100000043, NULL, NULL),
(202, 33, 100000048, NULL, NULL),
(203, 33, 100000016, NULL, NULL),
(204, 33, 100000057, NULL, NULL),
(205, 33, 100000045, NULL, NULL),
(206, 33, 100000025, NULL, NULL),
(207, 33, 100000033, NULL, NULL),
(208, 33, 100000044, NULL, NULL),
(209, 34, 100000046, NULL, NULL),
(210, 34, 100000015, NULL, NULL),
(211, 35, 100000046, NULL, NULL),
(212, 35, 100000015, NULL, NULL),
(213, 36, 100000031, NULL, NULL),
(214, 36, 100000014, NULL, NULL),
(215, 36, 100000008, NULL, NULL),
(216, 37, 100000014, NULL, NULL),
(217, 38, 100000031, NULL, NULL),
(218, 38, 100000014, NULL, NULL),
(219, 39, 100000027, NULL, NULL),
(220, 39, 100000043, NULL, NULL),
(221, 39, 100000045, NULL, NULL),
(222, 39, 100000033, NULL, NULL),
(227, 41, 100000028, NULL, NULL),
(228, 41, 100000046, NULL, NULL),
(229, 41, 100000064, NULL, NULL),
(230, 41, 100000027, NULL, NULL),
(231, 41, 100000026, NULL, NULL),
(232, 41, 100000043, NULL, NULL),
(233, 41, 100000016, NULL, NULL),
(234, 41, 100000015, NULL, NULL),
(235, 41, 100000045, NULL, NULL),
(236, 41, 100000071, NULL, NULL),
(237, 41, 100000025, NULL, NULL),
(238, 41, 100000033, NULL, NULL),
(239, 41, 100000044, NULL, NULL),
(240, 42, 100000019, NULL, NULL),
(241, 42, 100000020, NULL, NULL),
(242, 42, 100000050, NULL, NULL),
(243, 43, 100000031, NULL, NULL),
(244, 43, 100000014, NULL, NULL),
(245, 43, 100000043, NULL, NULL),
(246, 43, 100000024, NULL, NULL),
(247, 43, 100000048, NULL, NULL),
(248, 43, 100000016, NULL, NULL),
(249, 43, 100000015, NULL, NULL),
(250, 43, 100000045, NULL, NULL),
(251, 43, 100000008, NULL, NULL),
(252, 43, 100000065, NULL, NULL),
(253, 43, 100000044, NULL, NULL),
(254, 44, 100000062, NULL, NULL),
(255, 44, 100000015, NULL, NULL),
(256, 44, 100000063, NULL, NULL),
(259, 29, 100000046, NULL, NULL),
(260, 29, 100000027, NULL, NULL),
(261, 29, 100000026, NULL, NULL),
(262, 29, 100000043, NULL, NULL),
(263, 29, 100000048, NULL, NULL),
(264, 29, 100000016, NULL, NULL),
(265, 29, 100000057, NULL, NULL),
(266, 29, 100000045, NULL, NULL),
(267, 29, 100000033, NULL, NULL),
(268, 29, 100000044, NULL, NULL),
(269, 45, 100000028, NULL, NULL),
(270, 45, 100000046, NULL, NULL),
(271, 45, 100000064, NULL, NULL),
(272, 45, 100000027, NULL, NULL),
(273, 45, 100000026, NULL, NULL),
(274, 45, 100000043, NULL, NULL),
(275, 45, 100000016, NULL, NULL),
(276, 45, 100000015, NULL, NULL),
(277, 45, 100000045, NULL, NULL),
(278, 45, 100000071, NULL, NULL),
(279, 45, 100000025, NULL, NULL),
(280, 45, 100000033, NULL, NULL),
(281, 45, 100000044, NULL, NULL),
(282, 20, 100000062, NULL, NULL),
(283, 22, 100000063, NULL, NULL),
(284, 13, 100000033, NULL, NULL),
(285, 7, 100000016, NULL, NULL),
(286, 9, 100000043, NULL, NULL),
(287, 3, 100000008, NULL, NULL),
(288, 46, 100000014, NULL, NULL),
(289, 46, 100000019, NULL, NULL),
(290, 46, 100000020, NULL, NULL),
(291, 46, 100000050, NULL, NULL),
(292, 39, 100000057, NULL, NULL),
(293, 27, 100000061, NULL, NULL),
(294, 20, 100000018, NULL, NULL),
(295, 9, 100000015, NULL, NULL),
(296, 24, 100000026, NULL, NULL),
(297, 24, 100000028, NULL, NULL),
(298, 24, 100000043, NULL, NULL),
(299, 47, 100000019, NULL, NULL),
(300, 47, 100000020, NULL, NULL),
(301, 47, 100000045, NULL, NULL),
(302, 47, 100000050, NULL, NULL),
(303, 47, 100000065, NULL, NULL),
(304, 24, 100000018, NULL, NULL),
(305, 48, 100000025, NULL, NULL),
(306, 49, 100000020, NULL, NULL),
(307, 49, 100000050, NULL, NULL),
(308, 49, 100000062, NULL, NULL),
(309, 49, 100000063, NULL, NULL),
(311, 51, 100000057, NULL, NULL),
(313, 44, 100000014, NULL, NULL),
(314, 44, 100000020, NULL, NULL),
(315, 44, 100000024, NULL, NULL),
(316, 44, 100000025, NULL, NULL),
(317, 44, 100000027, NULL, NULL),
(318, 44, 100000028, NULL, NULL),
(319, 44, 100000045, NULL, NULL),
(320, 44, 100000046, NULL, NULL),
(321, 44, 100000050, NULL, NULL),
(322, 44, 100000064, NULL, NULL),
(323, 44, 100000071, NULL, NULL),
(324, 44, 100000018, NULL, NULL),
(325, 52, 100000064, NULL, NULL),
(326, 52, 100000025, NULL, NULL),
(327, 51, 100000071, NULL, NULL),
(328, 51, 100000025, NULL, NULL),
(329, 51, 100000045, NULL, NULL),
(330, 53, 100000046, NULL, NULL),
(331, 53, 100000027, NULL, NULL),
(332, 53, 100000062, NULL, NULL),
(333, 53, 100000031, NULL, NULL),
(334, 53, 100000014, NULL, NULL),
(335, 53, 100000026, NULL, NULL),
(336, 53, 100000072, NULL, NULL),
(337, 53, 100000024, NULL, NULL),
(338, 53, 100000048, NULL, NULL),
(339, 53, 100000016, NULL, NULL),
(340, 53, 100000015, NULL, NULL),
(341, 53, 100000063, NULL, NULL),
(342, 53, 100000057, NULL, NULL),
(343, 53, 100000045, NULL, NULL),
(344, 53, 100000071, NULL, NULL),
(345, 53, 100000008, NULL, NULL),
(346, 53, 100000010, NULL, NULL),
(347, 53, 100000033, NULL, NULL),
(348, 53, 100000065, NULL, NULL),
(349, 53, 100000044, NULL, NULL),
(350, 54, 100000062, NULL, NULL),
(351, 54, 100000019, NULL, NULL),
(352, 54, 100000014, NULL, NULL),
(353, 54, 100000072, NULL, NULL),
(354, 54, 100000048, NULL, NULL),
(355, 54, 100000016, NULL, NULL),
(356, 54, 100000045, NULL, NULL),
(357, 54, 100000020, NULL, NULL),
(358, 54, 100000050, NULL, NULL),
(359, 54, 100000008, NULL, NULL),
(360, 54, 100000010, NULL, NULL),
(361, 54, 100000065, NULL, NULL),
(362, 54, 100000044, NULL, NULL),
(363, 54, 100000071, NULL, NULL),
(364, 24, 100000071, NULL, NULL),
(365, 24, 100000059, NULL, NULL),
(366, 51, 100000064, NULL, NULL),
(367, 2, 100000018, NULL, NULL),
(368, 26, 100000018, NULL, NULL),
(369, 54, 100000057, NULL, NULL),
(370, 3, 100000045, NULL, NULL),
(371, 53, 100000028, NULL, NULL),
(372, 53, 100000043, NULL, NULL),
(373, 54, 100000043, NULL, NULL),
(374, 38, 100000008, NULL, NULL),
(375, 46, 100000062, NULL, NULL),
(376, 55, 100000072, NULL, NULL),
(377, 55, 100000016, NULL, NULL),
(378, 55, 100000057, NULL, NULL),
(379, 55, 100000045, NULL, NULL),
(380, 55, 100000071, NULL, NULL),
(381, 55, 100000010, NULL, NULL),
(382, 55, 100000065, NULL, NULL),
(383, 55, 100000044, NULL, NULL),
(384, 55, 100000043, NULL, NULL),
(385, 55, 100000049, NULL, NULL),
(386, 55, 100000026, NULL, NULL),
(387, 55, 100000048, NULL, NULL),
(388, 56, 100000064, NULL, NULL),
(389, 56, 100000015, NULL, NULL),
(390, 56, 100000010, NULL, NULL),
(391, 56, 100000065, NULL, NULL),
(392, 57, 100000064, NULL, NULL),
(393, 57, 100000027, NULL, NULL),
(394, 57, 100000019, NULL, NULL),
(395, 57, 100000015, NULL, NULL),
(396, 57, 100000020, NULL, NULL),
(397, 57, 100000050, NULL, NULL),
(398, 57, 100000010, NULL, NULL),
(399, 57, 100000046, NULL, NULL),
(400, 57, 100000057, NULL, NULL),
(401, 58, 100000031, NULL, NULL),
(402, 58, 100000014, NULL, NULL),
(403, 58, 100000024, NULL, NULL),
(404, 58, 100000008, NULL, NULL),
(405, 59, 100000064, NULL, NULL),
(406, 59, 100000062, NULL, NULL),
(407, 59, 100000031, NULL, NULL),
(408, 59, 100000072, NULL, NULL),
(410, 58, 100000064, NULL, NULL),
(411, 58, 100000015, NULL, NULL),
(412, 25, 100000046, NULL, NULL),
(413, 25, 100000027, NULL, NULL),
(414, 25, 100000015, NULL, NULL),
(415, 25, 100000071, NULL, NULL),
(416, 25, 100000008, NULL, NULL),
(417, 25, 100000010, NULL, NULL),
(418, 60, 100000028, NULL, NULL),
(419, 60, 100000046, NULL, NULL),
(420, 60, 100000064, NULL, NULL),
(421, 60, 100000027, NULL, NULL),
(422, 60, 100000062, NULL, NULL),
(423, 60, 100000026, NULL, NULL),
(424, 60, 100000043, NULL, NULL),
(425, 60, 100000024, NULL, NULL),
(426, 60, 100000016, NULL, NULL),
(427, 60, 100000015, NULL, NULL),
(428, 60, 100000063, NULL, NULL),
(429, 60, 100000045, NULL, NULL),
(430, 60, 100000025, NULL, NULL),
(431, 60, 100000065, NULL, NULL),
(432, 12, 100000065, NULL, NULL),
(433, 61, 100000012, NULL, NULL),
(434, 62, 100000027, NULL, NULL),
(435, 62, 100000016, NULL, NULL),
(436, 62, 100000025, NULL, NULL),
(437, 62, 100000045, NULL, NULL),
(438, 63, 100000062, NULL, NULL),
(439, 63, 100000015, NULL, NULL),
(440, 63, 100000063, NULL, NULL),
(441, 63, 100000010, NULL, NULL),
(442, 63, 100000065, NULL, NULL),
(443, 64, 100000028, NULL, NULL),
(444, 64, 100000057, NULL, NULL),
(446, 64, 100000071, NULL, NULL),
(447, 64, 100000025, NULL, NULL),
(448, 64, 100000033, NULL, NULL),
(449, 65, 100000027, NULL, NULL),
(450, 65, 100000072, NULL, NULL),
(451, 65, 100000043, NULL, NULL),
(452, 65, 100000016, NULL, NULL),
(453, 65, 100000057, NULL, NULL),
(454, 65, 100000010, NULL, NULL),
(455, 65, 100000025, NULL, NULL),
(456, 65, 100000065, NULL, NULL),
(457, 66, 100000028, NULL, NULL),
(458, 66, 100000050, NULL, NULL),
(459, 66, 100000025, NULL, NULL),
(460, 67, 100000028, NULL, NULL),
(461, 67, 100000046, NULL, NULL),
(462, 67, 100000064, NULL, NULL),
(463, 67, 100000027, NULL, NULL),
(464, 67, 100000062, NULL, NULL),
(465, 67, 100000019, NULL, NULL),
(466, 67, 100000014, NULL, NULL),
(467, 67, 100000026, NULL, NULL),
(468, 67, 100000072, NULL, NULL),
(469, 67, 100000043, NULL, NULL),
(470, 67, 100000048, NULL, NULL),
(471, 67, 100000016, NULL, NULL),
(472, 67, 100000015, NULL, NULL),
(473, 67, 100000063, NULL, NULL),
(474, 67, 100000057, NULL, NULL),
(475, 67, 100000045, NULL, NULL),
(477, 67, 100000050, NULL, NULL),
(478, 67, 100000071, NULL, NULL),
(479, 67, 100000008, NULL, NULL),
(480, 67, 100000010, NULL, NULL),
(481, 67, 100000025, NULL, NULL),
(482, 67, 100000065, NULL, NULL),
(483, 67, 100000044, NULL, NULL),
(484, 68, 100000028, NULL, NULL),
(485, 68, 100000046, NULL, NULL),
(486, 68, 100000062, NULL, NULL),
(487, 68, 100000026, NULL, NULL),
(488, 68, 100000043, NULL, NULL),
(489, 68, 100000048, NULL, NULL),
(490, 68, 100000016, NULL, NULL),
(491, 68, 100000057, NULL, NULL),
(492, 68, 100000045, NULL, NULL),
(493, 68, 100000044, NULL, NULL),
(494, 57, 100000062, NULL, NULL),
(495, 56, 100000072, NULL, NULL),
(496, 69, 100000028, NULL, NULL),
(497, 69, 100000024, NULL, NULL),
(498, 69, 100000025, NULL, NULL),
(499, 66, 100000062, NULL, NULL),
(500, 24, 100000062, NULL, NULL),
(501, 8, 100000057, NULL, NULL),
(502, 9, 100000057, NULL, NULL),
(503, 67, 100000031, NULL, NULL),
(504, 66, 100000031, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `project_additional_managers`
--

CREATE TABLE `project_additional_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `project_additional_managers`
--

INSERT INTO `project_additional_managers` (`id`, `project_id`, `employee_id`, `created_at`, `updated_at`) VALUES
(2, 51, 100000033, NULL, NULL),
(4, 60, 100000061, NULL, NULL),
(5, 53, 100000012, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `requests`
--

CREATE TABLE `requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `request_items`
--

CREATE TABLE `request_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `request_reads`
--

CREATE TABLE `request_reads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `readable_type` varchar(255) NOT NULL,
  `readable_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `request_recipients`
--

CREATE TABLE `request_recipients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recipientable_type` varchar(255) NOT NULL,
  `recipientable_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `request_validates`
--

CREATE TABLE `request_validates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `validatable_type` varchar(255) NOT NULL,
  `validatable_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(2, 'Director', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(3, 'Finance', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(4, 'HR', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(5, 'Commissioner', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(6, 'Employee', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46'),
(7, 'Project Manager', 'web', '2024-09-03 08:29:46', '2024-09-03 08:29:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(2, 1),
(2, 3),
(2, 4),
(3, 1),
(3, 3),
(3, 4),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(5, 1),
(5, 3),
(5, 4),
(6, 1),
(6, 3),
(6, 4),
(7, 1),
(7, 3),
(7, 4),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(9, 1),
(9, 3),
(9, 4),
(10, 1),
(10, 3),
(10, 4),
(11, 1),
(11, 3),
(11, 4),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(13, 1),
(13, 3),
(13, 4),
(14, 1),
(14, 3),
(14, 4),
(15, 1),
(15, 3),
(15, 4),
(16, 1),
(16, 2),
(16, 3),
(16, 4),
(17, 1),
(17, 3),
(18, 1),
(18, 3),
(19, 1),
(19, 3),
(20, 1),
(20, 2),
(20, 3),
(20, 4),
(21, 1),
(21, 3),
(21, 4),
(22, 1),
(22, 3),
(22, 4),
(23, 1),
(23, 3),
(23, 4),
(24, 1),
(24, 2),
(24, 3),
(24, 4),
(25, 1),
(25, 2),
(25, 3),
(25, 4),
(25, 6),
(26, 1),
(26, 3),
(26, 6),
(27, 1),
(27, 3),
(28, 1),
(28, 3),
(29, 1),
(29, 3),
(30, 1),
(30, 3),
(31, 1),
(31, 3),
(32, 1),
(32, 3),
(33, 1),
(33, 3),
(34, 1),
(34, 3),
(35, 1),
(35, 3),
(36, 1),
(36, 3),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(41, 2),
(41, 3),
(41, 4),
(42, 1),
(42, 2),
(42, 3),
(42, 4),
(42, 6),
(43, 1),
(43, 6),
(44, 1),
(44, 3),
(45, 1),
(45, 3),
(46, 1),
(46, 3),
(46, 4),
(47, 1),
(47, 3),
(47, 4),
(47, 6),
(48, 1),
(48, 6),
(49, 1),
(50, 1),
(51, 1),
(51, 3),
(51, 4),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(64, 2),
(64, 4),
(65, 1),
(66, 6),
(67, 1),
(67, 6),
(68, 1),
(68, 6),
(69, 1),
(69, 2),
(69, 3),
(69, 4),
(70, 1),
(70, 3),
(70, 4),
(71, 1),
(71, 3),
(71, 4),
(72, 1),
(72, 3),
(72, 4),
(73, 1),
(73, 2),
(73, 3),
(73, 4),
(74, 1),
(74, 2),
(74, 3),
(74, 4),
(74, 6),
(75, 6),
(76, 1),
(76, 3),
(77, 1),
(77, 3),
(78, 1),
(78, 2),
(78, 3),
(78, 6),
(79, 1),
(79, 2),
(79, 3),
(79, 4),
(80, 1),
(80, 2),
(80, 4),
(80, 6),
(81, 6),
(82, 1),
(82, 3),
(82, 4),
(82, 6),
(83, 1),
(83, 3),
(83, 4),
(83, 6),
(84, 1),
(84, 2),
(84, 3),
(84, 4),
(84, 6),
(85, 1),
(85, 2),
(85, 3),
(85, 4),
(86, 1),
(86, 2),
(86, 4),
(86, 6),
(87, 6),
(88, 1),
(88, 3),
(88, 4),
(88, 6),
(89, 1),
(89, 3),
(89, 4),
(89, 6),
(90, 1),
(90, 2),
(90, 3),
(90, 4),
(90, 6),
(91, 1),
(91, 2),
(91, 3),
(91, 4),
(91, 6),
(92, 1),
(92, 2),
(92, 4),
(93, 1),
(93, 2),
(93, 3),
(93, 6),
(94, 1),
(94, 2),
(94, 4),
(94, 6),
(95, 1),
(95, 2),
(95, 4),
(95, 6),
(96, 1),
(96, 2),
(96, 4),
(96, 6),
(97, 1),
(97, 2),
(97, 3),
(97, 4),
(97, 5),
(97, 6),
(97, 7),
(98, 1),
(98, 3),
(98, 5),
(98, 6),
(98, 7),
(99, 1),
(99, 7),
(100, 1),
(100, 7),
(101, 1),
(101, 7),
(102, 1),
(102, 2),
(102, 3),
(102, 4),
(102, 5),
(102, 6),
(102, 7),
(103, 2),
(103, 3),
(103, 4),
(103, 5),
(103, 6),
(103, 7),
(104, 1),
(104, 2),
(104, 3),
(104, 4),
(104, 5),
(105, 1),
(105, 3),
(106, 1),
(106, 3),
(107, 1),
(107, 3),
(108, 1),
(108, 3),
(109, 1),
(109, 2),
(109, 3),
(109, 4),
(109, 5),
(110, 1),
(110, 3),
(111, 1),
(111, 3),
(112, 1),
(112, 3),
(113, 1),
(113, 3),
(114, 1),
(114, 2),
(114, 3),
(114, 4),
(114, 5),
(115, 1),
(115, 3),
(115, 5),
(116, 1),
(116, 3),
(117, 1),
(117, 3),
(118, 1),
(118, 3),
(119, 2),
(119, 5),
(120, 1),
(120, 3),
(120, 7),
(121, 1),
(122, 1),
(122, 3),
(123, 1),
(123, 3),
(124, 1),
(124, 3),
(125, 1),
(125, 3),
(126, 1),
(126, 3),
(127, 1),
(127, 3),
(128, 1),
(128, 3),
(129, 1),
(129, 3),
(130, 1),
(130, 3),
(131, 1),
(131, 7),
(132, 1),
(132, 7),
(133, 1),
(133, 7),
(134, 1),
(134, 7),
(135, 1),
(135, 7),
(136, 1),
(136, 7),
(137, 1),
(137, 7),
(138, 1),
(138, 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sites`
--

CREATE TABLE `sites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `qrcode_path` varchar(255) DEFAULT NULL,
  `qrcode_url` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sites`
--

INSERT INTO `sites` (`id`, `uid`, `name`, `longitude`, `latitude`, `image_path`, `image_url`, `qrcode_path`, `qrcode_url`, `address`, `created_at`, `updated_at`) VALUES
(1, '1778a190-731f-4163-881d-3d3ba6883bd0', 'IMAJIWA', '106.798818', '-6.263122', NULL, NULL, 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TPM+Group', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TPM+Group', 'Jl. Kemang Dalam IV No.K24, RT.3/RW.3, Bangka, Kec. Mampang Prpt., Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12730', '2024-09-03 08:29:51', '2024-09-03 08:29:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `social_accounts`
--

CREATE TABLE `social_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `provider_id` varchar(255) NOT NULL,
  `provider_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `social_accounts`
--

INSERT INTO `social_accounts` (`id`, `user_id`, `provider_id`, `provider_name`, `created_at`, `updated_at`) VALUES
(1, 21, '110802146339334368707', 'google', '2025-03-10 08:11:23', '2025-03-10 08:11:23'),
(2, 10, '106764554726833046330', 'google', '2025-03-10 20:17:58', '2025-03-10 20:17:58'),
(3, 11, '103550321106280799147', 'google', '2025-03-11 12:08:29', '2025-03-11 12:08:29'),
(4, 39, '103381782797520889415', 'google', '2025-03-14 12:29:01', '2025-03-14 12:29:01'),
(5, 41, '116618372829000421848', 'google', '2025-06-04 11:39:53', '2025-06-04 11:39:53'),
(6, 9, '106377149031347938574', 'google', '2025-06-04 13:52:19', '2025-06-04 13:52:19'),
(7, 30, '118145185113636527665', 'google', '2025-07-28 10:02:19', '2025-07-28 10:02:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_inventories`
--

CREATE TABLE `status_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `status_inventories`
--

INSERT INTO `status_inventories` (`id`, `name`, `color`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'In Use', '#ffdd00', 'in-use', '2024-12-16 08:07:38', '2024-12-16 08:07:38'),
(2, 'Assigned', '#ff0000', 'assigned', '2024-12-16 08:07:58', '2024-12-16 08:07:58'),
(3, 'Available', '#59ff00', 'available', '2024-12-16 08:08:21', '2024-12-16 08:08:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `telescope_entries`
--

CREATE TABLE `telescope_entries` (
  `sequence` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `family_hash` varchar(255) DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(20) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `telescope_entries_tags`
--

CREATE TABLE `telescope_entries_tags` (
  `entry_uuid` char(36) NOT NULL,
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `telescope_monitoring`
--

CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `password_string` varchar(255) DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  `avatar_thumbnail_url` varchar(255) DEFAULT NULL,
  `avatar_thumbnail_path` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `password_string`, `avatar_url`, `avatar_path`, `avatar_thumbnail_url`, `avatar_thumbnail_path`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin', 'superadmin@imajiwa.id', NULL, '$2y$10$eh1zJn5N2yIyJdcbbZ2bHOU1IqSRPpGOTDziWAlGI/4lWe5R/.8P6', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2024-09-03 08:29:51', '2024-09-03 08:29:51'),
(4, 'A.HILMAN MAULANA', '100000028', 'hilman@imajiwa.id', NULL, '$2y$10$Ii81h34JSHRYFx7Lbub44eZ2vDvx3R/RxHh/LozGKF4tCT91rYLaK', 'Hilman01', NULL, NULL, NULL, NULL, 1, 'UKhgPhsqdSqXkuDW20Nhg3odQzyi4DdQOn3RIoPnlWIPksvrdpIUXXzqIOK0', '2024-09-03 08:32:37', '2024-09-30 08:58:43'),
(5, 'ACHMAD ALI GHUFRON', '100000012', 'ali@imajiwa.id', NULL, '$2y$10$CRVMKP7b2mQjMy.VEl0bnu6p3ZrWNyfo4WERFfhwxNR.r15.71wPu', 'Ali01', 'avatars/35dSE9tIobSaZuSnNfciWKcEsUbhyfkqQM6lSSeg.png', NULL, NULL, NULL, 1, 'xGOpjAJMaumzPohbOwl0beEr7nWDPI9doKbubzQbPsqbZopyUcyeZOBecdQW', '2024-09-03 08:32:37', '2024-09-30 08:58:42'),
(6, 'ADE KUSNADI', '100000046', 'ade@imajiwa.id', NULL, '$2y$10$peIK8yIZPJ1S4kehcBvRNeiAVVcSZltJKp42AZ926PppBa1vjk8uu', 'Ade01', 'avatars/8fulgzpNPuG1UkSxsTCWXleJd5vAgnfTspnvMpTe.png', NULL, NULL, NULL, 1, 'DqqTMyz00GAotrUw06wJSVWoZufxzbW0bwepFafrYrFrEkLMXk0aYbuaM3U8', '2024-09-03 08:32:37', '2024-10-30 13:08:15'),
(7, 'AFIF MUHAMMAD NADHMI', '100000064', 'afif@imajiwa.id', NULL, '$2y$10$tSihIei9zAg69FzRW4Fbr.02R/fk23nERsXRldMLquiAeC8Q1X3AC', 'Afif01', 'avatars/f7v4PwdWru3uDft14uoAtHjMRW1IhIGZYnyxbYWM.jpg', NULL, NULL, NULL, 1, 'AtTtbvi7jcDGmLXzn1vVZmwbKvC9xFfu8Ig0NblFZXeY2uSd4RXua2Jp6hnE', '2024-09-03 08:32:37', '2024-10-16 13:07:03'),
(8, 'ALAM BAYU KUSUMA', '100000027', 'alam@imajiwa.id', NULL, '$2y$10$WLO9USLZ2AQaR6Ge4x/SkedWhlvsDhdNxANWRvMcclODz0ZlYctB.', 'Doubl3JP3G', 'avatars/YMETtEQw0yfMyzUDYVqdiPMmKTr11iuQsfR8bgDP.jpg', NULL, NULL, NULL, 1, 'nTq264VeJFPEjuuqu6UTXLqyPNgN5HzrvXoeokItVdLVgTJspjbenA7gtJTw', '2024-09-03 08:32:37', '2024-09-30 08:58:43'),
(9, 'ALVIAN PAHLEVI', '100000062', 'levi@imajiwa.id', NULL, '$2y$10$t8PHniZDwFPfEq5TpQbqOubxBxXNx.JB8M95O8.zbDT4sD9Q9W3uu', 'Levi01', 'avatars/0C4COKlv8AnUsfhSMlAsAn2P8FidkxPcoJdbHUNx.jpg', NULL, NULL, NULL, 1, '49dGdOPGs29TwwpOZZmWWq9K1LbfFouM2NlVNnBB4522NFi5zngDbJTjv009', '2024-09-03 08:32:37', '2024-12-13 15:06:13'),
(10, 'ANDRI RISDIANTO', '100000019', 'trexon@imajiwa.id', NULL, '$2y$10$GJykCpt2LnT9WHq9UlmSAOKQ9q8K2gPu6/Zwrm4iysrGaqzYtxrdi', 'andri_13', 'avatars/4HFoPSezDwieJ8BTJSP5fqd89a255OLE2QZ5fuyj.jpg', NULL, NULL, NULL, 1, 'w96VH8VX1Yaj7iuqaFxD04yvSV5YYgzTQ1WLhkso2OgPmJ1EEvbzP4IU4KRY', '2024-09-03 08:32:37', '2024-09-30 08:58:42'),
(11, 'ANGGA FRADIKSA', '100000031', 'angga@imajiwa.id', NULL, '$2y$10$TUYzuKhRYgo2H2xQ7DR7p.8LQLGaIC0W4MAa79HmJtTP3p4zSXuJa', 'Angga01', NULL, NULL, NULL, NULL, 1, 'UVD20pYCxwN0rX2sH6GzfGwmLbDPJQhW3UprF4zo9K2LXJp9WyX412lDWnoT', '2024-09-03 08:32:38', '2024-09-30 08:58:44'),
(12, 'ARI YANTI ALITA', '100000003', 'ari@imajiwa.id', NULL, '$2y$10$EgDYtzrML3chEUg2bVAueO0vHm1anITS/0FDP.9J2IGrq..N1awgu', 'Ari01', 'avatars/JMPd5NZ1EVmj8cSKb22dwIDVg7wcB6aMvFi31hfn.jpg', NULL, NULL, NULL, 1, 'nMVCq1b1nGHPs9TQWYnN6EpHY4DSfZHGQuirLCkdCi3bPclzBNb7NnkKbSzM', '2024-09-03 08:32:38', '2024-10-07 02:58:41'),
(13, 'ARIF HERMANTO', '100000014', 'arif@imajiwa.id', NULL, '$2y$10$YPkeu3tGbjTu6EjgzZd1xe0TC7.xnZ9ZksLxu4ctDacWzMc1J9bBC', 'Arif01', 'avatars/WbabM06UztuMm7U7EqLwoYomym2klWE3X7U4NdgJ.webp', NULL, NULL, NULL, 1, 'pwRGFl7W90TPaNgFmXkqatPjOPVNNnfUsEiealDFiY8CkTCYPTKNDAOLDHJz', '2024-09-03 08:32:38', '2024-09-30 08:58:42'),
(14, 'AYU IDA FAIDAH', '100000002', 'finance@imajiwa.id', NULL, '$2y$10$tly9MeHFE4kRUlrtHB2QCukzYool0vynogX4tzoHhHJEj77QrZsM2', 'Ida01', NULL, NULL, NULL, NULL, 1, NULL, '2024-09-03 08:32:38', '2024-09-30 08:58:41'),
(15, 'BIJAHIKA MAULANA KOHRI RIJAL', '100000026', 'bijahika@imajiwa.id', NULL, '$2y$10$IMuufZa7pfFzpqhghY222OO/fLGjzKkyUALrJLkDWmlD4rZ/oBvh6', 'Bija01', 'avatars/xAFPNL9TNjTy9V0ACPTASkHmoXRuZGOnCcV4K6qN.jpg', NULL, NULL, NULL, 1, 'qbIc7W3SVlAU3iCJT6zNeXje4npdR3S5GCsiohOzV3r9yUXLwDJUeVi1Lb9U', '2024-09-03 08:32:38', '2024-11-05 10:43:57'),
(16, 'CICILIA JOSEFINE', '100000072', 'cicilia@imajiwa.id', NULL, '$2y$10$WnDo31Hz1IKnIpUWaEEBeeHgGTJk0rXJwbtUIqSTDVMqvoI0ruskG', 'Cicil01', NULL, NULL, NULL, NULL, 1, 's14HDP8Xaw0bPMPBBNy4UWYtxoXwDifGgKAQmyKHOVqWrrUnxgQ3ak73vz2l', '2024-09-03 08:32:38', '2024-09-30 08:58:46'),
(17, 'DICKY RAKA PUTRA', '100000043', 'raka@imajiwa.id', NULL, '$2y$10$M3TpxH6XDdYVuDIqpj1Ws.BrTGs4Bq1M6IE8o9MnJ/uXloFozvh0q', 'Dicky01', 'avatars/XkHrr7xhpRUn09tbVlSbmiNflaum9pR4g5u4H3Zu.jpg', NULL, NULL, NULL, 1, 'ORi62SHl1VspoVCkm4gMBYTLt0j6f7buMNU5YeG4nrpgISgQ7Np8iwEoIhix', '2024-09-03 08:32:38', '2024-11-26 20:04:46'),
(18, 'FARID NURHIDAYAT', '100000018', 'farid@imajiwa.id', NULL, '$2y$10$QaXfIJA.oKKKb8Zp82M/cOipu2lD9c36EzumauPPRnSxNEqwSrO02', 'Fn123$%^', 'avatars/4GO6Oq4zMEJXVG1aUCziFUMLOvPHedawynLF9l6u.jpg', NULL, NULL, NULL, 1, NULL, '2024-09-03 08:32:38', '2024-09-30 08:58:42'),
(19, 'HIGGANA APRILIA', '100000030', 'higgana@imajiwa.id', NULL, '$2y$10$WK/5IY2XLlXFbPgLjhoPHe3g91tOgY62V8VLPQ3pmT4qpOZVtx/ki', 'Gana555666', 'avatars/WHBdHGnHRQFyB9gSYn55otknHfPtKg5K8c1TEJBB.jpg', NULL, NULL, NULL, 1, 'vcb1p1WAfE0rDpsDuYqZREClRInETPfc1N4TZn1dL3LsnKtlwovNMfaqctXC', '2024-09-03 08:32:38', '2024-09-30 08:58:43'),
(20, 'JAMES WIDYABUDHI PRAKARSA', 'James', 'james.prakarsa@gmail.com', NULL, '$2y$10$iWa70PHSXEsLsAxk/Ye.GOs6z4a6usfEm0.tTI/zblmXt9sDdZpIa', 'James01', NULL, NULL, NULL, NULL, 1, NULL, '2024-09-03 08:32:38', '2024-09-30 08:58:41'),
(21, 'JAUHAR AHMAD', '100000024', 'jauhar@imajiwa.id', NULL, '$2y$10$0G0ivMQp54DBCNuqD4zzge9TPPG9fywBvflvqXsl/L302PT.2alG.', 'Joimajiwa26', NULL, NULL, NULL, NULL, 1, '0VATQAw2ago507biaAvfmQIizDTEyJP60Ay1JQRBj6BHtKhfbZVwKzyGug52', '2024-09-03 08:32:39', '2024-12-18 11:28:33'),
(22, 'JESON THEO PILUS MORIS', '100000048', 'jeson@imajiwa.id', NULL, '$2y$10$G94fx6qYHq6i4Ohx0H6eOuRqSURGLs7.jz4HNkIu3OAl8MXZObIxW', 'Jeson01', 'avatars/NFnXiPTQeddjt966J2WHlKn6ydBPyXxocNm28kD7.png', NULL, NULL, NULL, 1, 'Vp2WIMz8pLT59hWDiaFpOcCKgUdjvfiZKIBMdZQCgtG3jOA2rdycfFzmVrak', '2024-09-03 08:32:39', '2024-11-05 10:44:15'),
(23, 'JOHAN MUSTOPA SUMAHAR', '100000016', 'johan@imajiwa.id', NULL, '$2y$10$LYvzTB5o8M1SanJaaALqle6zoRb3R.GBWIjBBrCrS070AYktOi4ra', 'kopites36', NULL, NULL, NULL, NULL, 1, NULL, '2024-09-03 08:32:39', '2025-01-09 12:27:32'),
(24, 'LEMBANG SURA\' SAPAK', '100000061', 'sura@imajiwa.id', NULL, '$2y$10$j/gjt7FXX3fntEXiq6TU7uBKh39etwvT8AWTohHzj.LxG7ifGE7Ty', 'Sura01', NULL, NULL, NULL, NULL, 1, NULL, '2024-09-03 08:32:39', '2024-09-30 08:58:45'),
(25, 'MADA SATYAGRAHA', '100000015', 'mada@imajiwa.id', NULL, '$2y$10$EzEa3szMbMbCklUWKEfEeuIYRXeF31E4NKYgSXLiao.GsyqHo0XJC', 'Mada01', 'avatars/G7n90fmMW4h6sx1CCzLTQAuPqTZTTsphNFHUcBXY.jpg', NULL, NULL, NULL, 1, 'HI9yS2pO3MhmWCYsBz831MaltwOIwg50zm9WHwgp9J95IWDuxsso45D05IJy', '2024-09-03 08:32:39', '2024-11-05 09:05:23'),
(26, 'MAHFIRA FITRI MAULANI', '100000063', 'fira@imajiwa.id', NULL, '$2y$10$c7nrUhfB9Mod8qZkjv2dA.fdLOiR3.6MikiW5auLh.ZvR1u1K0SSy', 'jul!eismine29', 'avatars/NX5toLroebtip2OCxZqDhnruLTt9PzcBWq1sc05b.jpg', NULL, NULL, NULL, 1, 'MkJtvCc8YZgLHzeIebUSjtHk4l2PJMMDzAZuEJb6qN8hV9xYJ9ZwCdbYzojK', '2024-09-03 08:32:39', '2024-09-30 08:58:45'),
(27, 'MAJAZUL HAQ', '100000057', 'adhink@imajiwa.id', NULL, '$2y$10$pCpN6THAAOMj/mlhxWYDJuRTuivGpajNZiCk2AWCxOI0XaMovESVq', 'Adhink01', 'avatars/iglC4Fj4ZjNjArA6aBU1eF3p2gDBPyh9Pg0tVNlG.jpg', NULL, NULL, NULL, 1, NULL, '2024-09-03 08:32:39', '2024-09-30 08:58:45'),
(28, 'MUHAMAD FIKRI HAIKAL', '100000045', 'iki@imajiwa.id', NULL, '$2y$10$J7LgSjKIHweVfEqS99ZnhugR.jzDFrN53hmD5sDnSIjxgadQEsiyK', 'Fikri01', NULL, NULL, NULL, NULL, 1, '0s92NnKPV2e8Wq0tZL5ZeFif6QPhstbbDnHjU3AwZ3zNgTSHYjQlG93vKo3b', '2024-09-03 08:32:39', '2024-09-30 08:58:44'),
(29, 'MUHAMAD FRASAN IQBAL', '100000049', 'iqbal@imajiwa.id', NULL, '$2y$10$vbdz6GgqrXfW3fAnTvHUS.nvUTmxCaKvh11As5srdZeuMMfdsr/3y', 'cadell14', 'avatars/Xn3AjX0CxlDLjjfiVuBdGs5hcIExNAu1WvxNr7sI.jpg', NULL, NULL, NULL, 1, 'kn8LJBtPPMZhPORCvCsmC3nvmQeh6pbWgUHCQucbSxTk6HN258fytwYM5oLm', '2024-09-03 08:32:39', '2024-09-30 08:58:45'),
(30, 'MUHAMMAD ARIF ROFIUDIN', '100000020', 'arifrofi@imajiwa.id', NULL, '$2y$10$MNlbIdLG8kpZR2.AliIbPuXU8rbrIRP6v07/8NDgZUgdWyDfRloGu', 'Arifrofi01', NULL, NULL, NULL, NULL, 1, '5TpvrpNcPaT0SWK6GsiKb3mXj5kxacQ8PcDlxLxDPjroxOpkyRav910OmPIm', '2024-09-03 08:32:39', '2024-09-30 08:58:43'),
(31, 'MUHAMMAD FAIZ SATRIO', '100000050', 'satrio@imajiwa.id', NULL, '$2y$10$eZ6.p5NRXzcuOxga1u9aL.Q6YtvJsG/q4Q824Q4NFUxIvM4qODU9a', 'cokasu567', 'avatars/kcbmpGEPIwYzTT4KM8GATXfAwTnO0tuuBxOZkEA6.png', NULL, NULL, NULL, 1, 'vaknO8VzXyu3o4XZzJ1YFQesHhjEFnC4QKep6rO437j6m7TuBMsh5ycBc2HS', '2024-09-03 08:32:40', '2024-09-30 08:58:45'),
(32, 'NABHILA BANGUN CIPTA JK', '100000071', 'bilalkirana@imajiwa.id', NULL, '$2y$10$u/dhugUYcCw0bGFZTxbTuO4bzGxXFCpy7rA913w1Ak0bT/35AfdFO', 'Bilalkirana', 'avatars/npFUVeyHeOP6ydleC98LBF9rzdtYpGldaCpDl8OF.jpg', NULL, NULL, NULL, 1, '6Pcs5xgEnRqglpDFGClukaRDctD7ANHXEL7Fdd1sVWTtps48d4WY8kYz5MeN', '2024-09-03 08:32:40', '2024-10-21 09:21:12'),
(33, 'RAYHAN INDRA', '100000059', 'rayhan@imajiwa.id', NULL, '$2y$10$gxXZoR1CVGOtZudXAfZHP.JHSdBTKUBT8F.oqH7U6qWy1lFPJDuvO', 'Rayhan01', 'avatars/IEeIS1Jqfrmn43iMjRJ5hGRodc4ggPEQcOjpoN1D.jpg', NULL, NULL, NULL, 1, 'VY6EfTMcqOaIPiRfnL5wteNuyV10fQJ1QYPQPvXEurCYmlfxJAVZBYNvJgew', '2024-09-03 08:32:40', '2024-09-30 08:58:45'),
(34, 'SANDI FEBRIAN', '100000008', 'sandi@imajiwa.id', NULL, '$2y$10$LsKZQpxlCFzY1KPpsrzHEOeufvhGfZ2iqpV/vWRN95vbqHu5RcCYm', 'Sandi32', 'avatars/smqLlyHxIbdmY2coGiOTLfhgHoOsCHhxkwwszCcL.jpg', NULL, NULL, NULL, 1, '25MY6KFNpTQCRz9hs7OgQXWpTZg1Btvt4rHFrD2DB6xb7wv0KLVk7t86neC2', '2024-09-03 08:32:40', '2024-10-15 09:24:44'),
(35, 'SONY PRIMANTO', '100000010', 'sony@imajiwa.id', NULL, '$2y$10$ycXZZlFU8i7CNy8G09OIDu31fU6dnUsDUXzgjder8PDfOusIqH036', 'Sony01', NULL, NULL, NULL, NULL, 1, NULL, '2024-09-03 08:32:40', '2024-09-30 08:58:42'),
(36, 'SUBOKASTOWO S', '100000022', 'subokastowo.s@gmail.com', NULL, '$2y$10$4h5/ZBh46LwRuUDm6fCCB.hd5Udiq9w6sb7189fvrtB4.Q7L181Ta', 'Subo01', NULL, NULL, NULL, NULL, 1, NULL, '2024-09-03 08:32:40', '2024-09-30 08:58:43'),
(37, 'VINDI KUSNUL ARIFIN', '100000025', 'vindi@imajiwa.id', NULL, '$2y$10$zkRtf/ZrodJE13cucPcpSO6DwCxuykz28PcoXtVc.5HGX9IIk5gm2', 'imajiwaid', 'avatars/B92J09c5LJn63iRuev99TgrrA7idaHWtv6FWpnws.jpg', NULL, NULL, NULL, 1, NULL, '2024-09-03 08:32:40', '2024-11-26 07:29:52'),
(38, 'YEDUTUN LINUS SUWARNO', '100000033', 'ones@imajiwa.id', NULL, '$2y$10$iKoTLFsyt2SRJEkoDXd/buYJb2PRJ.UQyDhBHbZqeSxF/q8txg2bm', 'xoNezxBlckL!st27', 'avatars/zAE2q7GNyEMjmjaaDgX4sxSOmnpa1m0gdaM5EyEF.jpg', NULL, NULL, NULL, 1, 'dlFGN8CIgbZ92Xk20jAM7KhXkOLt93I8KzADypMQuC6db2kLIgxeacXZba0T', '2024-09-03 08:32:40', '2024-09-30 08:58:44'),
(39, 'YOGA WAHYU SADEWO', '100000065', 'yoga@imajiwa.id', NULL, '$2y$10$1ZZNaUZAVo7dCh9OnUOBcOc45FbD8ZOqH35EWozLjc.BiVEnQkL3K', 'Yoga01', 'avatars/KOwcdXLRWzNrqPGHfYJOrA2wULox7v21EzNu3Ghi.jpg', NULL, NULL, NULL, 1, 'VVHubSrveoPWJ10tBvqkfvMcXhlhkMNaJ17jN06oStkOJ8vH8yd3fNUmrpAZ', '2024-09-03 08:32:40', '2024-12-16 11:08:43'),
(40, 'ZENDRI RAHMAN', '100000044', 'zendri@imajiwa.id', NULL, '$2y$10$siF5dFem3JXcqPCy3qXZLeq/xNuUNglQaPp5Ttwcgo6kQfzo/KFU.', 'Zendri01', 'avatars/MvPNpAzVfAcbWdl5s5ttDBvlpyP4eFTTf2p6bzsx.jpg', NULL, NULL, NULL, 1, 'FeQDSF6AAGfe33v86cIQ3GvOWHKbi4jqxa5Ym22e86kDJszLwJAJ2ewVt1nk', '2024-09-03 08:32:40', '2024-11-05 10:42:59'),
(41, 'ZHENY RISMAWATI', '100000005', 'risma@imajiwa.id', NULL, '$2y$10$3zZKLIsMVMkDLXWqy.IZFulmIHSy8wNo6GOMy9Eq8nPujtlCvv1zi', 'Risma01', 'avatars/MZydTkOFVMMgsw7IVB4Oxr4W8VmEsCrQJojBEDjH.jpg', NULL, NULL, NULL, 1, 'wzao8LLnYVw3RHkdBkOdPeGr5yIWZqDljYfDVAmKF5zBD5axAdkKWGdcq3NQ', '2024-09-03 08:32:41', '2025-01-07 08:11:08'),
(171, 'Yudi yansyah', '100000058', '100000058@example.com', NULL, '$2y$10$jKGxwSXUyC/AI65/l2iThuIQR2zqbX50SZKt8cZoZ/L/WN78eTBeu', '563f3c79e65f8f5a5489e5d5', NULL, NULL, NULL, NULL, 0, NULL, '2024-09-23 10:31:16', '2024-09-30 08:58:45'),
(172, 'Dana Rizki', '100000011', '100000011@example.com', NULL, '$2y$10$g69XP9HChOMJJXI6IVcpQesGh77TSvXwyHlv5Aa8BAWnFGnAZP846', 'e9cc5a6329c793519387b7ed', NULL, NULL, NULL, NULL, 0, NULL, '2024-09-23 10:31:47', '2024-09-30 08:58:42'),
(173, 'Muhammad Derajat Ali Mukti', '100000006', '100000006@example.com', NULL, '$2y$10$sf8iOACYSJ2ixvBmk3u0A.HtGPPNCOqLcrZnnOyC7UBLmCjuV/cHy', 'e9b1cec462ec4cf16c720a93', NULL, NULL, NULL, NULL, 0, NULL, '2024-09-23 10:31:54', '2024-09-30 08:58:41'),
(174, 'Endang Wati', '100000004', '100000004@example.com', NULL, '$2y$10$mHHMuqfHAkd9YDbQ.hbDiuXu66O1cXUFUNU04Nx5LhuODHxTfgYte', 'f60497be0cf2724d48eae0f7', NULL, NULL, NULL, NULL, 0, NULL, '2024-09-23 10:32:04', '2024-09-30 08:58:41'),
(175, 'Ign Tunggung Wahyu', '100000023', '100000023@example.com', NULL, '$2y$10$rTu08Sw2ASlllN9ugrr1eeaCE/Wk2ConKkB4JrccjFhLv41rx7Xn2', 'e8f0c0396203c2708c51d35d', NULL, NULL, NULL, NULL, 0, NULL, '2024-09-23 10:32:09', '2024-09-30 08:58:43'),
(176, 'Ahmad Fauzi', '100000047', '100000047@example.com', NULL, '$2y$10$kVsSwV5BUVwOIwoBQbjw7.iERcstisHdMVgQE8QDkaGz8PSiJZca2', 'c98f1d3d5a4f2b6396d428da', NULL, NULL, NULL, NULL, 0, NULL, '2024-09-23 10:32:12', '2024-09-30 08:58:44'),
(177, 'Hery Ary Setiawan', '100000009', '100000009@example.com', NULL, '$2y$10$kTFHZL87Rism3527onFqyOUEIvpcnj/fN1ZcUhUdjW/ZbTmFSythW', 'a5b33b2d7baf3dcd09da321e', NULL, NULL, NULL, NULL, 0, NULL, '2024-09-23 10:32:15', '2024-09-30 08:58:42'),
(178, 'Arif Hidayat', '100000021', '100000021@example.com', NULL, '$2y$10$QYDRom4.mEIEOEeO3AunXOtZ1CoQdCSDCHhDe7FmNVH8j6m.BORXi', 'b0774e8d5a18731a678ab8e5', NULL, NULL, NULL, NULL, 0, NULL, '2024-09-23 10:34:00', '2024-09-30 08:58:43'),
(179, 'Seno Nuchgroho', '100000007', '100000007@example.com', NULL, '$2y$10$cpZdSjDD6FXAs5Iz41i/QeUIbsdkFb60AiZYn8ZBmXY3tWykpFcXa', '2c2ae0e2e4458e1c7eef1b1b', NULL, NULL, NULL, NULL, 0, NULL, '2024-09-23 10:34:05', '2024-09-30 08:58:41'),
(180, 'Maulana Ibrahim', '100000055', '100000055@example.com', NULL, '$2b$10$GegpElwg.TQ14PQREEMYVOmugW.y61GjGRWqCTzSKBaIhdmqtPl4C', 'e998bcf9dd9b7dae17ab7dad', NULL, NULL, NULL, NULL, 1, NULL, '2024-11-20 12:26:43', NULL),
(182, 'Muh Wildan Ferdiansyah', '100000075', 'ferdi@imajiwa.id', NULL, '$2y$10$KNvXPbsJPRXBtxUfQqbob.X9vLTOJIha8NxNsmw1EBCGdfcy9nATO', 'wilferd19', 'avatars/SW9c7sZbPz5i9WDdpU6NpFh3gLMEdLvbjiMFsKIE.jpg', NULL, NULL, NULL, 1, NULL, '2025-03-26 09:21:27', '2025-03-26 09:45:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `visits`
--

CREATE TABLE `visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `site_id` bigint(20) UNSIGNED NOT NULL,
  `visit_category_id` bigint(20) UNSIGNED NOT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `visit_categories`
--

CREATE TABLE `visit_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `visit_categories`
--

INSERT INTO `visit_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Management Meeting', '2024-09-03 08:29:51', '2024-09-03 08:29:51'),
(2, 'Patroli', '2024-09-03 08:29:51', '2024-09-03 08:29:51'),
(3, 'Koordinasi', '2024-09-03 08:29:51', '2024-09-03 08:29:51');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absent_requests`
--
ALTER TABLE `absent_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absent_requests_employee_id_foreign` (`employee_id`),
  ADD KEY `absent_requests_director_id_foreign` (`director_id`),
  ADD KEY `absent_requests_supervisor_id_foreign` (`supervisor_id`),
  ADD KEY `absent_requests_hrd_id_foreign` (`hrd_id`);

--
-- Indeks untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indeks untuk tabel `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `announcements_slug_unique` (`slug`);

--
-- Indeks untuk tabel `announcements_recipients`
--
ALTER TABLE `announcements_recipients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_recipients_announcement_id_foreign` (`announcement_id`),
  ADD KEY `announcements_recipients_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_employee_id_foreign` (`employee_id`),
  ADD KEY `attendances_machine_id_foreign` (`machine_id`),
  ADD KEY `attendances_attendance_method_id_foreign` (`attendance_method_id`),
  ADD KEY `attendances_site_id_foreign` (`site_id`);

--
-- Indeks untuk tabel `attendance_methods`
--
ALTER TABLE `attendance_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `attendance_temps`
--
ALTER TABLE `attendance_temps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_temps_employee_id_foreign` (`employee_id`),
  ADD KEY `attendance_temps_machine_id_foreign` (`machine_id`),
  ADD KEY `attendance_temps_attendance_method_id_foreign` (`attendance_method_id`),
  ADD KEY `attendance_temps_site_id_foreign` (`site_id`);

--
-- Indeks untuk tabel `category_inventories`
--
ALTER TABLE `category_inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `category_projects`
--
ALTER TABLE `category_projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_projects_name_unique` (`name`);

--
-- Indeks untuk tabel `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_email_unique` (`email`);

--
-- Indeks untuk tabel `daily_reports`
--
ALTER TABLE `daily_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_reports_employee_id_foreign` (`employee_id`);

--
-- Indeks untuk tabel `daily_report_comments`
--
ALTER TABLE `daily_report_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_report_comments_daily_report_id_foreign` (`daily_report_id`),
  ADD KEY `daily_report_comments_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `daily_report_reads`
--
ALTER TABLE `daily_report_reads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_report_reads_daily_report_id_foreign` (`daily_report_id`),
  ADD KEY `daily_report_reads_employee_id_foreign` (`employee_id`);

--
-- Indeks untuk tabel `daily_report_recipients`
--
ALTER TABLE `daily_report_recipients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_report_recipients_daily_report_id_foreign` (`daily_report_id`),
  ADD KEY `daily_report_recipients_employee_id_foreign` (`employee_id`);

--
-- Indeks untuk tabel `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_site_id_foreign` (`site_id`),
  ADD KEY `departments_supervisor_id_foreign` (`supervisor_id`),
  ADD KEY `departments_director_id_foreign` (`director_id`);

--
-- Indeks untuk tabel `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_templates_slug_unique` (`slug`);

--
-- Indeks untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `employees_positions`
--
ALTER TABLE `employees_positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_positions_employee_id_foreign` (`employee_id`),
  ADD KEY `employees_positions_position_id_foreign` (`position_id`);

--
-- Indeks untuk tabel `employee_inventories`
--
ALTER TABLE `employee_inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_inventories_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_inventories_inventory_id_foreign` (`inventory_id`),
  ADD KEY `employee_inventories_status_id_foreign` (`status_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `financial_requests`
--
ALTER TABLE `financial_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financial_requests_employee_id_foreign` (`employee_id`);

--
-- Indeks untuk tabel `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventories_category_inventory_id_foreign` (`category_inventory_id`),
  ADD KEY `inventories_status_id_foreign` (`status_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_requests_employee_id_foreign` (`employee_id`),
  ADD KEY `leave_requests_director_id_foreign` (`director_id`),
  ADD KEY `leave_requests_supervisor_id_foreign` (`supervisor_id`),
  ADD KEY `leave_requests_hrd_id_foreign` (`hrd_id`);

--
-- Indeks untuk tabel `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `positions_department_id_foreign` (`department_id`);

--
-- Indeks untuk tabel `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_code_unique` (`code`),
  ADD KEY `projects_employee_id_foreign` (`employee_id`),
  ADD KEY `projects_category_id_foreign` (`category_id`),
  ADD KEY `projects_client_id_foreign` (`client_id`);

--
-- Indeks untuk tabel `projects_employees`
--
ALTER TABLE `projects_employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_employees_project_id_foreign` (`project_id`),
  ADD KEY `projects_employees_employee_id_foreign` (`employee_id`);

--
-- Indeks untuk tabel `project_additional_managers`
--
ALTER TABLE `project_additional_managers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_additional_managers_project_id_foreign` (`project_id`),
  ADD KEY `project_additional_managers_employee_id_foreign` (`employee_id`);

--
-- Indeks untuk tabel `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `request_items`
--
ALTER TABLE `request_items`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `request_reads`
--
ALTER TABLE `request_reads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_reads_employee_id_foreign` (`employee_id`);

--
-- Indeks untuk tabel `request_recipients`
--
ALTER TABLE `request_recipients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_recipients_employee_id_foreign` (`employee_id`);

--
-- Indeks untuk tabel `request_validates`
--
ALTER TABLE `request_validates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_validates_employee_id_foreign` (`employee_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `social_accounts`
--
ALTER TABLE `social_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `social_accounts_provider_id_unique` (`provider_id`);

--
-- Indeks untuk tabel `status_inventories`
--
ALTER TABLE `status_inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `telescope_entries`
--
ALTER TABLE `telescope_entries`
  ADD PRIMARY KEY (`sequence`),
  ADD UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  ADD KEY `telescope_entries_batch_id_index` (`batch_id`),
  ADD KEY `telescope_entries_family_hash_index` (`family_hash`),
  ADD KEY `telescope_entries_created_at_index` (`created_at`),
  ADD KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`);

--
-- Indeks untuk tabel `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD PRIMARY KEY (`entry_uuid`,`tag`),
  ADD KEY `telescope_entries_tags_tag_index` (`tag`);

--
-- Indeks untuk tabel `telescope_monitoring`
--
ALTER TABLE `telescope_monitoring`
  ADD PRIMARY KEY (`tag`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visits_employee_id_foreign` (`employee_id`),
  ADD KEY `visits_site_id_foreign` (`site_id`),
  ADD KEY `visits_visit_category_id_foreign` (`visit_category_id`);

--
-- Indeks untuk tabel `visit_categories`
--
ALTER TABLE `visit_categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absent_requests`
--
ALTER TABLE `absent_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `announcements_recipients`
--
ALTER TABLE `announcements_recipients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `attendance_methods`
--
ALTER TABLE `attendance_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `attendance_temps`
--
ALTER TABLE `attendance_temps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `category_inventories`
--
ALTER TABLE `category_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `category_projects`
--
ALTER TABLE `category_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `daily_reports`
--
ALTER TABLE `daily_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `daily_report_comments`
--
ALTER TABLE `daily_report_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `daily_report_reads`
--
ALTER TABLE `daily_report_reads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `daily_report_recipients`
--
ALTER TABLE `daily_report_recipients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `employees_positions`
--
ALTER TABLE `employees_positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee_inventories`
--
ALTER TABLE `employee_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `financial_requests`
--
ALTER TABLE `financial_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `machines`
--
ALTER TABLE `machines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT untuk tabel `projects_employees`
--
ALTER TABLE `projects_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=505;

--
-- AUTO_INCREMENT untuk tabel `project_additional_managers`
--
ALTER TABLE `project_additional_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `requests`
--
ALTER TABLE `requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `request_items`
--
ALTER TABLE `request_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `request_reads`
--
ALTER TABLE `request_reads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `request_recipients`
--
ALTER TABLE `request_recipients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `request_validates`
--
ALTER TABLE `request_validates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `sites`
--
ALTER TABLE `sites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `social_accounts`
--
ALTER TABLE `social_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `status_inventories`
--
ALTER TABLE `status_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `telescope_entries`
--
ALTER TABLE `telescope_entries`
  MODIFY `sequence` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT untuk tabel `visits`
--
ALTER TABLE `visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `visit_categories`
--
ALTER TABLE `visit_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absent_requests`
--
ALTER TABLE `absent_requests`
  ADD CONSTRAINT `absent_requests_director_id_foreign` FOREIGN KEY (`director_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `absent_requests_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absent_requests_hrd_id_foreign` FOREIGN KEY (`hrd_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `absent_requests_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `announcements_recipients`
--
ALTER TABLE `announcements_recipients`
  ADD CONSTRAINT `announcements_recipients_announcement_id_foreign` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `announcements_recipients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_attendance_method_id_foreign` FOREIGN KEY (`attendance_method_id`) REFERENCES `attendance_methods` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_machine_id_foreign` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `attendance_temps`
--
ALTER TABLE `attendance_temps`
  ADD CONSTRAINT `attendance_temps_attendance_method_id_foreign` FOREIGN KEY (`attendance_method_id`) REFERENCES `attendance_methods` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_temps_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_temps_machine_id_foreign` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_temps_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `daily_reports`
--
ALTER TABLE `daily_reports`
  ADD CONSTRAINT `daily_reports_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `daily_report_comments`
--
ALTER TABLE `daily_report_comments`
  ADD CONSTRAINT `daily_report_comments_daily_report_id_foreign` FOREIGN KEY (`daily_report_id`) REFERENCES `daily_reports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `daily_report_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `daily_report_reads`
--
ALTER TABLE `daily_report_reads`
  ADD CONSTRAINT `daily_report_reads_daily_report_id_foreign` FOREIGN KEY (`daily_report_id`) REFERENCES `daily_reports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `daily_report_reads_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `daily_report_recipients`
--
ALTER TABLE `daily_report_recipients`
  ADD CONSTRAINT `daily_report_recipients_daily_report_id_foreign` FOREIGN KEY (`daily_report_id`) REFERENCES `daily_reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `daily_report_recipients_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_director_id_foreign` FOREIGN KEY (`director_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `departments_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `departments_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `employees_positions`
--
ALTER TABLE `employees_positions`
  ADD CONSTRAINT `employees_positions_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_positions_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `employee_inventories`
--
ALTER TABLE `employee_inventories`
  ADD CONSTRAINT `employee_inventories_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_inventories_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_inventories_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `status_inventories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `financial_requests`
--
ALTER TABLE `financial_requests`
  ADD CONSTRAINT `financial_requests_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_category_inventory_id_foreign` FOREIGN KEY (`category_inventory_id`) REFERENCES `category_inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `status_inventories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_director_id_foreign` FOREIGN KEY (`director_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_requests_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leave_requests_hrd_id_foreign` FOREIGN KEY (`hrd_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_requests_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `positions_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category_projects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `projects_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `projects_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `projects_employees`
--
ALTER TABLE `projects_employees`
  ADD CONSTRAINT `projects_employees_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_employees_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `project_additional_managers`
--
ALTER TABLE `project_additional_managers`
  ADD CONSTRAINT `project_additional_managers_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_additional_managers_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `request_reads`
--
ALTER TABLE `request_reads`
  ADD CONSTRAINT `request_reads_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `request_recipients`
--
ALTER TABLE `request_recipients`
  ADD CONSTRAINT `request_recipients_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `request_validates`
--
ALTER TABLE `request_validates`
  ADD CONSTRAINT `request_validates_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `visits_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `visits_visit_category_id_foreign` FOREIGN KEY (`visit_category_id`) REFERENCES `visit_categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
