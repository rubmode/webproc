-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 20-08-2015 a las 00:06:46
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `webproc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `keys`
--

CREATE TABLE IF NOT EXISTS `keys` (
`_id` int(11) NOT NULL,
  `key` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `app` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `keys`
--

INSERT INTO `keys` (`_id`, `key`, `app`) VALUES
(1, 'w384ppl1c4710n', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`_id` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`_id`, `email`, `password`, `date`) VALUES
(1, 'ruben@w3are.mx', '0cf7409df6cb955477edeb674d3ef1ec', '2015-06-01');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `keys`
--
ALTER TABLE `keys`
 ADD PRIMARY KEY (`_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `keys`
--
ALTER TABLE `keys`
MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
