-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2019 a las 13:32:27
-- Versión del servidor: 5.7.17
-- Versión de PHP: 7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `projecte_daw`
--

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`username`, `password`, `email`, `role`, `activated`, `activation_code`) VALUES
('company1', '63a9f0ea7bb98050796b649e85481845', 'w2.gcaballe@infomila.info', 1, 1, NULL),
('usuari1', '63a9f0ea7bb98050796b649e85481845', 'm2.gcaballe@infomila.info', 2, 1, NULL),
('admin', '63a9f0ea7bb98050796b649e85481845', 'admin@admin', 0, 1, NULL);


--
-- Volcado de datos para la tabla `company`
--

INSERT INTO `company` (`id`, `name`, `cif`, `user`, `address`, `lat`, `lng`) VALUES
(3997, 'Restaurant la Sal', '12341932481', 6170, '', 41.56956323391536, 1.4080948028564535);


--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `company`, `name`, `description`) VALUES
(20, 3997, 'Pernil york', 'Un pernil de X denominació d\'origen, molt bó.'),
(21, 3997, 'Formatge de cabra', 'De les cabres més simpàtiques dels pirineus.'),
(22, 3997, 'Vi del penedès 95', 'La collita del 95 és una collita excepcional.'),
(23, 3997, 'Vi barato', 'Excel·lent per fer calimotxos després d\'una setmana intensa de p');



--
-- Volcado de datos para la tabla `activity`
--

INSERT INTO `activity` (`id`, `name`, `product`, `description`, `status`, `timestamp`) VALUES
(36, 'Tast de Pernil Dolç', 20, 'Es combinara amb encara més pernil.', 'done', '2019-05-31 11:31:03.3277'),
(37, 'Tast de formatge', 21, 'Es repartirán mostres per mportar.', 'done', '2019-05-31 11:31:08.6458'),
(38, 'Tast de Pernil Dolç 2', 20, 'També hi hauràn bocatas.', 'open', '2019-05-30 08:00:00.0000'),
(40, 'Tast de vi', 23, 'Ho farem al nostre local.', 'done', '2019-05-31 11:31:13.8365');



-- Volcado de datos para la tabla `review`
--

INSERT INTO `review` (`user`, `activity`, `enrolled`, `rating`, `text`) VALUES
(6171, 37, 1, 3, 'Molt bo.'),
(6171, 40, 1, 0, '');


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
