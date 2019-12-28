-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2019 at 08:22 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dionizliga`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `homeTeam` int(11) NOT NULL,
  `awayTeam` int(11) NOT NULL,
  `results` varchar(100) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `homeTeamGoals` int(11) DEFAULT NULL,
  `awayTeamGoals` int(11) DEFAULT NULL,
  `league` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id`, `homeTeam`, `awayTeam`, `results`, `description`, `homeTeamGoals`, `awayTeamGoals`, `league`) VALUES
(270, 106, 111, NULL, '1', 3, 1, 39),
(271, 107, 112, NULL, '1', 0, 0, 39),
(272, 108, 113, NULL, '1', 2, 1, 39),
(273, 109, 114, NULL, '1', 1, 1, 39),
(274, 110, 115, NULL, '1', 1, 3, 39),
(275, 106, 111, NULL, '2', 5, 1, 39),
(277, 166, 169, NULL, '1', 1, 3, 57),
(278, 167, 170, NULL, '1', 2, 0, 57),
(279, 168, 176, NULL, '1', 1, 2, 57),
(280, 166, 167, NULL, '1', 2, 0, 57),
(281, 168, 169, NULL, '1', 2, 0, 57),
(282, 176, 170, NULL, '1', 1, 0, 57),
(283, 166, 168, NULL, '1', 2, 4, 57),
(284, 176, 167, NULL, '1', 1, 0, 57),
(285, 170, 169, NULL, '1', 1, 2, 57),
(286, 166, 176, NULL, '1', 4, 3, 57),
(287, 170, 168, NULL, '1', 2, 2, 57),
(288, 169, 167, NULL, '1', 1, 1, 57),
(289, 166, 170, NULL, '1', 3, 2, 57),
(290, 169, 176, NULL, '1', 1, 3, 57),
(291, 167, 168, NULL, '1', 2, 2, 57),
(292, 171, 174, NULL, '1', 2, 1, 58),
(293, 172, 175, NULL, '1', 3, 2, 58),
(294, 173, 177, NULL, '1', 0, 2, 58),
(295, 171, 172, NULL, '1', 3, 1, 58),
(296, 173, 174, NULL, '1', 0, 2, 58),
(297, 177, 175, NULL, '1', 4, 1, 58),
(298, 171, 173, NULL, '1', 2, 2, 58),
(299, 177, 172, NULL, '1', 1, 0, 58),
(300, 175, 174, NULL, '1', 2, 2, 58),
(301, 171, 177, NULL, '1', 1, 1, 58),
(302, 174, 172, NULL, '1', 5, 2, 58),
(303, 171, 175, NULL, '1', 2, 4, 58),
(304, 174, 177, NULL, '1', 2, 2, 58),
(305, 172, 173, NULL, '1', 0, 3, 58);

-- --------------------------------------------------------

--
-- Table structure for table `gameplayer`
--

