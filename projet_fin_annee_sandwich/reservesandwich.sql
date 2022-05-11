-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 11 mai 2022 à 06:56
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
-- Base de données : `reservesandwich`
--

-- --------------------------------------------------------

--
-- Structure de la table `accueil`
--

DROP TABLE IF EXISTS `accueil`;
CREATE TABLE IF NOT EXISTS `accueil` (
  `id_accueil` int(11) NOT NULL,
  `texte_accueil` text NOT NULL,
  `lien_pdf` varchar(255) NOT NULL,
  PRIMARY KEY (`id_accueil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `accueil`
--

INSERT INTO `accueil` (`id_accueil`, `texte_accueil`, `lien_pdf`) VALUES
(1, 'lalala *hymne* !!!', 'Rappels_Python.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `boisson`
--

DROP TABLE IF EXISTS `boisson`;
CREATE TABLE IF NOT EXISTS `boisson` (
  `id_boisson` int(11) NOT NULL AUTO_INCREMENT,
  `nom_boisson` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dispo_boisson` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_boisson`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `boisson`
--

INSERT INTO `boisson` (`id_boisson`, `nom_boisson`, `dispo_boisson`) VALUES
(1, 'Coca-Cola', 1),
(2, 'Fanta', 1),
(3, 'Eau', 1),
(4, 'Sprite', 1),
(5, 'SevenUp', 1),
(6, 'Coca-Cherry', 1);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_com` int(11) NOT NULL AUTO_INCREMENT,
  `fk_user_id` int(11) NOT NULL,
  `fk_sandwich_id` int(11) NOT NULL,
  `fk_boisson_id` int(11) NOT NULL,
  `fk_dessert_id` int(11) NOT NULL,
  `chips_com` tinyint(1) NOT NULL,
  `date_heure_com` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_heure_livraison_com` datetime NOT NULL,
  `annule_com` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_com`),
  KEY `IDX_B15F29ADCF8EC6B0` (`fk_sandwich_id`),
  KEY `IDX_B15F29AD10326266` (`fk_boisson_id`),
  KEY `IDX_B15F29AD83C52771` (`fk_dessert_id`),
  KEY `IDX_B15F29AD996F9D6F` (`fk_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_com`, `fk_user_id`, `fk_sandwich_id`, `fk_boisson_id`, `fk_dessert_id`, `chips_com`, `date_heure_com`, `date_heure_livraison_com`, `annule_com`) VALUES
(1, 1, 1, 1, 1, 1, '2022-04-12 14:20:36', '2022-04-11 16:20:00', 0),
(3, 1, 3, 3, 3, 0, '2022-04-11 13:50:07', '2022-04-04 10:28:00', 0),
(4, 1, 3, 2, 5, 1, '2022-04-12 08:39:06', '2022-04-12 11:40:00', 0),
(5, 1, 2, 3, 2, 1, '2022-04-13 14:14:03', '2022-04-22 13:10:00', 0),
(6, 1, 2, 2, 4, 0, '2022-04-28 09:24:19', '2022-04-29 11:24:00', 0),
(7, 1, 2, 4, 3, 1, '2022-04-13 15:20:11', '2022-04-21 02:47:00', 1),
(8, 2, 3, 6, 1, 1, '2022-04-12 09:26:31', '2022-04-18 11:00:00', 0),
(9, 1, 3, 6, 1, 1, '2022-04-12 13:54:17', '2022-04-13 16:00:00', 1),
(10, 1, 3, 5, 2, 0, '2022-04-13 15:20:27', '2022-04-15 10:20:00', 0),
(11, 1, 2, 3, 3, 0, '2022-05-02 08:20:13', '2022-05-06 10:20:00', 0),
(12, 1, 1, 1, 1, 0, '2022-05-02 08:27:18', '2022-05-06 10:27:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `dessert`
--

DROP TABLE IF EXISTS `dessert`;
CREATE TABLE IF NOT EXISTS `dessert` (
  `id_dessert` int(11) NOT NULL AUTO_INCREMENT,
  `nom_dessert` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dispo_dessert` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_dessert`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `dessert`
--

INSERT INTO `dessert` (`id_dessert`, `nom_dessert`, `dispo_dessert`) VALUES
(1, 'Cookie', 1),
(2, 'Brownie', 1),
(3, 'Donut\'s', 1),
(4, 'Beignet pomme', 1),
(5, 'Beignet chocolat', 1);

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

DROP TABLE IF EXISTS `historique`;
CREATE TABLE IF NOT EXISTS `historique` (
  `id_hist` int(11) NOT NULL AUTO_INCREMENT,
  `dateDebut_hist` date NOT NULL,
  `dateFin_hist` date NOT NULL,
  `dateInsertion_hist` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id_hist`),
  KEY `fk_user_id` (`fk_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `historique`
--

INSERT INTO `historique` (`id_hist`, `dateDebut_hist`, `dateFin_hist`, `dateInsertion_hist`, `fk_user_id`) VALUES
(101, '2022-04-04', '2022-05-06', '2022-05-09 12:04:26', 1),
(102, '2022-04-18', '2022-04-18', '2022-05-09 12:01:30', 2);

-- --------------------------------------------------------

--
-- Structure de la table `sandwich`
--

DROP TABLE IF EXISTS `sandwich`;
CREATE TABLE IF NOT EXISTS `sandwich` (
  `id_sandwich` int(11) NOT NULL AUTO_INCREMENT,
  `nom_sandwich` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dispo_sandwich` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_sandwich`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sandwich`
--

INSERT INTO `sandwich` (`id_sandwich`, `nom_sandwich`, `dispo_sandwich`) VALUES
(1, 'Sandwich Jambon', 1),
(2, 'Sandwich Poulet', 1),
(3, 'Sandwich Thon', 1),
(4, 'Sandwich Crudités', 1),
(5, 'Panini', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `role_user` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_user` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active_user` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email_user` (`email_user`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_user`, `role_user`, `email_user`, `password_user`, `nom_user`, `prenom_user`, `active_user`) VALUES
(1, 'b', 'test1@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$bGtVdkwwOGt4d0U0bHdoUg$YShQbp9gsDnNEV/xXv0bEekvWHft2YkPp58KRRZb9Lg', 'user', 'test', 1),
(2, 'b', 'test@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$bGtVdkwwOGt4d0U0bHdoUg$YShQbp9gsDnNEV/xXv0bEekvWHft2YkPp58KRRZb9Lg', 'mathon', 'sélafaim', 1),
(3, 'b', 'test2@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$bGtVdkwwOGt4d0U0bHdoUg$YShQbp9gsDnNEV/xXv0bEekvWHft2YkPp58KRRZb9Lg', 'mkdir', 'touch', 1),
(4, 'a', 'administrateur@wanadoo.fr', '$argon2i$v=19$m=65536,t=4,p=1$bGtVdkwwOGt4d0U0bHdoUg$YShQbp9gsDnNEV/xXv0bEekvWHft2YkPp58KRRZb9Lg', 'idasiak', 'mickael', 1),
(13, 'b', 'okok@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$QUl3Qm05L1M5N0tNcVBhcg$pOsbyX+GPXaYH5S5IgdDAs3ZClL0IFOpXdenD1K2D3o', 'ok', 'ko', 1),
(14, 'b', 'testok@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$ZEVlelZkNEkyVVM1NXcvNg$FQmh8dJS5DlzAmEnwBh1g005v4G0T25tmnvNVcs78HU', 'tgtbyh', 'uyghbnj', 1),
(15, 'b', 'lepetitrigolodu69@gpt.cum', '$argon2i$v=19$m=65536,t=4,p=1$TnVNb1dERHovV2tCZjNocw$yiXfrnm2nTahh726nQQ5y6l5/reWOLO8kr961y/Qwr0', 'GOntrand', 'pzgrv', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_B15F29AD10326266` FOREIGN KEY (`fk_boisson_id`) REFERENCES `boisson` (`id_boisson`),
  ADD CONSTRAINT `FK_B15F29AD83C52771` FOREIGN KEY (`fk_dessert_id`) REFERENCES `dessert` (`id_dessert`),
  ADD CONSTRAINT `FK_B15F29AD996F9D6F` FOREIGN KEY (`fk_user_id`) REFERENCES `utilisateur` (`id_user`),
  ADD CONSTRAINT `FK_B15F29ADCF8EC6B0` FOREIGN KEY (`fk_sandwich_id`) REFERENCES `sandwich` (`id_sandwich`);

--
-- Contraintes pour la table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`fk_user_id`) REFERENCES `utilisateur` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
