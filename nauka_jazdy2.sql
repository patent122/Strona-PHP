-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2024 at 10:13 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nauka_jazdy2`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `IloscWykorzystanychLekcji` (`IdZakupionegoPakietu` INT) RETURNS INT(11)  BEGIN
    DECLARE wynik INT;  
    
    SELECT COUNT(*) INTO wynik FROM Lekcje WHERE ZakupionyPakietID=IdZakupionegoPakietu; 
    RETURN wynik;  
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `egzaminy`
--

CREATE TABLE `egzaminy` (
  `ID` int(11) NOT NULL,
  `DataEgzaminu` date NOT NULL,
  `CzasEgzaminu` time NOT NULL,
  `UczenID` int(11) NOT NULL,
  `Wynik` enum('pozytywny','negatywny') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `egzaminy`
--

INSERT INTO `egzaminy` (`ID`, `DataEgzaminu`, `CzasEgzaminu`, `UczenID`, `Wynik`) VALUES
(1, '2023-06-01', '00:39:15', 2, 'pozytywny'),
(2, '2023-07-01', '00:30:26', 2, 'negatywny'),
(3, '2023-08-01', '00:35:03', 3, 'pozytywny'),
(4, '2023-09-01', '00:28:38', 3, 'negatywny'),
(5, '2023-10-01', '00:32:25', 3, 'pozytywny');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lekcje`
--

