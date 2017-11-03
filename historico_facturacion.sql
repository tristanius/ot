-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 30-10-2017 a las 22:52:26
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
-- Estructura de tabla para la tabla `historico_facturacion`
--

CREATE TABLE `historico_facturacion` (
  `idhistorico_facturacion` int(1) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `mes` int(1) DEFAULT NULL,
  `Quincena` int(1) DEFAULT NULL,
  `contrato` varchar(25) DEFAULT NULL,
  `gerencia` varchar(25) DEFAULT NULL,
  `nombre_departamento` varchar(100) DEFAULT NULL,
  `departamento_ecp` varchar(100) DEFAULT NULL,
  `sector` varchar(45) DEFAULT NULL,
  `base` varchar(45) DEFAULT NULL,
  `centro_operacion` varchar(45) DEFAULT NULL,
  `unidad_negocio` varchar(25) DEFAULT NULL,
  `fecha_reporte` date DEFAULT NULL,
  `no_OT` varchar(50) DEFAULT NULL,
  `cedula` varchar(25) DEFAULT NULL,
  `nombre_completo` varchar(33) DEFAULT NULL,
  `item` varchar(12) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `conv_leg` varchar(12) DEFAULT NULL,
  `clasifica_gral` varchar(6) DEFAULT NULL,
  `clasifica_deta` varchar(28) DEFAULT NULL,
  `tarifa` double DEFAULT NULL,
  `unidad` varchar(25) DEFAULT NULL,
  `cantidad_total` decimal(25,0) DEFAULT NULL,
  `valor_subtotal` double DEFAULT NULL,
  `a` double DEFAULT NULL,
  `i` double DEFAULT NULL,
  `u` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `municipio` varchar(75) DEFAULT NULL,
  `zona` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `historico_facturacion`
--
ALTER TABLE `historico_facturacion`
  ADD PRIMARY KEY (`idhistorico_facturacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historico_facturacion`
--
ALTER TABLE `historico_facturacion`
  MODIFY `idhistorico_facturacion` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
