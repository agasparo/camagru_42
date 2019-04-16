SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `aime` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_aim` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `banned` (
  `id` int(11) NOT NULL,
  `ip` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `comm` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `texte` text NOT NULL,
  `id_obj` text NOT NULL,
  `id_pers` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `galerie` (
  `id` int(11) NOT NULL,
  `photo` text NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `img` (
  `id` int(11) NOT NULL,
  `photo` text NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `mail` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `membre` (
  `id` int(11) NOT NULL,
  `nom_prenom` text NOT NULL,
  `mail` text NOT NULL,
  `password` text NOT NULL,
  `verif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `membre` (`id`, `nom_prenom`, `mail`, `password`, `verif`) VALUES
(1, 'arthur', 'arthurysiite@gmail.com', 'b39e04771ec9d25557f0129d20da03ce2bd54ce8', 1),
(15, 'arthur1', 'arthurysiite@gmail.com', 'b39e04771ec9d25557f0129d20da03ce2bd54ce8', 1);

ALTER TABLE `aime`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `banned`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `comm`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `galerie`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `img`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mail`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `membre`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `aime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `banned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `comm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `galerie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `membre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
