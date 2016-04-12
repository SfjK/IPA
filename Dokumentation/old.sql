-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 06. Apr 2016 um 10:34
-- Server-Version: 10.1.9-MariaDB
-- PHP-Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `test`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbenutzer`
--

CREATE TABLE `tbenutzer` (
  `cBenutzerID` int(11) NOT NULL,
  `cUsername` text CHARACTER SET latin1 NOT NULL,
  `cVorname` text CHARACTER SET latin1 NOT NULL,
  `cNachname` text CHARACTER SET latin1 NOT NULL,
  `cPasswort` text CHARACTER SET latin1 NOT NULL,
  `cRolle` int(11) NOT NULL,
  `cEmail` text CHARACTER SET latin1 NOT NULL,
  `cPhone` text CHARACTER SET latin1 NOT NULL,
  `cMobile` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `tbenutzer`
--

INSERT INTO `tbenutzer` (`cBenutzerID`, `cUsername`, `cVorname`, `cNachname`, `cPasswort`, `cRolle`, `cEmail`, `cPhone`, `cMobile`) VALUES
(0, 'Nicht Zugewiesen', 'Nicht', 'Zugewiesen', '4dff4ea340f0a823f15d3f4f01ab62eae0e5da579ccb851f8db9dfe84c58b2b37b89903a740e1ee172da793a6e79d560e5f7', 1, '', '', ''),
(1, 'ske', 'Samuel', 'Keller', 'a8cebf1698dc14282c507b1e1cfb7f2c9d5216aa7bd0854b50561e02c2b99d9a38945ec0f81e55f9699062b1eac6d0083411', 1, 'samuel.keller@sba.ch', '', ''),
(2, '123', 'we', 'we', 'e54ee7e285fbb0275279143abc4c554e5314e7b417ecac83a5984a964facbaad68866a2841c3e83ddf125a2985566261c401', 2, 'asd', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tfiles`
--

CREATE TABLE `tfiles` (
  `cFileID` int(11) NOT NULL,
  `cFileName` text COLLATE utf8_unicode_ci NOT NULL,
  `cFilepath` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tkategorie`
--

CREATE TABLE `tkategorie` (
  `cKategorieID` int(11) NOT NULL,
  `cKategorieName` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `tkategorie`
--

INSERT INTO `tkategorie` (`cKategorieID`, `cKategorieName`) VALUES
(1, '(Sonstiges)'),
(2, 'Abacus'),
(3, 'Access'),
(4, 'Adobe Acrobat'),
(5, 'Adress Plus'),
(6, 'AntiVirus'),
(7, 'Anwenderfehler'),
(8, 'ASDE'),
(9, 'Autofiler'),
(10, 'Backup'),
(11, 'Berechtigungen'),
(12, 'BlackBerry'),
(13, 'Citrix Receiver'),
(14, 'Clicktime'),
(15, 'Corporate Design'),
(16, 'CUG'),
(17, 'Datenbanken'),
(18, 'Doku IT'),
(19, 'Doku Web'),
(20, 'DoLite'),
(21, 'Domas'),
(22, 'Druckerproblem'),
(23, 'e-Copy'),
(24, 'Enterprise Vault (Outlook-Archivierung)'),
(25, 'Excel'),
(26, 'Extranet'),
(27, 'Fax'),
(28, 'Firefox'),
(29, 'Freeze'),
(30, 'Hardware'),
(31, 'InterMit'),
(32, 'Internet Explorer'),
(33, 'Intranet'),
(34, 'MetaFrame Server'),
(35, 'Mitglied'),
(36, 'Netzwerkproblem'),
(37, 'Obtree'),
(38, 'ODBC'),
(39, 'OpenOffice'),
(40, 'Outlook'),
(41, 'Passwort'),
(42, 'Login'),
(43, 'PDF Allgemein'),
(44, 'Portal'),
(45, 'Powerpoint'),
(46, 'Projekte'),
(47, 'Reperatur'),
(48, 'Replikation'),
(49, 'SafeWord'),
(50, 'Software'),
(51, 'SPPS'),
(52, 'Support'),
(53, 'Telephonie'),
(54, 'Uniflow'),
(55, 'Video'),
(56, 'Web'),
(57, 'WebMail'),
(58, 'WI (Citrix WebInterface)'),
(59, 'W-LAN'),
(60, 'Word'),
(61, 'Zelmer Applikationen (Allgemein)'),
(62, 'C4');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `trollen`
--

CREATE TABLE `trollen` (
  `cRolle` int(11) NOT NULL,
  `cRolleBeschreibung` text CHARACTER SET latin1 NOT NULL
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
  `cStatusName` text CHARACTER SET latin1 NOT NULL
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
  MODIFY `cBenutzerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `tfiles`
--
ALTER TABLE `tfiles`
  MODIFY `cFileID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `tkategorie`
--
ALTER TABLE `tkategorie`
  MODIFY `cKategorieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
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
  MODIFY `cTicketFileID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ttickets`
--
ALTER TABLE `ttickets`
  MODIFY `cTicketID` int(11) NOT NULL AUTO_INCREMENT;
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
