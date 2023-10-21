-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 21 Paź 2023, 22:53
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `project_pai`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `booking`
--

CREATE TABLE `booking` (
  `book_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_date` date NOT NULL,
  `book_start` date NOT NULL,
  `book_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `places`
--

CREATE TABLE `places` (
  `place_id` int(11) NOT NULL,
  `country` varchar(70) COLLATE utf16_polish_ci NOT NULL,
  `city` varchar(70) COLLATE utf16_polish_ci NOT NULL,
  `address` varchar(100) COLLATE utf16_polish_ci NOT NULL,
  `description` varchar(250) COLLATE utf16_polish_ci NOT NULL,
  `max_people` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sessions`
--

CREATE TABLE `sessions` (
  `token` varchar(64) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `sessions`
--

INSERT INTO `sessions` (`token`, `user_id`, `expires_at`) VALUES
('0413ddcf23b63c790c5b4132be4724c4ab91fcddb150d8d44de0d6a719eab079', 9, 1698087251),
('79271cabe5c3528963222bd9c165f85bd3ad364ef8b1755e0d7eee008a9641b7', 1, 1698094040),
('9a182a3eadc8311a2f613bb8a34d2c97b4d8eaee4b8c9c7ada8e6db9df589e70', 1, 1698086206);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf16_polish_ci NOT NULL,
  `email` varchar(255) COLLATE utf16_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf16_polish_ci NOT NULL,
  `name` varchar(50) COLLATE utf16_polish_ci NOT NULL,
  `surname` varchar(70) COLLATE utf16_polish_ci NOT NULL,
  `dob` date NOT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `login`, `email`, `password`, `name`, `surname`, `dob`, `is_admin`) VALUES
(1, 'banana', 'baba@gmail.com', '$2y$10$dt2TPPMcR2nEzLkQUWswgezEeglkBC9I7EeZvN8iYnqM2dK6Sh.aa', 'jack', 'appleson', '0000-00-00', NULL),
(2, 'admin', 'admin@gmail.com', '$2y$10$gBGsV23TaWxLonyYGyJLdexmvBFFZZrMVvJcF.F54Nu4Dfpfoi1Ni', 'jack', 'apple', '0000-00-00', NULL),
(3, 'testaccount1', 'ggg@gmail.com', '$2y$10$KxJP5oIr943PTSkB1YiLq.55SFaXnQnYoxJOMw7mGRhl.fWBMGTpa', 'ggg', 'gaygg', '2023-10-25', NULL),
(4, 'abd', 'b@g', '$2y$10$vISnnENoDPyEswuO1zwkMuoCknmgBf4yWqeRQCLsA99fB9MWquF5O', 'ads', 'dbadbsd', '2023-10-21', NULL),
(5, 'apple', 'apple@gmail.com', '$2y$10$8LIQ0yq5sA4aBSJPM9RdXelqKrLBiZ7fMlmr.nHrTupU9ER66DJ7q', 'x', 'x', '2023-10-05', NULL),
(6, 'pear', 'pear@g', '$2y$10$/RxdatjR46wmQIL/fA46geUHi.E6heKi99RKlDndBS9eiaU82GHoy', 'pear', 'pear', '2023-10-07', NULL),
(9, 'test', 'poopy@gmail.com', '$2y$10$Ck/Z1jXjocQNufUUusy.F.y4Q3TJSrFM9EjtT6CgiysvGSKjOtUaW', 'my pass is', 'poop', '2023-10-03', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_bookings`
--

CREATE TABLE `user_bookings` (
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `place_id` (`place_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`place_id`);

--
-- Indeksy dla tabeli `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`token`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `booking`
--
ALTER TABLE `booking`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`place_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
