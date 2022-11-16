-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 16-11-2022 a las 10:18:36
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `apicars_laravel`
--
CREATE DATABASE IF NOT EXISTS `apicars_laravel` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `apicars_laravel`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cars`
--

DROP TABLE IF EXISTS `cars`;
CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `price` varchar(30) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cars_users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cars`
--

INSERT INTO `cars` (`id`, `user_id`, `title`, `description`, `price`, `status`, `created_at`, `updated_at`) VALUES
(6, 12, 'Coche de admin', 'admin admin', '1500', 'false', '2022-09-27 08:13:30', '2022-09-27 08:13:30'),
(7, 12, 'Primer video del canal', 'hola', '2500', 'false', '2022-09-27 08:18:39', '2022-09-27 08:18:39'),
(8, 13, 'Coche de angel :)', 'Confirmado que es mio', '5000', 'true', '2022-09-27 08:29:13', '2022-09-27 08:29:13'),
(9, 14, 'Mercedez Benz 2', 'hola', '1200', 'true', '2022-10-06 16:08:52', '2022-10-06 16:08:52'),
(10, 14, '12222222', '2w2wwwww', '126666', 'false', '2022-10-06 16:09:33', '2022-10-06 16:09:33'),
(11, 14, '223333', '322222', '13344', 'false', '2022-10-06 16:09:44', '2022-10-06 16:09:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `role`, `name`, `surname`, `password`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'angel@angel.com', 'ROLE_USER', 'Angel', 'Borrero', '519ba91a5a5b4afb9dc66f8805ce8c442b6576316c19c6896af2fa9bda6aff71', '2022-09-22 19:18:14', '2022-09-22 19:18:14', NULL),
(12, 'admin@admin.com', 'ROLE_USER', 'admin', 'admin', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2022-09-25 16:29:02', '2022-09-25 16:29:02', NULL),
(13, 'abocas@abocas.com', 'ROLE_USER', 'Angeeel', 'Borrero', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2022-09-27 08:22:35', '2022-09-27 08:22:35', NULL),
(14, 'pepe@pepe.com', 'ROLE_USER', 'pepe', 'ollero', '7c9e7c1494b2684ab7c19d6aff737e460fa9e98d5a234da1310c97ddf5691834', '2022-10-06 16:07:50', '2022-10-06 16:07:50', NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `fk_cars_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
