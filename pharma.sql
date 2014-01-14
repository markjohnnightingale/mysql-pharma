-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2014 at 08:44 AM
-- Server version: 5.6.7-rc
-- PHP Version: 5.5.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pharma`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `no_client` char(10) NOT NULL,
  `civilite` char(5) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` int(11) NOT NULL,
  `date_naissance` date NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `code_postal` char(5) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `tel` char(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_insee` char(15) NOT NULL,
  `caisse` varchar(255) NOT NULL,
  `mutuelle` varchar(255) NOT NULL,
  PRIMARY KEY (`no_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` char(10) NOT NULL,
  `date` datetime NOT NULL,
  `client` char(10) NOT NULL,
  `mode_reglement` varchar(4) NOT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `client_2` (`client`),
  KEY `client_3` (`client`),
  KEY `client_4` (`client`),
  KEY `client` (`client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `commande_medicaments`
--

CREATE TABLE IF NOT EXISTS `commande_medicaments` (
  `id_commande` char(10) NOT NULL,
  `id_med` char(10) NOT NULL,
  `qte` smallint(6) NOT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `id_med` (`id_med`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fournisseur`
--

CREATE TABLE IF NOT EXISTS `fournisseur` (
  `id_fournisseur` varchar(10) NOT NULL,
  `nom_fournisseur` varchar(255) NOT NULL,
  `personne_contact` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `code_postal` char(5) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `tel` char(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id_fournisseur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fournisseur`
--

INSERT INTO `fournisseur` (`id_fournisseur`, `nom_fournisseur`, `personne_contact`, `adresse`, `code_postal`, `ville`, `tel`, `email`) VALUES
('GLAX010203', 'Glaxo Smithklein', 'Mr. Glaxo', 'Glaxo Smithklein Place', '87512', 'LILLE CEDEX', '0189554725', 'commandes@glaxosmithklein.fr');

-- --------------------------------------------------------

--
-- Table structure for table `medicament`
--

CREATE TABLE IF NOT EXISTS `medicament` (
  `id_med` char(10) NOT NULL DEFAULT '',
  `nom_med` varchar(255) DEFAULT NULL,
  `equiv_generique` varchar(255) DEFAULT NULL,
  `agents_actifs` varchar(255) DEFAULT NULL,
  `prix` double DEFAULT NULL,
  `stock` smallint(6) DEFAULT NULL,
  `fournisseur` char(10) DEFAULT NULL,
  `maladie_traitee` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_med`),
  KEY `fournisseur` (`fournisseur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicament`
--

INSERT INTO `medicament` (`id_med`, `nom_med`, `equiv_generique`, `agents_actifs`, `prix`, `stock`, `fournisseur`, `maladie_traitee`) VALUES
('ASPR154876', 'Tylenol ASP', 'Asperine', 'Aspérine', 2.44, 7, 'GLAX010203', 'Mal de tête'),
('BENA456722', 'Benadryl', 'Cétrazine', 'Cétrazine 5mg', 4.56, 1, 'GLAX010203', 'Foin de rhume, réaction allergiques, allérgies'),
('CALP201334', 'Calpol Junior', 'Paracétamol', 'Paracétamol 100mg', 3.89, 23, 'GLAX010203', 'Douleurs chez l''enfant, fièvre'),
('CALP201345', 'Calpol', 'Paracétamol', 'Paracétamol 50mg', 2.33, 23, 'GLAX010203', 'Douleurs chez l''enfant, fièvre'),
('DOLI234098', 'Doliprane', 'Paracétamol', 'Paracétamol', 4.2, 0, 'GLAX010203', 'Douleurs'),
('DURE764889', 'Durex Play', 'Préservatif', 'Préservatif', 6.57, 87, 'GLAX010203', 'Contraceptif'),
('HUME201334', 'HUMEX', 'N/A', 'Paracétamol 100mg et Codeine 50mg', 7.87, 1, 'GLAX010203', 'Toux sèche et fièvre, états graippaux');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`client`) REFERENCES `clients` (`no_client`);

--
-- Constraints for table `commande_medicaments`
--
ALTER TABLE `commande_medicaments`
  ADD CONSTRAINT `commande_medicaments_ibfk_3` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_medicaments_ibfk_4` FOREIGN KEY (`id_med`) REFERENCES `medicament` (`id_med`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicament`
--
ALTER TABLE `medicament`
  ADD CONSTRAINT `medicament_ibfk_1` FOREIGN KEY (`fournisseur`) REFERENCES `fournisseur` (`id_fournisseur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
