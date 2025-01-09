-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 07 jan. 2025 à 15:24
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ent`
--

-- --------------------------------------------------------

--
-- Structure de la table `etats_rendus`
--

DROP TABLE IF EXISTS `etats_rendus`;
CREATE TABLE IF NOT EXISTS `etats_rendus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_user` int NOT NULL,
  `fk_rendu` int NOT NULL,
  `etat` enum('a-faire','en-cours','fait') DEFAULT 'a-faire',
  `pinned` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_user` (`fk_user`),
  KEY `fk_rendu` (`fk_rendu`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `etats_rendus`
--

INSERT INTO `etats_rendus` (`id`, `fk_user`, `fk_rendu`, `etat`, `pinned`) VALUES
(1, 4, 5, 'fait', 0),
(2, 4, 7, 'en-cours', 1),
(3, 4, 10, 'a-faire', 1),
(4, 4, 6, 'en-cours', 0),
(5, 4, 11, 'en-cours', 0),
(6, 3, 7, 'a-faire', 0),
(7, 3, 5, 'fait', 0);

-- --------------------------------------------------------

--
-- Structure de la table `fichiers`
--

DROP TABLE IF EXISTS `fichiers`;
CREATE TABLE IF NOT EXISTS `fichiers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `chemin` varchar(255) NOT NULL,
  `fk_user` int NOT NULL,
  `fk_rendu` int NOT NULL,
  `date_upload` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`fk_user`),
  KEY `fk_rendu` (`fk_rendu`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `fichiers`
--

INSERT INTO `fichiers` (`id`, `nom`, `chemin`, `fk_user`, `fk_rendu`, `date_upload`) VALUES
(2, 'Modèle de données.png', 'uploads/Modèle de données.png', 4, 6, '2025-01-06 17:40:45'),
(3, 'integration.jpg', 'uploads/integration.jpg', 4, 6, '2025-01-06 17:41:01'),
(15, 'inscription.php', 'uploads/inscription.php', 4, 7, '2025-01-07 13:13:19'),
(5, 'baron.png', 'uploads/baron.png', 4, 6, '2025-01-06 17:52:12'),
(7, 'france.png', 'uploads/france.png', 4, 5, '2025-01-06 20:42:57'),
(9, 'TP miniblog_S3_2024.pdf', 'uploads/TP miniblog_S3_2024.pdf', 4, 5, '2025-01-06 20:53:08'),
(13, 'destroysession.php', 'uploads/destroysession.php', 4, 7, '2025-01-06 22:32:34'),
(11, 'form_photo.php', 'uploads/form_photo.php', 4, 7, '2025-01-06 21:01:18');

-- --------------------------------------------------------

--
-- Structure de la table `pins`
--

DROP TABLE IF EXISTS `pins`;
CREATE TABLE IF NOT EXISTS `pins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_user` int NOT NULL,
  `fk_rendu` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_user` (`fk_user`,`fk_rendu`),
  KEY `fk_rendu` (`fk_rendu`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `pins`
--

INSERT INTO `pins` (`id`, `fk_user`, `fk_rendu`, `created_at`) VALUES
(20, 4, 6, '2025-01-07 13:13:03'),
(3, 3, 5, '2025-01-05 21:48:58');

-- --------------------------------------------------------

--
-- Structure de la table `rendus`
--

DROP TABLE IF EXISTS `rendus`;
CREATE TABLE IF NOT EXISTS `rendus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL,
  `etat` enum('fait','a-faire','en-cours','') CHARACTER SET utf8mb4 NOT NULL DEFAULT 'a-faire',
  `fk_user` int DEFAULT NULL,
  `pinned` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `rendus`
--

INSERT INTO `rendus` (`id`, `titre`, `description`, `date`, `etat`, `fk_user`, `pinned`) VALUES
(5, 'SAE 3.01', 'Penser et développer un ENT', '2025-01-10 00:00:00', 'a-faire', NULL, 0),
(7, 'CV vidéo', 'Tourner et monter un cv vidéo qui vous sera utile pour votre recherche de stage', '2025-01-05 12:00:00', 'fait', NULL, 1),
(6, 'test rendu 1', '', '2025-02-14 14:26:00', 'en-cours', 4, 1),
(10, 'test etat 2', '', '2025-01-05 22:13:30', 'fait', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `role` enum('etudiant','prof','secretaire','') CHARACTER SET utf8mb4 NOT NULL,
  `formation` varchar(255) NOT NULL,
  `ine` int NOT NULL,
  `num_etudiant` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `id_2` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `mdp`, `nom`, `prenom`, `mail`, `role`, `formation`, `ine`, `num_etudiant`) VALUES
(4, 'clara.moubarak', '$2y$10$FKHBQUXdJxwcBcpUOSN9weH6Cv4vh3Il2.qwQicek8.//b2DIEM5.', 'moubarak', 'clara', '', 'etudiant', '', 0, 0),
(3, 'alyssa.karahan', '$2y$10$69kTi4oDXmXM6zndz5dTO.FmeVe//7RusZSx0S296F5tw7JcgvXVm', 'alyssa', 'alyssa', '', 'etudiant', '', 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
