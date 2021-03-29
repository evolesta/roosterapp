-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 25 jan 2021 om 17:32
-- Serverversie: 10.4.17-MariaDB
-- PHP-versie: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roosterapp`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `activation`
--

CREATE TABLE `activation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activation_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activated` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `activation`
--

INSERT INTO `activation` (`id`, `username`, `activation_id`, `activated`, `created_at`, `updated_at`) VALUES
(2, 'elange', 'kTWvggXFDc1q7AnY2Yz9EUZ2LcgpbCN7XKqgkg2UbadfZLf77HfhZSNZ0M39TFjH', 1, '2020-12-07 13:53:05', '2020-12-08 10:54:17'),
(3, 'rgrote', 'lIz475uq9IT3EEGYAepOd0N1DmsUury96g4Rz0BJ6MaLhhzGPBsnvoUVwDxtC9D8', 1, '2020-12-09 14:42:24', '2020-12-21 15:49:08'),
(4, 'jklave', '1YverG7WhLL9bL32TbJWaSsXhv6QonpYDNfAH3nxz7hDAWr8IjxYJUZ3qbDzIMJn', 0, '2020-12-09 14:42:52', '2020-12-09 14:42:52'),
(5, 'jbosk', '3RSyJbxHsQRMteM5B9D9uJKzLEd6INn7xtGIv3PvywLrdALyWeSDzmZfGsPF5Mck', 0, '2020-12-14 15:31:12', '2020-12-14 15:31:12'),
(6, 'jbloem', 'QnMdUyGFDFZn1VvpWGHTYckOOnMKU3bB5XhRnSlfsnHSLTe7JCj0w2jiIAg4QTkk', 1, '2020-12-28 16:06:19', '2020-12-28 16:06:46');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9, '2020_10_26_140859_create_users_table', 1),
(10, '2020_10_26_190014_create_reg_table', 1),
(12, '2020_11_09_181532_create_saldo_table', 3),
(13, '2020_11_10_105810_create_workhours', 4),
(15, '2020_11_30_145646_create_team_members', 5),
(16, '2020_11_30_150100_create_team', 6),
(17, '2020_11_30_150221_create_sector', 7),
(18, '2020_12_07_125233_create_activation_table', 8),
(19, '2020_12_21_161903_create_password_reset_table', 9),
(20, '2020_12_29_124402_create_verlof_table', 10);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `password_reset`
--

CREATE TABLE `password_reset` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reset_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `password_set` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `password_reset`
--

INSERT INTO `password_reset` (`id`, `username`, `reset_id`, `expiration`, `password_set`, `created_at`, `updated_at`) VALUES
(4, 'elange', 'ZW6J6LsPnTbTg3FObFalsSAqcTZW8g2N0M69Jwpf4BkG5pq63qGiWMS8B3mNmxzB', '2020-12-24 13:17:37', 0, '2020-12-23 16:05:35', '2020-12-23 16:05:35'),
(5, 'elange', 'HJU9dVfOlrNSEQEIBY26PjOxpKuMOQvYZppM3qtFPVxkSjJkF12qNAbwveQ9SzDW', '2020-12-24 14:32:44', 1, '2020-12-24 14:28:09', '2020-12-24 14:32:44');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `registrations`
--

CREATE TABLE `registrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `workedHours` time NOT NULL,
  `extraHours` time NOT NULL,
  `calc` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `registrations`
--

