-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 12. Apr 2016 um 17:35
-- Server-Version: 10.1.9-MariaDB
-- PHP-Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ipa`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbenutzer`
--

CREATE TABLE `tbenutzer` (
  `cBenutzerID` int(11) NOT NULL,
  `cUsername` varchar(32) CHARACTER SET latin1 NOT NULL,
  `cVorname` varchar(32) CHARACTER SET latin1 NOT NULL,
  `cNachname` varchar(32) CHARACTER SET latin1 NOT NULL,
  `cPasswort` varchar(128) CHARACTER SET latin1 NOT NULL,
  `cRolle` int(11) NOT NULL,
  `cEmail` varchar(255) CHARACTER SET latin1 NOT NULL,
  `cPhone` varchar(50) CHARACTER SET latin1 NOT NULL,
  `cMobile` varchar(50) CHARACTER SET latin1 NOT NULL,
  `cAktiv` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `tbenutzer`
--

INSERT INTO `tbenutzer` (`cBenutzerID`, `cUsername`, `cVorname`, `cNachname`, `cPasswort`, `cRolle`, `cEmail`, `cPhone`, `cMobile`, `cAktiv`) VALUES
(0, 'Nicht Zugewiesen', 'Nicht', 'Zugewiesen', '4dff4ea340f0a823f15d3f4f01ab62eae0e5da579ccb851f8db9dfe84c58b2b37b89903a740e1ee172da793a6e79d560e5f7', 1, '', '', '', 0),
(1, 'ske', 'Samuel', 'Keller', '40b244112641dd78dd4f93b6c9190dd46e0099194d5a44257b7efad6ef9ff4683da1eda0244448cb343aa688f5d3efd7314dafe580ac0bcbf115aeca9e8dc114', 1, 'samuel.keller@sba.ch', '', '', 1),
(3, 'benutzer', 'Test', 'Benutzer', '1efc3eb1e11ef16aa9ca89421d87e14ed58e2e9e6fd115f661930f27e3af20794716caa5f19bf482e2f27897779751fa956717e4e1cc3da2ca5c17abd6c22101', 2, 'ske@sba.ch', '0041612959257', '0041764826518', 1),
(5, 'loli', 'Lolita', 'McNice', '5c5ecd11c1fdbf33e209fa48967d9a052d91125d28ccbe3e3121e423e98bb3fa1de2ed779ba0ebd094d05c8c58fd7ef892ab32550d90196b6e1881b14039c03d', 2, 'l.olita@lol.ch', '', '', 1),
(7, 'asdfasdf', 'fddasddf', 'sdfasdf', '4dff4ea340f0a823f15d3f4f01ab62eae0e5da579ccb851f8db9dfe84c58b2b37b89903a740e1ee172da793a6e79d560e5f7f9bd058a12a280433ed6fa46510a', 1, 'l@l.ch', '', '', 1),
(8, 'asdfasdfss', 'fddasddf', 'sdfasdf', '2ce7d6433926ee23e62b15cfef41664b3955ab7304b8ea5dac25e755927564a066930f6e62aacfd3c2f92fe3bc5939995b1ccbc03f74065b896c04c2508a5652', 2, 'wewe@s.ch', '', '', 0),
(9, 'dnu', 'Detlef', 'NÃ¼nninghof', '77a0953c40a128e47e7983c05e8dadee7c9a62fa1e8d66f703ae93fbae9d8ea0948dba82babba428c8dd0a286104b1b69b56d06e0b54a6cf00cebcab0a2d49a2', 1, 'dnu@sba.ch', '', '', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tfiles`
--

CREATE TABLE `tfiles` (
  `cFileID` int(11) NOT NULL,
  `cFileName` text COLLATE utf8_unicode_ci NOT NULL,
  `cFilepath` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `tfiles`
--

INSERT INTO `tfiles` (`cFileID`, `cFileName`, `cFilepath`) VALUES
(1, 'Plan.JPG', 'uploads/114608188308eb1457065887125068525446a66d8e.jpg'),
(2, 'page-header.jpg', 'uploads/1400879155128d737da85225ee09974ddfe3ac8b2e.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tkategorie`
--

CREATE TABLE `tkategorie` (
  `cKategorieID` int(11) NOT NULL,
  `cKategorieName` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `tkategorie`
--

INSERT INTO `tkategorie` (`cKategorieID`, `cKategorieName`) VALUES
(1, '(Sonstiges)'),
(2, 'SwissBanking.org'),
(3, 'insight'),
(4, 'One Voice'),
(5, 'Bankenbarometer'),
(6, 'CUG'),
(7, 'Portal'),
(8, 'Bankersday'),
(9, 'Zirkulare'),
(10, 'SBC'),
(11, 'Veranstaltungen'),
(12, 'Topics'),
(13, 'e-Alarm'),
(14, 'La Coupole'),
(15, 'SwissBanking Future'),
(16, 'Grundbildung SwissBanking Future'),
(17, 'Holdingverband'),
(18, 'SKSF'),
(19, 'esisuisse'),
(20, 'Swissefinance Institute'),
(21, 'Arbeitgeber Banken'),
(22, 'ASDE');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `trollen`
--

CREATE TABLE `trollen` (
  `cRolle` int(11) NOT NULL,
  `cRolleBeschreibung` varchar(32) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `trollen`
--

INSERT INTO `trollen` (`cRolle`, `cRolleBeschreibung`) VALUES
(1, 'Administrator'),
(2, 'Benutzer');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tstatus`
--

CREATE TABLE `tstatus` (
  `cStatusID` int(11) NOT NULL,
  `cStatusName` varchar(32) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `tstatus`
--

INSERT INTO `tstatus` (`cStatusID`, `cStatusName`) VALUES
(1, 'Offen'),
(2, 'In Beobachtung'),
(3, 'In Bearbeitung'),
(4, 'Geschlossen'),
(5, 'Gelöscht'),
(6, 'Wiedervorlage'),
(7, 'Archiv');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tticketfiles`
--

CREATE TABLE `tticketfiles` (
  `cTicketFileID` int(11) NOT NULL,
  `cTicketID` int(11) NOT NULL,
  `cFileID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `tticketfiles`
--

INSERT INTO `tticketfiles` (`cTicketFileID`, `cTicketID`, `cFileID`) VALUES
(1, 5, 1),
(2, 10, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ttickets`
--

CREATE TABLE `ttickets` (
  `cTicketID` int(11) NOT NULL,
  `cTicketTitle` text COLLATE utf8_unicode_ci NOT NULL,
  `cKategorieID` int(11) NOT NULL,
  `cTicketBeschreibung` text COLLATE utf8_unicode_ci NOT NULL,
  `cStatusID` int(11) NOT NULL DEFAULT '1',
  `cTicketCreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cTicketLastChange` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cTicketDeadline` datetime NOT NULL,
  `cOwnerID` int(11) NOT NULL,
  `cSupporterID` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `ttickets`
--

INSERT INTO `ttickets` (`cTicketID`, `cTicketTitle`, `cKategorieID`, `cTicketBeschreibung`, `cStatusID`, `cTicketCreateDate`, `cTicketLastChange`, `cTicketDeadline`, `cOwnerID`, `cSupporterID`) VALUES
(1, 'Test Ticket id1', 2, 'Beschreibung *', 2, '2016-04-11 13:00:14', '2016-04-12 12:29:27', '2016-04-20 00:00:00', 1, 9),
(2, 'qweqeqwe', 1, 'asdasdasd', 1, '2016-04-12 11:32:51', '2016-04-12 11:32:51', '0000-00-00 00:00:00', 1, 0),
(3, 'qweqeqwe', 1, 'asdasdasd', 1, '2016-04-12 11:35:44', '2016-04-12 11:35:44', '0000-00-00 00:00:00', 1, 0),
(4, '23', 1, '23', 1, '2016-04-12 11:36:35', '2016-04-12 11:36:35', '0000-00-00 00:00:00', 1, 0),
(5, '2323', 1, '2323', 1, '2016-04-12 11:36:50', '2016-04-12 11:36:50', '0000-00-00 00:00:00', 1, 0),
(6, 'wqqd', 1, 'asdasd', 1, '2016-04-12 11:46:15', '2016-04-12 11:46:15', '0000-00-00 00:00:00', 1, 0),
(7, 'sdsd', 1, 'sdsd', 1, '2016-04-12 11:46:41', '2016-04-12 11:46:41', '0000-00-00 00:00:00', 1, 0),
(8, 'we', 1, 'wewe', 1, '2016-04-12 11:47:22', '2016-04-12 11:47:22', '0000-00-00 00:00:00', 1, 0),
(9, 'we', 1, 'wewe', 3, '2016-04-12 11:51:36', '2016-04-12 12:27:36', '0000-00-00 00:00:00', 1, 9),
(10, 'Ticket mit Bild', 3, 'Beschreibung', 1, '2016-04-12 12:31:09', '2016-04-12 14:19:25', '2016-04-24 01:01:01', 9, 0),
(11, 'Test DNU 14:32', 1, 'nichts', 1, '2016-04-12 12:32:20', '2016-04-12 12:32:20', '0000-00-00 00:00:00', 9, 0),
(12, 'adasd', 1, 'asdasdad', 1, '2016-04-12 12:37:54', '2016-04-12 12:37:54', '0000-00-00 00:00:00', 1, 0),
(13, 'adasd', 1, 'asdasd', 1, '2016-04-12 12:39:03', '2016-04-12 12:39:03', '0000-00-00 00:00:00', 1, 0),
(14, 'asdf', 1, 'asd', 1, '2016-04-12 12:57:12', '2016-04-12 12:57:12', '0000-00-00 00:00:00', 1, 0),
(15, 'wer', 1, 'erwgr', 1, '2016-04-12 13:00:54', '2016-04-12 13:00:54', '0000-00-00 00:00:00', 1, 0),
(16, 'sdsd', 1, 'sdsdsd', 1, '2016-04-12 13:16:34', '2016-04-12 13:16:34', '0000-00-00 00:00:00', 1, 0),
(17, 'sdsd', 1, 'sdsdsd', 1, '2016-04-12 13:19:09', '2016-04-12 13:19:09', '0000-00-00 00:00:00', 1, 0),
(18, 'sdsd', 1, 'sdsdsd', 1, '2016-04-12 13:19:36', '2016-04-12 13:19:36', '0000-00-00 00:00:00', 1, 0),
(19, 'sdsd', 1, 'sdsdsd', 1, '2016-04-12 13:20:18', '2016-04-12 13:20:18', '0000-00-00 00:00:00', 1, 0),
(20, 'werwe', 1, 'wer', 1, '2016-04-12 13:20:53', '2016-04-12 13:20:53', '0000-00-00 00:00:00', 1, 0),
(21, 'werwerwrwer', 1, 'wer', 1, '2016-04-12 13:22:32', '2016-04-12 13:22:32', '0000-00-00 00:00:00', 1, 0),
(22, 'qweqwe', 1, 'qwqweqwe', 1, '2016-04-12 13:23:21', '2016-04-12 13:23:21', '0000-00-00 00:00:00', 1, 0),
(23, 'qweqwe', 1, 'qwqweqwe', 1, '2016-04-12 13:23:40', '2016-04-12 13:23:40', '0000-00-00 00:00:00', 1, 0),
(24, 'Test DNU 15:57', 1, 'wewer', 1, '2016-04-12 13:25:41', '2016-04-12 13:25:41', '0000-00-00 00:00:00', 9, 0),
(25, ' Nope, Sorrysdsdsdsdsd', 1, 'wewer', 1, '2016-04-12 13:27:29', '2016-04-12 14:08:11', '0000-00-00 00:00:00', 9, 9);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tbenutzer`
--
ALTER TABLE `tbenutzer`
  ADD PRIMARY KEY (`cBenutzerID`),
  ADD KEY `cRolle` (`cRolle`);

--
-- Indizes für die Tabelle `tfiles`
--
ALTER TABLE `tfiles`
  ADD PRIMARY KEY (`cFileID`);

--
-- Indizes für die Tabelle `tkategorie`
--
ALTER TABLE `tkategorie`
  ADD PRIMARY KEY (`cKategorieID`);

--
-- Indizes für die Tabelle `trollen`
--
ALTER TABLE `trollen`
  ADD PRIMARY KEY (`cRolle`);

--
-- Indizes für die Tabelle `tstatus`
--
ALTER TABLE `tstatus`
  ADD PRIMARY KEY (`cStatusID`);

--
-- Indizes für die Tabelle `tticketfiles`
--
ALTER TABLE `tticketfiles`
  ADD PRIMARY KEY (`cTicketFileID`),
  ADD KEY `cTicketID` (`cTicketID`),
  ADD KEY `cFileID` (`cFileID`);

--
-- Indizes für die Tabelle `ttickets`
--
ALTER TABLE `ttickets`
  ADD PRIMARY KEY (`cTicketID`),
  ADD KEY `cStatusID` (`cStatusID`),
  ADD KEY `cOwnerID` (`cOwnerID`),
  ADD KEY `cSupporterID` (`cSupporterID`),
  ADD KEY `cKategorieID` (`cKategorieID`),
  ADD KEY `cSupporterID_2` (`cSupporterID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tbenutzer`
--
ALTER TABLE `tbenutzer`
  MODIFY `cBenutzerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `tfiles`
--
ALTER TABLE `tfiles`
  MODIFY `cFileID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `tkategorie`
--
ALTER TABLE `tkategorie`
  MODIFY `cKategorieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT für Tabelle `trollen`
--
ALTER TABLE `trollen`
  MODIFY `cRolle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `tstatus`
--
ALTER TABLE `tstatus`
  MODIFY `cStatusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT für Tabelle `tticketfiles`
--
ALTER TABLE `tticketfiles`
  MODIFY `cTicketFileID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `ttickets`
--
ALTER TABLE `ttickets`
  MODIFY `cTicketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tbenutzer`
--
ALTER TABLE `tbenutzer`
  ADD CONSTRAINT `tbenutzer_ibfk_1` FOREIGN KEY (`cRolle`) REFERENCES `trollen` (`cRolle`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tticketfiles`
--
ALTER TABLE `tticketfiles`
  ADD CONSTRAINT `tticketfiles_ibfk_1` FOREIGN KEY (`cTicketID`) REFERENCES `ttickets` (`cTicketID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tticketfiles_ibfk_2` FOREIGN KEY (`cFileID`) REFERENCES `tfiles` (`cFileID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints der Tabelle `ttickets`
--
ALTER TABLE `ttickets`
  ADD CONSTRAINT `ttickets_ibfk_1` FOREIGN KEY (`cOwnerID`) REFERENCES `tbenutzer` (`cBenutzerID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ttickets_ibfk_2` FOREIGN KEY (`cKategorieID`) REFERENCES `tkategorie` (`cKategorieID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ttickets_ibfk_3` FOREIGN KEY (`cStatusID`) REFERENCES `tstatus` (`cStatusID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ttickets_ibfk_4` FOREIGN KEY (`cSupporterID`) REFERENCES `tbenutzer` (`cBenutzerID`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
