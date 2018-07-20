-- phpMyAdmin SQL Dump
-- version 4.0.10.15
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 20-07-2018 a las 13:13:00
-- Versión del servidor: 5.1.73-community
-- Versión de PHP: 5.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajeria`
--

CREATE TABLE IF NOT EXISTS `mensajeria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `fecha` datetime NOT NULL,
  `mensaje` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE IF NOT EXISTS `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `foto` varchar(200) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `texto` longtext CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE IF NOT EXISTS `partidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(1) NOT NULL,
  `fecha` date NOT NULL,
  `local` varchar(2) NOT NULL,
  `visitante` varchar(2) NOT NULL,
  `marcadorLocal` int(2) NOT NULL DEFAULT '0',
  `marcadorVisitante` int(2) NOT NULL DEFAULT '0',
  `fase` enum('grupo','octavos','cuartos','semis','final') NOT NULL,
  `jugado` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id`, `grupo`, `fecha`, `local`, `visitante`, `marcadorLocal`, `marcadorVisitante`, `fase`, `jugado`) VALUES
(1, 'A', '2017-06-14', 'RU', 'SA', 2, 1, 'grupo', 1),
(2, 'A', '2018-06-15', 'EG', 'UR', 0, 3, 'grupo', 1),
(3, 'B', '2018-06-15', 'MA', 'IR', 0, 0, 'grupo', 0),
(4, 'B', '2018-06-15', 'PT', 'ES', 0, 0, 'grupo', 0),
(5, 'C', '2018-06-16', 'FR', 'AU', 0, 0, 'grupo', 0),
(6, 'D', '2018-06-16', 'AR', 'IS', 0, 0, 'grupo', 0),
(7, 'C', '2018-06-16', 'PE', 'DK', 0, 0, 'grupo', 0),
(8, 'D', '2018-06-16', 'HR', 'NG', 0, 0, 'grupo', 0),
(9, 'E', '2018-06-17', 'CR', 'RS', 0, 0, 'grupo', 0),
(10, 'F', '2018-06-17', 'DE', 'MX', 0, 0, 'grupo', 0),
(11, 'E', '2018-06-17', 'BR', 'CH', 0, 0, 'grupo', 0),
(12, 'F', '2018-06-18', 'SE', 'KR', 0, 0, 'grupo', 0),
(13, 'G', '2018-06-18', 'BE', 'PA', 0, 0, 'grupo', 0),
(14, 'G', '2018-06-18', 'TN', 'GB', 0, 0, 'grupo', 0),
(15, 'H', '2018-06-19', 'CO', 'JP', 0, 0, 'grupo', 0),
(16, 'H', '2018-06-19', 'PL', 'SN', 0, 0, 'grupo', 0),
(17, 'A', '2018-06-19', 'RU', 'EG', 1, 1, 'grupo', 1),
(18, 'B', '2018-06-20', 'PT', 'MA', 0, 0, 'grupo', 0),
(19, 'A', '2018-06-20', 'UR', 'SA', 0, 0, 'grupo', 0),
(20, 'B', '2018-06-20', 'IR', 'ES', 0, 0, 'grupo', 0),
(21, 'C', '2018-06-21', 'DK', 'AU', 0, 0, 'grupo', 0),
(22, 'C', '2018-06-21', 'FR', 'PE', 0, 0, 'grupo', 0),
(23, 'D', '2018-06-21', 'AR', 'HR', 0, 0, 'grupo', 0),
(24, 'E', '2018-06-22', 'BR', 'CR', 0, 0, 'grupo', 0),
(25, 'D', '2018-06-22', 'NG', 'IS', 0, 0, 'grupo', 0),
(26, 'E', '2018-06-22', 'RS', 'CH', 0, 0, 'grupo', 0),
(27, 'G', '2018-06-23', 'BE', 'TN', 0, 0, 'grupo', 0),
(28, 'F', '2018-06-23', 'KR', 'MX', 0, 0, 'grupo', 0),
(29, 'F', '2018-06-23', 'DE', 'SE', 0, 0, 'grupo', 0),
(30, 'G', '2018-06-24', 'GB', 'PA', 0, 0, 'grupo', 0),
(31, 'H', '2018-06-24', 'JP', 'SN', 0, 0, 'grupo', 0),
(32, 'H', '2018-06-24', 'PL', 'CO', 0, 0, 'grupo', 0),
(33, 'A', '2018-06-25', 'SA', 'EG', 0, 0, 'grupo', 0),
(34, 'A', '2018-06-25', 'UR', 'RU', 0, 0, 'grupo', 0),
(35, 'B', '2018-06-25', 'IR', 'PT', 0, 0, 'grupo', 0),
(36, 'B', '2018-06-25', 'ES', 'MA', 0, 0, 'grupo', 0),
(37, 'C', '2018-06-26', 'AU', 'PE', 0, 0, 'grupo', 0),
(38, 'C', '2018-06-26', 'DK', 'FR', 0, 0, 'grupo', 0),
(39, 'D', '2018-06-26', 'NG', 'AR', 0, 0, 'grupo', 0),
(40, 'D', '2018-06-26', 'IS', 'HR', 0, 0, 'grupo', 0),
(41, 'F', '2018-06-27', 'KR', 'DE', 0, 0, 'grupo', 0),
(42, 'F', '2018-06-27', 'MX', 'SE', 0, 0, 'grupo', 0),
(43, 'E', '2018-06-27', 'CH', 'CR', 0, 0, 'grupo', 0),
(44, 'E', '2018-06-27', 'RS', 'BR', 0, 0, 'grupo', 0),
(45, 'H', '2018-06-28', 'SN', 'CO', 0, 0, 'grupo', 0),
(46, 'H', '2018-06-28', 'JP', 'PL', 0, 0, 'grupo', 0),
(47, 'G', '2018-06-28', 'GB', 'BE', 0, 0, 'grupo', 0),
(48, 'G', '2018-06-28', 'PA', 'TN', 0, 0, 'grupo', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predicciones`
--

