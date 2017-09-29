-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 29-09-2017 a las 22:23:42
-- Versión del servidor: 5.6.31
-- Versión de PHP: 5.6.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ot`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sabana_facturacion`
--

CREATE TABLE `sabana_facturacion` (
  `idsabana_facturacion` int(11) NOT NULL,
  `año` int(4) DEFAULT NULL,
  `mes` int(1) DEFAULT NULL,
  `Quincena` int(1) DEFAULT NULL,
  `contrato` varchar(9) DEFAULT NULL,
  `gerencia` varchar(3) DEFAULT NULL,
  `nombre_departamento` varchar(6) DEFAULT NULL,
  `departamento_ecp` varchar(3) DEFAULT NULL,
  `sector` varchar(15) DEFAULT NULL,
  `base` varchar(8) DEFAULT NULL,
  `CO` varchar(10) DEFAULT NULL,
  `UN` varchar(9) DEFAULT NULL,
  `fecha_reporte` date DEFAULT NULL,
  `No_OT` varchar(10) DEFAULT NULL,
  `cedula` varchar(10) DEFAULT NULL,
  `nombre_completo` varchar(10) DEFAULT NULL,
  `item` varchar(6) DEFAULT NULL,
  `descripcion` varchar(44) DEFAULT NULL,
  `conv_leg` varchar(5) DEFAULT NULL,
  `clasifica_gral` varchar(8) DEFAULT NULL,
  `clasifica_deta` varchar(26) DEFAULT NULL,
  `tarifa` int(6) DEFAULT NULL,
  `unidad` varchar(2) DEFAULT NULL,
  `cantidad_total` varchar(3) DEFAULT NULL,
  `valor_subtotal` varchar(9) DEFAULT NULL,
  `a` varchar(9) DEFAULT NULL,
  `i` varchar(9) DEFAULT NULL,
  `u` varchar(8) DEFAULT NULL,
  `total` varchar(11) DEFAULT NULL,
  `lugar` varchar(28) DEFAULT NULL,
  `municipio` varchar(9) DEFAULT NULL,
  `zona` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sabana_facturacion`
--
ALTER TABLE `sabana_facturacion`
  ADD PRIMARY KEY (`idsabana_facturacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `sabana_facturacion`
--
ALTER TABLE `sabana_facturacion`
  MODIFY `idsabana_facturacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30806;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
