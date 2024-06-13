-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 13, 2024 at 12:47 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eco_pratices`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id_article` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id_article`, `id_user`, `titre`, `description`, `date`) VALUES
(2, 4, 'Limiter l\'utilisation de l\'eau', 'Installer des dispositifs économiseurs d\'eau, réparer les fuites, prendre des douches courtes au lieu de bains et utiliser des méthodes de jardinage économes en eau, comme le paillage.', '2024-06-12 13:05:15'),
(3, 4, 'Réduire, réutiliser, recycler ', 'Pratiquer les 3R pour minimiser les déchets. Réduire l\'achat de produits à usage unique, réutiliser les objets et recycler les matériaux comme le papier, le plastique, le verre et les métaux.', '2024-06-12 13:05:15'),
(4, 4, 'Utiliser les transports durables', 'Favoriser les modes de transport écologiques tels que la marche, le vélo, le covoiturage et les transports en commun. Opter pour des véhicules électriques ou hybrides si possible.', '2024-06-12 13:05:38'),
(5, 5, 'Consommer des produits locaux et de saison', 'Acheter des produits alimentaires locaux et de saison pour réduire l\'empreinte carbone liée au transport des aliments et soutenir l\'économie locale.', '2024-06-12 14:36:20'),
(8, 5, 'Adopter une alimentation durable V1', 'Réduire la consommation de viande et de produits d\'origine animale, privilégier les aliments biologiques et minimiser le gaspillage alimentaire en planifiant les repas et en conservant correctement les aliments.\r\n\r\n', '2024-06-13 09:22:19'),
(11, 5, 'Utiliser des produits écologiques', 'Choisir des produits ménagers et de soins personnels écologiques, sans produits chimiques nocifs, et privilégier les emballages recyclables ou compostables.', '2024-06-13 11:16:55'),
(12, 4, 'Pratiquer le compostage', 'Composter les déchets organiques comme les restes de nourriture et les déchets de jardin pour produire un amendement naturel pour les sols et réduire les déchets envoyés à la décharge.', '2024-06-13 11:17:37'),
(13, 4, 'Planter des arbres et des jardins', 'Participer à des initiatives de plantation d\'arbres, créer des jardins potagers et favoriser la biodiversité en plantant des espèces locales et mellifères.\r\n\r\n', '2024-06-13 14:46:51'),
(14, 5, 'Sensibiliser et éduquer', 'Partager les connaissances et les pratiques écologiques avec les amis, la famille et la communauté pour encourager un mode de vie durable et responsable.', '2024-06-13 14:46:51');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `login`, `password`, `email`, `role`) VALUES
(4, 'thomas', '$2y$10$hYlIcVqsw/XdkpCVO9p6CuPqqYOMbyz4hzoDY0fCkFlfafjJHo3We', 'thomas@lemeilleurdudev.fr', 'admin'),
(5, 'toma', '$2y$10$TpjxVOSf0PlnFQ1tGsDznObI5R5LHMe3jSQaQQ8Y9y9JZPmAmizC.', 'thoma@pasoufoufoufoufdudev.fr', 'editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id_article` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
