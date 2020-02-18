-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 18, 2020 at 01:45 PM
-- Server version: 5.5.64-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jirka01`
--

-- --------------------------------------------------------

--
-- Table structure for table `AUTOR`
--

CREATE TABLE IF NOT EXISTS `AUTOR` (
  `Jmeno` varchar(20) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `Cele_jmeno` varchar(60) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `AUTOR`
--

INSERT INTO `AUTOR` (`Jmeno`, `Cele_jmeno`) VALUES
('belindajonesova', 'Belinda Jonesová'),
('bozenanemcova', 'Božena Němcová'),
('eduardpetiska', 'Eduard Petiška'),
('franktetauer', 'Frank Tetauer'),
('Jan', 'Novák'),
('jiriwprochazka', 'Jiří W. Procházka'),
('lenkareinerova', 'Lenka Reinerová'),
('michalajvaz', 'Michal Ajvaz'),
('miroslavzamboch', 'Miroslav Žamboch'),
('smraďoch', 'Noha Smraďochova');

-- --------------------------------------------------------

--
-- Table structure for table `FINANCE`
--

CREATE TABLE IF NOT EXISTS `FINANCE` (
  `Id_faktury` int(8) NOT NULL,
  `Id_knihy` int(8) DEFAULT NULL,
  `Druh_polozky` tinyint(1) NOT NULL,
  `Cena_bez_dph` float DEFAULT NULL,
  `Cena_s_dph` float DEFAULT NULL,
  `DPH` float DEFAULT NULL,
  `Datum` datetime NOT NULL,
  `Zadavatel` varchar(8) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `FINANCE`
--

INSERT INTO `FINANCE` (`Id_faktury`, `Id_knihy`, `Druh_polozky`, `Cena_bez_dph`, `Cena_s_dph`, `DPH`, `Datum`, `Zadavatel`) VALUES
(181, 2, 1, 60, 72.6, 0.21, '2020-01-08 18:05:35', 'wedmin');

-- --------------------------------------------------------

--
-- Table structure for table `JAZYK`
--

CREATE TABLE IF NOT EXISTS `JAZYK` (
  `Zkratka` varchar(3) COLLATE utf8_czech_ci NOT NULL,
  `Nazev` varchar(20) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `JAZYK`
--

INSERT INTO `JAZYK` (`Zkratka`, `Nazev`) VALUES
('ar', 'arabština'),
('bg', 'bulharština'),
('ca', 'katalánština'),
('ceb', 'cebuánština'),
('cs', 'čeština'),
('da', 'dánština'),
('de', 'němčina'),
('en', 'angličtina'),
('eo', 'esperanto'),
('es', 'španělština'),
('eu', 'baskičtina'),
('fa', 'perština'),
('fi', 'finština'),
('fr', 'francouzština'),
('he', 'hebrejština'),
('hu', 'maďarština'),
('hy', 'arménština'),
('id', 'indonéština'),
('it', 'italština'),
('ja', 'japonština'),
('kk', 'kazaština'),
('ko', 'korejština'),
('lt', 'litevština'),
('min', 'minangkabauština'),
('ms', 'malajština'),
('nl', 'nizozemština'),
('no', 'norština'),
('pl', 'polština'),
('pt', 'portugalština'),
('ro', 'rumunština'),
('ru', 'ruština'),
('sh', 'srbochorvatština'),
('sk', 'slovenština'),
('sr', 'srbština'),
('sv', 'švédština'),
('tr', 'turečtina'),
('uk', 'ukrajinština'),
('vi', 'vietnamština'),
('war', 'warajština'),
('zh', 'čínština');

-- --------------------------------------------------------

--
-- Table structure for table `KATEGORIE`
--

CREATE TABLE IF NOT EXISTS `KATEGORIE` (
  `Id_kategorie` int(11) NOT NULL,
  `Kategorie` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `Popis` text COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `KATEGORIE`
--

INSERT INTO `KATEGORIE` (`Id_kategorie`, `Kategorie`, `Popis`) VALUES
(1, 'Báje a pověsti', 'Do bájí neboli mýtů jsou vtěleny dávné představy lidí o vzniku světa a jeho povaze; o životě bohů; přírodních jevech a jejich příčinách; o člověku, jeho vzniku a jeho pozemském i posmrtném životě atd.'),
(2, 'Cestopisy', 'Cestopisy zpravidla popisují autorovu cestu do cizích zemí a krajin, objevují a přibližují jejich geografické, národní, kulturní či sociální zvláštnosti.'),
(3, 'Detektivka', 'Detektivní romány, povídky a novely či zkráceně detektivky jsou čtenářsky velice oblíbeným žánrem populární literatury.'),
(4, 'Dívčí román', 'Dívčí román je jeden ze žánrů populární literatury. Je přímo určen dospívajícím dívkám.'),
(5, 'Drama', 'Drama je vedle prózy a poezie jedním ze základních literárních druhů. Většinou je drama založeno čistě na ději, který je však vyprávěn výhradně pomocí přímé řeči.'),
(6, 'Erotika', 'Erotická literatura je uměleckým ztvárněním lidské sexuality, které nabývá mnoha podob s ohledem na žánr, styl i funkci.'),
(7, 'Fantasy', 'Fantasy je žánr populární literatury založený především na smyšlených či fantaskních jevech jako jsou užití magie či nadpřirozené prvky (bájné bytosti, bohové, démoni).'),
(8, 'Horor', 'Horor je jedním z žánrů populární literatury. Hlavním cílem hororu je vyvolat u čtenáře pocit hrůzy, strachu, děsu a napětí.'),
(9, 'Humor a Satira', 'Humoristická literatura je založena na humorné nadsázce a pomocí nadhledu a vtipu se snaží odlehčit leckdy neveselou realitu.'),
(10, 'Komiks', 'Komiks je umělecké médium, někdy bývá označován jako „deváté umění“. '),
(11, 'Poezie', 'Poezie, neboli básnictví či básnické umění, patří vedle prózy a dramatu k základním druhům literatury.'),
(12, 'Povídka', 'Povídka je kratší próza, která většinou vypráví příběh s jednoduchým dějem a malým počtem postav.'),
(13, 'Pro mládež', 'Literatura pro děti a mládež někdy také označována pouze jako literatura dětská, zahrnuje literaturu (prózu, poezii i drama), která je přímo určená pro děti a mládež (intencionální četba) i literární texty.'),
(14, 'Próza', 'Próza je každý psaný text, který je psán běžnou a přirozenou formou, nikoli ve verších. Próza je nejčastěji spojována s epikou.'),
(15, 'Publicistika', 'Publicistika je svébytný druh literatury a je součástí žurnalistiky. Je určena pro veřejnost a na rozdíl od běžného zpravodajství obsahuje kromě konkrétních informací také autorův subjektivní názor.'),
(16, 'Román pro ženy', 'Naše sekce Romány pro ženy nezahrnuje pouze klasickou „červenou knihovnu“, ale také příběhy z každodenního života nejrůznějších typů žen, ze všech společenských vrstev a historických období. Najdete zde zkrátka romány o ženách a pro ženy.'),
(17, 'Romány', 'Román je asi nejrozšířenějším literárním žánrem současnosti. Je to rozsáhlé prozaické smyšlené vyprávění se spletitým dějem a velkým množstvím postav z nejrůznějšího společenského prostředí.'),
(18, 'Sci-fi', 'Science fiction, zkráceně sci-fi či SF, česky označovaná také jako vědecko-fantastická próza, je jedním z žánrů populární literatury.');

-- --------------------------------------------------------

--
-- Table structure for table `KNIHA`
--

CREATE TABLE IF NOT EXISTS `KNIHA` (
  `Id` int(8) NOT NULL,
  `Nazev` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  `Autor` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `Spoluautor` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `Kategorie` int(11) NOT NULL,
  `Jazyk` varchar(3) COLLATE utf8_czech_ci NOT NULL,
  `Cena` float unsigned NOT NULL,
  `Vazba` varchar(60) COLLATE utf8_czech_ci DEFAULT 'Nespecifikována',
  `Rok_vydani` int(4) DEFAULT NULL,
  `Vydal` varchar(50) COLLATE utf8_czech_ci DEFAULT 'Nespecifikováno',
  `Stav` varchar(80) COLLATE utf8_czech_ci DEFAULT 'Nespecifikovaný',
  `Prodano` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `KNIHA`
--

INSERT INTO `KNIHA` (`Id`, `Nazev`, `Autor`, `Spoluautor`, `Kategorie`, `Jazyk`, `Cena`, `Vazba`, `Rok_vydani`, `Vydal`, `Stav`, `Prodano`) VALUES
(1, 'Novákovi', 'Jan', 'franktetauer', 1, 'cs', 359, '', 0, '', '', 0),
(2, 'Lodní lístek', 'lenkareinerova', NULL, 2, 'cs', 60, 'Pevná s obálkou', 2009, 'Labyrint', 'dobrý', 1),
(4, 'Pašerák', 'miroslavzamboch', 'jiriwprochazka', 7, 'cs', 100, 'Pevná s obálkou', 2005, 'Triton', 'Dobrý', 0),
(5, 'Miluju Caprii', 'belindajonesova', NULL, 1, 'cs', 150, 'Pevná s obálkou', 2007, 'BB', 'Dobrý', 0),
(6, 'Testing', 'jiriwprochazka', 'bozenanemcova', 5, 'ar', 150, 'Pevná s obálkou', 1943, 'Hamak', 'Zachovalý stav knihy', 0),
(52, 'Lorem Ipsum', 'franktetauer', 'belindajonesova', 2, 'ca', 500, 'Nespecifikována', NULL, 'Nespecifikováno', 'Nespecifikovaný', 0),
(136, 'Drama i jeho svět', 'belindajonesova', NULL, 3, 'cs', 70, '', 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `NOVINKY`
--

CREATE TABLE IF NOT EXISTS `NOVINKY` (
  `Id_novinky` int(11) NOT NULL,
  `Nadpis` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  `Obsah` mediumtext COLLATE utf8_czech_ci NOT NULL,
  `Datum_vytvoreni` date NOT NULL DEFAULT '0000-00-00',
  `Druh_novinek` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `NOVINKY`
--

INSERT INTO `NOVINKY` (`Id_novinky`, `Nadpis`, `Obsah`, `Datum_vytvoreni`, `Druh_novinek`) VALUES
(1, 'Prodavač / Prodavačka', 'Zdravím, hledáme milou a pracovitou osobu na tuto pozici. Požadavky jsou: samostatné a iniciativní řešení pracovních úkolů, samostatné a pohotové rozhodování, profesní etika, praktická aplikace získaných vědomostí a dovedností, umění jednat s lidmi, estetické cítění a uplatňování estetických hledisek.', '2020-01-18', 0),
(2, 'Slavnostní otevření', 'Rádi bychom vás pozvali na slavnostní otevření naší první specializované prodejny zaměřené na staré knih.', '2020-01-18', 0),
(3, 'Otevírací doba', 'Pondělí: 09.00 - 16.00\r\nÚterý: 09.00 - 16.00\r\nStředa: 09.00 - 16.00\r\nČtvrtek: 09.00 - 16.00\r\nPátek: 08.00 - 16.00\r\nSobota: 10.00 - 14.00\r\nNeděle: Zavřeno', '2020-01-18', 0),
(4, 'Aktuální situace', 'V aktuální době máme zavřeno. Omlouváme se všem, kteří mají zájem o krásnou starou literaturu.', '2020-01-18', 1),
(5, 'Nápověda', 'Pro přihlášení do systému klikněte na na tlačítko přihlášení v pravém horním rohu.', '2020-01-18', 1),
(6, 'Popis aplikace', 'Tato aplikace je výsledkem bakalářské práce studenta. Informace, které zde naleznete se neslučují se skutečností. Přeji krásný den.', '2020-01-18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `OBJEKT`
--

CREATE TABLE IF NOT EXISTS `OBJEKT` (
  `Id` int(8) NOT NULL,
  `Nazev` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `Druh_majetku` tinyint(1) NOT NULL DEFAULT '1',
  `Zarucni_doba` int(11) NOT NULL DEFAULT '2',
  `Cena` float unsigned NOT NULL,
  `Datum_porizeni` date NOT NULL DEFAULT '0000-00-00',
  `Datum_vyrazeni` date DEFAULT NULL,
  `Vyrazeno` tinyint(1) NOT NULL DEFAULT '0',
  `Pocet_kusu` int(11) NOT NULL DEFAULT '1',
  `Prodejce` varchar(60) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `OBJEKT`
--

INSERT INTO `OBJEKT` (`Id`, `Nazev`, `Druh_majetku`, `Zarucni_doba`, `Cena`, `Datum_porizeni`, `Datum_vyrazeni`, `Vyrazeno`, `Pocet_kusu`, `Prodejce`) VALUES
(1, 'Nachový kancelářský stůl', 1, 3, 449.99, '2019-12-11', NULL, 0, 1, 'Dřevařství S.R.O.'),
(2, 'Azurová židle sedmi moří', 1, 4, 999.99, '2019-11-11', '2019-11-12', 1, 1, 'Milan a Syn'),
(3, 'Počítačová klávesnice', 1, 2, 1500, '2019-12-12', NULL, 0, 1, 'Logitech s.r.o.'),
(4, 'Adobe Acrobat Pro', 0, 0, 1300, '2019-12-04', NULL, 0, 1, 'Adobe'),
(5, 'Lampička bílá', 1, 2, 250, '2019-12-12', NULL, 0, 1, 'Logitech s.r.o.'),
(6, 'Hnědozelené křeslo', 1, 2, 1400, '2019-12-12', '2019-12-12', 1, 1, 'Lombi a.s.');

-- --------------------------------------------------------

--
-- Table structure for table `UCET`
--

CREATE TABLE IF NOT EXISTS `UCET` (
  `Login` varchar(8) COLLATE utf8_czech_ci NOT NULL,
  `Heslo` varchar(130) COLLATE utf8_czech_ci NOT NULL,
  `Rc` varchar(15) COLLATE utf8_czech_ci DEFAULT NULL,
  `Opravneni` int(11) NOT NULL,
  `Zalozeni` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `UCET`
--

INSERT INTO `UCET` (`Login`, `Heslo`, `Rc`, `Opravneni`, `Zalozeni`) VALUES
('admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', '920202/1299', 1, '2019-10-13'),
('testing', '521b9ccefbcd14d179e7a1bb877752870a6d620938b28a66a107eac6e6805b9d0989f45b5730508041aa5e710847d439ea74cd312c9355f1f2dae08d40e41d50', NULL, 0, '2019-12-12'),
('user', 'b14361404c078ffd549c03db443c3fede2f3e534d73f78f77301ed97d4a436a9fd9db05ee8b325c0ad36438b43fec8510c204fc1c1edb21d0941c00e9e2c1ce2', '920101/1112', 0, '2019-11-20'),
('wedmin', 'e8bc335b8ae97b6bec2f29c7e2ee98d79f3a3f4ad9db5aa6c6095d3033f506045017c156f5faa0ff79e21d73ea595cdfd4f51c8cf3ae1473d1d891e885a95652', '981012/1565', 1, '2019-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `ZAMESTNANEC`
--

CREATE TABLE IF NOT EXISTS `ZAMESTNANEC` (
  `Rc` varchar(15) COLLATE utf8_czech_ci NOT NULL,
  `Jmeno` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  `Adresa` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `Mesto` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `Psc` varchar(5) COLLATE utf8_czech_ci NOT NULL,
  `Email` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  `Telefon` varchar(13) COLLATE utf8_czech_ci NOT NULL,
  `Datum_prijeti` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `ZAMESTNANEC`
--

INSERT INTO `ZAMESTNANEC` (`Rc`, `Jmeno`, `Adresa`, `Mesto`, `Psc`, `Email`, `Telefon`, `Datum_prijeti`) VALUES
('920101/1112', 'Flint Houžvička', 'Tomanova 99', 'Hluchov', '55236', 'flint05@domenasluzeb.cz', '+420365222111', '2019-11-12'),
('920202/1299', 'Tomáš Jednočko', 'Hluboká 12', 'Truncov', '25311', 'tomasocko@domenasluzby.com', '+420755355255', '2019-10-13'),
('920301/1515', 'Kateřina Jirková', 'Somers Rd 71', 'London', 'E17 6', 'katajiku@gmail.com', '07746178285', '2019-12-12'),
('981012/1565', 'Lucie Janková', 'Přítlucká 22', 'Blondckov', '55241', 'lucipuci@gmail.com', '07746178285', '2019-12-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AUTOR`
--
ALTER TABLE `AUTOR`
  ADD PRIMARY KEY (`Jmeno`);

