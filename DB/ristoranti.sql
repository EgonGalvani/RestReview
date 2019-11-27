-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Ott 25, 2019 alle 08:33
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
  `Nome` varchar(32) NOT NULL
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
-- Struttura della tabella `mi_piace`
--

CREATE TABLE `mi_piace` (
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
  `Oggetto` varchar(64) NOT NULL,
  `Descrizione` text NOT NULL,
  `ID_Utente` int(11) NOT NULL,
  `ID_Ristorante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `ristorante`
--

CREATE TABLE `ristorante` (
  `ID` int(11) NOT NULL,
  `ID_Proprietario` int(11) NOT NULL,
  `Nome` varchar(64) NOT NULL,
  `Categoria` varchar(32) NOT NULL,
  `Descrizione` text,
  `Tel` varchar(13) NOT NULL,
  `Mail` varchar(128) NOT NULL,
  `Giorno_Chiusura` varchar(16) NOT NULL,
  `Ora_Apertura` time NOT NULL,
  `Ora_Chiusura` time NOT NULL,
  `Nazione` varchar(32) NOT NULL,
  `Citta` varchar(32) NOT NULL,
  `CAP` varchar(5) NOT NULL,
  `Via` varchar(32) NOT NULL,
  `Civico` varchar(16) NOT NULL,
  `Approvato` enum('Non approvato','In attesa','Approvato','') NOT NULL DEFAULT 'In attesa',
  `sito` varchar(2048) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `ID` int(11) NOT NULL,
  `PWD` varchar(64) NOT NULL,
  `Mail` varchar(128) NOT NULL,
  `Nome` varchar(64) NOT NULL,
  `Cognome` varchar(64) NOT NULL,
  `Data_Nascita` date NOT NULL,
  `ID_Foto` int(11) DEFAULT NULL,
  `Ragione_Sociale` varchar(64) DEFAULT NULL,
  `P_IVA` int(11) DEFAULT NULL,
  `Permessi` enum('Utente','Ristoratore','Admin') DEFAULT NULL,
  `Sesso` enum('Maschio','Femmina','Altro','Sconosciuto') DEFAULT 'Sconosciuto'
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
  ADD PRIMARY KEY (`ID_Foto`,`ID_Ristorante`),
  ADD KEY `ID_Ristorante` (`ID_Ristorante`);

--
-- Indici per le tabelle `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `mi_piace`
--
ALTER TABLE `mi_piace`
  ADD PRIMARY KEY (`ID_Utente`,`ID_Recensione`),
  ADD KEY `mi_piace_ibfk_1` (`ID_Recensione`);

--
-- Indici per le tabelle `recensione`
--
ALTER TABLE `recensione`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Utente` (`ID_Utente`),
  ADD KEY `ID_Ristorante` (`ID_Ristorante`);

--
-- Indici per le tabelle `ristorante`
--
ALTER TABLE `ristorante`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Proprietario` (`ID_Proprietario`),
  ADD KEY `Categoria` (`Categoria`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Foto` (`ID_Foto`);

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

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `corrispondenza`
--
ALTER TABLE `corrispondenza`
  ADD CONSTRAINT `corrispondenza_ibfk_1` FOREIGN KEY (`ID_Foto`) REFERENCES `foto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `corrispondenza_ibfk_2` FOREIGN KEY (`ID_Ristorante`) REFERENCES `ristorante` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `mi_piace`
--
ALTER TABLE `mi_piace`
  ADD CONSTRAINT `mi_piace_ibfk_1` FOREIGN KEY (`ID_Recensione`) REFERENCES `recensione` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mi_piace_ibfk_2` FOREIGN KEY (`ID_Utente`) REFERENCES `utente` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `recensione`
--
ALTER TABLE `recensione`
  ADD CONSTRAINT `recensione_ibfk_1` FOREIGN KEY (`ID_Utente`) REFERENCES `utente` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `recensione_ibfk_2` FOREIGN KEY (`ID_Ristorante`) REFERENCES `ristorante` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `ristorante`
--
ALTER TABLE `ristorante`
  ADD CONSTRAINT `ristorante_ibfk_1` FOREIGN KEY (`ID_Proprietario`) REFERENCES `utente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ristorante_ibfk_2` FOREIGN KEY (`Categoria`) REFERENCES `categoria` (`Nome`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`ID_Foto`) REFERENCES `foto` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
