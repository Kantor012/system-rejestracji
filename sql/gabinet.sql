-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 25 Cze 2022, 04:04
-- Wersja serwera: 10.4.17-MariaDB
-- Wersja PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `gabinet`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` varchar(13) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('m','f','o') NOT NULL,
  `is_admin` enum('0','1') NOT NULL,
  `is_doctor` enum('0','1') NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `gender`, `is_admin`, `is_doctor`, `created_at`) VALUES
('051f87b92369e', 'Jan', 'Kowalski', 'doctor', '', 'f9f16d97c90d8c6f2cab37bb6d1f1992', 'm', '0', '1', '2022-06-22'),
('27b1cd53cb5f8', 'Stanisław', 'Marysia', 'testuser3', '', '1e4332f65a7a921075fbfb92c7c60cce', 'o', '0', '0', '2022-06-24'),
('454954896ee05', 'Henryk', 'Kwinto', 'testuser2', '', '58dd024d49e1d1b83a5d307f09f32734', 'm', '0', '0', '2022-06-24'),
('54f52e8ba7959', 'Krzysztof', 'Jarzyna', 'doctor2', '', 'f9f16d97c90d8c6f2cab37bb6d1f1992', 'm', '0', '1', '2022-06-24'),
('7d5c65db0d42b', 'Hanna', 'Mostowiak', 'testuser', '', '5d9c68c6c50ed3d02a2fcf54f63993b6', 'f', '0', '1', '2022-06-24'),
('e708860e6cb8c', '', '', 'root', '', '63a9f0ea7bb98050796b649e85481845', 'm', '1', '0', '2022-06-22'),
('fb2cd53e7275d', 'Jerzy', 'Kiler', 'user', '', 'ee11cbb19052e40b07aac0ca060c23ee', 'm', '0', '0', '2022-06-22');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `doctor_id` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(10) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeksy dla tabeli `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
