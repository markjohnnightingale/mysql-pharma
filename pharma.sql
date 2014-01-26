-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2014 at 06:55 PM
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
  `prenom` char(20) NOT NULL,
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

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`no_client`, `civilite`, `nom`, `prenom`, `date_naissance`, `adresse`, `code_postal`, `ville`, `tel`, `email`, `no_insee`, `caisse`, `mutuelle`) VALUES
('AMEL854712', 'Mme', 'Viviane', 'AMELLAL', '1987-12-23', '33, impasse Sandrié', '75004', 'Paris', '0178741251', 'viviamea@orange.fr', '287127589665741', 'CPAM Ile-De-France', 'Matmut'),
('CERC032411', 'Mme', 'Marie-Isabelle', 'CERCOTTE', '1952-06-05', '164, rue Maurice-Denis', '67450', 'Mundolseim', '0365412778', '', '252066741225798', 'CPAM Bas-Rhin', 'Mutuelle Complémentaire d''Alsace'),
('DESC001465', 'Mr.', 'Patrice ', 'Deschamps', '1990-11-06', '15, rue de Steinkerque', '67500', 'Mertzwiller', '0396005472', 'pdeschamps67@laposte.net', '190116784156997', 'CPAM Bas-Rhin', 'Novamut'),
('DURA785474', 'Mme', 'Durand', 'Nathalie', '1969-05-04', '14, Place Broglie', '67000', 'Strasbourg', '0389320045', 'ndurand@gmail.com', '269054959815780', 'CPAM Bas-Rhin', 'MMA'),
('LEMO778564', 'Mr.', 'Thibault ', 'Lemoine', '1954-04-17', '220, rue André-Colledeboeuf', '35000', 'Rennes', '0245869711', '', '154043578541069', 'CPAM Ille-et-Vilaine', 'MAAF');

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `client` char(10) NOT NULL,
  `mode_reglement` enum('cb','cheque','especes') NOT NULL,
  `statut` enum('Validé','En attente des stocks') NOT NULL DEFAULT 'Validé',
  PRIMARY KEY (`id_commande`),
  KEY `client_2` (`client`),
  KEY `client_3` (`client`),
  KEY `client_4` (`client`),
  KEY `client` (`client`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`id_commande`, `date`, `client`, `mode_reglement`, `statut`) VALUES
(1, '2014-01-25 17:58:22', 'DESC001465', 'cheque', 'Validé'),
(2, '2014-01-25 18:03:54', 'DURA785474', 'cheque', 'Validé'),
(3, '2014-01-25 18:14:12', 'DURA785474', 'cheque', 'Validé'),
(4, '2014-01-25 18:16:43', 'DURA785474', 'cheque', 'Validé'),
(5, '2014-01-25 18:17:12', 'DURA785474', 'cheque', 'Validé'),
(6, '2014-01-25 18:34:16', 'DURA785474', 'cheque', 'Validé'),
(7, '2014-01-25 18:42:50', 'DURA785474', 'cb', 'Validé'),
(8, '2014-01-25 18:44:47', 'DURA785474', 'cb', 'Validé'),
(9, '2014-01-25 18:45:36', 'DURA785474', 'cb', 'Validé'),
(10, '2014-01-25 18:45:54', 'DURA785474', 'cb', 'Validé'),
(11, '2014-01-25 18:46:06', 'DURA785474', 'cb', 'Validé'),
(12, '2014-01-25 18:46:42', 'DURA785474', 'especes', 'Validé'),
(13, '2014-01-25 18:50:53', 'DURA785474', 'especes', 'Validé'),
(14, '2014-01-25 18:51:44', 'DURA785474', 'especes', 'Validé'),
(15, '2014-01-25 18:52:00', 'DURA785474', 'especes', 'Validé'),
(16, '2014-01-25 19:39:15', 'DESC001465', 'cheque', 'Validé'),
(17, '2014-01-25 19:41:07', 'DESC001465', 'cheque', 'Validé'),
(18, '2014-01-25 19:43:21', 'DESC001465', 'cheque', 'Validé'),
(19, '2014-01-25 19:43:30', 'DESC001465', 'cheque', 'Validé'),
(20, '2014-01-25 19:44:43', 'CERC032411', 'cheque', 'Validé'),
(21, '2014-01-25 19:47:46', 'DESC001465', 'cb', 'Validé'),
(22, '2014-01-25 19:53:30', 'DESC001465', 'cb', 'Validé'),
(23, '2014-01-25 19:53:51', 'LEMO778564', 'cb', 'Validé'),
(24, '2014-01-25 21:34:12', 'DURA785474', 'cb', 'Validé'),
(25, '2014-01-26 16:21:06', 'LEMO778564', 'cheque', 'Validé'),
(26, '2014-01-26 16:23:44', 'DURA785474', 'cheque', 'Validé'),
(27, '2014-01-26 16:31:47', 'DURA785474', 'cb', 'Validé'),
(28, '2014-01-26 16:32:10', 'LEMO778564', 'cb', 'Validé'),
(29, '2014-01-26 18:07:01', 'DESC001465', 'cheque', 'Validé'),
(30, '2014-01-26 19:22:39', 'DESC001465', 'cheque', 'Validé');

-- --------------------------------------------------------

--
-- Table structure for table `commande_medicaments`
--