INSERT INTO `registrations` (`id`, `username`, `date`, `start`, `end`, `workedHours`, `extraHours`, `calc`, `created_at`, `updated_at`) VALUES
(5, 'testg', '2020-11-01', '07:30:00', '16:43:00', '09:13:00', '01:13:00', 1, '2020-11-02 15:42:47', '2020-11-02 15:44:23'),
(13, 'testg', '2020-11-02', '07:30:00', '17:00:00', '09:30:00', '01:30:00', 1, '2020-11-02 19:02:46', '2020-11-02 19:02:52'),
(15, 'testg', '2020-11-09', '09:00:00', '17:30:00', '08:30:00', '00:30:00', 1, '2020-11-09 19:38:56', '2020-11-09 19:39:08'),
(16, 'testg', '2020-11-10', '08:25:00', '00:00:00', '00:00:00', '00:00:00', 1, '2020-11-10 10:38:43', '2020-11-10 10:38:43'),
(17, 'testg', '2020-11-15', '07:00:00', '16:00:00', '09:00:00', '01:00:00', 1, '2020-11-16 18:53:33', '2020-11-16 18:54:33'),
(28, 'testg', '2020-11-24', '08:00:00', '17:00:00', '09:00:00', '01:00:00', 1, '2020-11-24 14:05:04', '2020-11-27 12:44:52'),
(31, 'rgrote', '2020-12-18', '07:30:00', '16:30:00', '09:00:00', '00:00:00', 1, '2020-12-18 12:27:09', '2020-12-28 15:36:12'),
(32, 'rgrote', '2020-12-28', '08:00:00', '16:32:00', '08:32:00', '-00:28:00', 1, '2020-12-28 15:32:30', '2020-12-28 15:35:15'),
(35, 'elange', '2021-01-02', '07:30:00', '16:00:00', '08:30:00', '00:30:00', 1, '2021-01-13 15:26:46', '2021-01-13 15:26:46'),
(36, 'elange', '2021-01-03', '08:00:00', '16:00:00', '08:00:00', '00:00:00', 1, '2021-01-13 15:27:18', '2021-01-13 15:27:18'),
(37, 'elange', '2021-01-04', '08:00:00', '17:00:00', '09:00:00', '01:00:00', 1, '2021-01-13 15:27:18', '2021-01-13 15:27:18'),
(43, 'testg', '2021-01-25', '08:00:00', '16:19:00', '08:19:00', '00:19:00', 1, '2021-01-25 15:17:38', '2021-01-25 15:19:26'),
(45, 'testg', '2021-01-18', '08:00:00', '17:00:00', '09:00:00', '01:00:00', 1, '2021-01-25 15:25:37', '2021-01-25 15:25:37'),
(46, 'testg', '2021-01-19', '09:00:00', '15:00:00', '06:00:00', '-02:00:00', 1, '2021-01-25 15:25:37', '2021-01-25 15:25:37');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `saldo`
--

CREATE TABLE `saldo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `workedHours` time NOT NULL,
  `saldo` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `saldo`
--

INSERT INTO `saldo` (`id`, `user_id`, `username`, `workedHours`, `saldo`, `created_at`, `updated_at`) VALUES
(1, 1, 'testg', '68:32:00', '04:32:00', NULL, '2021-01-25 15:25:37'),
(3, 4, 'elange', '25:30:00', '01:30:00', '2020-12-07 13:53:05', '2021-01-13 15:27:18'),
(4, 5, 'rgrote', '17:32:00', '-00:28:00', '2020-12-09 14:42:24', '2020-12-28 15:36:12'),
(5, 6, 'jklave', '00:00:00', '00:00:00', '2020-12-09 14:42:52', '2020-12-09 14:42:52'),
(7, 8, 'jbosk', '00:00:00', '00:00:00', '2020-12-14 15:31:12', '2020-12-14 15:31:12'),
(8, 12, 'jbloem', '00:00:00', '00:00:00', '2020-12-28 16:06:19', '2020-12-28 16:06:19');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sector`
--

CREATE TABLE `sector` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `sector`
--

INSERT INTO `sector` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'Shared Service Centrum', '2020-12-02 14:16:27', '2020-12-02 15:56:35'),
(4, 'Sociaal Domein', '2020-12-02 14:52:16', '2020-12-02 14:52:16'),
(5, 'Fysiek Domein', '2020-12-02 15:56:46', '2020-12-11 11:17:27'),
(6, 'Publieke Dienstverlening', '2020-12-04 10:15:46', '2020-12-04 10:25:38');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `team`
--

CREATE TABLE `team` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manager_Id` int(11) NOT NULL,
  `sector_Id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `team`
--

INSERT INTO `team` (`id`, `name`, `manager_Id`, `sector_Id`, `created_at`, `updated_at`) VALUES
(1, 'Informatie en Communicatie Technologie', 5, 2, '2020-12-10 10:18:46', '2020-12-14 14:04:20'),
(4, 'Informatie Management', 5, 2, '2020-12-11 13:21:15', '2020-12-27 13:47:02'),
(5, 'Burgerzaken', 6, 6, '2020-12-14 14:05:19', '2020-12-14 14:05:19');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `team_members`
--

