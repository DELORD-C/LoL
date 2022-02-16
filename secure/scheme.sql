-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 16 fév. 2022 à 02:09
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lolapi`
--

-- --------------------------------------------------------

--
-- Structure de la table `champions`
--

DROP TABLE IF EXISTS `champions`;
CREATE TABLE IF NOT EXISTS `champions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `champion-key` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `attack` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `magic` int(11) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `full` varchar(255) NOT NULL,
  `sprite` varchar(255) NOT NULL,
  `tags` text NOT NULL,
  `energy` varchar(255) NOT NULL,
  `lore` text NOT NULL,
  `allytips` text NOT NULL,
  `enemytips` text NOT NULL,
  `stats` text NOT NULL,
  `skins` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2509 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item-id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `plaintext` varchar(255) DEFAULT NULL,
  `item-into` text,
  `full` varchar(255) DEFAULT NULL,
  `sprite` varchar(255) DEFAULT NULL,
  `gold` int(11) DEFAULT NULL,
  `tags` text,
  `stats` text,
  `depth` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1607 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `spells`
--

DROP TABLE IF EXISTS `spells`;
CREATE TABLE IF NOT EXISTS `spells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `champion-key` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id-spell` varchar(255) DEFAULT NULL,
  `description` text,
  `tooltip` text,
  `leveltip` text,
  `maxrank` int(11) DEFAULT NULL,
  `cooldown` text,
  `cooldownBurn` text,
  `cost` text,
  `costBurn` text,
  `datavalues` text,
  `effect` text,
  `effectBurn` text,
  `vars` text,
  `costType` varchar(255) DEFAULT NULL,
  `maxammo` text,
  `spellrange` text,
  `rangeBurn` text,
  `full` varchar(255) DEFAULT NULL,
  `sprite` varchar(255) DEFAULT NULL,
  `ressource` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12377 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
