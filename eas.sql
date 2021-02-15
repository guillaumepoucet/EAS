-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 05 oct. 2020 à 08:40
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `eas`
--

-- --------------------------------------------------------

--
-- Structure de la table `announcement`
--

DROP TABLE IF EXISTS `announcement`;
CREATE TABLE IF NOT EXISTS `announcement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `announcement_title` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `announcement_content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_draft` tinyint(1) NOT NULL,
  `announcement_date` date NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4DB9D91CA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `announcement`
--

INSERT INTO `announcement` (`id`, `announcement_title`, `announcement_content`, `is_draft`, `announcement_date`, `user_id`) VALUES
(13, 'Formation Brain', '<p>Bonjour,</p>\r\n\r\n<p>il reste encore quelques places pour la formation en Brain gym</p>\r\n\r\n<p>(FIN DES INSCRIPTIONS LE 2 OCTOBRE ).</p>\r\n\r\n<p>Possibilit&eacute;s de mettre en place et animer suite &agrave; la formation&nbsp;<strong>des ateliers dynamiques de mouvements parents enfants</strong>&nbsp;ou<strong>&nbsp;avec des enfants&nbsp;</strong>(mais aussi des adultes)</p>\r\n\r\n<p>Merci d&#39;en parler autour de vous et de partager .</p>\r\n\r\n<p>Belle journ&eacute;e,</p>\r\n\r\n<p>Sonia Lobr&eacute;aux, directrice de l&#39;EAS</p>', 1, '2020-10-02', 3),
(14, 'Nouveauté : Massage sportif / formation cranio sacrée informationnelle', '<div style=\"text-align:start\">Bonjour &agrave; toutes et tous.</div>\r\n\r\n<div style=\"text-align:start\">&nbsp;</div>\r\n\r\n<div style=\"text-align:start\">Ci-joint le calendrier&nbsp;de&nbsp;l&#39;&eacute;cole&nbsp;de&nbsp;septembre 2020 &agrave; juin 2021 (nous allons le compl&eacute;ter au fur et &agrave; mesure ) :</div>\r\n\r\n<div style=\"text-align:start\">&nbsp;</div>\r\n\r\n<div style=\"text-align:start\"><strong>Nouveaut&eacute;s : </strong></div>\r\n\r\n<ul>\r\n	<li style=\"text-align:start\"><strong>Massage sportif&nbsp;</strong></li>\r\n	<li style=\"text-align:start\"><strong>Formation en cranio sacr&eacute;e informationnelle</strong></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div style=\"text-align:start\">Pour plus&nbsp;d&#39;informations, nous sommes joignables aux num&eacute;ros ci dessous</div>\r\n\r\n<div style=\"text-align:start\">Vous retrouverez &eacute;galement&nbsp;des&nbsp;informations sur le site&nbsp;de&nbsp;l&#39;&eacute;cole&nbsp;:&nbsp;</div>\r\n\r\n<div style=\"text-align:start\"><a href=\"http://www.ecoledesartsdusouffle.com/\" style=\"color:#1155cc\" target=\"_blank\">www.ecoledesartsdusouffle.com</a></div>\r\n\r\n<div style=\"text-align:start\">&nbsp;</div>\r\n\r\n<div style=\"text-align:start\">Belle fin&nbsp;de&nbsp;journ&eacute;e,</div>\r\n\r\n<div style=\"text-align:start\">&nbsp;</div>\r\n\r\n<div style=\"text-align:start\">Sonia Lobr&eacute;aux, directrice&nbsp;de&nbsp;l&#39;EAS</div>', 0, '2020-10-01', 3);

-- --------------------------------------------------------

--
-- Structure de la table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `course`
--

INSERT INTO `course` (`id`, `course_name`) VALUES
(1, 'Massage californien'),
(2, 'Massage'),
(3, 'Brain gym'),
(6, 'Massage sportif'),
(7, 'Touch');

-- --------------------------------------------------------

--
-- Structure de la table `course_document`
--

DROP TABLE IF EXISTS `course_document`;
CREATE TABLE IF NOT EXISTS `course_document` (
  `course_id` int NOT NULL,
  `document_id` int NOT NULL,
  PRIMARY KEY (`course_id`,`document_id`),
  KEY `IDX_71DDE720591CC992` (`course_id`),
  KEY `IDX_71DDE720C33F7837` (`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `course_document`
--