CREATE TABLE `lekcje` (
  `ID` int(11) NOT NULL,
  `DataLekcji` date NOT NULL,
  `CzasLekcji` time NOT NULL,
  `InstruktorID` int(11) DEFAULT NULL,
  `ZakupionyPakietID` int(11) DEFAULT NULL,
  `SamochodID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lekcje`
--

INSERT INTO `lekcje` (`ID`, `DataLekcji`, `CzasLekcji`, `InstruktorID`, `ZakupionyPakietID`, `SamochodID`) VALUES
(1, '2023-01-02', '10:00:00', 1, 4, 1),
(2, '2023-02-02', '11:00:00', 2, 4, 2),
(3, '2023-03-02', '12:00:00', 3, 4, 3),
(4, '2023-04-02', '13:00:00', 4, 5, 4),
(5, '2023-05-02', '14:00:00', 5, 5, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pakiety`
--

CREATE TABLE `pakiety` (
  `ID` int(11) NOT NULL,
  `NazwaPakietu` varchar(50) NOT NULL,
  `IloscLekcji` int(11) NOT NULL,
  `Cena` decimal(8,2) NOT NULL,
  `Opis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pakiety`
--

INSERT INTO `pakiety` (`ID`, `NazwaPakietu`, `IloscLekcji`, `Cena`, `Opis`) VALUES
(1, 'Pakiet Standard', 10, 1000.00, '10 lekcji jazdy'),
(2, 'Pakiet Komfort', 20, 1900.00, '20 lekcji jazdy'),
(3, 'Pakiet Premium', 30, 2700.00, '30 lekcji jazdy'),
(4, 'Pakiet VIP', 40, 3400.00, '40 lekcji jazdy'),
(5, 'Pakiet DeLuxe', 50, 4000.00, '50 lekcji jazdy');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `samochody`
--

CREATE TABLE `samochody` (
  `ID` int(11) NOT NULL,
  `Marka` varchar(50) NOT NULL,
  `Model` varchar(50) NOT NULL,
  `RokProdukcji` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `samochody`
--

INSERT INTO `samochody` (`ID`, `Marka`, `Model`, `RokProdukcji`) VALUES
(1, 'Toyota', 'Corolla', '2020'),
(2, 'Volkswagen', 'Golf', '2019'),
(3, 'Ford', 'Focus', '2021'),
(4, 'Skoda', 'Octavia', '2022'),
(5, 'Opel', 'Astra', '2020'),
(6, 'Lamborghini ', 'Urus', '2023');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `ID` int(11) NOT NULL,
  `Imie` varchar(50) NOT NULL,
  `Nazwisko` varchar(50) NOT NULL,
  `NumerTelefonu` varchar(15) NOT NULL,
  `Login` varchar(50) NOT NULL,
  `Haslo` varchar(255) NOT NULL,
  `Rola` enum('administrator','uczen','instruktor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`ID`, `Imie`, `Nazwisko`, `NumerTelefonu`, `Login`, `Haslo`, `Rola`) VALUES
(1, 'Kasia', 'Kowalska', '123456789', 'Kasia', '$2y$10$z2BF.3b6tPrYmUO2QSlt8uRMgeY.B3yQmOZ0XnSfuABc85PrHhlkO', 'administrator'),
(2, 'Klaudia', 'Nowak', '987654321', 'Klaudia', '$2y$10$Pvs9WOZ.xTQ5yRAJ8PTLeukDZoTPSzG.jDosVIy3gSjd6765ICOgi', 'uczen'),
(3, 'Piotr', 'Zieliński', '456789123', 'Piotrek', '$2y$10$Ox9leJi2Kcf3MpsLlzGUVuFbxzG4ri6fWounwJE5OaK6mGoJ55drm', 'uczen'),
(4, 'Szymon', 'Wiśniewski', '321987654', 'Szymon', '$2y$10$La9YBAhh.apTsTB5Gn1LeusZW8mktuubwbZBkyXid2AuEOj95ZGT.', 'instruktor'),
(5, 'Cezary', 'Wójcik', '654321987', 'Cezary', '$2y$10$1gO3KTM1mIz3vrE9l7hJ3OO/JiWG9uRJLaTYmicq/mNj4hXeBZJTK', 'instruktor'),
(6, 'Ewa ', 'Matynia', '123123123', 'ematynia', '$2y$10$ylawhb7lyJeRX7iBSu3rMOc77xS9MPTireduN610yFcdBHSJfzKVu', 'instruktor'),
(7, 'Robert', 'Zabijaka', '666666666', 'rzabijaka', '$2y$10$yYEi/26qi27P.45rbJxp3./dW5XnDtIq80rU9QqWuO9obyGnrMrT.', 'uczen');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zakupionepakiety`
--

CREATE TABLE `zakupionepakiety` (
  `ID` int(11) NOT NULL,
  `UczenID` int(11) DEFAULT NULL,
  `PakietID` int(11) DEFAULT NULL,
  `Status` enum('aktywny','wykorzystany') NOT NULL DEFAULT 'aktywny',
  `DataZakupu` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zakupionepakiety`
--

INSERT INTO `zakupionepakiety` (`ID`, `UczenID`, `PakietID`, `Status`, `DataZakupu`) VALUES
(1, 2, 1, 'aktywny', '2023-01-01'),
(2, 2, 2, 'aktywny', '2023-02-01'),
(3, 3, 3, 'aktywny', '2023-03-01'),
(4, 3, 4, 'aktywny', '2023-04-01'),
(5, 3, 5, 'aktywny', '2023-05-01'),
(6, 7, 5, 'aktywny', '2024-02-13');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `egzaminy`
--
ALTER TABLE `egzaminy`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UczenID` (`UczenID`);

--
-- Indeksy dla tabeli `lekcje`
--
ALTER TABLE `lekcje`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `InstruktorID` (`InstruktorID`),
  ADD KEY `ZakupionyPakietID` (`ZakupionyPakietID`),
  ADD KEY `SamochodID` (`SamochodID`);

--
-- Indeksy dla tabeli `pakiety`
--
ALTER TABLE `pakiety`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `samochody`
--
ALTER TABLE `samochody`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `NumerTelefonu` (`NumerTelefonu`),
  ADD UNIQUE KEY `Login` (`Login`);

--
-- Indeksy dla tabeli `zakupionepakiety`
--
ALTER TABLE `zakupionepakiety`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UczenID` (`UczenID`),
  ADD KEY `PakietID` (`PakietID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `egzaminy`
--
ALTER TABLE `egzaminy`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lekcje`
--
ALTER TABLE `lekcje`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pakiety`
--
ALTER TABLE `pakiety`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `samochody`
--
ALTER TABLE `samochody`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `zakupionepakiety`
--
ALTER TABLE `zakupionepakiety`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `egzaminy`
--
ALTER TABLE `egzaminy`
  ADD CONSTRAINT `egzaminy_ibfk_1` FOREIGN KEY (`UczenID`) REFERENCES `uzytkownicy` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `lekcje`
--
ALTER TABLE `lekcje`
  ADD CONSTRAINT `lekcje_ibfk_1` FOREIGN KEY (`InstruktorID`) REFERENCES `uzytkownicy` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `lekcje_ibfk_2` FOREIGN KEY (`ZakupionyPakietID`) REFERENCES `zakupionepakiety` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `lekcje_ibfk_3` FOREIGN KEY (`SamochodID`) REFERENCES `samochody` (`ID`) ON DELETE SET NULL;

--
-- Constraints for table `zakupionepakiety`
--
ALTER TABLE `zakupionepakiety`
  ADD CONSTRAINT `zakupionepakiety_ibfk_1` FOREIGN KEY (`UczenID`) REFERENCES `uzytkownicy` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `zakupionepakiety_ibfk_2` FOREIGN KEY (`PakietID`) REFERENCES `pakiety` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
