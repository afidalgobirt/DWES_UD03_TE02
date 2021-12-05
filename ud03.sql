-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2021 a las 18:26:49
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ud03`
--
CREATE DATABASE IF NOT EXISTS `ud03` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ud03`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cesta`
--

CREATE TABLE `cesta` (
  `idcesta` int(11) UNSIGNED NOT NULL,
  `idusuario` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cesta_lineas`
--

CREATE TABLE `cesta_lineas` (
  `idcesta_lineas` int(11) UNSIGNED NOT NULL,
  `idcesta` int(11) UNSIGNED NOT NULL,
  `idproducto` int(11) UNSIGNED NOT NULL,
  `cantidad` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familia`
--

CREATE TABLE `familia` (
  `idFamilia` int(11) UNSIGNED NOT NULL,
  `Familia` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `familia`
--

INSERT INTO `familia` (`idFamilia`, `Familia`) VALUES
(1, 'Digital');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(11) UNSIGNED NOT NULL,
  `ProductoNombre` varchar(45) NOT NULL,
  `idTipoProducto` int(11) UNSIGNED NOT NULL,
  `Unidad` varchar(45) NOT NULL,
  `Descripcion` varchar(45) NOT NULL,
  `pvpUnidad` float NOT NULL,
  `Descuento` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `ProductoNombre`, `idTipoProducto`, `Unidad`, `Descripcion`, `pvpUnidad`, `Descuento`) VALUES
(1, 'HP 13 Envy', 1, 'ud', 'Ordenador HP', 1230, 20),
(2, 'Macbook 13', 2, 'ud', 'Ordenador 13 pulgadas', 1350, 10),
(3, 'Visual Studio', 2, 'ud', 'Visual Studio', 56, 1),
(4, 'Nikon D3500', 3, 'ud', 'Camara de fotos', 399, 0),
(5, 'Sony FDR', 4, 'ud', 'Camara de video', 700, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `idTipo_producto` int(11) UNSIGNED NOT NULL,
  `DescTipoProd` varchar(45) NOT NULL,
  `idFamilia` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`idTipo_producto`, `DescTipoProd`, `idFamilia`) VALUES
(1, 'Hardware', 1),
(2, 'Software', 1),
(3, 'Camara', 1),
(4, 'Video', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) UNSIGNED NOT NULL,
  `Nombre` varchar(45) NOT NULL,
  `Apellidos` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cesta`
--
ALTER TABLE `cesta`
  ADD PRIMARY KEY (`idcesta`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `cesta_lineas`
--
ALTER TABLE `cesta_lineas`
  ADD PRIMARY KEY (`idcesta_lineas`),
  ADD KEY `idcesta` (`idcesta`),
  ADD KEY `idproducto` (`idproducto`);

--
-- Indices de la tabla `familia`
--
ALTER TABLE `familia`
  ADD PRIMARY KEY (`idFamilia`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `idTipoProducto` (`idTipoProducto`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`idTipo_producto`),
  ADD KEY `idFamilia` (`idFamilia`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cesta`
--
ALTER TABLE `cesta`
  ADD CONSTRAINT `cesta_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION;

--
-- Filtros para la tabla `cesta_lineas`
--
ALTER TABLE `cesta_lineas`
  ADD CONSTRAINT `cesta_lineas_ibfk_1` FOREIGN KEY (`idcesta`) REFERENCES `cesta` (`idcesta`) ON DELETE CASCADE,
  ADD CONSTRAINT `cesta_lineas_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idTipoProducto`) REFERENCES `tipo_producto` (`idTipo_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD CONSTRAINT `tipo_producto_ibfk_1` FOREIGN KEY (`idFamilia`) REFERENCES `familia` (`idFamilia`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