INSERT INTO `course_document` (`course_id`, `document_id`) VALUES
(1, 38),
(1, 39),
(2, 40),
(3, 38),
(6, 40),
(7, 40);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200814080820', '2020-08-14 08:08:35', 56),
('DoctrineMigrations\\Version20200815101058', '2020-08-15 10:11:07', 46),
('DoctrineMigrations\\Version20200815102917', '2020-08-15 10:29:25', 57),
('DoctrineMigrations\\Version20200817123128', '2020-08-17 12:31:37', 928),
('DoctrineMigrations\\Version20200817132556', '2020-08-18 12:38:48', 791),
('DoctrineMigrations\\Version20200818124309', '2020-08-18 12:43:34', 242),
('DoctrineMigrations\\Version20200818131142', '2020-08-18 13:11:55', 156),
('DoctrineMigrations\\Version20200820071240', '2020-08-20 07:13:18', 2080),
('DoctrineMigrations\\Version20200820071606', '2020-08-20 07:16:11', 163),
('DoctrineMigrations\\Version20200820072126', '2020-08-20 07:21:32', 341),
('DoctrineMigrations\\Version20200820075301', '2020-08-20 07:53:06', 78),
('DoctrineMigrations\\Version20200821081012', '2020-08-21 08:10:27', 749),
('DoctrineMigrations\\Version20200821081551', '2020-08-21 08:15:55', 211),
('DoctrineMigrations\\Version20200821085727', '2020-08-21 08:57:33', 142),
('DoctrineMigrations\\Version20200826143021', '2020-08-26 14:30:53', 50),
('DoctrineMigrations\\Version20200827083511', '2020-08-27 08:35:22', 326),
('DoctrineMigrations\\Version20200830130313', '2020-08-30 13:04:22', 541),
('DoctrineMigrations\\Version20200830145025', '2020-08-30 14:50:30', 681),
('DoctrineMigrations\\Version20200830145108', '2020-08-30 14:51:11', 113),
('DoctrineMigrations\\Version20200830194343', '2020-08-30 19:43:57', 717),
('DoctrineMigrations\\Version20200830195500', '2020-08-30 19:55:05', 241);

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_desc` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` int DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `document`
--

INSERT INTO `document` (`id`, `file_name`, `file_desc`, `file_size`, `file`) VALUES
(38, 'doc-5f5888f564f68.png', 'oijieozjf', NULL, 'C:\\wamp64\\tmp\\phpE230.tmp'),
(39, 'doc-5f589904188a1.png', NULL, NULL, 'C:\\wamp64\\tmp\\php96B6.tmp'),
(40, 'doc-5f5a1b7bbef73.png', NULL, NULL, 'C:\\wamp64\\tmp\\php44BD.tmp'),
(41, 'doc-5f5a1c03c4273.gif', NULL, NULL, 'C:\\wamp64\\tmp\\php5813.tmp');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int DEFAULT NULL,
  `img_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045F4B89032C` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `recipient_id` int NOT NULL,
  `message_content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_date` datetime NOT NULL,
  `is_reported` tinyint(1) NOT NULL,
  `read_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FF624B39D` (`sender_id`),
  KEY `IDX_B6BD307FE92F8F78` (`recipient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `sender_id`, `recipient_id`, `message_content`, `message_date`, `is_reported`, `read_at`) VALUES
(1, 2, 3, 'bonjour !', '2020-08-27 00:00:00', 0, '2020-08-29 00:00:00'),
(2, 3, 2, 'Comment ça va ?', '2020-08-27 00:00:00', 0, '2020-08-29 00:00:00'),
(3, 2, 3, 'Très bien et vous ?', '2020-08-27 05:00:00', 0, '2020-08-29 00:00:00'),
(4, 23, 2, 'Bonjour !', '2020-08-27 00:00:00', 0, '2020-08-29 00:00:00'),
(5, 3, 2, 'Bien bien', '2020-08-27 00:18:12', 0, '2020-08-29 00:00:00'),
(6, 23, 2, 'Serez-vous présent lundi ?', '2020-08-27 13:00:00', 0, '2020-08-29 00:00:00'),
(7, 2, 23, 'Oui !', '2020-08-28 00:00:00', 0, NULL),
(9, 25, 26, 'Bonsoir !', '2020-08-28 00:00:00', 0, NULL),
(31, 2, 28, 'Bonjour Vincent !', '2020-09-27 20:27:54', 0, NULL),
(33, 3, 38, 'Bnojour', '2020-09-29 09:19:16', 0, NULL),
(34, 2, 3, 'Serez-vous dispo mardi ?', '2020-10-01 12:15:37', 0, NULL),
(36, 35, 3, 'Bonjour !', '0000-00-00 00:00:00', 0, NULL),
(38, 2, 35, 'hello !', '2020-10-02 07:29:25', 0, NULL),
(39, 3, 38, 'bonjour', '2020-10-02 13:00:04', 0, NULL),
(40, 3, 28, 'bponjor', '2020-10-02 13:00:53', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `post_date` date NOT NULL,
  `is_visible` tinyint(1) NOT NULL,
  `post_cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_archived` tinyint(1) DEFAULT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8DA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D4591CC992` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`id`, `start_date`, `end_date`, `course_id`) VALUES
(1, '2020-08-05', '2020-08-13', 1),
(2, '2020-08-19', '2020-08-20', 2),
(3, '2021-10-17', '2022-12-18', 3),
(6, '2016-01-05', '2017-12-16', 2),
(8, '2016-01-05', '2017-12-16', 2),
(9, '2022-09-16', '2023-09-15', 1);

