-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: comparador
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articulo_etiquetas`
--

DROP TABLE IF EXISTS `articulo_etiquetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulo_etiquetas` (
  `articulo_id` int(11) NOT NULL,
  `etiqueta_id` int(11) NOT NULL,
  PRIMARY KEY (`articulo_id`,`etiqueta_id`),
  KEY `fk_articulo_etiquetas_etiqueta` (`etiqueta_id`),
  CONSTRAINT `fk_articulo_etiquetas_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_articulo_etiquetas_etiqueta` FOREIGN KEY (`etiqueta_id`) REFERENCES `etiquetas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulo_etiquetas`
--

LOCK TABLES `articulo_etiquetas` WRITE;
/*!40000 ALTER TABLE `articulo_etiquetas` DISABLE KEYS */;
INSERT INTO `articulo_etiquetas` VALUES (1,1),(2,2),(3,3),(4,4),(5,5);
/*!40000 ALTER TABLE `articulo_etiquetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulos`
--

DROP TABLE IF EXISTS `articulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL COMMENT 'nombre del articulo',
  `descripcion` text DEFAULT NULL COMMENT 'descripcion del articulo',
  `categoria_id` int(11) DEFAULT NULL COMMENT 'id de la categoria del producto',
  `etiqueta_id` int(11) DEFAULT NULL COMMENT 'id de la etiqueta del producto',
  `imagen_principal` varchar(255) DEFAULT NULL COMMENT 'imagen del articulo',
  `visible` tinyint(1) DEFAULT 1 COMMENT 'si el articulo esta visible o no, por defecto si',
  `cerrado` tinyint(1) DEFAULT 0 COMMENT 'si el articulo esta cerrado a la venta, por defecto no',
  `tipo_marcado` enum('comun','particular') DEFAULT 'comun' COMMENT 'tipo de articulo',
  `registro_id` int(11) DEFAULT NULL COMMENT 'id del usuario creador',
  `articulo_tienda_id` int(11) DEFAULT NULL COMMENT 'id relacionado con tabla articulo-tienda',
  PRIMARY KEY (`id`),
  KEY `fk_articulos_categoria` (`categoria_id`),
  KEY `fk_articulos_etiqueta` (`etiqueta_id`),
  KEY `fk_articulos_registro` (`registro_id`),
  KEY `fk_articulos_articulo_tienda` (`articulo_tienda_id`),
  CONSTRAINT `fk_articulos_articulo_tienda` FOREIGN KEY (`articulo_tienda_id`) REFERENCES `articulos_tienda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_articulos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_articulos_etiqueta` FOREIGN KEY (`etiqueta_id`) REFERENCES `etiquetas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_articulos_registro` FOREIGN KEY (`registro_id`) REFERENCES `registro_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulos`
--

