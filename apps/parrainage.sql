-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 22 mars 2021 à 00:25
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `parrainage`
--

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

DROP TABLE IF EXISTS `filieres`;
CREATE TABLE IF NOT EXISTS `filieres` (
  `id_fil` int(3) NOT NULL AUTO_INCREMENT,
  `sigle_fil` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desig_fil` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_fil`),
  UNIQUE KEY `sigle_fil` (`sigle_fil`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `filieres`
--

INSERT INTO `filieres` (`id_fil`, `sigle_fil`, `desig_fil`) VALUES
(1, 'IDA', 'Informatique Développeur d\'Application'),
(2, 'FCGE', 'Finance Comptabilité et Gestion des Entreprises'),
(3, 'RIT', 'Réseaux Informatique et Télécommunication'),
(4, 'ATPA', 'Agriculture Tropicale Production Animale'),
(5, 'ATPV', 'Agriculture Tropicale Production Végétale'),
(6, 'ELT', 'Électrotechnique'),
(7, 'GEC', 'Gestion Commerciale'),
(8, 'IACC', '');

-- --------------------------------------------------------

--
-- Structure de la table `filleuls`
--

DROP TABLE IF EXISTS `filleuls`;
CREATE TABLE IF NOT EXISTS `filleuls` (
  `mat_filleul` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_filleul` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pre_filleul` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `niv_filleul` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_filleul` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filiere_filleul` int(3) NOT NULL,
  `ecole_filleul` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`mat_filleul`),
  UNIQUE KEY `photo_filleul` (`photo_filleul`(40))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `filleuls`
--

INSERT INTO `filleuls` (`mat_filleul`, `nom_filleul`, `pre_filleul`, `niv_filleul`, `photo_filleul`, `filiere_filleul`, `ecole_filleul`) VALUES
('2020etc065', 'KOFFI', 'Gerard', '1ere année', 'DSC_0160.jpg', 1, 'ESETEC'),
('2019ETC005', 'fofana', 'abou', '1ere année', 'photo2 (1).jpg', 3, 'ESETEC'),
('2020ETC003', 'KOFFI', 'ANNAN', '1ere année', 'DSC_0559.jpg', 1, 'ESETEC'),
('2020ETC004', 'KOFFI', 'ANNAN', '1ere année', 'DSC_0557.jpg', 1, 'ESETEC');

-- --------------------------------------------------------

--
-- Structure de la table `parrainer`
--

DROP TABLE IF EXISTS `parrainer`;
CREATE TABLE IF NOT EXISTS `parrainer` (
  `id_parrainer` int(11) NOT NULL AUTO_INCREMENT,
  `mat_filleul` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mat_parrain` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filiere_parrainage` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_parrainer`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `parrainer`
--

INSERT INTO `parrainer` (`id_parrainer`, `mat_filleul`, `mat_parrain`, `filiere_parrainage`) VALUES
(1, '2020ETC001', '2019ETC114', 'IDA'),
(2, '2020ETC002', '2019ETC115', 'IDA');

-- --------------------------------------------------------

--
-- Structure de la table `parrains`
--

DROP TABLE IF EXISTS `parrains`;
CREATE TABLE IF NOT EXISTS `parrains` (
  `mat_parrain` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_parrain` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pre_parrain` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `niv_parrain` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_parrain` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filiere_parrain` int(3) NOT NULL,
  `ecole_parrain` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`mat_parrain`),
  UNIQUE KEY `photo_par` (`photo_parrain`(40))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `parrains`
--

INSERT INTO `parrains` (`mat_parrain`, `nom_parrain`, `pre_parrain`, `niv_parrain`, `photo_parrain`, `filiere_parrain`, `ecole_parrain`) VALUES
('2019ETC001', 'kone', 'ismael', '2e année', 'DSC_0473.jpg', 3, 'ESETEC'),
('2020ETC007', 'ouatt', 'kam', '2e année', 'DSC_0200.jpg', 1, 'ESETEC'),
('2019ETC005', 'Kone', 'rosine', '2e année', 'DSC_0157.jpg', 1, 'ESETEC');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int(2) NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_utilisateur` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_utilisateur` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass_utilisateur` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel_utilisateur` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email_utilisateur` (`email_utilisateur`),
  UNIQUE KEY `pass_utilisateur` (`pass_utilisateur`),
  UNIQUE KEY `tel_utilisateur` (`tel_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom_utilisateur`, `prenom_utilisateur`, `email_utilisateur`, `pass_utilisateur`, `tel_utilisateur`) VALUES
(1, 'SORO', 'ADAMA', 'soroadama182@gmail.com', '$2y$10$fJ2nrQudZs8c9NZSm.BCZ.GJ/I4HxGngHaig5zo4Nl9SBnSz21EGa', '0759814793'),
(2, 'Satifu Owade ', 'Alexia Rainan', 'alexiaowade7@gmail.com', '$2y$10$3N.DdrZ1cM6m0q9xp1DLx.aDwoaLoP4Gv5mCPmxt68bk9q2PRzWwu', '0788807654');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