-- --------------------------------------------------------

--
-- Structure de la table `session_user`
--

DROP TABLE IF EXISTS `session_user`;
CREATE TABLE IF NOT EXISTS `session_user` (
  `session_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`session_id`,`user_id`),
  KEY `IDX_4BE2D663613FECDF` (`session_id`),
  KEY `IDX_4BE2D663A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `session_user`
--

INSERT INTO `session_user` (`session_id`, `user_id`) VALUES
(1, 2),
(1, 3),
(1, 38),
(2, 2),
(2, 3),
(2, 23),
(2, 33),
(2, 37),
(3, 2),
(3, 23),
(6, 23),
(6, 35),
(6, 37),
(8, 2),
(8, 3),
(8, 26),
(8, 28);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `last_name`, `first_name`, `birth_date`, `is_verified`) VALUES
(2, 'user@user.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$MmpBZTRoeFQ1d0Y1Rkg3Mw$D7GUETnhr7/sIaCr71508oSnBXggr6aeBwzkLS9VQSk', 'Pissenlit', 'Jean-Jacques', '2015-02-01', 0),
(3, 'admin@admin.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$cEpMZ0EwL1VRemVpRkQuSA$pC8PMrZU7hlasGp1IOzorh+1BaIAVlnmlEd+6Af/0fY', 'Lobréaux', 'Sonia', '2015-03-02', 0),
(23, 'session@user.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$cy44UFFkaTRFWEgzR3htYw$tYEtTiIj/zzcViFKpeYYtfdnCB67c9/C3fE8H8SCHMo', 'Lingat', 'Pol', '2018-01-04', 0),
(25, 'user0@user.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$MllFc3pKZFd2dWY2OWxwQg$yS2v7RB4SLv5LQQriwlPLUXjdAF44g7Vcr5Rb45p6Q8', 'Voisin', 'Thierry', NULL, 0),
(26, 'user1@user.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$WGNLQU1tOTVkT29SbklGTQ$Rym483iZKL5V9o97kcchbhqHFdGZsDXIBt4LPRWsy1U', 'Levy', 'Thomas', '2015-08-13', 0),
(28, 'user3@user.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$Ui5XT0o4bUlNV2g1dk5EVg$rJo85QskxMh5q1SE2fqLdDQmqioExkC0iLsU2OqoaGU', 'Charrier', 'Vincent', '2020-01-06', 0),
(29, 'user4@user.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$QUFGczl5S3Jrbml5aDNESw$q55vFu1dAHwNTM5cc9Wks6JdXFoR+FDF3kZmeobySBI', 'Lejeune', 'Roger', '1970-01-01', 0),
(32, 'flashy@user.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$L2pIcWozalY0a0pMcWtvMw$9hYseVnEytIWNHLV5vDV/Rpw7wyMEubllQLBRwWHvVA', 'Allen', 'Barry', NULL, 0),
(33, 'flash@user.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$MXlGRkszZHBvTjJOU0hQWg$XXSNf4gxYPo3BPDJXOXytlttdmitsG9/dEhmq/w8+8k', 'Gordon', 'Flash', NULL, 0),
(35, 'zdzdz@user.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$Z2JnRHNtSVhVTjhSNGR2TQ$TaPoz/q3eg0fd03uZZFvhpZdTwOxOkEDpdPnKjUVbss', 'Jupinet', 'Jean-Julien', NULL, 0),
(36, 'zdaz@user.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$d0psem9uR09xZWxFVC9tNw$kcIT03IOIWXvhqh2+cUO8EZaXjs6+TduquysIoRQdww', 'Lefevre', 'Grégoire', NULL, 0),
(37, 'pzzpf@user.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$Ynlwd2s3UnZ1SjlwTkt1cg$acbvSD+YXqgzIiEf9EypWtYCMlWYV5hDy7We4RusDU0', 'Vassaux', 'Axel', '2020-11-18', 0),
(38, 'user32@user.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$S2sybkxWZXRLcmFjSHNlTw$Khp8QUp8la7MMugKiHGxweOo2H3p7v8WQ46UAfkeRSc', 'Rouve', 'Jean Paul', '2020-07-17', 0),
(43, 'albert@user.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$REMzdVczc0cwdVowSE5kaA$lE6OG2bD8TMimbUuGooPjJevjre+XB7v1+5OjTup1+U', 'Dagobert', 'Albert', NULL, 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `FK_4DB9D91CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `course_document`
--
ALTER TABLE `course_document`
  ADD CONSTRAINT `FK_71DDE720591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_71DDE720C33F7837` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045F4B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307FE92F8F78` FOREIGN KEY (`recipient_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B6BD307FF624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `FK_D044D5D4591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);

--
-- Contraintes pour la table `session_user`
--
ALTER TABLE `session_user`
  ADD CONSTRAINT `FK_4BE2D663613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_4BE2D663A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
