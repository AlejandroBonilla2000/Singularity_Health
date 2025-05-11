-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2025 a las 23:21:40
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `singularity_health`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `appuser_tb`
--

CREATE TABLE `appuser_tb` (
  `id` int(11) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `IsMilitar` tinyint(1) DEFAULT 0,
  `IsTemporal` tinyint(1) DEFAULT 0,
  `TimeCreate` datetime DEFAULT current_timestamp(),
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `emailVerified` tinyint(1) DEFAULT 0,
  `verificationToken` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactinfo_tb`
--

CREATE TABLE `contactinfo_tb` (
  `id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Address` varchar(60) DEFAULT NULL,
  `CountryID` int(11) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `CelPhone` varchar(20) DEFAULT NULL,
  `EmergencyName` varchar(100) DEFAULT NULL,
  `EmergencyPhone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `country_tb`
--

CREATE TABLE `country_tb` (
  `id` int(11) NOT NULL,
  `CountryCode` varchar(4) NOT NULL,
  `CountryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `country_tb`
--

INSERT INTO `country_tb` (`id`, `CountryCode`, `CountryName`) VALUES
(1, 'US', 'United States'),
(2, 'CO', 'Colombia'),
(3, 'MX', 'Mexico'),
(4, 'AR', 'Argentina'),
(5, 'BR', 'Brazil'),
(6, 'CL', 'Chile'),
(7, 'PE', 'Peru'),
(8, 'VE', 'Venezuela'),
(9, 'PA', 'Panama'),
(10, 'EC', 'Ecuador'),
(11, 'CR', 'Costa Rica'),
(12, 'ES', 'Spain'),
(13, 'FR', 'France'),
(14, 'DE', 'Germany'),
(15, 'IT', 'Italy'),
(16, 'JP', 'Japan'),
(17, 'CN', 'China'),
(18, 'IN', 'India'),
(19, 'RU', 'Russia'),
(20, 'CA', 'Canada'),
(21, 'AU', 'Australia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `typedocument_tb`
--

CREATE TABLE `typedocument_tb` (
  `id` int(11) NOT NULL,
  `NameTypeDocument` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `typedocument_tb`
--

INSERT INTO `typedocument_tb` (`id`, `NameTypeDocument`) VALUES
(1, 'Cédula de Ciudadanía'),
(2, 'Pasaporte'),
(3, 'Tarjeta de Identidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userdocument_tb`
--

CREATE TABLE `userdocument_tb` (
  `id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Document` varchar(20) NOT NULL,
  `TypeDocumentID` int(11) NOT NULL,
  `PlaceExpedition` varchar(60) NOT NULL,
  `DateExpedition` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `appuser_tb`
--
ALTER TABLE `appuser_tb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `contactinfo_tb`
--
ALTER TABLE `contactinfo_tb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `CountryID` (`CountryID`);

--
-- Indices de la tabla `country_tb`
--
ALTER TABLE `country_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `typedocument_tb`
--
ALTER TABLE `typedocument_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `userdocument_tb`
--
ALTER TABLE `userdocument_tb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `TypeDocumentID` (`TypeDocumentID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `appuser_tb`
--
ALTER TABLE `appuser_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `contactinfo_tb`
--
ALTER TABLE `contactinfo_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `country_tb`
--
ALTER TABLE `country_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `typedocument_tb`
--
ALTER TABLE `typedocument_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `userdocument_tb`
--
ALTER TABLE `userdocument_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contactinfo_tb`
--
ALTER TABLE `contactinfo_tb`
  ADD CONSTRAINT `contactinfo_tb_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `appuser_tb` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contactinfo_tb_ibfk_2` FOREIGN KEY (`CountryID`) REFERENCES `country_tb` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `userdocument_tb`
--
ALTER TABLE `userdocument_tb`
  ADD CONSTRAINT `userdocument_tb_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `appuser_tb` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `userdocument_tb_ibfk_2` FOREIGN KEY (`TypeDocumentID`) REFERENCES `typedocument_tb` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