CREATE TABLE IF NOT EXISTS `commande_medicaments` (
  `id_relation` int(10) NOT NULL AUTO_INCREMENT,
  `id_commande` int(10) unsigned NOT NULL,
  `id_med` char(10) NOT NULL,
  `qte` smallint(6) NOT NULL,
  PRIMARY KEY (`id_relation`),
  KEY `id_med` (`id_med`),
  KEY `id_commande` (`id_commande`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `commande_medicaments`
--

INSERT INTO `commande_medicaments` (`id_relation`, `id_commande`, `id_med`, `qte`) VALUES
(1, 16, 'DURE764889', 1),
(2, 17, 'DURE764889', 1),
(3, 18, 'DURE764889', 1),
(4, 19, 'DURE764889', 1),
(5, 20, 'DURE764889', 1),
(6, 21, 'INON775819', 1),
(7, 22, 'INON775819', 1),
(8, 23, 'CALP201334', 1),
(9, 24, 'ADVI856574', 12),
(10, 24, 'CALP201345', 1),
(11, 24, 'EXOM445691', 1),
(12, 24, 'HUME201334', 1),
(13, 25, 'EXOM445691', 1),
(14, 26, 'ADVI856574', 3),
(15, 26, 'EXOM445691', 4),
(16, 27, 'CALP201345', 1),
(17, 27, 'MAXI245563', 1),
(18, 28, 'DOLI234098', 6),
(19, 29, 'INON775819', 2),
(20, 30, 'MAXI245563', 3),
(21, 30, 'DURE764889', 81),
(22, 30, 'DOLI234098', 7);

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
('ARRO785496', 'Arrow Generiques', 'Mr. Requin', '26 avenue Tony Garnier ', '69007', 'Lyon', '0472726072', 'arrow@arrow-generiques.com '),
('BIOG775869', 'BIOGARAN', 'Mr. Lenoir', '15 boulevard Charles de Gaulle', '92707', 'Colombes Cedex', '0155724100', 'rlenoir@biogaran.net'),
('EGLA125486', 'EG LABO', 'Mme Lavoie', '12 rue Danjou - Bâtiment A Le Quintet', '92100', 'Boulogne-Billancourt', '0146948686', 'contact@eglabo.com '),
('GIFR566311', 'GIFRER BARBEZAT', 'Mme Barbezat', '8-10 rue Paul Bert', '69153', 'Décines Cedex', '0472933434', ''),
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
('ADVI856574', 'AdvilTab', 'Ibuprofène', 'Ibuprofène ', 3.15, 45, 'BIOG775869', 'Fièvre, Douleurs'),
('BENA456722', 'Benadryl', 'Cétrazine', 'Cétrazine 5mg', 4.56, 1, 'GIFR566311', 'Rhume des foins, réaction allergiques, allergies'),
('CALP201334', 'Calpol Junior', 'Paracétamol', 'Paracétamol 100mg', 3.89, 22, 'ARRO785496', 'Douleurs chez l''enfant, fièvre'),
('CALP201345', 'Calpol', 'Paracétamol', 'Paracétamol 50mg', 2.33, 22, 'GLAX010203', 'Douleurs chez l''enfant, fièvre'),
('DEXE847562', 'Dexeryl', '', 'Glycérol', 4.39, 2, 'ARRO785496', 'Sécheresse cutanée, brûlures superficielles'),
('DOLI234098', 'Doliprane', 'Paracétamol', 'Paracétamol', 4.2, 0, 'EGLA125486', 'Douleurs'),
('DURE764889', 'Durex Play', 'Préservatif', 'Préservatif', 6.57, 81, 'GLAX010203', 'Contraceptif'),
('ESBE533624', 'Esberiven Fort', '', 'SALICYLATE DE METHYLE', 8.5, 16, 'GIFR566311', 'Troubles veineux'),
('EUPH002356', 'Euphytose', '', 'Valériane', 5.2, 10, 'BIOG775869', 'Troubles mineurs de l''anxiété et du sommeil '),
('EXOM445691', 'Exomuc', 'Acétylcystéïne B', 'N-Acétylcystéine', 3.5, 12, 'BIOG775869', 'Bronchites'),
('HUME201334', 'HUMEX', 'N/A', 'Paracétamol 100mg et Codeine 50mg', 7.87, 14, 'GLAX010203', 'Toux sèche et fièvre, états graippaux'),
('INON775819', 'Inongan', '', 'SALICYLATE DE METHYLE', 5, 0, 'GIFR566311', 'Douleurs d''origine musculaire et tendino-ligamentaire'),
('MAXI245563', 'Maxilase', 'Alfa-Amylase ', 'Alpha-Amylase', 3.5, 5, 'EGLA125486', 'Maux de gorge'),
('PRON885687', 'Prontalgine', 'Paracétamol', 'Paracétamol', 4.6, 21, 'ARRO785496', 'Douleurs d''intensité modérée'),
('TYLE154876', 'Tylenol ASP', 'Asperine', 'Aspérine', 2.44, 7, 'BIOG775869', 'Mal de tête');

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
  ADD CONSTRAINT `commande_medicaments_ibfk_4` FOREIGN KEY (`id_med`) REFERENCES `medicament` (`id_med`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_medicaments_ibfk_5` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicament`
--
ALTER TABLE `medicament`
  ADD CONSTRAINT `medicament_ibfk_1` FOREIGN KEY (`fournisseur`) REFERENCES `fournisseur` (`id_fournisseur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
