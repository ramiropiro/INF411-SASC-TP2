-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for cafe_corrientes
CREATE DATABASE IF NOT EXISTS `cafe_corrientes` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `cafe_corrientes`;

-- Dumping structure for table cafe_corrientes.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombres` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cafe_corrientes.clientes: ~0 rows (approximately)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id`, `apellido`, `direccion`) VALUES
	(1, 'RAMIREZ', 'Hipolito Irigoyen 335');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Dumping structure for table cafe_corrientes.forma_pagos
CREATE TABLE IF NOT EXISTS `forma_pagos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cafe_corrientes.forma_pagos: ~2 rows (approximately)
/*!40000 ALTER TABLE `forma_pagos` DISABLE KEYS */;
INSERT INTO `forma_pagos` (`id`, `descripcion`) VALUES
	(1, 'CREDITO'),
	(2, 'DEBITO'),
	(3, 'EFECTIVO');
/*!40000 ALTER TABLE `forma_pagos` ENABLE KEYS */;

-- Dumping structure for table cafe_corrientes.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `clientes_id` bigint(20) unsigned NOT NULL,
  `forma_pagos_id` bigint(20) unsigned NOT NULL,
  `fecha_pedido` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pedidos_clientes_id_foreign` (`clientes_id`),
  KEY `pedidos_forma_pagos_id_foreign` (`forma_pagos_id`),
  CONSTRAINT `pedidos_clientes_id_foreign` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pedidos_forma_pagos_id_foreign` FOREIGN KEY (`forma_pagos_id`) REFERENCES `forma_pagos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cafe_corrientes.pedidos: ~0 rows (approximately)
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` (`id`, `clientes_id`, `forma_pagos_id`, `fecha_pedido`) VALUES
	(1, 1, 3, '2022-08-23');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;

-- Dumping structure for table cafe_corrientes.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `stock_minimo` int(11) NOT NULL,
  `precio_unitario` double(8,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cafe_corrientes.productos: ~7 rows (approximately)
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` (`id`, `descripcion`, `codigo`, `imagen`, `stock`, `stock_minimo`, `precio_unitario`) VALUES
	(1, 'CHAI LATE', 'CC0005', 'img_productos/chai_late.png', 10, 50, 130.00),
	(2, 'CORTADO', 'CC0006', 'img_productos/cortado.png', 350, 50, 115.00),
	(3, 'ICED AMERICANO', 'CC0007', 'img_productos/iced_americano.png', 70, 50, 235.00),
	(4, 'ICED CORTADO', 'CC0008', 'img_productos/iced_cortado.png', 90, 80, 215.00),
	(5, 'LATTE', 'CC0009', 'img_productos/latte.png', 25, 60, 195.00),
	(6, 'SALTED CARAMEL', 'CC0010', 'img_productos/salted_caramel.png', 35, 50, 190.00),
	(7, 'CHIPA x 5', 'CC0011', 'img_productos/chipa.png', 80, 50, 250.00);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;

-- Dumping structure for table cafe_corrientes.detalle_pedidos
CREATE TABLE IF NOT EXISTS `detalle_pedidos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pedidos_id` bigint(20) unsigned NOT NULL,
  `productos_id` bigint(20) unsigned NOT NULL,
  `precio_unitario` double(8,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `detalle_pedidos_pedidos_id_foreign` (`pedidos_id`),
  KEY `detalle_pedidos_productos_id_foreign` (`productos_id`),
  CONSTRAINT `detalle_pedidos_pedidos_id_foreign` FOREIGN KEY (`pedidos_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_pedidos_productos_id_foreign` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cafe_corrientes.detalle_pedidos: ~0 rows (approximately)
/*!40000 ALTER TABLE `detalle_pedidos` DISABLE KEYS */;
INSERT INTO `detalle_pedidos` (`id`, `pedidos_id`, `productos_id`, `precio_unitario`, `cantidad`) VALUES
	(1, 1, 1, 250.00, 1);
/*!40000 ALTER TABLE `detalle_pedidos` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
