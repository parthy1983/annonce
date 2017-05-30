-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 20 Avril 2017 à 16:51
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `annonceo`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `id_annonce` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description_courte` varchar(255) NOT NULL,
  `description_longue` text NOT NULL,
  `prix` float NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `pays` varchar(45) DEFAULT NULL,
  `ville` varchar(45) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `cp` int(5) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL,
  `membre_id` int(3) DEFAULT NULL,
  `photo_id` int(3) DEFAULT NULL,
  `categorie_id` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `motscles` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `titre`, `motscles`) VALUES
(1, 'Vehicle', 'Voitures, Motos, Bateaux, Velos, Equipement'),
(2, 'Vacances', 'Camping, Hotels, Hotê'),
(3, 'Services', 'Présentations de services , Evénements'),
(4, 'Maison', 'Ameublement, Electroménager,Bricolage');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(3) NOT NULL,
  `membre_id` int(3) DEFAULT NULL,
  `annonce_id` int(3) DEFAULT NULL,
  `commentaire` text,
  `date_enregistrement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(11) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `civilite` enum('h','f') DEFAULT NULL,
  `statut` int(1) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `telephone`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(1, 'parthy', 'e0e019070546d998969102b6e987993e1e04f72a', 'MUTHULINGAM', 'Thamizhselvan', '1245623156', 'parthy1983@gmail.com1', 'h', 0, '2017-04-19 11:32:48'),
(4, 'Thamizh', '915e8443a94cf330cdcaf2f85b1af49888cf616f', 'Muthulingam', 'Thami', '0652020114', 'thami.developpeur.web@gmail.com', 'h', 1, '2017-04-19 11:51:14'),
(5, 'Jeromie', 'ac02166e635085994a91135fc35f56476fdb4be3', 'jer', 'mie', '1245623156', 'Jeromie@gmail.com', 'h', 1, '2017-04-20 11:29:41'),
(6, 'vetrivel', '2cbde1bddf90c41de7dfaa385920556d35fda93d', 'Muthulingam', 'vetrivel', '00919790283232', 'vetrivel@gmail.com', 'f', 1, '2017-04-20 15:33:40'),
(7, 'gnanavel', '254f641a4c78981836238a5be01f25d0cb48472e', 'Muthulingam', 'gnanavel', '12546232562', 'gnanavel@gmail.com', 'f', 0, '2017-04-20 15:35:36');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id_note` int(3) NOT NULL,
  `membre_id1` int(3) DEFAULT NULL,
  `membre_id2` int(3) DEFAULT NULL,
  `note` int(3) DEFAULT NULL,
  `avis` text,
  `date_enregistrement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id_photo` int(11) NOT NULL,
  `photo1` varchar(255) NOT NULL,
  `photo2` varchar(255) DEFAULT NULL,
  `photo3` varchar(255) DEFAULT NULL,
  `photo4` varchar(255) DEFAULT NULL,
  `photo5` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id_annonce`),
  ADD KEY `photo_id_idx` (`photo_id`),
  ADD KEY `membre_id_idx` (`membre_id`),
  ADD KEY `categorie_id_idx` (`categorie_id`);

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
  ADD KEY `membre_id_idx` (`membre_id`),
  ADD KEY `annonce_id_idx` (`annonce_id`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_note`),
  ADD KEY `membre_id1_idx` (`membre_id1`),
  ADD KEY `membre_id2_idx` (`membre_id2`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id_photo`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id_annonce` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `annonce_id` FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id_annonce`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `membre_id` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `membre_id1` FOREIGN KEY (`membre_id1`) REFERENCES `membre` (`id_membre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `membre_id2` FOREIGN KEY (`membre_id2`) REFERENCES `membre` (`id_membre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