CREATE TABLE `team_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Team_Id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `team_members`
--

INSERT INTO `team_members` (`id`, `User_Id`, `Team_Id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, NULL, '2020-12-14 19:38:05'),
(2, 1, 1, NULL, NULL),
(3, 8, 4, '2020-12-14 15:31:12', '2020-12-14 15:31:12'),
(4, 12, 4, '2020-12-28 16:06:19', '2020-12-28 16:06:19');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','manager','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `email_notification` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `role`, `active`, `email_notification`, `created_at`, `updated_at`) VALUES
(1, 'testg', '$2y$10$tIBB2T6lGjEewUUVSkC9/.VwL/10fwp82eXTl28FLXlxEllVQL99S', 'Test Gebruiker', 'erik.langendijk@gmail.com', 'admin', 1, 1, NULL, '2020-11-24 16:33:49'),
(4, 'elange', '$2y$10$XpqXluBnNEU.9ZwctyjHv.qdLOQ2OOpZdNpTNxv4LUHOkLRoPzmqe', 'Erik Langendijk', 'erik.langendijk@gmail.com', 'user', 1, 1, '2020-12-07 13:53:04', '2020-12-24 14:32:44'),
(5, 'rgrote', '$2y$10$y9clpeIx5XEo7Mo3ClhNReybBTQtZ5ILj5aeUm9OmCaXIs5LFA4VK', 'Roberto Groter', 'erik.langendijk@gmail.com', 'manager', 1, 1, '2020-12-09 14:42:24', '2020-12-28 15:48:06'),
(6, 'jklave', '$2y$10$PluGk3tuJ/iL6ciFLKFcO.fkpsYmijvEGqF4wd09cv3zbhKCNByN6', 'Jesse Klaver', 'jesse.klaver@mail.nl', 'manager', 0, 1, '2020-12-09 14:42:52', '2020-12-09 14:42:52'),
(8, 'jbosk', '$2y$10$OsqvOf/iA2FolcIoybMtBeTWUYVGXVRl9qfB8445EQVIzRlaw6KAK', 'Jantine Boskamp', 'j.boskamp@mailtje.nl', 'user', 0, 1, '2020-12-14 15:31:12', '2020-12-14 15:31:12'),
(12, 'jbloem', '$2y$10$ub7xXsc2wT64FpM/peLD2.tEoxhq1wDBc/vTdkbO4wNrUYhqY7rUC', 'Jelle Bloemhof', 'info@veela.nl', 'user', 1, 1, '2020-12-28 16:06:19', '2020-12-28 16:06:46');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `verlof`
--

CREATE TABLE `verlof` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `hours` float NOT NULL,
  `status` enum('concept','beoordeling','akkoord','afgewezen') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `verlof`
--

INSERT INTO `verlof` (`id`, `user_id`, `username`, `reason`, `start`, `end`, `hours`, `status`, `created_at`, `updated_at`) VALUES
(2, 4, 'elange', 'Vrij', '2020-12-31', '2020-12-31', 8, 'akkoord', '2020-12-30 10:12:50', '2021-01-11 13:37:31'),
(3, 4, 'elange', 'Vakantie', '2021-01-04', '2021-01-08', 36, 'afgewezen', '2020-12-30 10:16:25', '2021-01-11 13:48:45'),
(6, 4, 'elange', 'Test', '2021-08-01', '2021-08-01', 8, 'akkoord', '2021-01-11 13:52:05', '2021-01-15 15:07:11'),
(7, 1, 'testg', 'Vrij', '2021-01-27', '2021-01-27', 8, 'afgewezen', '2021-01-25 15:27:11', '2021-01-25 15:34:53');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `workhours`
--

CREATE TABLE `workhours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `workhours` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `workhours`
--

INSERT INTO `workhours` (`id`, `user_id`, `username`, `workhours`, `created_at`, `updated_at`) VALUES
(1, 1, 'testg', '08:00:00', NULL, '2020-11-18 15:50:08'),
(3, 4, 'elange', '08:00:00', '2020-12-07 13:53:05', '2020-12-14 19:38:05'),
(4, 5, 'rgrote', '09:00:00', '2020-12-09 14:42:24', '2020-12-09 14:42:24'),
(5, 6, 'jklave', '08:00:00', '2020-12-09 14:42:52', '2020-12-09 14:42:52'),
(7, 8, 'jbosk', '04:00:00', '2020-12-14 15:31:12', '2020-12-14 15:31:12'),
(10, 12, 'jbloem', '08:00:00', '2020-12-28 16:06:19', '2020-12-28 16:06:19');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `activation`
--
ALTER TABLE `activation`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrations_id_index` (`id`);

--
-- Indexen voor tabel `saldo`
--
ALTER TABLE `saldo`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `verlof`
--
ALTER TABLE `verlof`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `workhours`
--
ALTER TABLE `workhours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workhours_username_index` (`username`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `activation`
--
ALTER TABLE `activation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT voor een tabel `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT voor een tabel `saldo`
--
ALTER TABLE `saldo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `sector`
--
ALTER TABLE `sector`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `team`
--
ALTER TABLE `team`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `verlof`
--
ALTER TABLE `verlof`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `workhours`
--
ALTER TABLE `workhours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
