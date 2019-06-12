-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Temps de generació: 11-06-2019 a les 17:24:18
-- Versió del servidor: 5.7.17
-- Versió de PHP: 7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `projecte_daw`
--


--
-- Bolcant dades de la taula `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `role`, `activated`, `activation_code`) VALUES
(1, 'admin', '63a9f0ea7bb98050796b649e85481845', 'admin@admin', 0, 1, NULL),
(2, 'company1', '63a9f0ea7bb98050796b649e85481845', 'w2.gcaballe@infomila.info', 1, 1, NULL),
(3, 'marc', '63a9f0ea7bb98050796b649e85481845', 'mbrufau@xtec.cat', 1, 1, NULL),
(4, 'usuari1', '63a9f0ea7bb98050796b649e85481845', 'm2.gcaballe@infomila.info', 2, 1, NULL),
(5, 'usuari2', '63a9f0ea7bb98050796b649e85481845', 'mail@mail.info', 2, 1, NULL);
COMMIT;


--
-- Bolcant dades de la taula `company`
--

INSERT INTO `company` (`id`, `name`, `cif`, `user`, `address`, `lat`, `lng`) VALUES
(1, 'Restaurant la Sal', '12341932481', 2, 'Igualada', 41.56956323391536, 1.4080948028564535),
(2, 'marc company', '4736834', 3, 'Igualada', 41.51200161313139, 1.4007991943359457);



--
-- Bolcant dades de la taula `product`
--

INSERT INTO `product` (`id`, `company`, `name`, `description`) VALUES
(10, 1, 'Costelles de Xai', 'Ben sucoses'),
(11, 1, 'Meló amb pernil', 'Meló de l\'Anoia'),
(12, 1, 'Pollastre a la planxa', 'Si, es raro fer tastos d\'això.'),
(20, 2, 'Pernil york', 'Un pernil de X denominació d\'origen, molt bó.'),
(21, 2, 'Formatge de cabra', 'De les cabres més simpàtiques dels pirineus.'),
(22, 2, 'Vi del penedès 95', 'La collita del 95 és una collita excepcional.'),
(23, 2, 'Vi barato', 'Excel·lent per fer calimotxos després d\'una setmana intensa de p');


--
-- Bolcant dades de la taula `activity`
--

INSERT INTO `activity` (`id`, `name`, `product`, `description`, `status`, `timestamp`) VALUES
(41, 'Tast de Pernil Dolç', 20, 'Es combinara amb encara més pernil.', 'done', '2019-06-02 17:34:30.7950'),
(42, 'Tast de formatge', 21, 'Es repartirán mostres per mportar.', 'closed', '2019-05-31 17:24:25.4404'),
(43, 'Tast de Pernil Dolç 2', 20, 'També hi hauràn bocatas.', 'open', '2019-06-02 17:41:35.4026'),
(44, 'Tast de formatge 2', 21, 'En el nostre local', 'open', '2019-06-02 17:41:43.4229'),
(45, 'Tast de perro verde', 23, 'Al restaurante emperador també en pots tastar.', 'done', '2019-06-02 17:52:33.2641'),
(46, 'Tast de costelletes', 10, 'Es fará al nostre restaurant', 'done', '2019-06-11 15:08:56.8770'),
(47, 'Tast de costelletes 2', 10, 'Aquest cop el farem a la terrassa', 'done', '2019-06-11 15:08:47.8746'),
(48, 'Tast de pernil i meló', 11, 'El pernil no és lo principal', 'done', '2019-06-11 15:08:52.7695');


--
-- Bolcant dades de la taula `review`
--

INSERT INTO `review` (`user`, `activity`, `enrolled`, `rating`, `text`) VALUES
(4, 41, 1, 4, 'Molt bó'),
(4, 42, 1, 0, ''),
(4, 44, 1, 2, 'Malament'),
(4, 45, 1, 1, 'Faltava una galleta per escupir...hic!'),
(4, 46, 1, 1, 'Sóc vegetarià!'),
(4, 47, 1, 5, 'Avui ja sóc carnívor.'),
(4, 48, 1, 3, 'Boníssim.');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
commit;