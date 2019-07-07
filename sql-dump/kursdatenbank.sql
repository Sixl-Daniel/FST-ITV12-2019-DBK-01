-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3307
-- Erstellungszeit: 07. Jul 2019 um 19:58
-- Server-Version: 10.2.24-MariaDB
-- PHP-Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `kursdatenbank`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kurs`
--

CREATE TABLE IF NOT EXISTS `kurs` (
  `kursnr` int(11) NOT NULL,
  `kurs` tinytext CHARACTER SET utf8 NOT NULL,
  `dauer` tinyint(4) DEFAULT NULL,
  `voraussetzungen` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ortnr` tinyint(3) unsigned zerofill NOT NULL,
  `katalognummer` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Daten für Tabelle `kurs`
--

INSERT INTO `kurs` (`kursnr`, `kurs`, `dauer`, `voraussetzungen`, `ortnr`, `katalognummer`) VALUES
(1, 'Projektmanagment', 5, 'keine', 010, '2.0'),
(2, 'Kostenrechnung', 2, 'keine', 011, '3.1'),
(3, 'IT-Marketing', 1, 'Teilnahme am Modul Kostenrechnung', 011, '3.2'),
(4, 'Grundlagen PC-Technik', 2, 'keine', 013, '4.1'),
(5, 'Vertiefung PC-Technik', 2, 'Modul 4.1', 013, '4.3'),
(6, 'Java Fortgeschrittenenkurs', 10, 'Programmiererfahrung', 014, '5.1b'),
(7, 'C++ Anfängerkurs', 14, 'keine', 014, '5.1c'),
(8, 'C++ Fortgeschrittenenkurs', 10, 'Programmiererfahrung', 014, '5.1d'),
(9, 'Vertiefung Java', 1, 'Teilnahme am Fortgeschrittenenkurs oder vergleichbare Kenntnisse', 015, '5.3'),
(10, 'Dynamische Web-Seiten', 2, 'Kenntnisse einer höheren Programmiersprache', 010, '5.4'),
(11, 'Grundlagen Datenbanken', 5, 'keine', 013, '5.6');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ort`
--

CREATE TABLE IF NOT EXISTS `ort` (
  `ortnr` tinyint(3) unsigned zerofill NOT NULL,
  `ort` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `schule` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Daten für Tabelle `ort`
--

INSERT INTO `ort` (`ortnr`, `ort`, `schule`) VALUES
(010, 'Ulm', 'Robert-Bosch-Schule'),
(011, 'Pforzheim', 'Fritz-Erler-Schule'),
(013, 'Pforzheim', 'Heinrich-Wieland-Schule'),
(014, 'Freiburg', 'Walther-Rathenau-Schule'),
(015, 'Sindelfingen', 'Gottlieb-Daimler-Schule II');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teilnehmer`
--

CREATE TABLE IF NOT EXISTS `teilnehmer` (
  `teilnnr` int(10) NOT NULL,
  `name` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `vorname` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hausnummer` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `postleitzahl` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ort` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `strassenname` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Daten für Tabelle `teilnehmer`
--

INSERT INTO `teilnehmer` (`teilnnr`, `name`, `vorname`, `hausnummer`, `postleitzahl`, `ort`, `strassenname`) VALUES
(100, 'Hirsch', 'Harry', '2', '75175', 'Pforzheim', 'Baumgartenstr.'),
(101, 'Nicks', 'Steffi', '8', '73124', 'Oberndorf', 'Holzweg'),
(102, 'Unterländer', 'Elke', '12', '81023', 'München', 'Max-Weber-Str.'),
(103, 'Peters', 'Paul', '1', '53522', 'Köln', 'Am Markt'),
(104, 'Wallung', 'Walther', '33', '09663', 'Grünstadt', 'Panoramapfad'),
(105, 'Peiffer', 'Claudia', '6', '74121', 'Ludwigshafen', 'Mozartweg'),
(106, 'Hauer', 'Hans', '16a', '12329', 'Talhausen', 'Im Winkel'),
(107, 'Hofmann', 'Helma', '3', '66822', 'Heidelberg', 'Am Bächle'),
(108, 'Sorglos', 'Susi', '143', '40210', 'Sonnstetten', 'Hauptstr.'),
(127, 'Mustermann', 'Max', '57b', '90459', 'Fürth', 'Teststraße');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tkz`
--

CREATE TABLE IF NOT EXISTS `tkz` (
  `id` int(10) NOT NULL,
  `teilnnr` int(10) NOT NULL,
  `kursnr` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Daten für Tabelle `tkz`
--

INSERT INTO `tkz` (`id`, `teilnnr`, `kursnr`) VALUES
(2, 107, 1),
(3, 107, 10),
(4, 101, 1),
(5, 102, 1),
(6, 103, 1),
(7, 100, 7),
(9, 101, 7),
(10, 103, 7),
(13, 107, 7),
(16, 100, 5);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `kurs`
--
ALTER TABLE `kurs`
  ADD PRIMARY KEY (`kursnr`),
  ADD UNIQUE KEY `kurs_katalognummer_uindex` (`katalognummer`),
  ADD KEY `kurs2_ibfk_1` (`ortnr`);

--
-- Indizes für die Tabelle `ort`
--
ALTER TABLE `ort`
  ADD PRIMARY KEY (`ortnr`);

--
-- Indizes für die Tabelle `teilnehmer`
--
ALTER TABLE `teilnehmer`
  ADD PRIMARY KEY (`teilnnr`);

--
-- Indizes für die Tabelle `tkz`
--
ALTER TABLE `tkz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teilnnr` (`teilnnr`),
  ADD KEY `kursnr` (`kursnr`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `kurs`
--
ALTER TABLE `kurs`
  MODIFY `kursnr` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT für Tabelle `ort`
--
ALTER TABLE `ort`
  MODIFY `ortnr` tinyint(3) unsigned zerofill NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT für Tabelle `teilnehmer`
--
ALTER TABLE `teilnehmer`
  MODIFY `teilnnr` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=128;
--
-- AUTO_INCREMENT für Tabelle `tkz`
--
ALTER TABLE `tkz`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `kurs`
--
ALTER TABLE `kurs`
  ADD CONSTRAINT `kurs_ibfk_1` FOREIGN KEY (`ortnr`) REFERENCES `ort` (`ortnr`);

--
-- Constraints der Tabelle `tkz`
--
ALTER TABLE `tkz`
  ADD CONSTRAINT `tkz_ibfk_1` FOREIGN KEY (`teilnnr`) REFERENCES `teilnehmer` (`teilnnr`) ON DELETE CASCADE,
  ADD CONSTRAINT `tkz_ibfk_2` FOREIGN KEY (`kursnr`) REFERENCES `kurs` (`kursnr`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
