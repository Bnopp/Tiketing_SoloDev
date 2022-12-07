-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 07 déc. 2022 à 08:30
-- Version du serveur : 5.7.11
-- Version de PHP : 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_ticketing`
--
CREATE DATABASE IF NOT EXISTS `db_ticketing` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db_ticketing`;

-- --------------------------------------------------------

--
-- Structure de la table `t_attachement`
--

CREATE TABLE `t_attachement` (
  `idAttachement` int(11) NOT NULL,
  `attUrl` varchar(200) NOT NULL,
  `fkPost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `t_categorie`
--

CREATE TABLE `t_categorie` (
  `idCategorie` int(11) NOT NULL,
  `catTitle` varchar(50) NOT NULL,
  `catDescription` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `t_priority`
--

CREATE TABLE `t_priority` (
  `idPriority` int(11) NOT NULL,
  `priTitle` varchar(50) NOT NULL,
  `priDescription` varchar(500) NOT NULL,
  `priColorHex` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `t_reply`
--

CREATE TABLE `t_reply` (
  `idReply` int(11) NOT NULL,
  `repContent` varchar(2000) NOT NULL,
  `repCreationDate` datetime NOT NULL,
  `fkTicket` int(11) NOT NULL,
  `fkUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `t_status`
--

CREATE TABLE `t_status` (
  `idStauts` int(11) NOT NULL,
  `staTitle` varchar(50) NOT NULL,
  `staDescription` varchar(500) NOT NULL,
  `staColorHex` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `t_ticket`
--

CREATE TABLE `t_ticket` (
  `idTicket` int(11) NOT NULL,
  `ticTitle` varchar(50) NOT NULL,
  `ticDescription` varchar(2000) NOT NULL,
  `ticPriority` int(11) NOT NULL,
  `ticStatus` int(11) NOT NULL,
  `ticCreationDate` datetime NOT NULL,
  `ticResolutionDate` datetime NOT NULL,
  `fkCategorie` int(11) NOT NULL,
  `fkUser` int(11) NOT NULL,
  `fkResolver` int(11) NOT NULL,
  `fkSolution` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

CREATE TABLE `t_user` (
  `idUser` int(11) NOT NULL,
  `useSurname` varchar(20) NOT NULL,
  `useName` varchar(20) NOT NULL,
  `useEmail` varchar(100) NOT NULL,
  `useUsername` varchar(20) NOT NULL,
  `usePassword` varchar(100) NOT NULL,
  `useAdmin` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `t_user`
--

INSERT INTO `t_user` (`idUser`, `useSurname`, `useName`, `useEmail`, `useUsername`, `usePassword`, `useAdmin`) VALUES
(1, 'Dupont', 'Admin', 'admin.dupont@eduvaud.ch', 'admin', '$2y$10$7HKzpJkFzp56lgbuYZnyVu8rYNqopK4y1gA8FJlQZeD1j1a4XfXMm', 1),
(2, 'Eleve', 'Dupont', 'eleve.dupont@gmail.com', 'user', '$2y$10$7HKzpJkFzp56lgbuYZnyVu8rYNqopK4y1gA8FJlQZeD1j1a4XfXMm', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `t_attachement`
--
ALTER TABLE `t_attachement`
  ADD PRIMARY KEY (`idAttachement`),
  ADD KEY `fk_TicketAtt` (`fkPost`);

--
-- Index pour la table `t_categorie`
--
ALTER TABLE `t_categorie`
  ADD PRIMARY KEY (`idCategorie`);

--
-- Index pour la table `t_priority`
--
ALTER TABLE `t_priority`
  ADD PRIMARY KEY (`idPriority`);

--
-- Index pour la table `t_reply`
--
ALTER TABLE `t_reply`
  ADD PRIMARY KEY (`idReply`),
  ADD KEY `fk_ReplyAuthor` (`fkUser`),
  ADD KEY `fk_Ticket` (`fkTicket`);

--
-- Index pour la table `t_status`
--
ALTER TABLE `t_status`
  ADD PRIMARY KEY (`idStauts`);

--
-- Index pour la table `t_ticket`
--
ALTER TABLE `t_ticket`
  ADD PRIMARY KEY (`idTicket`),
  ADD KEY `fk_Categorie` (`fkCategorie`),
  ADD KEY `fk_Solution` (`fkSolution`),
  ADD KEY `fk_Priority` (`ticPriority`),
  ADD KEY `fk_Status` (`ticStatus`),
  ADD KEY `fk_Resolver` (`fkResolver`),
  ADD KEY `fk_User` (`fkUser`);

--
-- Index pour la table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `t_attachement`
--
ALTER TABLE `t_attachement`
  MODIFY `idAttachement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t_categorie`
--
ALTER TABLE `t_categorie`
  MODIFY `idCategorie` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t_priority`
--
ALTER TABLE `t_priority`
  MODIFY `idPriority` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t_reply`
--
ALTER TABLE `t_reply`
  MODIFY `idReply` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t_status`
--
ALTER TABLE `t_status`
  MODIFY `idStauts` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t_ticket`
--
ALTER TABLE `t_ticket`
  MODIFY `idTicket` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `t_attachement`
--
ALTER TABLE `t_attachement`
  ADD CONSTRAINT `fk_ReplyAtt` FOREIGN KEY (`fkPost`) REFERENCES `t_reply` (`idReply`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_TicketAtt` FOREIGN KEY (`fkPost`) REFERENCES `t_ticket` (`idTicket`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `t_reply`
--
ALTER TABLE `t_reply`
  ADD CONSTRAINT `fk_ReplyAuthor` FOREIGN KEY (`fkUser`) REFERENCES `t_user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Ticket` FOREIGN KEY (`fkTicket`) REFERENCES `t_ticket` (`idTicket`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `t_ticket`
--
ALTER TABLE `t_ticket`
  ADD CONSTRAINT `fk_Categorie` FOREIGN KEY (`fkCategorie`) REFERENCES `t_categorie` (`idCategorie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Priority` FOREIGN KEY (`ticPriority`) REFERENCES `t_priority` (`idPriority`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Resolver` FOREIGN KEY (`fkResolver`) REFERENCES `t_user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Solution` FOREIGN KEY (`fkSolution`) REFERENCES `t_reply` (`idReply`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Status` FOREIGN KEY (`ticStatus`) REFERENCES `t_status` (`idStauts`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_User` FOREIGN KEY (`fkUser`) REFERENCES `t_user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
