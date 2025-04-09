-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2025 a las 13:43:57
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `projectofinal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hashp` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `imagen` varchar(255) DEFAULT 'avatar_default.png',
  `confirmado` tinyint(1) DEFAULT 0,
  `token` varchar(255) DEFAULT NULL,
  `token_expira_a` datetime DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `nif_nie` varchar(15) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `rol` enum('administrador','cliente') DEFAULT 'cliente',
  `creado_a` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `hashp`, `nombre`, `apellidos`, `imagen`, `confirmado`, `token`, `token_expira_a`, `telefono`, `nif_nie`, `fecha_nacimiento`, `rol`, `creado_a`) VALUES
(7, 'daniel.admin@ejemplo.com', '$2y$10$eDUpKDrXNuN0P9vdgUKNU.gj.8W8wYFeU9eHuvQaBblRhLru7Ru9y', 'Daniel', 'Ruiz', 'default.png', 1, NULL, NULL, '600123456', '12345678A', '1990-05-12', 'administrador', '2025-04-09 12:00:00'),
(8, 'juan.cliente@ejemplo.com', '$2y$10$PG70k4EQAlRt1QtZ2TnrHOtiEuSzRfncs7KAEbWEpIXpNEZnpFe3W', 'Juan', 'Pérez', 'default.png', 1, NULL, NULL, '600111111', '11111111A', '1985-02-15', 'cliente', '2025-04-09 12:00:00'),
(9, 'marta.cliente@ejemplo.com', '$2y$10$9YFnBxlK2UNflmE5olnDNeD2FbgdrYcKcyZzN7pAaImxMZ4o27ddK', 'Marta', 'López', 'default.png', 1, NULL, NULL, '600222222', '22222222B', '1992-07-20', 'cliente', '2025-04-09 12:00:00'),
(10, 'luis.cliente@ejemplo.com', '$2y$10$IKmmwUnlPWU4GfYGyISGquDPEkEJuK9HKr00VRRo4MXxvEYDbU9Q6', 'Luis', 'Martínez', 'default.png', 1, NULL, NULL, '600333333', '33333333C', '1988-11-05', 'cliente', '2025-04-09 12:00:00'),
(11, 'ana.cliente@ejemplo.com', '$2y$10$KRZquBbVhxuT0YtGzOZnGOWuSCxqE1BbDQUtKnkj1y9q1EtBN1aR6', 'Ana', 'García', 'default.png', 1, NULL, NULL, '600444444', '44444444D', '1995-04-17', 'cliente', '2025-04-09 12:00:00'),
(12, 'carla.cliente@ejemplo.com', '$2y$10$1AeFi8eNOrqb7KMG9gX8suIQcyVFRhzLRAZr4Trt8OpIAp5KuWhKm', 'Carla', 'Sánchez', 'default.png', 1, NULL, NULL, '600555555', '55555555E', '1993-09-09', 'cliente', '2025-04-09 12:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nif_nie` (`nif_nie`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
