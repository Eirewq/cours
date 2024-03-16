-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql
-- Généré le : sam. 16 mars 2024 à 16:06
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `accordenergie`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nomCategorie` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `created_at`, `update_at`, `nomCategorie`) VALUES
(1, '2024-02-18 11:37:13', '2024-03-16 10:03:16', 'Plomberie'),
(2, '2024-02-18 11:37:13', '2024-02-18 11:37:13', 'Mecanique');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int NOT NULL,
  `id_service` int NOT NULL,
  `id_user` int NOT NULL,
  `contenu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `id_service`, `id_user`, `contenu`, `created_at`) VALUES
(1, 2, 26, 'oeee la team', '2024-03-16 14:53:44'),
(2, 2, 26, 'ietiner', '2024-03-16 15:01:06'),
(3, 2, 26, 'oeee la tcheam', '2024-03-16 15:02:08'),
(4, 2, 25, 'okokok', '2024-03-16 15:03:05'),
(5, 2, 25, 'yaaahouuu', '2024-03-16 15:35:32'),
(6, 2, 25, 'c fini ', '2024-03-16 15:35:37');

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `id_service` int NOT NULL,
  `id_intervenant` int NOT NULL,
  `id_client` int NOT NULL,
  `id_standardiste` int NOT NULL,
  `id_categorie` int NOT NULL,
  `id_urgence` int NOT NULL,
  `id_status` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateIntervention` date NOT NULL,
  `nomService` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `heureFin` time NOT NULL,
  `heureDebut` time NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id_service`, `id_intervenant`, `id_client`, `id_standardiste`, `id_categorie`, `id_urgence`, `id_status`, `created_at`, `dateIntervention`, `nomService`, `heureFin`, `heureDebut`, `update_at`) VALUES
(2, 25, 26, 19, 1, 2, 3, '2024-02-28 18:35:26', '2024-02-28', 'panne évier', '15:00:00', '14:00:00', '2024-03-03 15:36:07');

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

CREATE TABLE `status` (
  `id_statut` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nomStatut` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `status`
--

INSERT INTO `status` (`id_statut`, `created_at`, `nomStatut`, `update_at`) VALUES
(1, '2024-02-18 14:49:36', 'Programmé', '2024-02-18 14:49:36'),
(2, '2024-02-18 14:49:36', 'En Cours', '2024-02-18 14:49:36'),
(3, '2024-02-18 14:49:36', 'Finis', '2024-03-12 17:17:35');

-- --------------------------------------------------------

--
-- Structure de la table `urgence`
--

CREATE TABLE `urgence` (
  `id_urgence` int NOT NULL,
  `nomUrgence` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `urgence`
--

INSERT INTO `urgence` (`id_urgence`, `nomUrgence`, `update_at`) VALUES
(1, 'Nécessaire', '2024-02-18 14:43:33'),
(2, 'Urgent', '2024-02-18 14:43:33'),
(4, 'Vitales', '2024-03-12 17:15:25');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Client'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `prenom`, `created_at`, `email`, `password`, `update_at`, `role`) VALUES
(19, 'frfr', 'hyhy', '2024-02-05 12:20:56', 'test@test.com', '$2y$10$fDKig5cGZgzz5e.xW9rRZ.dntIGx8vZmKD13uCTeo5MoxTbJbI4aq', '2024-02-18 11:14:11', 'Standardiste'),
(26, 'juju', 'luku', '2024-02-12 13:10:58', 'gtgtgt@tes.com', '$2y$10$8b1LgoT1npUjAs7oS5Z.9eD5YZVUjcoSJCtma5N0SWUEYZpdQaVWu', '2024-02-12 13:11:04', 'Client'),
(25, 'Tony', 'Dosantos', '2024-02-12 10:31:19', 'sasa@test.com', '$2y$10$nnv06X36N8P/p7dzaL1OsOAzbl1CB0fgW8vqoLhD0KyXmwNz9MmC.', '2024-02-18 14:02:26', 'Intervenant'),
(24, 'lolo', 'popo', '2024-02-12 10:04:52', 'dede@gmail.com', '$2y$10$U0GkHVTe2E92RCNkc9XWzuSoCz5x2qcSG6FzeXAs.pkhcHt2PteOi', '2024-02-12 12:53:54', 'Admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `id_service` (`id_service`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id_service`),
  ADD KEY `id_categorie` (`id_categorie`),
  ADD KEY `id_status` (`id_status`),
  ADD KEY `id_urgence` (`id_urgence`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_standardiste` (`id_standardiste`),
  ADD KEY `id_intervenant` (`id_intervenant`);

--
-- Index pour la table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_statut`);

--
-- Index pour la table `urgence`
--
ALTER TABLE `urgence`
  ADD PRIMARY KEY (`id_urgence`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `id_service` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `status`
--
ALTER TABLE `status`
  MODIFY `id_statut` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `urgence`
--
ALTER TABLE `urgence`
  MODIFY `id_urgence` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