LOCK TABLES `articulos` WRITE;
/*!40000 ALTER TABLE `articulos` DISABLE KEYS */;
INSERT INTO `articulos` VALUES (1,'Smartphone XYZ','Un smartphone de última generación con todas las características que necesitas.',1,1,'smartphone_xyz.jpg',1,0,'comun',1,NULL),(2,'Televisor 4K Ultra HD','Televisor con resolución 4K Ultra HD y tecnología HDR.',1,2,'televisor_4k.jpg',1,0,'comun',2,NULL),(3,'Lavadora Eco','Lavadora de alta eficiencia energética con múltiples programas de lavado.',2,3,'lavadora_eco.jpg',1,0,'comun',3,NULL),(4,'Camiseta Deportiva','Camiseta deportiva de alta calidad, ideal para cualquier actividad física.',3,4,'camiseta_deportiva.jpg',1,0,'comun',4,NULL),(5,'3342','rr4',1,1,'algo.png',0,1,'comun',5,NULL),(7,'aa','sss',1,1,'algo.png',1,0,'comun',NULL,NULL),(8,'aa','sss',1,1,'algo.png',1,0,'comun',NULL,NULL),(9,'aa','sss',1,1,'algo.png',1,0,'comun',NULL,NULL),(10,'aa','sss',1,1,'algo.png',1,0,'comun',NULL,NULL),(11,'aa','sss',1,1,'algo.png',1,0,'comun',NULL,NULL),(12,'aa','sss',1,1,'algo.png',1,0,'comun',NULL,NULL);
/*!40000 ALTER TABLE `articulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulos_tienda`
--

DROP TABLE IF EXISTS `articulos_tienda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulos_tienda` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id del registro',
  `articulo_id` int(11) DEFAULT NULL COMMENT 'id del articulo',
  `tienda_id` int(11) DEFAULT NULL COMMENT 'id de la tienda',
  `precio_actual` decimal(10,2) DEFAULT NULL COMMENT 'precio del producto',
  `historico_id` int(11) DEFAULT NULL COMMENT 'id del historico',
  `oferta_id` int(11) DEFAULT NULL COMMENT 'id de la oferta',
  `suma_valoraciones` int(11) DEFAULT 0 COMMENT 'suma de valoraciones',
  `suma_votos` int(11) DEFAULT 0 COMMENT 'suma de los votos',
  `visible` tinyint(1) DEFAULT 1 COMMENT 'si esta visible o no',
  `cerrado` tinyint(1) DEFAULT 0 COMMENT 'si esta cerrado o no',
  `denuncias` int(11) DEFAULT 0 COMMENT 'numero de denuncias',
  `fecha_primera_denuncia` datetime DEFAULT NULL COMMENT 'fecha primera denuncia',
  `motivo_denuncia` text DEFAULT NULL COMMENT 'motivo de denuncia',
  `bloqueado` tinyint(1) DEFAULT 0 COMMENT 'si esta bloqueado o no',
  `fecha_bloqueo` datetime DEFAULT NULL COMMENT 'fecha del bloqueo',
  `motivo_bloqueo` text DEFAULT NULL COMMENT 'motivo del bloqueo',
  `cerrado_comentar` tinyint(1) DEFAULT 0 COMMENT 'si puede recibir comentarios',
  `registro_id` int(11) DEFAULT NULL COMMENT 'id del usuario creador',
  `comentario_id` int(11) DEFAULT NULL COMMENT 'id de comentarios relacionado',
  PRIMARY KEY (`id`),
  KEY `fk_articulos_tienda_articulo` (`articulo_id`),
  KEY `fk_articulos_tienda_tienda` (`tienda_id`),
  KEY `fk_articulos_tienda_historico` (`historico_id`),
  KEY `fk_articulos_tienda_oferta` (`oferta_id`),
  KEY `fk_articulos_tienda_registro` (`registro_id`),
  KEY `fk_articulos_tienda_comentario` (`comentario_id`),
  CONSTRAINT `fk_articulos_tienda_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_articulos_tienda_comentario` FOREIGN KEY (`comentario_id`) REFERENCES `comentarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_articulos_tienda_historico` FOREIGN KEY (`historico_id`) REFERENCES `historico_precios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_articulos_tienda_oferta` FOREIGN KEY (`oferta_id`) REFERENCES `ofertas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_articulos_tienda_registro` FOREIGN KEY (`registro_id`) REFERENCES `registro_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_articulos_tienda_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulos_tienda`
--

LOCK TABLES `articulos_tienda` WRITE;
/*!40000 ALTER TABLE `articulos_tienda` DISABLE KEYS */;
INSERT INTO `articulos_tienda` VALUES (1,1,1,299.99,1,1,10,5,1,0,0,NULL,NULL,0,NULL,NULL,0,1,NULL),(2,2,2,499.99,2,2,20,10,1,0,0,NULL,NULL,0,NULL,NULL,0,2,NULL),(3,3,3,199.99,3,3,30,15,1,0,0,NULL,NULL,0,NULL,NULL,0,3,NULL),(4,4,4,29.99,4,4,40,20,1,0,0,NULL,NULL,0,NULL,NULL,0,4,NULL),(5,5,5,9.99,5,5,50,25,0,0,0,NULL,NULL,0,NULL,NULL,0,5,NULL);
/*!40000 ALTER TABLE `articulos_tienda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avisos`
--

DROP TABLE IF EXISTS `avisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clase` enum('Aviso','Denuncia','Consulta','Mensaje Generico','Bloqueo') NOT NULL,
  `texto` text DEFAULT NULL,
  `usuario_origen_id` int(11) NOT NULL,
  `usuario_destino_id` int(11) NOT NULL,
  `tienda_id` int(11) DEFAULT 0,
  `articulo_id` int(11) DEFAULT 0,
  `comentario_id` int(11) DEFAULT 0,
  `fecha_lectura` datetime DEFAULT NULL COMMENT 'para usuario destino',
  `fecha_aceptado` datetime DEFAULT NULL COMMENT 'para moderadores o administradores',
  PRIMARY KEY (`id`),
  KEY `fk_avisos_usuario_origen` (`usuario_origen_id`),
  KEY `fk_avisos_usuario_destino` (`usuario_destino_id`),
  KEY `fk_avisos_tienda` (`tienda_id`),
  KEY `fk_avisos_articulo` (`articulo_id`),
  KEY `fk_avisos_comentario` (`comentario_id`),
  CONSTRAINT `fk_avisos_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_avisos_comentario` FOREIGN KEY (`comentario_id`) REFERENCES `comentarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_avisos_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_avisos_usuario_destino` FOREIGN KEY (`usuario_destino_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_avisos_usuario_origen` FOREIGN KEY (`usuario_origen_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avisos`
--

LOCK TABLES `avisos` WRITE;
/*!40000 ALTER TABLE `avisos` DISABLE KEYS */;
INSERT INTO `avisos` VALUES (1,'Aviso','Este es un aviso de prueba.',1,2,1,1,1,NULL,NULL),(2,'Denuncia','Este es una denuncia de prueba.',2,3,2,2,2,NULL,NULL),(3,'Consulta','Este es una consulta de prueba.',3,4,3,3,3,NULL,NULL),(4,'Mensaje Generico','Este es un mensaje genérico de prueba.',4,5,4,4,4,NULL,NULL),(5,'Bloqueo','Este es un bloqueo de prueba.',5,1,5,5,5,NULL,NULL);
/*!40000 ALTER TABLE `avisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backup`
--

DROP TABLE IF EXISTS `backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_archivo` varchar(255) NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `tamaño` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup`
--

LOCK TABLES `backup` WRITE;
/*!40000 ALTER TABLE `backup` DISABLE KEYS */;
/*!40000 ALTER TABLE `backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `icono` varchar(255) DEFAULT NULL,
  `categoria_padre_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categorias_padre` (`categoria_padre_id`),
  CONSTRAINT `fk_categorias_padre` FOREIGN KEY (`categoria_padre_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Electrónica','Productos electrónicos y gadgets',NULL,NULL),(2,'Hogar','Artículos para el hogar y decoración',NULL,NULL),(3,'Ropa','Prendas de vestir y accesorios',NULL,NULL),(4,'Deportes','Equipamiento y ropa deportiva',NULL,NULL),(5,'Libros','Libros y material de lectura',NULL,NULL);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clasificaciones`
--

DROP TABLE IF EXISTS `clasificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clasificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `icono` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clasificaciones`
--

LOCK TABLES `clasificaciones` WRITE;
/*!40000 ALTER TABLE `clasificaciones` DISABLE KEYS */;
INSERT INTO `clasificaciones` VALUES (1,'Electrónica','Productos electrónicos y gadgets','icono_electronica.png'),(2,'Hogar','Artículos para el hogar y decoración','icono_hogar.png'),(3,'Ropa','Prendas de vestir y accesorios','icono_ropa.png'),(4,'Deportes','Equipamiento y ropa deportiva','icono_deportes.png'),(5,'Libros','Libros y material de lectura','icono_libros.png');
/*!40000 ALTER TABLE `clasificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tienda_id` int(11) DEFAULT NULL COMMENT 'id de la tienda',
  `articulo_id` int(11) DEFAULT NULL COMMENT 'id del articulo, NULL si es comentario de tienda',
  `valoracion` int(11) DEFAULT NULL COMMENT 'valoracion del comentario',
  `texto` text DEFAULT NULL COMMENT 'texto del comentario',
  `comentario_padre_id` int(11) DEFAULT NULL COMMENT 'id del comentario padre',
  `cerrado` tinyint(1) DEFAULT 0 COMMENT 'si permite o no respuestas',
  `denuncias` int(11) DEFAULT 0 COMMENT 'numero de denuncias al comentario',
  `fecha_primera_denuncia` datetime DEFAULT NULL COMMENT 'fecha de la primera denuncia',
  `motivo_denuncia` text DEFAULT NULL COMMENT 'motivo de la denuncia',
  `bloqueado` tinyint(1) DEFAULT 0 COMMENT 'si esta bloqueado el comentario',
  `fecha_bloqueo` datetime DEFAULT NULL COMMENT 'fecha de bloqueo',
  `motivo_bloqueo` text DEFAULT NULL COMMENT 'motivo del bloqueo',
  `registro_id` int(11) DEFAULT NULL COMMENT 'id del creador del comentario',
  PRIMARY KEY (`id`),
  KEY `fk_comentarios_tienda` (`tienda_id`),
  KEY `fk_comentarios_articulo` (`articulo_id`),
  KEY `fk_comentarios_padre` (`comentario_padre_id`),
  KEY `fk_comentarios_registro` (`registro_id`),
  CONSTRAINT `fk_comentarios_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_comentarios_padre` FOREIGN KEY (`comentario_padre_id`) REFERENCES `comentarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_comentarios_registro` FOREIGN KEY (`registro_id`) REFERENCES `registro_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_comentarios_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` VALUES (1,1,1,5,'Excelente producto, muy recomendado.',NULL,0,0,NULL,NULL,0,NULL,NULL,1),(2,2,2,4,'Buen producto, pero podría mejorar.',NULL,0,0,NULL,NULL,0,NULL,NULL,2),(3,3,3,3,'Producto regular, cumple con lo básico.',NULL,0,0,NULL,NULL,0,NULL,NULL,3),(4,4,4,2,'No me gustó el producto, tiene varios defectos.',NULL,0,0,NULL,NULL,0,NULL,NULL,4),(5,5,5,1,'Muy mal producto, no lo recomiendo.',NULL,0,0,NULL,NULL,0,NULL,NULL,5);
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuraciones`
--

DROP TABLE IF EXISTS `configuraciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuraciones` (
  `clave` varchar(50) NOT NULL,
  `valor` text DEFAULT NULL,
  PRIMARY KEY (`clave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuraciones`
--

LOCK TABLES `configuraciones` WRITE;
/*!40000 ALTER TABLE `configuraciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `configuraciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `duenos`
--

DROP TABLE IF EXISTS `duenos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `duenos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tienda` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `nif` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_duenos_tienda` (`id_tienda`),
  KEY `fk_duenos_usuario` (`id_usuario`),
  CONSTRAINT `fk_duenos_tienda` FOREIGN KEY (`id_tienda`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_duenos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `duenos`
--

LOCK TABLES `duenos` WRITE;
/*!40000 ALTER TABLE `duenos` DISABLE KEYS */;
INSERT INTO `duenos` VALUES (1,1,1,'Tienda Electrónica S.A.','12345678A'),(2,2,2,'Hogar y Decoración S.L.','87654321B'),(3,3,3,'Deportes y Fitness C.B.','11223344C'),(4,4,4,'Librería Central S.A.','44332211D'),(5,5,5,'Moda y Estilo S.L.','55667788E');
/*!40000 ALTER TABLE `duenos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etiquetas`
--

DROP TABLE IF EXISTS `etiquetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etiquetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etiquetas`
--

LOCK TABLES `etiquetas` WRITE;
/*!40000 ALTER TABLE `etiquetas` DISABLE KEYS */;
INSERT INTO `etiquetas` VALUES (1,'Electrónica','Productos relacionados con dispositivos electrónicos'),(2,'Hogar','Artículos para el hogar y decoración'),(3,'Ropa','Prendas de vestir y accesorios'),(4,'Deportes','Equipamiento y ropa deportiva'),(5,'Libros','Libros y material de lectura');
/*!40000 ALTER TABLE `etiquetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historico_precios`
--

DROP TABLE IF EXISTS `historico_precios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historico_precios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `articulo_id` int(11) DEFAULT NULL,
  `tienda_id` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_historico_articulo` (`articulo_id`),
  KEY `fk_historico_tienda` (`tienda_id`),
  CONSTRAINT `fk_historico_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_historico_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico_precios`
--

LOCK TABLES `historico_precios` WRITE;
/*!40000 ALTER TABLE `historico_precios` DISABLE KEYS */;
INSERT INTO `historico_precios` VALUES (1,1,1,'2023-09-01 00:00:00',399.99),(2,1,1,'2023-10-01 00:00:00',299.99),(3,2,2,'2023-10-01 00:00:00',599.99),(4,2,2,'2023-11-01 00:00:00',499.99),(5,3,3,'2023-11-01 00:00:00',299.99),(6,3,3,'2023-12-01 00:00:00',199.99),(7,4,4,'2023-12-01 00:00:00',39.99),(8,4,4,'2024-01-01 00:00:00',29.99),(9,5,5,'2024-01-01 00:00:00',19.99),(10,5,5,'2024-02-01 00:00:00',9.99),(11,7,5,'2025-01-08 01:42:50',0.00),(12,7,5,'2025-01-08 01:43:04',0.00),(13,7,5,'2025-01-08 01:48:06',0.00),(14,7,5,'2025-01-08 01:54:05',0.00),(15,7,5,'2025-01-08 01:58:31',0.00),(16,5,5,'2025-01-08 09:37:18',NULL),(17,5,5,'2025-01-08 10:00:23',15.00),(18,5,5,'2025-01-08 10:33:12',14.00),(19,5,5,'2025-01-08 10:34:22',14.00),(20,5,5,'2025-01-08 10:39:05',14.00),(21,5,5,'2025-01-08 10:39:45',14.00),(22,5,5,'2025-01-08 10:40:10',14.00),(23,5,5,'2025-01-08 11:04:42',23.00),(24,NULL,5,'2025-01-08 11:11:03',23.00),(25,NULL,5,'2025-01-08 11:15:23',23.00),(26,NULL,5,'2025-01-08 11:18:11',23.00),(27,NULL,5,'2025-01-08 11:19:56',23.00),(28,NULL,5,'2025-01-08 11:22:47',222.00),(29,NULL,5,'2025-01-08 11:29:59',222.00),(30,NULL,5,'2025-01-08 12:16:33',23.00);
/*!40000 ALTER TABLE `historico_precios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moderador`
--

DROP TABLE IF EXISTS `moderador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moderador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `nif` char(9) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `baja_solicitada` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_moderador_region` (`region_id`),
  CONSTRAINT `fk_moderador_region` FOREIGN KEY (`region_id`) REFERENCES `regiones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moderador`
--

LOCK TABLES `moderador` WRITE;
/*!40000 ALTER TABLE `moderador` DISABLE KEYS */;
INSERT INTO `moderador` VALUES (6,1,'12345678A','Juan Pérez','Calle Falsa 123',19,'123456789','Moderador Juan Pérez',0),(7,2,'87654321B','María García','Avenida Siempre Viva 456',24,'987654321','Moderadora María García',0),(8,3,'11223344C','Carlos López','Boulevard de los Sueños 789',23,'456123789','Moderador Carlos López',0),(9,4,'44332211D','Ana Martínez','Plaza Mayor 101',20,'321654987','Moderadora Ana Martínez',1),(10,5,'55667788E','Luis Fernández','Calle del Sol 202',22,'789321456','Moderador Luis Fernández',0);
/*!40000 ALTER TABLE `moderador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ofertas`
--

DROP TABLE IF EXISTS `ofertas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `articulo_id` int(11) DEFAULT NULL,
  `tienda_id` int(11) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `precio_oferta` decimal(10,2) DEFAULT NULL,
  `precio_og` decimal(10,2) DEFAULT NULL,
  `registro_id` int(11) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ofertas_articulo` (`articulo_id`),
  KEY `fk_ofertas_tienda` (`tienda_id`),
  KEY `fk_ofertas_registro` (`registro_id`),
  CONSTRAINT `fk_ofertas_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ofertas_registro` FOREIGN KEY (`registro_id`) REFERENCES `registro_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ofertas_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ofertas`
--

LOCK TABLES `ofertas` WRITE;
/*!40000 ALTER TABLE `ofertas` DISABLE KEYS */;
INSERT INTO `ofertas` VALUES (1,1,1,'2023-10-01 00:00:00','2023-10-31 23:59:59',299.99,399.99,1,'Oferta especial de lanzamiento'),(2,2,2,'2023-11-01 00:00:00','2023-11-30 23:59:59',499.99,599.99,2,'Descuento por temporada'),(3,3,3,'2023-12-01 00:00:00','2023-12-31 23:59:59',199.99,299.99,3,'Oferta de fin de año'),(4,4,4,'2024-01-01 00:00:00','2024-01-31 23:59:59',29.99,39.99,4,'Descuento de año nuevo'),(5,5,5,'2024-02-01 00:00:00','2024-02-28 23:59:59',9.99,19.99,5,'Oferta de San Valentín'),(6,5,5,'2025-01-21 19:23:00','2025-01-23 19:23:00',23.00,9.99,NULL,'Oferta creada por el usuario'),(13,NULL,5,'2013-04-21 19:34:00','2015-05-26 19:09:00',222.00,NULL,NULL,NULL),(14,NULL,5,'2023-01-21 20:10:00','2023-02-23 12:00:00',23.00,NULL,NULL,NULL);
/*!40000 ALTER TABLE `ofertas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regiones`
--

DROP TABLE IF EXISTS `regiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clase` enum('C','P','E','PR') NOT NULL COMMENT 'Continente, Pais, Estado, Provincia',
  `nombre` varchar(255) NOT NULL,
  `region_padre_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_regiones_padre` (`region_padre_id`),
  CONSTRAINT `fk_regiones_padre` FOREIGN KEY (`region_padre_id`) REFERENCES `regiones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regiones`
--

LOCK TABLES `regiones` WRITE;
/*!40000 ALTER TABLE `regiones` DISABLE KEYS */;
INSERT INTO `regiones` VALUES (19,'C','África',NULL),(20,'C','América',NULL),(21,'C','Asia',NULL),(22,'C','Oceanía',NULL),(23,'C','Antártida',NULL),(24,'C','Europa',NULL);
/*!40000 ALTER TABLE `regiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regiones_moderador`
--

DROP TABLE IF EXISTS `regiones_moderador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regiones_moderador` (
  `mod_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  PRIMARY KEY (`mod_id`,`region_id`),
  KEY `fk_regiones_moderador_mod` (`mod_id`),
  KEY `fk_regiones_moderador_region` (`region_id`),
  CONSTRAINT `fk_regiones_moderador_mod` FOREIGN KEY (`mod_id`) REFERENCES `moderador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_regiones_moderador_region` FOREIGN KEY (`region_id`) REFERENCES `regiones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regiones_moderador`
--

LOCK TABLES `regiones_moderador` WRITE;
/*!40000 ALTER TABLE `regiones_moderador` DISABLE KEYS */;
INSERT INTO `regiones_moderador` VALUES (6,19),(7,20),(8,23),(9,24),(10,21);
/*!40000 ALTER TABLE `regiones_moderador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_logs`
--

DROP TABLE IF EXISTS `registro_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_log` datetime NOT NULL,
  `mensaje` varchar(500) NOT NULL,
  `nivel` enum('INFO','WARNING','ERROR','DEBUG') NOT NULL,
  `usuario` varchar(500) NOT NULL,
  `accion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_logs`
--

LOCK TABLES `registro_logs` WRITE;
/*!40000 ALTER TABLE `registro_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_usuarios`
--

DROP TABLE IF EXISTS `registro_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_creacion` datetime DEFAULT NULL,
  `creador_id` int(11) NOT NULL,
  `fecha_mod` datetime DEFAULT NULL,
  `mod_id` int(11) DEFAULT NULL,
  `notas_admin` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_registro_creador` (`creador_id`),
  KEY `fk_registro_mod` (`mod_id`),
  CONSTRAINT `fk_registro_creador` FOREIGN KEY (`creador_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_registro_mod` FOREIGN KEY (`mod_id`) REFERENCES `moderador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_usuarios`
--

LOCK TABLES `registro_usuarios` WRITE;
/*!40000 ALTER TABLE `registro_usuarios` DISABLE KEYS */;
INSERT INTO `registro_usuarios` VALUES (1,'2025-01-04 21:54:45',1,'2025-01-04 21:54:45',6,'Usuario registrado por el admin'),(2,'2025-01-04 21:54:45',1,'2025-01-04 21:54:45',7,'Usuario registrado por el admin'),(3,'2025-01-04 21:54:45',1,'2025-01-04 21:54:45',8,'Usuario registrado por el admin'),(4,'2025-01-04 21:54:45',1,'2025-01-04 21:54:45',10,'Usuario registrado por el admin'),(5,'2025-01-04 21:54:45',1,'2025-01-04 21:54:45',9,'Usuario registrado por el admin');
/*!40000 ALTER TABLE `registro_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registros`
--

DROP TABLE IF EXISTS `registros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_registro` datetime NOT NULL COMMENT 'Fecha y Hora del registro.',
  `clase_log_id` char(1) NOT NULL COMMENT 'código de clase de log: E=Error, A=Aviso, S=Seguimiento, I=Información, D=Depuración, ...',
  `modulo` varchar(50) DEFAULT 'app' COMMENT 'Modulo o Sección de la aplicación que ha generado el mensaje de registro.',
  `texto` text DEFAULT NULL COMMENT 'Texto con el mensaje de registro.',
  `ip` varchar(40) DEFAULT NULL COMMENT 'Dirección IP desde donde accede el usuario (vale para IPv4 e IPv6.',
  `browser` text DEFAULT NULL COMMENT 'Texto con información del navegador utilizado en el acceso.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registros`
--

LOCK TABLES `registros` WRITE;
/*!40000 ALTER TABLE `registros` DISABLE KEYS */;
INSERT INTO `registros` VALUES (1,'2025-01-04 21:53:30','I','app','Usuario registrado exitosamente.','192.168.1.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3'),(2,'2025-01-04 21:53:30','E','app','Error al intentar registrar usuario.','192.168.1.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3'),(3,'2025-01-04 21:53:30','A','app','Intento de acceso fallido.','192.168.1.3','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3'),(4,'2025-01-04 21:53:30','S','app','Seguimiento de actividad del usuario.','192.168.1.4','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3'),(5,'2025-01-04 21:53:30','D','app','Depuración del sistema.','192.168.1.5','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');
/*!40000 ALTER TABLE `registros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguimientos`
--

DROP TABLE IF EXISTS `seguimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seguimientos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL COMMENT 'id del usuario del seguimiento',
  `tienda_id` int(11) DEFAULT NULL COMMENT 'id del usuario de la tienda o 0 si no es tienda',
  `articulo_id` int(11) DEFAULT NULL COMMENT 'id del usuario del articulo o 0 si no es articulo',
  `oferta_id` int(11) DEFAULT NULL COMMENT 'id de la oferta del seguimiento o 0 si no es oferta',
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_seguimientos_usuario` (`usuario_id`),
  KEY `fk_seguimientos_tienda` (`tienda_id`),
  KEY `fk_seguimientos_articulo` (`articulo_id`),
  KEY `fk_seguimientos_oferta` (`oferta_id`),
  CONSTRAINT `fk_seguimientos_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_seguimientos_oferta` FOREIGN KEY (`oferta_id`) REFERENCES `ofertas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_seguimientos_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_seguimientos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguimientos`
--

LOCK TABLES `seguimientos` WRITE;
/*!40000 ALTER TABLE `seguimientos` DISABLE KEYS */;
INSERT INTO `seguimientos` VALUES (1,1,1,1,1,'2025-01-04 22:15:19'),(2,2,2,2,2,'2025-01-04 22:15:19'),(3,3,3,3,3,'2025-01-04 22:15:19'),(4,4,4,4,4,'2025-01-04 22:15:19'),(5,5,5,5,5,'2025-01-04 22:15:19');
/*!40000 ALTER TABLE `seguimientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiendas`
--

DROP TABLE IF EXISTS `tiendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `lugar` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `clasificacion_id` int(11) DEFAULT NULL,
  `etiquetas_id` int(11) DEFAULT NULL,
  `imagen_principal` varchar(255) DEFAULT NULL,
  `suma_valoraciones` int(11) DEFAULT 0,
  `suma_votos` int(11) DEFAULT 0,
  `visible` tinyint(1) DEFAULT 1,
  `cerrada` tinyint(1) DEFAULT 0,
  `denuncias` int(11) DEFAULT 0,
  `fecha_primera_denuncia` datetime DEFAULT NULL,
  `motivo_denuncia` text DEFAULT NULL,
  `bloqueada` tinyint(1) DEFAULT 0,
  `fecha_bloqueo` datetime DEFAULT NULL,
  `motivo_bloqueo` text DEFAULT NULL,
  `comentarios_id` int(11) DEFAULT NULL,
  `cerrado_comentar` tinyint(1) DEFAULT 0,
  `seguimiento_id` int(11) DEFAULT NULL,
  `registro_id` int(11) NOT NULL,
  `articulo_tienda_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tiendas_region` (`region_id`),
  KEY `fk_tiendas_clasificacion` (`clasificacion_id`),
  KEY `fk_tiendas_articulo_tienda` (`articulo_tienda_id`),
  KEY `fk_tiendas_registro` (`registro_id`),
  KEY `fk_tiendas_etiquetas` (`etiquetas_id`),
  KEY `fk_tiendas_comentarios` (`comentarios_id`),
  KEY `fk_tiendas_seguimiento` (`seguimiento_id`),
  CONSTRAINT `fk_tiendas_articulo_tienda` FOREIGN KEY (`articulo_tienda_id`) REFERENCES `articulos_tienda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tiendas_clasificacion` FOREIGN KEY (`clasificacion_id`) REFERENCES `clasificaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tiendas_comentarios` FOREIGN KEY (`comentarios_id`) REFERENCES `comentarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tiendas_etiquetas` FOREIGN KEY (`etiquetas_id`) REFERENCES `etiquetas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tiendas_region` FOREIGN KEY (`region_id`) REFERENCES `regiones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tiendas_registro` FOREIGN KEY (`registro_id`) REFERENCES `registro_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tiendas_seguimiento` FOREIGN KEY (`seguimiento_id`) REFERENCES `seguimientos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiendas`
--

LOCK TABLES `tiendas` WRITE;
/*!40000 ALTER TABLE `tiendas` DISABLE KEYS */;
INSERT INTO `tiendas` VALUES (1,'Tienda Electrónica','Tienda especializada en productos electrónicos.','Ciudad A','http://www.tiendaelectronica.com','Calle Falsa 123',19,'123456789',1,1,'logo_tienda_electronica.png',0,0,1,0,0,NULL,NULL,0,NULL,NULL,NULL,0,NULL,1,NULL),(2,'Hogar y Decoración','Tienda de artículos para el hogar y decoración.','Ciudad B','http://www.hogarydecoracion.com','Avenida Siempre Viva 456',20,'987654321',2,2,'logo_hogar_decoracion.png',0,0,1,0,0,NULL,NULL,0,NULL,NULL,NULL,0,NULL,2,NULL),(3,'Deportes y Fitness','Tienda de equipamiento y ropa deportiva.','Ciudad C','http://www.deportesyfitness.com','Boulevard de los Sueños 789',23,'456123789',3,3,'logo_deportes_fitness.png',0,0,1,0,0,NULL,NULL,0,NULL,NULL,NULL,0,NULL,3,NULL),(4,'Librería Central','Librería con una amplia variedad de libros.','Ciudad D','http://www.libreriacentral.com','Plaza Mayor 101',24,'321654987',4,4,'logo_libreria_central.png',0,0,1,0,0,NULL,NULL,0,NULL,NULL,NULL,0,NULL,4,NULL),(5,'Moda y Estilo','Tienda de prendas de vestir y accesorios.','Ciudad E','http://www.modayestilo.com','Calle del Sol 202',22,'789321456',5,5,'logo_moda_estilo.png',0,0,1,0,0,NULL,NULL,0,NULL,NULL,NULL,0,NULL,5,NULL);
/*!40000 ALTER TABLE `tiendas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiendas_etiquetas`
--

DROP TABLE IF EXISTS `tiendas_etiquetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiendas_etiquetas` (
  `tienda_id` int(11) NOT NULL,
  `etiqueta_id` int(11) NOT NULL,
  PRIMARY KEY (`tienda_id`,`etiqueta_id`),
  KEY `fk_tiendas_etiquetas_etiqueta` (`etiqueta_id`),
  CONSTRAINT `fk_tiendas_etiquetas_etiqueta` FOREIGN KEY (`etiqueta_id`) REFERENCES `etiquetas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tiendas_etiquetas_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiendas_etiquetas`
--

LOCK TABLES `tiendas_etiquetas` WRITE;
/*!40000 ALTER TABLE `tiendas_etiquetas` DISABLE KEYS */;
INSERT INTO `tiendas_etiquetas` VALUES (1,1),(2,2),(3,3),(4,4),(5,5);
/*!40000 ALTER TABLE `tiendas_etiquetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiendas_moderador`
--

DROP TABLE IF EXISTS `tiendas_moderador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiendas_moderador` (
  `mod_id` int(11) NOT NULL,
  `tienda_id` int(11) NOT NULL,
  PRIMARY KEY (`mod_id`,`tienda_id`),
  KEY `fk_tiendas_moderador_mod` (`mod_id`),
  KEY `fk_tiendas_moderador_tienda` (`tienda_id`),
  CONSTRAINT `fk_tiendas_moderador_mod` FOREIGN KEY (`mod_id`) REFERENCES `moderador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tiendas_moderador_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiendas_moderador`
--

LOCK TABLES `tiendas_moderador` WRITE;
/*!40000 ALTER TABLE `tiendas_moderador` DISABLE KEYS */;
INSERT INTO `tiendas_moderador` VALUES (6,1),(7,2),(8,3),(9,4),(10,5);
/*!40000 ALTER TABLE `tiendas_moderador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nick` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `registro_confirmado` tinyint(1) DEFAULT 0,
  `fecha_acceso` datetime DEFAULT NULL,
  `accesos_fallidos` int(11) DEFAULT 0,
  `bloqueado` tinyint(1) DEFAULT 0,
  `fecha_bloqueo` datetime DEFAULT NULL,
  `motivo_bloqueo` text DEFAULT NULL,
  `rol` enum('Invitado','Usuario Normal','Usuario Tienda','Moderador','Administrador','Superadministrador') NOT NULL DEFAULT 'Invitado',
  PRIMARY KEY (`id`),
  KEY `fk_usuarios_region` (`region_id`),
  CONSTRAINT `fk_usuarios_region` FOREIGN KEY (`region_id`) REFERENCES `regiones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'juan.perez@example.com','password123','juanp','Juan','Pérez','Calle Falsa 123',19,'123456789','1980-01-01','2025-01-04 21:44:56',1,'2025-01-04 21:44:56',0,0,NULL,NULL,'Usuario Normal'),(2,'maria.garcia@example.com','password456','mariag','María','García','Avenida Siempre Viva 456',21,'987654321','1990-02-02','2025-01-04 21:44:56',1,'2025-01-04 21:44:56',0,0,NULL,NULL,'Moderador'),(3,'carlos.lopez@example.com','password789','carlosl','Carlos','López','Boulevard de los Sueños 789',20,'456123789','1985-03-03','2025-01-04 21:44:56',1,'2025-01-04 21:44:56',0,0,NULL,NULL,'Administrador'),(4,'ana.martinez@example.com','password101','anam','Ana','Martínez','Plaza Mayor 101',24,'321654987','1995-04-04','2025-01-04 21:44:56',1,'2025-01-04 21:44:56',0,0,NULL,NULL,'Superadministrador'),(5,'luis.fernandez@example.com','password202','luisf','Luis','Fernández','Calle del Sol 202',23,'789321456','1975-05-05','2025-01-04 21:44:56',1,'2025-01-04 21:44:56',0,0,NULL,NULL,'Usuario Normal');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-15  2:44:21