--
-- Indexes for table `FINANCE`
--
ALTER TABLE `FINANCE`
  ADD PRIMARY KEY (`Id_faktury`),
  ADD UNIQUE KEY `Id_knihy_2` (`Id_knihy`),
  ADD KEY `Zadavatel` (`Zadavatel`),
  ADD KEY `Id_knihy` (`Id_knihy`);

--
-- Indexes for table `JAZYK`
--
ALTER TABLE `JAZYK`
  ADD PRIMARY KEY (`Zkratka`);

--
-- Indexes for table `KATEGORIE`
--
ALTER TABLE `KATEGORIE`
  ADD PRIMARY KEY (`Id_kategorie`);

--
-- Indexes for table `KNIHA`
--
ALTER TABLE `KNIHA`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Kategorie` (`Kategorie`),
  ADD KEY `Jazyk` (`Jazyk`),
  ADD KEY `Autor` (`Autor`),
  ADD KEY `Spoluautor` (`Spoluautor`);

--
-- Indexes for table `NOVINKY`
--
ALTER TABLE `NOVINKY`
  ADD PRIMARY KEY (`Id_novinky`);

--
-- Indexes for table `OBJEKT`
--
ALTER TABLE `OBJEKT`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `UCET`
--
ALTER TABLE `UCET`
  ADD PRIMARY KEY (`Login`),
  ADD UNIQUE KEY `Rc_2` (`Rc`),
  ADD KEY `Rc` (`Rc`);

--
-- Indexes for table `ZAMESTNANEC`
--
ALTER TABLE `ZAMESTNANEC`
  ADD PRIMARY KEY (`Rc`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `FINANCE`
--
ALTER TABLE `FINANCE`
  MODIFY `Id_faktury` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=182;
--
-- AUTO_INCREMENT for table `KATEGORIE`
--
ALTER TABLE `KATEGORIE`
  MODIFY `Id_kategorie` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `KNIHA`
--
ALTER TABLE `KNIHA`
  MODIFY `Id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=137;
