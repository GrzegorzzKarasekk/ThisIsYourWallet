-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 11 Gru 2019, 18:30
-- Wersja serwera: 10.4.6-MariaDB
-- Wersja PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `stronadozarzadzania`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przychody`
--

CREATE TABLE `przychody` (
  `id_przychodu` int(11) UNSIGNED NOT NULL,
  `id_uzytkownika` int(11) UNSIGNED NOT NULL,
  `id_kategorii_przychodu_przypisanej_do_uzytkownika` int(11) NOT NULL,
  `kwota` decimal(8,2) NOT NULL DEFAULT 0.00,
  `data_przychodu` date NOT NULL,
  `komentarz_przychodu` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przychody_kategorie_podstawowe`
--

CREATE TABLE `przychody_kategorie_podstawowe` (
  `id` int(11) UNSIGNED NOT NULL,
  `nazwa_kategorii_przychodu` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `przychody_kategorie_podstawowe`
--

INSERT INTO `przychody_kategorie_podstawowe` (`id`, `nazwa_kategorii_przychodu`) VALUES
(1, 'Wypłata'),
(2, 'Odsetki Bankowe'),
(3, 'Allegro'),
(4, 'Inne');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przychody_przypisane_do_uzytkownika`
--

CREATE TABLE `przychody_przypisane_do_uzytkownika` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_uzytkownika` int(11) UNSIGNED NOT NULL,
  `nazwa_przychodu` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sposoby_platnosci_podstawowe`
--

CREATE TABLE `sposoby_platnosci_podstawowe` (
  `id` int(11) UNSIGNED NOT NULL,
  `nazwa_sposobu_platnosci` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `sposoby_platnosci_podstawowe`
--

INSERT INTO `sposoby_platnosci_podstawowe` (`id`, `nazwa_sposobu_platnosci`) VALUES
(1, 'Gotówka'),
(2, 'Karta debetowa'),
(3, 'Karta kredytowa');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sposoby_platnosci_przypisane_do_uzytkownika`
--

CREATE TABLE `sposoby_platnosci_przypisane_do_uzytkownika` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_uzytkownika` int(11) UNSIGNED NOT NULL,
  `nazwa_sposobu_platnosci` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id_uzytkownika` int(11) UNSIGNED NOT NULL,
  `imie_uzytkownika` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `haslo` text COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wydatki`
--

CREATE TABLE `wydatki` (
  `id_wydatku` int(11) UNSIGNED NOT NULL,
  `id_uzytkownika` int(11) UNSIGNED NOT NULL,
  `id_kategorii_wydatku_przypisanej_do_uzytkownika` int(11) UNSIGNED NOT NULL,
  `id_sposobu_platnosci_przypisanego_do_uzytkownika` int(11) UNSIGNED NOT NULL,
  `kwota` decimal(8,2) NOT NULL DEFAULT 0.00,
  `data_wydatku` date NOT NULL,
  `komentarz_wydatku` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wydatki_kategorie_podstawowe`
--

CREATE TABLE `wydatki_kategorie_podstawowe` (
  `id` int(11) UNSIGNED NOT NULL,
  `nazwa_kategorii_wydatku` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `wydatki_kategorie_podstawowe`
--

INSERT INTO `wydatki_kategorie_podstawowe` (`id`, `nazwa_kategorii_wydatku`) VALUES
(1, 'Jedzenie'),
(2, 'Mieszkanie'),
(3, 'Transport'),
(4, 'Telekomunikacja'),
(5, 'Opieka zdrowotna'),
(6, 'Ubranie'),
(7, 'Higiena'),
(8, 'Dzieci'),
(9, 'Rozrywka'),
(10, 'Wycieczka'),
(11, 'Szkolenia'),
(12, 'Książki'),
(13, 'Oszczędności'),
(14, 'Na złotą jesień'),
(15, 'Spłata długów'),
(16, 'Darowizna'),
(17, 'Inne wydatki');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wydatki_przypisane_do_uzytkownika`
--

CREATE TABLE `wydatki_przypisane_do_uzytkownika` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_uzytkownika` int(11) UNSIGNED NOT NULL,
  `nazwa_wydatku` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `przychody`
--
ALTER TABLE `przychody`
  ADD PRIMARY KEY (`id_przychodu`);

--
-- Indeksy dla tabeli `przychody_kategorie_podstawowe`
--
ALTER TABLE `przychody_kategorie_podstawowe`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `przychody_przypisane_do_uzytkownika`
--
ALTER TABLE `przychody_przypisane_do_uzytkownika`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `sposoby_platnosci_podstawowe`
--
ALTER TABLE `sposoby_platnosci_podstawowe`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `sposoby_platnosci_przypisane_do_uzytkownika`
--
ALTER TABLE `sposoby_platnosci_przypisane_do_uzytkownika`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id_uzytkownika`);

--
-- Indeksy dla tabeli `wydatki`
--
ALTER TABLE `wydatki`
  ADD PRIMARY KEY (`id_wydatku`);

--
-- Indeksy dla tabeli `wydatki_kategorie_podstawowe`
--
ALTER TABLE `wydatki_kategorie_podstawowe`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `wydatki_przypisane_do_uzytkownika`
--
ALTER TABLE `wydatki_przypisane_do_uzytkownika`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `przychody`
--
ALTER TABLE `przychody`
  MODIFY `id_przychodu` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `przychody_kategorie_podstawowe`
--
ALTER TABLE `przychody_kategorie_podstawowe`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `przychody_przypisane_do_uzytkownika`
--
ALTER TABLE `przychody_przypisane_do_uzytkownika`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `sposoby_platnosci_podstawowe`
--
ALTER TABLE `sposoby_platnosci_podstawowe`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `sposoby_platnosci_przypisane_do_uzytkownika`
--
ALTER TABLE `sposoby_platnosci_przypisane_do_uzytkownika`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id_uzytkownika` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `wydatki`
--
ALTER TABLE `wydatki`
  MODIFY `id_wydatku` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `wydatki_kategorie_podstawowe`
--
ALTER TABLE `wydatki_kategorie_podstawowe`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `wydatki_przypisane_do_uzytkownika`
--
ALTER TABLE `wydatki_przypisane_do_uzytkownika`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
