-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 11 août 2019 à 20:38
-- Version du serveur :  5.7.19
-- Version de PHP :  7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `videohub`
--

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'Cinéma', 'Des films cultes'),
(2, 'Cuisine', 'Régalons-nous'),
(6, 'Automobile', NULL);

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `birthday`, `roles`, `registered_at`) VALUES
(16, 'admin@videohub.com', '$argon2id$v=19$m=65536,t=6,p=1$NWN2SGtjNmpYSkRNWi9kNA$EealUAggDmbrapv22IZFPunASxhvFII129vOmhrm1uU', '1986-03-05 04:11:00', 'ROLE_USER,ROLE_ADMIN', '2019-08-11 20:30:46'),
(17, 'example@videohub.com', '$argon2id$v=19$m=65536,t=6,p=1$OG91Y3RXN1pnalEwa3dZQg$q35r/9DJ+94DYjC+KPXc0Y0Ry3uoQQBXSE/v+qx+Z9I', '1984-08-08 07:12:00', 'ROLE_USER', '2019-08-11 20:34:33');

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `title`, `created_at`, `is_published`, `url`, `description`, `user_id`, `category_id`) VALUES
(1, 'Me at the zoo', '2019-08-11 19:00:00', 1, 'https://www.youtube.com/watch?v=jNQXAC9IVRw', 'Première vidéo de Youtube', 16, 1),
(2, 'JDG Harry Potter', '2019-08-12 08:22:20', 0, 'https://www.youtube.com/watch?v=Ugs9HASX4rA', NULL, 17, 1),
(3, 'Comment marche un moteur', '2019-08-11 16:29:03', 1, 'https://www.youtube.com/watch?v=6gT8NnjJV2c', 'Une vidéo de Vilebrequin', 17, 6);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
