-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: iun. 20, 2024 la 07:11 PM
-- Versiune server: 10.4.24-MariaDB
-- Versiune PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `simvideo`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `abonamente`
--

CREATE TABLE `abonamente` (
  `id` int(11) NOT NULL,
  `id_abonat` int(11) NOT NULL,
  `id_creator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `abonamente`
--

INSERT INTO `abonamente` (`id`, `id_abonat`, `id_creator`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `aprecieri`
--

CREATE TABLE `aprecieri` (
  `id` int(11) NOT NULL,
  `id_utilizator` int(11) NOT NULL,
  `id_videoclip` int(11) NOT NULL,
  `id_creator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `blacklist_profile`
--

CREATE TABLE `blacklist_profile` (
  `id` int(11) NOT NULL,
  `id_creator` int(11) NOT NULL,
  `id_utilizator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `blacklist_videoclipuri`
--

CREATE TABLE `blacklist_videoclipuri` (
  `id` int(11) NOT NULL,
  `id_videoclip` int(11) NOT NULL,
  `id_utilizator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `blacklist_videoclipuri`
--

INSERT INTO `blacklist_videoclipuri` (`id`, `id_videoclip`, `id_utilizator`) VALUES
(2, 1, 7);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `categorii`
--

CREATE TABLE `categorii` (
  `id` int(11) NOT NULL,
  `nume` varchar(250) COLLATE utf8_romanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `categorii`
--

INSERT INTO `categorii` (`id`, `nume`) VALUES
(1, 'Gaming'),
(2, 'Tutoriale'),
(3, 'Copii'),
(4, 'Muzica'),
(5, 'Vloguri'),
(6, 'Prezentari');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `chaturi`
--

CREATE TABLE `chaturi` (
  `id` int(11) NOT NULL,
  `uniqid` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `id_utilizator` int(11) NOT NULL,
  `nume` varchar(250) COLLATE utf8_romanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `chaturi`
--

INSERT INTO `chaturi` (`id`, `uniqid`, `id_utilizator`, `nume`) VALUES
(5, '665aacf617b41', 1, 'Comunitatea Sergiu');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `comentarii`
--

CREATE TABLE `comentarii` (
  `id` int(11) NOT NULL,
  `id_videoclip` int(11) NOT NULL,
  `id_creator` int(11) NOT NULL,
  `id_comentator` int(11) NOT NULL,
  `comentariu` text COLLATE utf8_romanian_ci NOT NULL,
  `imagine` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `data` varchar(50) COLLATE utf8_romanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `comentarii`
--

INSERT INTO `comentarii` (`id`, `id_videoclip`, `id_creator`, `id_comentator`, `comentariu`, `imagine`, `data`) VALUES
(1, 3, 2, 1, 'Acesta este comentariul videoclipului', '', '14-06-2023 19:28'),
(2, 3, 2, 1, 'Imi place foarte mult acest videoclip!', '', '26-08-2023 12:16'),
(3, 2, 1, 1, 'dwadaw', '', '16-05-2024 12:32'),
(4, 3, 2, 1, 'awdwdawdwa', '', '01-06-2024 00:00'),
(5, 3, 2, 1, 'awdawda', '', '01-06-2024 00:01'),
(9, 2, 1, 1, 'Acesta este un comentariu cu imagine', '665aaa2194663.png', '01-06-2024 07:57');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `mesaje_chat`
--

CREATE TABLE `mesaje_chat` (
  `id` int(11) NOT NULL,
  `id_chat` int(11) NOT NULL,
  `id_utilizator` int(11) NOT NULL,
  `mesaj` text COLLATE utf8_romanian_ci NOT NULL,
  `imagine` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `data` varchar(50) COLLATE utf8_romanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `mesaje_chat`
--

INSERT INTO `mesaje_chat` (`id`, `id_chat`, `id_utilizator`, `mesaj`, `imagine`, `data`) VALUES
(6, 5, 1, 'Acesta este primul mesaj', '', '15-06-2024 09:22'),
(7, 5, 1, 'Acesta este un mesaj ce contine imagine', '666d332de056b.png', '15-06-2024 09:22');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `subcategorii`
--

CREATE TABLE `subcategorii` (
  `id` int(11) NOT NULL,
  `categorie` int(11) NOT NULL,
  `nume` varchar(250) COLLATE utf8_romanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `subcategorii`
--

INSERT INTO `subcategorii` (`id`, `categorie`, `nume`) VALUES
(1, 1, 'Story'),
(2, 1, 'RPG'),
(3, 1, 'Auto'),
(4, 2, 'IT'),
(5, 2, 'Constructii '),
(6, 2, 'Mecanica'),
(7, 3, 'Muzica'),
(8, 3, 'Vloguri'),
(9, 3, 'Desene'),
(10, 4, 'Rap'),
(11, 4, 'Pop'),
(12, 4, 'Rock'),
(13, 5, 'Daily vlog'),
(14, 5, 'Vloguri de calatorie'),
(15, 5, 'Diverse'),
(16, 6, 'Electronice si electrocasnice'),
(17, 6, 'Auto'),
(18, 7, 'Case');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `utilizatori`
--

CREATE TABLE `utilizatori` (
  `id` int(11) NOT NULL,
  `nume` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `prenume` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `telefon` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `parola` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `imagine` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `descriere` text COLLATE utf8_romanian_ci NOT NULL,
  `data_nasterii` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `tip` varchar(100) COLLATE utf8_romanian_ci NOT NULL,
  `cont_minor` int(2) NOT NULL,
  `varsta` int(2) NOT NULL,
  `asociere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `utilizatori`
--

INSERT INTO `utilizatori` (`id`, `nume`, `prenume`, `email`, `telefon`, `parola`, `imagine`, `descriere`, `data_nasterii`, `tip`, `cont_minor`, `varsta`, `asociere`) VALUES
(1, 'Sperneac', 'Sergiu', 'sergiu.sperneac@yahoo.com', '0754719842', '$2y$10$I1yhzY/pYZO.YbJpFSvLW.f6bV2tu4PxAPQomORBsJtyc5iLAxhme', '66465e102ddd2.png', 'dawd awdwa dwa ', '2000-08-12', 'fara_restrictie', 0, 0, 0),
(2, 'Ionescu', 'George', 'george.ionescu@gmail.com', '07864562532', '$2y$10$PtVkK6TDz8zNWMq8WULphO2xAB6C1mcVzc/h6eZBI/mlpCU9qSyQ6', '6489ce8528640.png', 'Integer consectetur volutpat rhoncus. Aenean sit amet posuere nisi. Integer vel turpis odio. Sed tristique purus vitae efficitur cursus. Donec congue rhoncus orci ut laoreet. Quisque porttitor velit augue, vel condimentum sapien convallis at. Mauris interdum pretium nunc, at vulputate arcu lacinia et. Aliquam mattis arcu eget dolor euismod, et interdum ligula rutrum.', '', 'fara_restrictie', 0, 0, 0),
(7, 'Ionescu', 'Adrian', 'ionescu.adrian@gmail.com', '', '$2y$10$Vaq5W/.0evWHk8A0I4jAjeUfH5H6zD/f8BJQwqFB6/b6kg6y.7ROa', '', '', '', '', 1, 9, 1);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `utilizatori_chat`
--

CREATE TABLE `utilizatori_chat` (
  `id` int(11) NOT NULL,
  `id_chat` int(11) NOT NULL,
  `id_utilizator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `utilizatori_chat`
--

INSERT INTO `utilizatori_chat` (`id`, `id_chat`, `id_utilizator`) VALUES
(5, 5, 1);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `videoclipuri`
--

CREATE TABLE `videoclipuri` (
  `id` int(11) NOT NULL,
  `uniqid` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `titlu` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `categorie` int(11) NOT NULL,
  `subcategorie` int(11) NOT NULL,
  `video` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `durata` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `thumbnail` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `descriere` text COLLATE utf8_romanian_ci NOT NULL,
  `data` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `id_creator` int(11) NOT NULL,
  `status` int(2) NOT NULL,
  `vizualizari` int(11) NOT NULL,
  `tip` varchar(100) COLLATE utf8_romanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `videoclipuri`
--

INSERT INTO `videoclipuri` (`id`, `uniqid`, `titlu`, `categorie`, `subcategorie`, `video`, `durata`, `thumbnail`, `descriere`, `data`, `id_creator`, `status`, `vizualizari`, `tip`) VALUES
(1, '6486ecbcdfe9c', 'Acesta este titlul unui videoclip nou', 4, 10, 'video.mp4', '00:33', '66465e34696ba.jpg', 'Descrierea videoclipului nou', '12-06-2023 13:00', 1, 1, 9, 'fara_restrictie'),
(2, '6489b6511fd8d', 'Videoclip pentru testul 2', 0, 0, 'video.mp4', '00:33', '6489ccdceb16e.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce iaculis blandit nulla. Sed malesuada augue nec massa viverra, eget euismod diam facilisis. Integer euismod tempor ex, quis posuere ante elementum a. In at egestas neque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer elementum mi est, sed posuere quam dictum quis.', '14-06-2023 15:45', 1, 1, 65, 'fara_restrictie'),
(3, '6489ce1f382e6', 'Acesta este titlul unui videoclip', 0, 0, 'video.mp4', '00:33', '6489ce5be2ed5.jpg', 'Integer consectetur volutpat rhoncus. Aenean sit amet posuere nisi. Integer vel turpis odio. Sed tristique purus vitae efficitur cursus. Donec congue rhoncus orci ut laoreet. Quisque porttitor velit augue, vel condimentum sapien convallis at. Mauris interdum pretium nunc, at vulputate arcu lacinia et. Aliquam mattis arcu eget dolor euismod, et interdum ligula rutrum.', '14-06-2023 17:26', 2, 1, 75, 'fara_restrictie'),
(4, '64f8668d6b18f', 'Videoclip fara titlu', 0, 0, 'bandicam 2023-03-06 13-16-44-060.mp4', '', '', '', '06-09-2023 14:46', 1, 0, 0, 'fara_restrictie'),
(5, '64f86697a9e0e', 'Videoclip fara titlu', 0, 0, 'bandicam 2023-01-29 17-11-35-963.mp4', '', '', '', '06-09-2023 14:46', 1, 0, 0, 'fara_restrictie'),
(6, '64f866b1b56a1', 'Videoclip fara titlu', 0, 0, 'video.mp4', '', '', '', '06-09-2023 14:46', 1, 0, 0, 'fara_restrictie'),
(7, '64f8673f7bf4e', 'Videoclip fara titlu', 0, 0, 'VID-20230425-WA0000.mp4', '', '', '', '06-09-2023 14:49', 1, 0, 3, 'fara_restrictie'),
(8, '64f8673facc4e', 'Videoclip fara titlu', 0, 0, 'VID-20230425-WA0000.mp4', '', '', '', '06-09-2023 14:49', 1, 0, 0, 'fara_restrictie'),
(9, '64f8674a9ee32', 'Videoclip fara titlu', 0, 0, 'VID-20230425-WA0000.mp4', '', '', '', '06-09-2023 14:49', 1, 0, 0, 'fara_restrictie'),
(10, '64f8674acb243', 'Videoclip fara titlu', 0, 0, 'VID-20230425-WA0000.mp4', '', '', '', '06-09-2023 14:49', 1, 0, 0, 'fara_restrictie');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `vizionate`
--

CREATE TABLE `vizionate` (
  `id` int(11) NOT NULL,
  `id_videoclip` int(11) NOT NULL,
  `id_utilizator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `vizionate`
--

INSERT INTO `vizionate` (`id`, `id_videoclip`, `id_utilizator`) VALUES
(3, 2, 7),
(37, 3, 1),
(63, 2, 1);

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `abonamente`
--
ALTER TABLE `abonamente`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `aprecieri`
--
ALTER TABLE `aprecieri`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `blacklist_profile`
--
ALTER TABLE `blacklist_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `blacklist_videoclipuri`
--
ALTER TABLE `blacklist_videoclipuri`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `categorii`
--
ALTER TABLE `categorii`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `chaturi`
--
ALTER TABLE `chaturi`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `comentarii`
--
ALTER TABLE `comentarii`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `mesaje_chat`
--
ALTER TABLE `mesaje_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `subcategorii`
--
ALTER TABLE `subcategorii`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `utilizatori_chat`
--
ALTER TABLE `utilizatori_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `videoclipuri`
--
ALTER TABLE `videoclipuri`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `vizionate`
--
ALTER TABLE `vizionate`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `abonamente`
--
ALTER TABLE `abonamente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pentru tabele `aprecieri`
--
ALTER TABLE `aprecieri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `blacklist_profile`
--
ALTER TABLE `blacklist_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pentru tabele `blacklist_videoclipuri`
--
ALTER TABLE `blacklist_videoclipuri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `categorii`
--
ALTER TABLE `categorii`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pentru tabele `chaturi`
--
ALTER TABLE `chaturi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pentru tabele `comentarii`
--
ALTER TABLE `comentarii`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pentru tabele `mesaje_chat`
--
ALTER TABLE `mesaje_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pentru tabele `subcategorii`
--
ALTER TABLE `subcategorii`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pentru tabele `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pentru tabele `utilizatori_chat`
--
ALTER TABLE `utilizatori_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pentru tabele `videoclipuri`
--
ALTER TABLE `videoclipuri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pentru tabele `vizionate`
--
ALTER TABLE `vizionate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
