-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-08-2015 a las 00:13:15
-- Versión del servidor: 5.5.34
-- Versión de PHP: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `test`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `test_multi_sets`()
    DETERMINISTIC
begin
        select user() as first_col;
        select user() as first_col, now() as second_col;
        select user() as first_col, now() as second_col, now() as third_col;
        end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entries`
--

CREATE TABLE IF NOT EXISTS `entries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `subtitle` varchar(150) NOT NULL,
  `author` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(120) DEFAULT NULL,
  `tags` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `entries`
--

INSERT INTO `entries` (`id`, `title`, `subtitle`, `author`, `text`, `date`, `image`, `tags`) VALUES
(1, 'I Am Testing!', 'I Am Testing!', 'user', '<p><strong>Este es un texto largo donde voy a probar como serian los posteos que haga...</strong></p>', '2015-08-20 20:13:12', 'istari.jpg', 'prueba,posteo,istari'),
(2, 'Aca iria otro titulo mas', 'Aca iria otro titulo mas', 'user', '<p>En este caso sigo menos inspirado que un bacalao. pero bueno. se hace lo que se puede che.</p>', '2015-08-21 21:01:59', '', 'nosemecaeunaidea,malisimo'),
(3, 'El ultimo!', 'El ultimo!', 'user', '<p>Lo juro, despues de este no escribo mas! pero que buena imagen lpm!</p>', '2015-08-21 21:03:11', '', 'ojota,fpv,guardaaltair');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `adm` varchar(50) NOT NULL,
  `pass` varchar(120) NOT NULL,
  `name` varchar(100) NOT NULL,
  `bg_image` varchar(500) NOT NULL,
  `subtitle` varchar(150) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `adm`, `pass`, `name`, `bg_image`, `subtitle`, `active`) VALUES
(1, 'user', '859a3b15d100eb581f17450e53875d7e', 'User', '', 'This is a test user', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
