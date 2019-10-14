-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Ott 14, 2019 alle 11:19
-- Versione del server: 10.1.37-MariaDB
-- Versione PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ristoranti`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `Nome` varchar(32) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Descrizione` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `corrispondenza`
--

CREATE TABLE `corrispondenza` (
  `ID_Foto` int(11) NOT NULL,
  `ID_Ristorante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `foto`
--

CREATE TABLE `foto` (
  `ID` int(11) NOT NULL,
  `Path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `like`
--

CREATE TABLE `like` (
  `ID_Utente` int(11) NOT NULL,
  `ID_Recensione` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `recensione`
--

CREATE TABLE `recensione` (
  `ID` int(11) NOT NULL,
  `Data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Stelle` enum('1','2','3','4','5') NOT NULL,
  `Oggetto` varchar(64) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Descrizione` text CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `ID_Utente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `ristorante`
--

CREATE TABLE `ristorante` (
  `ID` int(11) NOT NULL,
  `ID_Proprietario` int(11) NOT NULL,
  `Nome` varchar(64) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Categoria` varchar(32) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Descrizione` text CHARACTER SET utf16 COLLATE utf16_bin,
  `Tel` varchar(13) NOT NULL,
  `Mail` varchar(128) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Giorno_Chiusura` varchar(16) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Ora_Apertura` time NOT NULL,
  `Ora_Chiusura` time NOT NULL,
  `Nazione` varchar(32) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Citta` varchar(32) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `CAP` varchar(5) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Via` varchar(32) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Civico` varchar(16) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Approvato` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `ID` int(11) NOT NULL,
  `PWD` varchar(64) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Mail` varchar(128) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Nome` varchar(64) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Cognome` varchar(64) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Data_Nascita` date NOT NULL,
  `ID_Foto` int(11) DEFAULT NULL,
  `Ragione_Sociale` varchar(64) DEFAULT NULL,
  `P_IVA` int(11) DEFAULT NULL,
  `Permessi` enum('Utente','Ristoratore','Admin') CHARACTER SET utf16 COLLATE utf16_bin DEFAULT NULL,
  `Sesso` enum('Maschio','Femmina','Altro','Sconosciuto') CHARACTER SET utf16 COLLATE utf16_bin DEFAULT 'Sconosciuto'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`Nome`);

--
-- Indici per le tabelle `corrispondenza`
--
ALTER TABLE `corrispondenza`
  ADD PRIMARY KEY (`ID_Foto`,`ID_Ristorante`);

--
-- Indici per le tabelle `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`ID_Utente`,`ID_Recensione`);

--
-- Indici per le tabelle `recensione`
--
ALTER TABLE `recensione`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `ristorante`
--
ALTER TABLE `ristorante`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `foto`
--
ALTER TABLE `foto`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `recensione`
--
ALTER TABLE `recensione`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `ristorante`
--
ALTER TABLE `ristorante`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
