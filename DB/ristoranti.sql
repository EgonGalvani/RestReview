-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 18, 2019 alle 14:42
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
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`ID`, `PWD`, `Mail`, `Nome`, `Cognome`, `Data_Nascita`, `ID_Foto`, `Ragione_Sociale`, `P_IVA`, `Permessi`, `Sesso`) VALUES
(1, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'leila.pagnotto@rhyta.com', 'Leila', 'Pagnotto', '1993-10-27', NULL, NULL, NULL, 'Utente', 'Femmina'),
(2, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'DinoGenovese@dayrep.com', 'Dino', 'Genovese', '2004-07-21', NULL, NULL, NULL, 'Utente', 'Maschio'),
(3, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'NestoreMancini@dayrep.com', 'Nestore', 'Mancini', '1973-03-26', NULL, NULL, NULL, 'Utente', 'Maschio'),
(4, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'AlvisaLongo@jourrapide.com', 'Alvisa', 'Longo', '1963-04-03', NULL, NULL, NULL, 'Utente', 'Femmina'),
(5, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'CarisioDavide@teleworm.us', 'Davide', 'Carisio', '1988-10-23', NULL, NULL, NULL, 'Utente', 'Maschio'),
(6, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'alessandrodiscalzi98@gmail.com', 'Alessandro', 'Discalzi', '1998-10-23', NULL, NULL, NULL, 'Utente', 'Maschio'),
(7, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'albertococco98@gmail.com', 'Alberto', 'Cocco', '1998-06-15', NULL, NULL, NULL, 'Utente', 'Maschio'),
(8, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'galvaniegon@gmail.com', 'Egon', 'Galvani', '1999-11-17', NULL, NULL, NULL, 'Utente', 'Maschio'),
(9, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'matteomunari@gmail.com', 'Matteo', 'Munari', '1998-01-18', NULL, NULL, NULL, 'Utente', 'Maschio'),
(10, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'frostmourne96@teleworm.us', 'Marco', 'Fonta', '1996-12-08', NULL, NULL, NULL, 'Utente', 'Maschio'),
(11, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'AleardoMilano@armyspy.com', 'Aleardo', 'Milan', '1962-02-18', NULL, NULL, NULL, 'Utente', 'Maschio'),
(12, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'TamaraSiciliani@armyspy.com', 'Tamara', 'Siciliani', '1982-02-18', NULL, NULL, NULL, 'Utente', 'Femmina'),
(13, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'AbelardaMoretti@dayrep.com', 'Abelarda', 'Moretti', '1955-09-26', NULL, NULL, NULL, 'Utente', 'Femmina'),
(14, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'GiudittaNuci@jourrapide.com', 'Giuditta', 'Nuci', '1978-11-29', NULL, NULL, NULL, 'Utente', 'Femmina'),
(15, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'stanislawmanfrin@armyspy.com', 'Stanislao', 'Manfrin', '1978-10-11', NULL, NULL, NULL, 'Utente', 'Maschio'),
(16, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'generosamarcelo@dayrep.com', 'Generosa', 'Marcelo', '1980-11-16', NULL, NULL, NULL, 'Utente', 'Femmina'),
(17, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'benedetta.lettiere@teleworm.us', 'Benedetta', 'Lettiere', '1993-04-11', NULL, NULL, NULL, 'Utente', 'Femmina'),
(18, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'adarosi@teleworm.us', 'Adalberta', 'Rossi', '1978-02-10', NULL, NULL, NULL, 'Utente', 'Femmina'),
(19, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'lucrezia.piccio@jourrapide.com', 'Lucrezia', 'Piccio', '1996-08-08', NULL, NULL, NULL, 'Utente', 'Femmina'),
(20, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'giocchinofenice@dayrep.com', 'Gioacchino', 'Fenice', '1968-07-15', NULL, NULL, NULL, 'Utente', 'Maschio'),
(21, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'giuseppalori@teleworm.us', 'Giuseppa', 'Lori', '1975-05-02', NULL, 'Country Club Markets', 0, 'Ristoratore', 'Femmina'),
(22, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'paola.sagese@teleworm.us', 'Paola', 'Sagese', '1990-12-12', NULL, 'StopAndShop', 0, 'Ristoratore', 'Sconosciuto'),
(23, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'bernicebeneventi@dayrep.com', 'Bernice', 'Beneventi', '1971-05-05', NULL, 'Best Bar Restaurants', 0, 'Ristoratore', 'Femmina'),
(24, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'sofia.reticci@rhyta.com', 'Sofia', 'Reticci', '1974-07-01', NULL, 'FoodConsumers SRL', 0, 'Ristoratore', 'Femmina'),
(25, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'grazianopiazza@teleworm.us', 'Graziano', 'Piazza', '1957-03-18', NULL, 'Piazza e F.', 0, 'Ristoratore', 'Maschio'),
(26, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'lidiarossi@dayrep.com', 'Lidia', 'Rossi', '1965-08-08', NULL, NULL, 0, 'Ristoratore', 'Femmina'),
(27, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Giordano', 'Fantino', 'fantinogiordano@jourrapide.com', '1981-01-21', NULL, NULL, 0, 'Ristoratore', 'Maschio'),
(28, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'gaetanonio@teleworm.us', 'Gaetano', 'Onio', '1988-10-18', NULL, NULL, 0, 'Ristoratore', 'Maschio'),
(29, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'camillocolombo@rhyta.com', 'Camillo', 'Colombo', '1963-05-25', NULL, NULL, 0, 'Ristoratore', 'Maschio'),
(30, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'GIANETTOTOSCANO@teleworm.us', 'Gianetto', 'Toscano', '1993-12-25', NULL, NULL, 0, 'Ristoratore', 'Maschio');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