CREATE TABLE IF NOT EXISTS `predicciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `idPartido` int(11) NOT NULL,
  `marcadorLocal` int(2) NOT NULL,
  `marcadorVisitante` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


--
-- Estructura de tabla para la tabla `selecciones`
--

CREATE TABLE IF NOT EXISTS `selecciones` (
  `id` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `grupo` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `selecciones`
--

INSERT INTO `selecciones` (`id`, `nombre`, `grupo`) VALUES
('RU', 'Rusia', 'A'),
('SA', 'Arabia Saudí', 'A'),
('EG', 'Egipto', 'A'),
('UR', 'Uruguay', 'A'),
('PT', 'Portugal', 'B'),
('ES', 'España', 'B'),
('MA', 'Marruecos', 'B'),
('IR', 'Irán', 'B'),
('FR', 'Francia', 'C'),
('AU', 'Australia', 'C'),
('PE', 'Perú', 'C'),
('DK', 'Dinamarca', 'C'),
('AR', 'Argentina', 'D'),
('IS', 'Islandia', 'D'),
('HR', 'Croacia', 'D'),
('NG', 'Nigeria', 'D'),
('BR', 'Brasil', 'E'),
('CH', 'Suiza', 'E'),
('CR', 'Costa Rica', 'E'),
('RS', 'Serbia', 'E'),
('DE', 'Alemania', 'F'),
('MX', 'México', 'F'),
('SE', 'Suecia', 'F'),
('KR', 'Corea del Sur', 'F'),
('BE', 'Bélgica', 'G'),
('PA', 'Panamá', 'G'),
('TN', 'Túnez', 'G'),
('GB', 'Inglaterra', 'G'),
('PL', 'Polonia', 'H'),
('SN', 'Senegal', 'H'),
('CO', 'Colombia', 'H'),
('JP', 'Japón', 'H');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `code` varchar(5) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT '0',
  `tfcm` varchar(250) NOT NULL,
  PRIMARY KEY (`id`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
