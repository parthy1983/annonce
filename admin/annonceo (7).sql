-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Ven 21 Avril 2017 à 17:11
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

--
-- Contenu de la table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `titre`, `description_courte`, `description_longue`, `prix`, `photo`, `pays`, `ville`, `adresse`, `cp`, `date_enregistrement`, `membre_id`, `photo_id`, `categorie_id`) VALUES
(2, 'Annonce11111111111111', 'Description Courte 1', 'Description Longue 2', 12.22, '58f9b801a1b30_chemiseNoire.jpg', 'France', 'Chanteloup les vignes', 'adresse', 78570, '2017-04-21 09:42:57', 6, NULL, 4),
(3, 'Annonce2', 'Description Courte', 'Description Longue', 44.22, '58f9b9260b0d9_pullRouge.jpg', 'France', 'paris', 'aszdszd', 78570, '2017-04-21 09:47:50', 6, NULL, 4),
(4, 'Annonce 3', 'Description Courte', 'Description Longue', 32, '58f9b9b5af6fe_chemise1.jpg', 'France', 'Chanteloup les vignes', '4 rue des quertianes', 13325, '2017-04-21 09:50:13', NULL, NULL, 3),
(5, 'annon vetrivel', 'Description Courte', 'Description Longue', 44.22, '58f9d67d031a4_pantalon.jpg', 'France', 'Chanteloup les vignes', '1 rue des commerce', 13325, '2017-04-21 11:53:01', NULL, NULL, 2),
(6, 'xc vwxcvxwcv', 'Description Courte', 'Description Longueqsfqsfqsfqsf', 32, '58f9d7db54fe4_Taj.jpg', 'India', 'Delhi', 'adress', 13325, '2017-04-21 11:58:51', 6, NULL, 2),
(7, 'sdfdqsf', 'dfdqsf', 'dsqfqsdf', 32, '58f9e4af8ff3b_Taj.jpg', 'France', 'Chanteloup les vignes', 'fdgdf', 0, '2017-04-21 12:53:35', 6, 2, 2),
(8, 'Annonce10', 'Description Courte', 'Description Courte fqsf', 32, '58fa06f7c3e45_pantalon1.jpg', 'France', 'paris', 'fdgdf', 13325, '2017-04-21 15:19:51', 6, 3, 4),
(9, 'aezrzaqrdfqs', 'qsdqsd', 'qsdqsd', 44.22, '58fa08c7dfe8a_chemise.jpg', 'France', 'sfqs', '1 rue des commerce', 0, '2017-04-21 15:27:35', 6, 4, 3);

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
(1, 'parthy', 'e0e019070546d998969102b6e987993e1e04f72a', 'MUTHULINGAM', 'Thamizhselvan', '1245623156', 'parthy1983@gmail.com13', 'f', 0, '2017-04-19 11:32:48'),
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
-- Contenu de la table `photo`
--

INSERT INTO `photo` (`id_photo`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`) VALUES
(1, '58f9e39837152_Taj.jpg', '58f9e39837577_blanche.jpg', '58f9e3983793b_pantalon.jpg', '58f9e39837d6a_pantalon2.jpg', '58f9e398380ec_chemise1.jpg'),
(2, '58f9e4af8ff3b_Taj.jpg', '58f9e4af901dc_blanche.jpg', '58f9e4af90421_pantalon.jpg', '58f9e4af9064a_pantalon2.jpg', '58f9e4af9093a_chemise1.jpg'),
(3, '58fa06f7c3e45_pantalon1.jpg', '58fa06f7c4213_chemise.jpg', '58fa06f7c458c_blanche.jpg', '58fa06f7c492a_Taj.jpg', '58fa06f7c4d08_pantalon1.jpg'),
(4, '58fa08c7dfe8a_chemise.jpg', '58fa08c7e021e_chemise1.jpg', NULL, NULL, NULL);

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
  MODIFY `id_annonce` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
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
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
