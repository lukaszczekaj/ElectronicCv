-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 11 Cze 2017, 15:08
-- Wersja serwera: 5.5.55-0ubuntu0.14.04.1
-- Wersja PHP: 5.6.30-11+deb.sury.org~trusty+3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `electroniccv`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `additional_skills`
--

CREATE TABLE IF NOT EXISTS `additional_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `appRole`
--

CREATE TABLE IF NOT EXISTS `appRole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(45) DEFAULT NULL,
  `roleName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `appRole`
--

INSERT INTO `appRole` (`id`, `alias`, `roleName`) VALUES
(1, 'Administrator', 'admin'),
(2, 'Użytkownik', 'user');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cv`
--

CREATE TABLE IF NOT EXISTS `cv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `interests` text,
  `pdf_layout` int(11) DEFAULT NULL,
  `list_education` text,
  `list_workplace` text,
  `list_additional_skills` text,
  `list_languages` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `education`
--

CREATE TABLE IF NOT EXISTS `education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `date_of` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Zrzut danych tabeli `education`
--

INSERT INTO `education` (`id`, `userid`, `date_of`, `date_to`, `description`) VALUES
(5, 1, '2017-07-01 12:06:53', '2017-07-04 12:06:53', 'asdasd'),
(6, 1, '2017-06-21 12:10:05', '2017-06-21 12:10:05', 'sdfsdf'),
(7, 1, '2017-06-07 12:11:27', '2017-06-27 12:11:27', 'asdsad'),
(9, 1, '2017-06-15 13:03:10', '2017-06-22 13:03:10', 'www');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL,
  `imageUrl` text,
  `dateRegister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateLastLogon` datetime DEFAULT NULL,
  `birthDate` datetime DEFAULT NULL,
  `maritalStatus` varchar(255) DEFAULT NULL,
  `birthPlace` varchar(255) DEFAULT NULL,
  `addressStreet` varchar(255) DEFAULT NULL,
  `addressPost` varchar(255) DEFAULT NULL,
  `appRoleId` int(1) NOT NULL DEFAULT '2',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `authToken` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `mail`, `pass`, `firstName`, `lastName`, `imageUrl`, `dateRegister`, `dateLastLogon`, `birthDate`, `maritalStatus`, `birthPlace`, `addressStreet`, `addressPost`, `appRoleId`, `status`, `authToken`) VALUES
(1, 'test@test.pl', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Tester', 'Testowy', NULL, '2017-06-11 12:52:06', NULL, '1991-06-01 15:04:44', 'Kawaler', 'Kielce', 'Zagórska 72', '23-324 Kielce', 2, 1, 'dfa7d9dbbb9a99989416827a14890e61');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `workplace`
--

CREATE TABLE IF NOT EXISTS `workplace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `date_of` timestamp NULL DEFAULT NULL,
  `date_to` timestamp NULL DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
