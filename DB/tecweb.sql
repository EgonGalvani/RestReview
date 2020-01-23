-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 22, 2020 alle 19:10
-- Versione del server: 10.1.37-MariaDB
-- Versione PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tecweb`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `Nome` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`Nome`) VALUES
('Britannica'),
('Cucina tedesca'),
('Indiano'),
('Italiana'),
('Libanese'),
('Messicano'),
('Steakhouse'),
('Sushi'),
('Vegano');

-- --------------------------------------------------------

--
-- Struttura della tabella `corrispondenza`
--

CREATE TABLE `corrispondenza` (
  `ID_Foto` int(11) NOT NULL,
  `ID_Ristorante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `corrispondenza`
--

INSERT INTO `corrispondenza` (`ID_Foto`, `ID_Ristorante`) VALUES
(26, 2),
(27, 3),
(28, 4),
(29, 5),
(30, 6),
(31, 7),
(32, 8),
(33, 9);

-- --------------------------------------------------------

--
-- Struttura della tabella `foto`
--

CREATE TABLE `foto` (
  `ID` int(11) NOT NULL,
  `Path` text NOT NULL,
  `Descrizione` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `foto`
--

INSERT INTO `foto` (`ID`, `Path`, `Descrizione`) VALUES
(1, '../img/Utenti/1.jpeg', NULL),
(2, '../img/Utenti/2.jpg', NULL),
(3, '../img/Utenti/3.jpg', NULL),
(4, '../img/Utenti/4.jpeg', NULL),
(5, '../img/Utenti/5.jpg', NULL),
(6, '../img/Utenti/6.jpg', NULL),
(7, '../img/Utenti/7.jpeg', NULL),
(8, '../img/Utenti/8.jpeg', NULL),
(9, '../img/Utenti/9.jpeg', NULL),
(10, '../img/Utenti/10.jpeg', NULL),
(11, '../img/Utenti/11.jpeg', NULL),
(12, '../img/Utenti/12.jpg', NULL),
(13, '../img/Utenti/13.jpeg', NULL),
(14, '../img/Utenti/14.jpeg', NULL),
(15, '../img/Utenti/15.jpg', NULL),
(16, '../img/Utenti/16.jpeg', NULL),
(17, '../img/Utenti/17.jpeg', NULL),
(18, '../img/Utenti/18.jpeg', NULL),
(19, '../img/Utenti/19.jpeg', NULL),
(20, '../img/Utenti/20.jpeg', NULL),
(21, '../img/Utenti/21.jpg', NULL),
(22, '../img/Utenti/22.jpeg', NULL),
(23, '../img/Utenti/23.jpg', NULL),
(24, '../img/Utenti/24.jpeg', NULL),
(25, '../img/Utenti/25.jpeg', NULL),
(26, '../img/ristoranti/2.jpeg', NULL),
(27, '../img/ristoranti/3.jpeg', NULL),
(28, '../img/ristoranti/4.jpeg', NULL),
(29, '../img/ristoranti/5.jpeg', NULL),
(30, '../img/ristoranti/6.jpeg', NULL),
(31, '../img/ristoranti/7.jpeg', NULL),
(32, '../img/ristoranti/8.jpeg', NULL),
(33, '../img/ristoranti/9.jpeg', NULL),
(46, '../img/Utenti/ragioniere.JPG', NULL),
(47, '../img/Utenti/1578268256.jpg', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `mi_piace`
--

CREATE TABLE `mi_piace` (
  `ID_Utente` int(11) NOT NULL,
  `ID_Recensione` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `mi_piace`
--

INSERT INTO `mi_piace` (`ID_Utente`, `ID_Recensione`) VALUES
(1, 1),
(1, 6),
(1, 14),
(2, 1),
(2, 3),
(2, 6),
(2, 9),
(2, 11),
(2, 13),
(2, 18),
(3, 18),
(4, 8),
(4, 9),
(4, 15),
(5, 13),
(5, 16),
(5, 18),
(6, 6),
(6, 8),
(6, 9),
(6, 16),
(7, 10),
(7, 17),
(8, 8),
(8, 10),
(8, 16),
(8, 17),
(9, 6),
(9, 7),
(9, 12),
(9, 13),
(10, 17),
(11, 4),
(11, 10),
(11, 14),
(11, 18),
(12, 6),
(12, 9),
(12, 11),
(12, 15),
(13, 7),
(14, 5),
(14, 8),
(14, 10),
(14, 14),
(15, 2),
(16, 10),
(16, 11),
(17, 1),
(17, 12);

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

--
-- Dump dei dati per la tabella `recensione`
--

INSERT INTO `recensione` (`ID`, `Data`, `Stelle`, `Oggetto`, `Descrizione`, `ID_Utente`, `ID_Ristorante`) VALUES
(1, '2018-12-11 12:25:00', '5', 'Eccellente', 'Locale pulito e molto accogliente bella illuminazione ,personale qualificato e gentile, pizza e cibo ottimi , birra molto buona ', 3, 7),
(2, '2019-07-09 17:15:00', '1', 'Delusione totale ', 'Premetto che non sono novizio,ho fatto questo lavoro molti anni.Avrei dovuto mettere solo un punto,ma la cordialità del proprietario,credo ,la pulizia estrema,mi obbliga moralmente a dare la sufficienza.Lasciamo i 40 minuti d’attesa per due pizze,ma chieste ben cotte ,arrivate molli e crude al centro,sinonimo di cottura frettolosa.Ingredienti ,sorvolo sulla qualità,proprio appena nella media,ma scarsi e prosciutto troppo sottile.Pizze strapiene di pomodoro che copriva tutti i gusti.Non tornerò perché troppi errori in un piatto denotano scarsa preparazione ed amore per questo lavoro.', 15, 4),
(3, '2018-05-15 23:25:00', '4', 'È sempre un piacere', 'Siamo stati in questo locale più volte ed è stato sempre un grandissimo piacere tornare, sia per noi che per gli amici che portiamo. Questa sera in particolar modo abbiamo organizzato una festa di compleanno e come sempre l\'accoglienza, il servizio, la pulizia e soprattutto la qualitá dei prodotti ha fatto la differenza regalandoci una bellissima serata. CONSIGLIATISSIMO sia per una cena in compagnia che per una cena di coppia.', 9, 7),
(4, '2019-11-07 15:06:00', '5', 'Inaspettato', 'Il ristorante si trova al primo piano di un bellissimo palazzo proprio di fronte alla splendida Basilica Palladiana e con vista su essa. Il personale è professionale e molto preparato, lo chef propone abbinamenti di gusti e percorsi insoliti ma perfetti. Da assaggiare sicuramente il dolce “pane e olio”. Al piano terra, separato ma collegato con un ascensore, si trova il bistrot Garibaldi, molto carino anche questo.\r\nI prezzi non sono bassi ma nemmeno esagerati, stiamo comunque parlando di un ristorante stellato.\r\nDa ritornare sicuramente.', 12, 3),
(5, '2019-06-11 10:18:00', '5', 'Anniversario', 'È sempre bello venire a trovarvi per le ricorrenze speciali e farci coccolare!\r\nChef è un vulcano creativo in continua eruttazione di nuovi piatti dai sapori sorprendenti, la cantina non delude mai e i ragazzi dello staff ormai conoscono noi e i nostri gusti.\r\nContinuate a crescere e stupirci, alla prossima!', 2, 3),
(6, '2019-11-13 03:05:00', '2', 'Scarso', 'Un locale che si rifà il trucco, cambia nome, ma poi ti ritrovi le medesime persone fa pensare... Di fatto si è sicuramnete imbellettato come certe signore incapaci di accettare i segni del tempo che passa. Di fatto non ha nulla di nuovo nei sapori e nel gusto. i prezzi sono saliti , la qualità non.', 2, 7),
(7, '2017-07-11 17:12:00', '5', 'Troppo buono', 'Cibo buonissimo e di ottima qualità, personale simpatico e molto professionale, lo consiglio vivamente a chiunque', 6, 7),
(8, '2019-10-18 19:52:00', '4', 'pranzo di lavoro', 'Noi andiamo tutti i giorni a pranzo da loro, abbiamo una convenzione aziendale, molto gentili tutti, piatti sempre buoni, ottima scelta si mangia bene', 16, 4),
(9, '2019-01-08 21:12:00', '5', 'Buon ristorante ', 'Sono stata in questo locale qualche sera. Location informale ma gradevole, servizio cordiale e attento,   piatti ben presentati e anche la qualità del cibo non manca. Unico appunto sul conto che é risultato un po\' troppo caro per quello che abbiamo mangiato.', 7, 3),
(10, '2019-08-04 01:26:01', '3', 'Peccato per il dolce', 'Terza volta che ci vado, la pizza è ok nulla da dire, ma son rimasto veramente deluso dal dolce : un semifreddo a sfera con cuore morbido crema al caffè IMBARAZZANTE .\r\nServito con la cartina della produzione industriale sul fondo del piatto , sembrava veramente di mangiare un gelato confezionato.\r\nDeluso', 17, 3),
(11, '2019-11-13 07:14:00', '1', 'Bella e storica location, servizio scadente e maleducato', 'Tappa sicuramente divertente in questa birreria storica, ma per una città dove in ogni angolo che giri trovi una birreria tipica, meglio andare altrove. Camerieri che non ti filano se parli inglese o italiano, ma quando gli parlano in tedesco scattano immediatamente. Scortesi , oltre all\' obbligatorio litro di birra , ho preso un\' acqua che mi hanno portato calda quasi bollente ,con bottiglietta aperta , che mi sono fatta cambiare dopo ulteriori mille chiamate a vuoto. ', 10, 7),
(12, '2019-02-25 03:26:00', '4', 'Da vedere (e da assaggiare!)', 'Una volta nella vita bisogna bersi il litro di Original di questo posto, location suggestiva. Caos ma qualche posticino si trova', 8, 7),
(13, '2019-11-04 19:35:00', '4', 'Cena Bavarese ', 'Tipa birreria bavarese, ambiente allegro, gente simpatica e birra a fiumi. Consigliato per divertirsi in compagnia di amici per mangiare e bere cibo e birra locale. Rapporto qualità prezzo buono considerato il fatto che si è al centro della città in una delle birrerie più famose.\r\nConsigliato. ', 3, 7),
(14, '2019-11-27 19:27:51', '2', 'Gestito malissimo', 'Prenotato tavolo da 30 persone, ci sono voluti 25\' per trovarlo poiché ci mandavano da una sala all\'altra. Personale sgradevole, cibo mai arrivato completamente con un cameriera che fingendosi indaffarato, svuotava volontariamente i boccali sulle giacche delle persone. ', 4, 7),
(15, '2018-10-15 03:17:00', '2', 'Peccato per la scortesia', 'Il super market ha prodotti buoni anche se a prezzi alti. Al ristorante la qualità è minore e i dipendenti sono spesso scortesi. Proprio stasera il signore della security, vestito in nero, si è posto malissimo perché siamo entrati poco prima della chiusura e chiesto per un gelato. Migliorate i modi! ', 5, 4),
(16, '2019-11-16 05:51:00', '4', 'Ottima pizza ', 'Sono stato da Rosso Pomodoro diverse volte ma devo dire che ultimamente è nettamente migliorato. Sorprendente.', 19, 4),
(17, '2018-10-07 06:09:24', '3', 'Una pizza discreta', 'Se ci si aspetta di trovare la pizza sfoglia napoletana, probabilmente, questo ristorante non e` il migliore.\r\nIn compenso la gentilezza del servizio e la qualita` degli ingredienti, valgono la pena di una visita!\r\nAccompagnata da una discreta gamma di birre locali e artigianali, potrete degustare piu` di 20 tipi di pizza differenti immersi in un clima disteso amichevole.', 18, 4),
(18, '2019-11-27 19:41:09', '4', 'autentico e un buon rapporto qualità-prezzo!', 'il pasto è ottimo, il servizio è autentico italiano, l\'atmosfera è come una pizza comune in Italia - - niente di speciale, ma bello', 9, 4);

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

--
-- Dump dei dati per la tabella `ristorante`
--

INSERT INTO `ristorante` (`ID`, `ID_Proprietario`, `Nome`, `Categoria`, `Descrizione`, `Tel`, `Mail`, `Giorno_Chiusura`, `Ora_Apertura`, `Ora_Chiusura`, `Nazione`, `Citta`, `CAP`, `Via`, `Civico`, `Approvato`, `sito`) VALUES
(2, 21, 'Madito', 'Libanese', 'Madito offre una cucina libanese contemporanea, realizzata con prodotti freschi e sani e senza fritture.\r\nTutti i piatti sono realizzati dal nostro chef a comanda.', '+000000000000', 'madito@dayrep.com', 'Martedì', '12:00:00', '23:00:00', 'Francia', 'Parigi', '75012', 'Rue de citeaux', '38', 'In attesa', 'www.sitodimadito.com'),
(3, 22, 'The clink restaurant', 'Britannica', 'Situato vicino le vecchie case governative Inglesi risalenti al 1819, questo ristorante offre agli ospiti il tipico cibo Inglese.', '+000000000000', 'theclink@spy.us', 'Mercoledì', '18:00:00', '21:00:00', 'Inghilterra', 'Londra', 'SW2', 'Brixtonjebb avenue', '11', 'Approvato', 'www.theclinkcharity.org/rastaurant/brixton'),
(4, 23, 'Rosso pomodoro', 'Italiana', 'Noi di Rossopomodoro portiamo da vent\'anni un po’ di Napoli in tutto il mondo facendo gustare l\'autentica pizza napoletana artigianale a lunga lievitazione e la cucina campana in più di cento località, dal nord al sud Italia, fino a Nizza, Londra, San Paolo, Reykjavik, Jeddah, New York e tante altre città. Essere ambasciatori della cultura gastronomica napoletana è la nostra passione. Perché siamo legati alla nostra terra, ai suoi prodotti genuini e anche all\'atmosfera della nostra amata città, colorata, accogliente e allegra come i nostri ristoranti.\r\nBenvenuti a Rossopomodoro, benvenuti a Napoli!', '+000000000000', 'rossopomodoro@dayrep.com', 'Giovedì', '11:30:00', '24:00:00', 'Italia', 'Napoli', '80121', 'Corso Vittorio emanuele', '84', 'Approvato', 'www.rossopomodoro.it'),
(5, 23, 'Pizza Italia', 'Italiana', 'Solo qui potrai mangiare la vera pizza italiana in quel di Malta!', '+000000000000', 'pizzaitala@spy.us', 'Giovedì', '18:00:00', '24:00:00', 'Malta', 'La Valletta', '1012', 'Dawret il-Gzejjer St. Paul’s Bay', '12', 'In attesa', NULL),
(6, 24, 'La Boheme', 'Steakhouse', 'Casual international flair meets living room-like cosiness and culinary diversity. From the simple glass of wine with oven bread to the 5-course menu you can get everything you want. In addition, there are always vegetarian dishes in the menu. Chef Lilian Schumann and host Michael Urban with their young team have set the goal to give you a special dining experience.\r\nEspecially for our international guests coming from the airport or going to it, La Bohème is the first or last stop on your way. It’s worth stopping by.', '+0000000000', 'LaBoheme@dayrep.com', 'Lunedì', '18:00:00', '23:00:00', 'Germania', 'Monaco di Baviera', '80804', 'Leopoldstrasse', '180', 'In attesa', 'http://boheme-schwabing.de/en/the-restaurant/'),
(7, 26, 'Hofbrauhaus', 'Cucina tedesca', 'Situata nel cuore di Monaco per anni. Questo ristorante è una delle pietre miliari della cultura bavarese. Ogni giorno attraiamo persone da tutte le nazioni e c\'è spazio per tutti nelle stanze storiche', '+0000000000', 'Hofbraumhaus@dayrep.it', 'Mercoledì', '09:00:00', '24:00:00', 'Germania', 'Monaco di Baviera', '80331', 'Platzl', '9', 'Approvato', 'www.hofbraeuhaus.de'),
(8, 30, 'Da enzo', 'Italiana', 'Buonissimo ristorante, aperto per tutti :)', '+0000000000', 'Daenzo@troll.it', 'Domenica', '00:00:00', '01:00:30', 'Italia', 'Borgoricco', '35010', 'Via Giotto', '12', 'Non approvato', 'www.superenzo.it'),
(9, 29, 'Sumishi', 'Sushi', NULL, '+0000000000', 'sumishi@dayrep.it', 'Martedì', '12:00:00', '22:00:00', 'Italia', 'Monselice', '35043', 'Viale Lombardia', '19', 'In attesa', 'www.sumishi.it');

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
  `P_IVA` varchar(11) DEFAULT NULL,
  `Permessi` enum('Utente','Ristoratore','Admin') DEFAULT NULL,
  `Sesso` enum('Uomo','Donna','Altro','Sconosciuto') DEFAULT 'Sconosciuto'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`ID`, `PWD`, `Mail`, `Nome`, `Cognome`, `Data_Nascita`, `ID_Foto`, `Ragione_Sociale`, `P_IVA`, `Permessi`, `Sesso`) VALUES
(1, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'leila.pagnotto@rhyta.com', 'Leila', 'Pagnotto', '1993-10-27', 1, NULL, NULL, 'Utente', ''),
(2, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'DinoGenovese@dayrep.com', 'Dino', 'Genovese', '2004-07-21', 2, NULL, NULL, 'Utente', ''),
(3, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'NestoreMancini@dayrep.com', 'Nestore', 'Mancini', '1973-03-26', 3, NULL, NULL, 'Utente', ''),
(4, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'AlvisaLongo@jourrapide.com', 'Alvisa', 'Longo', '1963-04-03', 4, NULL, NULL, 'Utente', ''),
(5, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'CarisioDavide@teleworm.us', 'Davide', 'Carisio', '1988-10-23', 5, NULL, NULL, 'Utente', ''),
(6, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'alessandrodiscalzi98@gmail.com', 'Alessandro', 'Discalzi', '1998-10-23', 6, NULL, NULL, 'Utente', ''),
(7, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'albertococco98@gmail.com', 'Alberto', 'Cocco', '1998-06-15', 7, NULL, NULL, 'Utente', ''),
(8, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'galvaniegon@gmail.com', 'Egon', 'Galvani', '1999-11-17', 8, NULL, NULL, 'Utente', ''),
(9, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'matteomunari@gmail.com', 'Matteo', 'Munari', '1998-01-18', 9, NULL, NULL, 'Utente', ''),
(10, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'frostmourne96@teleworm.us', 'Marco', 'Fonta', '1996-12-08', 10, NULL, NULL, 'Utente', ''),
(11, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'AleardoMilano@armyspy.com', 'Aleardo', 'Milan', '1962-02-18', 11, NULL, NULL, 'Utente', ''),
(12, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'TamaraSiciliani@armyspy.com', 'Tamara', 'Siciliani', '1982-02-18', 12, NULL, NULL, 'Utente', ''),
(13, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'AbelardaMoretti@dayrep.com', 'Abelarda', 'Moretti', '1955-09-26', 13, NULL, NULL, 'Utente', ''),
(14, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'GiudittaNuci@jourrapide.com', '', 'Nuci', '1978-11-29', 14, NULL, NULL, 'Utente', ''),
(15, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'stanislawmanfrin@armyspy.com', 'Stanislao', 'Manfrin', '1978-10-11', 15, NULL, NULL, 'Utente', ''),
(16, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'generosamarcelo@dayrep.com', 'Generosa', 'Marcelo', '1980-11-16', 16, NULL, NULL, 'Utente', ''),
(17, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'benedetta.lettiere@teleworm.us', 'Benedetta', 'Lettiere', '1993-04-11', 17, NULL, NULL, 'Utente', ''),
(18, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'adarosi@teleworm.us', 'Adalberta', 'Rossi', '1978-02-10', 18, NULL, NULL, 'Utente', ''),
(19, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'lucrezia.piccio@jourrapide.com', 'Lucrezia', 'Piccio', '1996-08-08', 19, NULL, NULL, 'Utente', ''),
(20, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'giocchinofenice@dayrep.com', 'Gioacchino', 'Fenice', '1968-07-15', 20, NULL, NULL, 'Utente', ''),
(21, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'giuseppalori@teleworm.us', 'Giuseppa', 'Lori', '1975-05-02', 21, 'Country Club Markets', '0', 'Ristoratore', ''),
(22, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'paola.sagese@teleworm.us', 'Paola', 'Sagese', '1990-12-12', 22, 'StopAndShop', '0', 'Ristoratore', 'Sconosciuto'),
(23, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'bernicebeneventi@dayrep.com', 'Bernice', 'Beneventi', '1971-05-05', 23, 'Best Bar Restaurants', '0', 'Ristoratore', ''),
(24, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'sofia.reticci@rhyta.com', 'Sofia', 'Reticci', '1974-07-01', 24, 'FoodConsumers SRL', '12345678900', 'Ristoratore', 'Altro'),
(25, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'grazianopiazza@teleworm.us', 'Graziano', 'Piazza', '1957-03-18', 25, 'Piazza e F.', '0', 'Ristoratore', ''),
(26, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'lidiarossi@dayrep.com', 'Lidia', 'Rossi', '1965-08-08', NULL, NULL, '0', 'Ristoratore', ''),
(27, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'fantinogiordano@jourrapide.com', 'Giordano', 'Fantino', '1981-01-21', NULL, NULL, '0', 'Ristoratore', ''),
(28, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'gaetanonio@teleworm.us', 'Gaetano', 'Onio', '1988-10-18', NULL, NULL, '0', 'Ristoratore', ''),
(29, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'camillocolombo@rhyta.com', 'Camillo', 'Colombo', '1963-05-25', NULL, NULL, '0', 'Ristoratore', ''),
(30, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'GIANETTOTOSCANO@teleworm.us', 'Gianetto', 'Toscano', '1993-12-25', NULL, NULL, '0', 'Ristoratore', ''),
(78, '19513fdc9da4fb72a4a05eb66917548d3c90ff94d5419e1f2363eea89dfee1dd', 'paolovillaggio@gmail.com', 'Paolo', 'Villaggio', '1932-12-30', 46, NULL, NULL, 'Utente', 'Uomo'),
(79, '19513fdc9da4fb72a4a05eb66917548d3c90ff94d5419e1f2363eea89dfee1dd', 'vanessatroiani@ggg.it', 'Vanessa', 'Troiani', '1968-06-15', 47, NULL, NULL, 'Utente', 'Donna');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT per la tabella `recensione`
--
ALTER TABLE `recensione`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `ristorante`
--
ALTER TABLE `ristorante`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

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