--
-- AUTO_INCREMENT for table `NOVINKY`
--
ALTER TABLE `NOVINKY`
  MODIFY `Id_novinky` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `OBJEKT`
--
ALTER TABLE `OBJEKT`
  MODIFY `Id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `FINANCE`
--
ALTER TABLE `FINANCE`
  ADD CONSTRAINT `FINANCE_ibfk_2` FOREIGN KEY (`Zadavatel`) REFERENCES `UCET` (`Login`),
  ADD CONSTRAINT `FINANCE_ibfk_3` FOREIGN KEY (`Id_knihy`) REFERENCES `KNIHA` (`Id`);

--
-- Constraints for table `KNIHA`
--
ALTER TABLE `KNIHA`
  ADD CONSTRAINT `KNIHA_ibfk_2` FOREIGN KEY (`Jazyk`) REFERENCES `JAZYK` (`Zkratka`),
  ADD CONSTRAINT `KNIHA_ibfk_3` FOREIGN KEY (`Kategorie`) REFERENCES `KATEGORIE` (`Id_kategorie`),
  ADD CONSTRAINT `KNIHA_ibfk_4` FOREIGN KEY (`Autor`) REFERENCES `AUTOR` (`Jmeno`),
  ADD CONSTRAINT `KNIHA_ibfk_5` FOREIGN KEY (`Spoluautor`) REFERENCES `AUTOR` (`Jmeno`);

--
-- Constraints for table `UCET`
--
ALTER TABLE `UCET`
  ADD CONSTRAINT `UCET_ibfk_1` FOREIGN KEY (`Rc`) REFERENCES `ZAMESTNANEC` (`Rc`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
