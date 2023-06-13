-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 13 juin 2023 à 22:21
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `leboncoin`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

DROP TABLE IF EXISTS `annonces`;
CREATE TABLE IF NOT EXISTS `annonces` (
  `annonce_id` int(11) NOT NULL AUTO_INCREMENT,
  `annonce_titre` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `prix` int(11) NOT NULL,
  `annonce_date` datetime NOT NULL,
  `categories_categorie_id` int(11) NOT NULL,
  `users_user_id` int(11) NOT NULL,
  PRIMARY KEY (`annonce_id`),
  KEY `FK_users_annonces` (`users_user_id`),
  KEY `FK_categories_annonces` (`categories_categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `annonces`
--

INSERT INTO `annonces` (`annonce_id`, `annonce_titre`, `description`, `prix`, `annonce_date`, `categories_categorie_id`, `users_user_id`) VALUES
(32, 'PS5', 'PS5 édition exceptionnelle dans sa boite d\'origine en parfait état !', 700, '2022-12-03 14:16:22', 5, 14),
(33, 'IPhone 13', 'Vend IPhone 13 couleur Midnight très bon état, vendu avec la vitre de protection avant déjà sur le téléphone.\n\nVendu avec sa boîte d’origine et ses écouteurs sans fil', 650, '2022-12-03 14:30:08', 5, 14),
(34, 'Rolex Oyster Perpetual', 'Bonjour,\r\n\r\nJe vends cette magnifique Rolex Oyster Perpetual neuve, achetée chez un revendeur agréé en 2022. C’est une première main, j’ai les documents d’origines, ainsi que la facture.\r\nJe fonctionnement uniquement par un échange en physique avec un paiement par virement instantané au moment de la remise de la montre.\r\n\r\nDESCRIPTION DU PRODUIT\r\n\r\nMARQUE : Rolex\r\nMODELE : Oyster Perpetual 41mm\r\nREFERENCE : 124300 Cadran bleu vif\r\nANNEE : 2022\r\nCONTENU : Full Set\r\n\r\nJe reste disponible si vous avez la moindre question,\r\nBien cordialement', 11500, '2022-12-05 10:14:47', 3, 15),
(35, 'VTT ST100 ROCKRIDER neuf', 'Vélo VTT ST100 ROCKRIDER taille L à vendre en très bon état (neuf), il vient d\'être récupérer en magasin ! + casque offert .\r\nPrix négociable ! Pour plus d\'informations contactez moi !', 310, '2022-12-05 10:15:58', 8, 15),
(36, 'Jeans mom neuf Femme taille 38', 'jeans neuf, taille 38', 10, '2022-12-05 10:19:13', 3, 17),
(37, 'Casque bluetooth JBL', 'Casque bluetooth supra-auriculaire JBL E45BT noir.\r\nJe vends ce casque sans fil que je n’ai presque pas utilisé, il est en excellent état, il y a bien sûre le câble de chargement mais également le câble jack qui permet de le brancher à un téléphone si besoin.\r\nLe casque est léger et confortable et l’autonomie de la batterie est comme neuve(~16h). Le casque est également équipé d’un micro pour passer des appels.\r\n\r\nprix neuf : 80€', 50, '2022-12-05 10:22:00', 5, 16),
(38, 'Aspirateur balai Rowenta', 'Aspirateur sans fil balai de la marque Rowenta\r\nLongue autonomie et fonction boost\r\n\r\nAcheté en Mars 2022\r\nBatterie lithium\r\n\r\nCause cadeau d’un autre aspirateur', 110, '2022-12-05 15:29:53', 4, 15),
(39, 'jouet', 'un jouet Playmobil en bon Ã©tat ', 60, '2022-12-12 22:23:10', 6, 16),
(43, 'h,nytn', 'fghbjn,dnfdhufjn,;', 50, '2022-12-24 15:38:32', 3, 16),
(44, 'BrÃ©', 'Un enfant de deux ans', 2, '2022-12-26 16:28:23', 7, 16);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categorie_id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_titre` varchar(100) NOT NULL,
  PRIMARY KEY (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`categorie_id`, `categorie_titre`) VALUES
(1, 'Vehicules'),
(2, 'Immobilier'),
(3, 'Mode'),
(4, 'Maison'),
(5, 'Multimedia'),
(6, 'Loisirs'),
(7, 'Animaux'),
(8, 'Materiels professionnel'),
(9, 'Divers');

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `id_favoris` int(11) NOT NULL AUTO_INCREMENT,
  `users_user_id` int(11) NOT NULL,
  `annonces_annonce_id` int(11) NOT NULL,
  PRIMARY KEY (`id_favoris`),
  KEY `FK_annonces_favoris` (`annonces_annonce_id`),
  KEY `FK_users_favoris` (`users_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message` longtext NOT NULL,
  `message_date` datetime NOT NULL,
  `annonces_annonce_id` int(11) NOT NULL,
  `expediteur_id` int(11) NOT NULL,
  `destinataire_id` int(11) NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `FK_annonces_messages` (`annonces_annonce_id`),
  KEY `FK_users_messages` (`expediteur_id`) USING BTREE,
  KEY `FK_users_messages2` (`destinataire_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`message_id`, `message`, `message_date`, `annonces_annonce_id`, `expediteur_id`, `destinataire_id`) VALUES
(17, 'Hello le casque est dispo?', '2022-12-05 18:06:32', 37, 15, 16),
(18, 'salut dispo?', '2022-12-05 18:07:05', 37, 14, 16),
(19, 'le jean est dispo?', '2022-12-05 18:51:04', 36, 16, 17),
(20, 'velo dispo?', '2022-12-05 19:04:03', 35, 16, 15),
(21, 'dispo?', '2022-12-05 19:07:02', 38, 16, 15),
(22, 'Salut galdy', '2022-12-12 22:25:15', 39, 14, 16),
(23, 'J\'en veux bien', '2022-12-12 22:30:14', 39, 17, 16);

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE IF NOT EXISTS `photos` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_nom` varchar(50) NOT NULL,
  `annonces_annonce_id` int(11) NOT NULL,
  PRIMARY KEY (`photo_id`),
  KEY `FK_annonces_photos` (`annonces_annonce_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`photo_id`, `photo_nom`, `annonces_annonce_id`) VALUES
(24, 'annonce32_1.jpg', 32),
(25, 'annonce32_2.jpg', 32),
(26, 'annonce32_3.jpg', 32),
(27, 'annonce33_1.jpg', 33),
(28, 'annonce33_2.jpg', 33),
(29, 'annonce33_3.jpg', 33),
(30, 'annonce33_4.jpg', 33),
(31, 'annonce34_1.jpg', 34),
(32, 'annonce34_2.jpg', 34),
(33, 'annonce34_3.jpg', 34),
(34, 'annonce34_4.jpg', 34),
(35, 'annonce35_1.jpg', 35),
(36, 'annonce35_2.jpg', 35),
(37, 'annonce36_1.jpg', 36),
(38, 'annonce36_2.jpg', 36),
(39, 'annonce37_1.jpg', 37),
(40, 'annonce37_2.jpg', 37),
(41, 'annonce37_3.jpg', 37),
(42, 'annonce37_4.jpg', 37),
(43, 'annonce38_1.jpg', 38),
(44, 'annonce38_2.jpg', 38),
(45, 'annonce38_3.jpg', 38),
(46, 'annonce38_4.jpg', 38),
(49, 'annonce39_1.jpg', 39),
(57, 'annonce43_1.jpg', 43),
(58, 'annonce44_1.jpg', 44);

-- --------------------------------------------------------

--
-- Structure de la table `recuperation_mdp`
--

DROP TABLE IF EXISTS `recuperation_mdp`;
CREATE TABLE IF NOT EXISTS `recuperation_mdp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`) VALUES
(14, 'hamed', 'hamed@gmail.com', '$2y$10$OEY2Zv1ducuxJ6Z7vniPiuLoHXNRNL3ArE6HdkwPihMBHLNoQGLPW'),
(15, 'rufus', 'rufus@gmail.com', '$2y$10$d3WlnITVyNBUE2jj2rfI/e5jtDxnU4/lSGKjqKJm60/cFrs6UePW2'),
(16, 'galdy', 'galdy@gmail.com', '$2y$10$NH9QwFScAJoUhdfkqIvSZ.sp4ldYTaYEmaSIr8MeuU6Flcf19wz3m'),
(17, 'emmanuelle', 'emmanuelle@gmail.com', '$2y$10$9Hg/stwhSHUfSyx9lPk4OeCGp/XTyfZLZ/zxO3EnXlwYzmmzEmdE2'),
(18, '', '', '$2y$10$PEFGvNthhy5s4jov2wo/A.yxWhPh4EYgGhwdRnobmQpm.ZotCQ1oK'),
(19, 'brecht', 'brecht.@gmail.com', '$2y$10$nUWb9/WEfb9IFvJFESDvgOPj9Bh4HR5e20e6yvYp52ym7hbAfSqeW');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD CONSTRAINT `FK_categories_annonces` FOREIGN KEY (`categories_categorie_id`) REFERENCES `categories` (`categorie_id`),
  ADD CONSTRAINT `FK_users_annonces` FOREIGN KEY (`users_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `FK_annonces_messages` FOREIGN KEY (`annonces_annonce_id`) REFERENCES `annonces` (`annonce_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_annonces_users` FOREIGN KEY (`expediteur_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_users_messages2` FOREIGN KEY (`destinataire_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `FK_annonces_photos` FOREIGN KEY (`annonces_annonce_id`) REFERENCES `annonces` (`annonce_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