CREATE TABLE `gameplayer` (
  `id` int(11) NOT NULL,
  `Players` int(11) NOT NULL,
  `game` int(11) NOT NULL,
  `redCard` tinyint(1) DEFAULT NULL,
  `yellowCard` int(11) DEFAULT NULL,
  `goal` int(11) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gametype`
--

CREATE TABLE `gametype` (
  `id` int(11) NOT NULL,
  `gameName` varchar(50) NOT NULL,
  `pointsPerWin` int(11) NOT NULL,
  `pointsPerDraw` int(11) NOT NULL,
  `pointsPerLoss` int(11) NOT NULL,
  `description` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gametype`
--

INSERT INTO `gametype` (`id`, `gameName`, `pointsPerWin`, `pointsPerDraw`, `pointsPerLoss`, `description`) VALUES
(1, 'Nogomet', 3, 1, 0, 'Parametri za igru nogomet'),
(2, 'Rukomet', 2, 1, 0, 'Parametri za igru Rukomet'),
(3, 'ESPORTS', 2, 1, 0, 'Parametri za esport');

-- --------------------------------------------------------

--
-- Table structure for table `league`
--

CREATE TABLE `league` (
  `id` int(11) NOT NULL,
  `nameOfLeague` varchar(100) NOT NULL,
  `leagueEmblem` varchar(100) DEFAULT NULL,
  `users` int(11) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `gameType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `league`
--

INSERT INTO `league` (`id`, `nameOfLeague`, `leagueEmblem`, `users`, `description`, `gameType`) VALUES
(39, 'HNL', NULL, 9, '2', 1),
(56, 'Premijer Liga', NULL, 9, '1', 2),
(57, 'Skupina 1', NULL, 9, '1', 1),
(58, 'Skupina 2', NULL, 9, '1', 1),
(59, 'Skupina 3', NULL, 9, '1', 1),
(60, 'Skupina 4', NULL, 9, '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `leaguetable`
--

CREATE TABLE `leaguetable` (
  `id` int(11) NOT NULL,
  `nameOfTeam` varchar(100) NOT NULL,
  `teamEmblem` varchar(100) DEFAULT NULL,
  `league` int(11) NOT NULL,
  `totalPoints` int(11) NOT NULL,
  `totalGoalsScored` int(11) NOT NULL,
  `totalGoalsConceded` int(11) NOT NULL,
  `totalGamesPlayed` int(11) NOT NULL,
  `totalWins` int(11) NOT NULL,
  `totalLosses` int(11) NOT NULL,
  `totalDraws` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `leaguetable`
--

INSERT INTO `leaguetable` (`id`, `nameOfTeam`, `teamEmblem`, `league`, `totalPoints`, `totalGoalsScored`, `totalGoalsConceded`, `totalGamesPlayed`, `totalWins`, `totalLosses`, `totalDraws`) VALUES
(106, 'NK Osijek', NULL, 39, 6, 8, 2, 2, 2, 0, 0),
(107, 'HNK Hajduk ', NULL, 39, 1, 0, 0, 1, 0, 0, 1),
(108, 'GNK Dinamo Zagreb', NULL, 39, 3, 2, 1, 1, 1, 0, 0),
(109, 'HNK Rijeka', NULL, 39, 1, 1, 1, 1, 0, 0, 1),
(110, 'Istra 1961', NULL, 39, 0, 1, 3, 1, 0, 1, 0),
(111, 'NK Lokomotiva', NULL, 39, 0, 2, 8, 2, 0, 2, 0),
(112, 'HNK Gorica', NULL, 39, 1, 0, 0, 1, 0, 0, 1),
(113, 'Slaven Belupo', NULL, 39, 0, 1, 2, 1, 0, 1, 0),
(114, 'Inter Zaprešić', NULL, 39, 1, 1, 1, 1, 0, 0, 1),
(115, 'Rudeš', NULL, 39, 3, 3, 1, 1, 1, 0, 0),
(156, 'Dubrava', NULL, 56, 0, 0, 0, 0, 0, 0, 0),
(157, 'Gorica', NULL, 56, 0, 0, 0, 0, 0, 0, 0),
(158, 'MRK Umag', NULL, 56, 0, 0, 0, 0, 0, 0, 0),
(159, 'Poreč', NULL, 56, 0, 0, 0, 0, 0, 0, 0),
(160, 'Rudar Labin', NULL, 56, 0, 0, 0, 0, 0, 0, 0),
(161, 'Rudar', NULL, 56, 0, 0, 0, 0, 0, 0, 0),
(162, 'Sesvete', NULL, 56, 0, 0, 0, 0, 0, 0, 0),
(163, 'Spačva Vinkovci', NULL, 56, 0, 0, 0, 0, 0, 0, 0),
(164, 'Varaždin 1930', NULL, 56, 0, 0, 0, 0, 0, 0, 0),
(165, 'Zamet', NULL, 56, 0, 0, 0, 0, 0, 0, 0),
(166, 'Djenka', NULL, 57, 9, 12, 12, 5, 3, 2, 0),
(167, 'Cera', NULL, 57, 5, 5, 6, 5, 1, 2, 2),
(168, 'Srki', NULL, 57, 8, 11, 8, 5, 2, 1, 2),
(169, 'Karaica', NULL, 57, 7, 7, 8, 5, 2, 2, 1),
(170, 'Vule', NULL, 57, 1, 5, 10, 5, 0, 4, 1),
(171, 'MarkoS', NULL, 58, 8, 10, 9, 5, 2, 1, 2),
(172, 'Toni', NULL, 58, 3, 6, 14, 5, 1, 4, 0),
(173, 'Mane', NULL, 58, 4, 5, 6, 4, 1, 2, 1),
(174, 'Petar', NULL, 58, 8, 12, 8, 5, 2, 1, 2),
(175, 'Patrik', NULL, 58, 4, 9, 11, 4, 1, 2, 1),
(176, 'MarkoSedlar', NULL, 57, 12, 10, 6, 5, 4, 1, 0),
(177, 'Zelja', NULL, 58, 11, 10, 4, 5, 3, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `playerPhoto` varchar(100) DEFAULT NULL,
  `LeagueTable` int(11) NOT NULL,
  `totalGamesPlayed` int(11) NOT NULL,
  `totalGoalsScored` int(11) NOT NULL,
  `totallYellowCards` int(11) NOT NULL,
  `totallRedCards` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `firstName`, `lastName`, `playerPhoto`, `LeagueTable`, `totalGamesPlayed`, `totalGoalsScored`, `totallYellowCards`, `totallRedCards`) VALUES
(5, 'Ezekiel', 'Henty', NULL, 106, 0, 5, 1, 0),
(7, 'Mile', 'Škorić', NULL, 106, 0, 0, 2, 1),
(8, 'Tomislav', 'Šorša', NULL, 106, 0, 1, 0, 0),
(9, 'Dmytro', 'Lyopa', NULL, 106, 0, 0, 0, 0),
(11, 'Fran', 'Tudor', NULL, 107, 0, 2, 0, 0),
(12, 'Mnogo', 'Daje', NULL, 111, 0, 7, 0, 0),
(13, 'Solidan', 'Igrač', NULL, 113, 0, 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `administrator` tinyint(1) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profilePhoto` varchar(100) DEFAULT NULL,
  `registerWithGoogle` tinyint(1) NOT NULL,
  `registerWithFacebook` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `administrator`, `firstName`, `lastName`, `username`, `password`, `profilePhoto`, `registerWithGoogle`, `registerWithFacebook`) VALUES
(9, 1, 'Zeljko', 'Livaja', 'Zelja', '$2y$10$HOcHOTbX85K/z65UHlqy2.gyS120nx7TfSHU.KQdPgWpp11oQiPGG', NULL, 0, 0),
(11, 0, 'Test', 'asd', 'Testtt', 'asd', NULL, 1, 1),
(12, 0, 'Tomislav', 'Jakopec', 'tjakopec', '', NULL, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homeTeam` (`homeTeam`),
  ADD KEY `awayTeam` (`awayTeam`),
  ADD KEY `league` (`league`);

--
-- Indexes for table `gameplayer`
--
ALTER TABLE `gameplayer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game` (`game`),
  ADD KEY `Players` (`Players`);

--
-- Indexes for table `gametype`
--
ALTER TABLE `gametype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `league`
--
ALTER TABLE `league`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users` (`users`),
  ADD KEY `gameType` (`gameType`);

--
-- Indexes for table `leaguetable`
--
ALTER TABLE `leaguetable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `league` (`league`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `LeagueTable` (`LeagueTable`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- AUTO_INCREMENT for table `gameplayer`
--
ALTER TABLE `gameplayer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gametype`
--
ALTER TABLE `gametype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `league`
--
ALTER TABLE `league`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `leaguetable`
--
ALTER TABLE `leaguetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `game_ibfk_1` FOREIGN KEY (`homeTeam`) REFERENCES `leaguetable` (`id`),
  ADD CONSTRAINT `game_ibfk_2` FOREIGN KEY (`awayTeam`) REFERENCES `leaguetable` (`id`),
  ADD CONSTRAINT `game_ibfk_3` FOREIGN KEY (`league`) REFERENCES `league` (`id`);

--
-- Constraints for table `gameplayer`
--
ALTER TABLE `gameplayer`
  ADD CONSTRAINT `gamePlayer_ibfk_1` FOREIGN KEY (`game`) REFERENCES `game` (`id`),
  ADD CONSTRAINT `gamePlayer_ibfk_2` FOREIGN KEY (`Players`) REFERENCES `players` (`id`);

--
-- Constraints for table `league`
--
ALTER TABLE `league`
  ADD CONSTRAINT `league_ibfk_1` FOREIGN KEY (`users`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `league_ibfk_2` FOREIGN KEY (`gameType`) REFERENCES `gametype` (`id`);

--
-- Constraints for table `leaguetable`
--
ALTER TABLE `leaguetable`
  ADD CONSTRAINT `leagueTable_ibfk_1` FOREIGN KEY (`league`) REFERENCES `league` (`id`);

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `Players_ibfk_1` FOREIGN KEY (`LeagueTable`) REFERENCES `leaguetable` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
