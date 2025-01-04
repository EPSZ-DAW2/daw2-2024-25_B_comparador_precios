-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-12-2024 a las 23:24:39
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
-- Base de datos: `comparador`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL COMMENT 'nombre del articulo',
  `descripcion` text DEFAULT NULL COMMENT 'descripcion del articulo',
  `categoria_id` int(11) DEFAULT NULL COMMENT 'id de la categoria del producto',
  `etiqueta_id` int(11) DEFAULT NULL COMMENT 'id de la etiqueta del producto',
  `imagen_principal` varchar(255) DEFAULT NULL COMMENT 'imagen del articulo',
  `visible` tinyint(1) DEFAULT 1 COMMENT 'si el articulo esta visible o no, por defecto si',
  `cerrado` tinyint(1) DEFAULT 0 COMMENT 'si el articulo esta cerrado a la venta, por defecto no',
  `tipo_marcado` enum('comun','particular') DEFAULT 'comun' COMMENT 'tipo de articulo',
  `registro_id` int(11) DEFAULT NULL COMMENT 'id del usuario creador',
  `articulo_tienda_id` int(11) DEFAULT NULL COMMENT 'id relacionado con tabla articulo-tienda'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos_tienda`
--

CREATE TABLE `articulos_tienda` (
  `id` int(11) NOT NULL COMMENT 'id del registro',
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
  `comentario_id` int(11) DEFAULT NULL COMMENT 'id de comentarios relacionado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo_etiquetas`
--

CREATE TABLE `articulo_etiquetas` (
  `articulo_id` int(11) NOT NULL,
  `etiqueta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avisos`
--

CREATE TABLE `avisos` (
  `id` int(11) NOT NULL,
  `clase` enum('Aviso','Denuncia','Consulta','Mensaje Generico','Bloqueo') NOT NULL,
  `texto` text DEFAULT NULL,
  `usuario_origen_id` int(11) NOT NULL,
  `usuario_destino_id` int(11) NOT NULL,
  `tienda_id` int(11) DEFAULT 0,
  `articulo_id` int(11) DEFAULT 0,
  `comentario_id` int(11) DEFAULT 0,
  `fecha_lectura` datetime DEFAULT NULL COMMENT 'para usuario destino',
  `fecha_aceptado` datetime DEFAULT NULL COMMENT 'para moderadores o administradores'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `icono` varchar(255) DEFAULT NULL,
  `categoria_padre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificaciones`
--

CREATE TABLE `clasificaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `icono` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `tienda_id` int(11) DEFAULT NULL COMMENT 'id de la tienda',
  `articulo_id` int(11) DEFAULT 0 COMMENT 'id del articulo, 0 si es comentario de tienda',
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
  `registro_id` int(11) DEFAULT NULL COMMENT 'id del creador del comentario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones`
--

CREATE TABLE `configuraciones` (
  `clave` varchar(50) NOT NULL,
  `valor` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `duenos`
--

CREATE TABLE `duenos` (
  `id` int(11) NOT NULL,
  `id_tienda` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `nif` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas`
--

CREATE TABLE `etiquetas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_precios`
--

CREATE TABLE `historico_precios` (
  `id` int(11) NOT NULL,
  `articulo_id` int(11) DEFAULT NULL,
  `tienda_id` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moderador`
--

CREATE TABLE `moderador` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nif` char(9) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL,
  `articulo_id` int(11) DEFAULT NULL,
  `tienda_id` int(11) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `precio_oferta` decimal(10,2) DEFAULT NULL,
  `precio_og` decimal(10,2) DEFAULT NULL,
  `registro_id` int(11) DEFAULT NULL,
  `notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regiones`
--

CREATE TABLE `regiones` (
  `id` int(11) NOT NULL,
  `clase` enum('C','P','E','PR') NOT NULL COMMENT 'Continente, Pais, Estado, Provincia',
  `nombre` varchar(255) NOT NULL,
  `region_padre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regiones_moderador`
--

CREATE TABLE `regiones_moderador` (
  `mod_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL COMMENT 'Fecha y Hora del registro.',
  `clase_log_id` char(1) NOT NULL COMMENT 'código de clase de log: E=Error, A=Aviso, S=Seguimiento, I=Información, D=Depuración, ...',
  `modulo` varchar(50) DEFAULT 'app' COMMENT 'Modulo o Sección de la aplicación que ha generado el mensaje de registro.',
  `texto` text DEFAULT NULL COMMENT 'Texto con el mensaje de registro.',
  `ip` varchar(40) DEFAULT NULL COMMENT 'Dirección IP desde donde accede el usuario (vale para IPv4 e IPv6.',
  `browser` text DEFAULT NULL COMMENT 'Texto con información del navegador utilizado en el acceso.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_usuarios`
--

CREATE TABLE `registro_usuarios` (
  `id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `creador_id` int(11) NOT NULL,
  `fecha_mod` datetime DEFAULT NULL,
  `mod_id` int(11) DEFAULT NULL,
  `notas_admin` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimientos`
--

CREATE TABLE `seguimientos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL COMMENT 'id del usuario del seguimiento',
  `tienda_id` int(11) DEFAULT 0 COMMENT 'id del usuario de la tienda o 0 si no es tienda',
  `articulo_id` int(11) DEFAULT 0 COMMENT 'id del usuario del articulo o 0 si no es articulo',
  `oferta_id` int(11) DEFAULT 0 COMMENT 'id de la oferta del seguimiento o 0 si no es oferta',
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiendas`
--

CREATE TABLE `tiendas` (
  `id` int(11) NOT NULL,
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
  `articulo_tienda_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiendas_etiquetas`
--

CREATE TABLE `tiendas_etiquetas` (
  `tienda_id` int(11) NOT NULL,
  `etiqueta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiendas_moderador`
--

CREATE TABLE `tiendas_moderador` (
  `mod_id` int(11) NOT NULL,
  `tienda_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
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
  `motivo_bloqueo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_articulos_categoria` (`categoria_id`),
  ADD KEY `fk_articulos_etiqueta` (`etiqueta_id`),
  ADD KEY `fk_articulos_registro` (`registro_id`),
  ADD KEY `fk_articulos_articulo_tienda` (`articulo_tienda_id`);

--
-- Indices de la tabla `articulos_tienda`
--
ALTER TABLE `articulos_tienda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_articulos_tienda_articulo` (`articulo_id`),
  ADD KEY `fk_articulos_tienda_tienda` (`tienda_id`),
  ADD KEY `fk_articulos_tienda_historico` (`historico_id`),
  ADD KEY `fk_articulos_tienda_oferta` (`oferta_id`),
  ADD KEY `fk_articulos_tienda_registro` (`registro_id`),
  ADD KEY `fk_articulos_tienda_comentario` (`comentario_id`);

--
-- Indices de la tabla `articulo_etiquetas`
--
ALTER TABLE `articulo_etiquetas`
  ADD PRIMARY KEY (`articulo_id`,`etiqueta_id`),
  ADD KEY `fk_articulo_etiquetas_etiqueta` (`etiqueta_id`);

--
-- Indices de la tabla `avisos`
--
ALTER TABLE `avisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_avisos_usuario_origen` (`usuario_origen_id`),
  ADD KEY `fk_avisos_usuario_destino` (`usuario_destino_id`),
  ADD KEY `fk_avisos_tienda` (`tienda_id`),
  ADD KEY `fk_avisos_articulo` (`articulo_id`),
  ADD KEY `fk_avisos_comentario` (`comentario_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categorias_padre` (`categoria_padre_id`);

--
-- Indices de la tabla `clasificaciones`
--
ALTER TABLE `clasificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comentarios_tienda` (`tienda_id`),
  ADD KEY `fk_comentarios_articulo` (`articulo_id`),
  ADD KEY `fk_comentarios_padre` (`comentario_padre_id`),
  ADD KEY `fk_comentarios_registro` (`registro_id`);

--
-- Indices de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  ADD PRIMARY KEY (`clave`);

--
-- Indices de la tabla `duenos`
--
ALTER TABLE `duenos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_duenos_tienda` (`id_tienda`),
  ADD KEY `fk_duenos_usuario` (`id_usuario`);

--
-- Indices de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historico_precios`
--
ALTER TABLE `historico_precios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_historico_articulo` (`articulo_id`),
  ADD KEY `fk_historico_tienda` (`tienda_id`);

--
-- Indices de la tabla `moderador`
--
ALTER TABLE `moderador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_moderador_region` (`region_id`);

--
-- Indices de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ofertas_articulo` (`articulo_id`),
  ADD KEY `fk_ofertas_tienda` (`tienda_id`),
  ADD KEY `fk_ofertas_registro` (`registro_id`);

--
-- Indices de la tabla `regiones`
--
ALTER TABLE `regiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_regiones_padre` (`region_padre_id`);

--
-- Indices de la tabla `regiones_moderador`
--
ALTER TABLE `regiones_moderador`
  ADD PRIMARY KEY (`mod_id`,`region_id`),
  ADD KEY `fk_regiones_moderador_mod` (`mod_id`),
  ADD KEY `fk_regiones_moderador_region` (`region_id`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro_usuarios`
--
ALTER TABLE `registro_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_registro_creador` (`creador_id`),
  ADD KEY `fk_registro_mod` (`mod_id`);

--
-- Indices de la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_seguimientos_usuario` (`usuario_id`),
  ADD KEY `fk_seguimientos_tienda` (`tienda_id`),
  ADD KEY `fk_seguimientos_articulo` (`articulo_id`),
  ADD KEY `fk_seguimientos_oferta` (`oferta_id`);

--
-- Indices de la tabla `tiendas`
--
ALTER TABLE `tiendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tiendas_region` (`region_id`),
  ADD KEY `fk_tiendas_clasificacion` (`clasificacion_id`),
  ADD KEY `fk_tiendas_articulo_tienda` (`articulo_tienda_id`),
  ADD KEY `fk_tiendas_registro` (`registro_id`),
  ADD KEY `fk_tiendas_etiquetas` (`etiquetas_id`),
  ADD KEY `fk_tiendas_comentarios` (`comentarios_id`),
  ADD KEY `fk_tiendas_seguimiento` (`seguimiento_id`);

--
-- Indices de la tabla `tiendas_etiquetas`
--
ALTER TABLE `tiendas_etiquetas`
  ADD PRIMARY KEY (`tienda_id`,`etiqueta_id`),
  ADD KEY `fk_tiendas_etiquetas_etiqueta` (`etiqueta_id`);

--
-- Indices de la tabla `tiendas_moderador`
--
ALTER TABLE `tiendas_moderador`
  ADD PRIMARY KEY (`mod_id`,`tienda_id`),
  ADD KEY `fk_tiendas_moderador_mod` (`mod_id`),
  ADD KEY `fk_tiendas_moderador_tienda` (`tienda_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuarios_region` (`region_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `avisos`
--
ALTER TABLE `avisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clasificaciones`
--
ALTER TABLE `clasificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `duenos`
--
ALTER TABLE `duenos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historico_precios`
--
ALTER TABLE `historico_precios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `moderador`
--
ALTER TABLE `moderador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `regiones`
--
ALTER TABLE `regiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_usuarios`
--
ALTER TABLE `registro_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tiendas`
--
ALTER TABLE `tiendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `fk_articulos_articulo_tienda` FOREIGN KEY (`articulo_tienda_id`) REFERENCES `articulos_tienda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_articulos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_articulos_etiqueta` FOREIGN KEY (`etiqueta_id`) REFERENCES `etiquetas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_articulos_registro` FOREIGN KEY (`registro_id`) REFERENCES `registro_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `articulos_tienda`
--
ALTER TABLE `articulos_tienda`
  ADD CONSTRAINT `fk_articulos_tienda_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_articulos_tienda_comentario` FOREIGN KEY (`comentario_id`) REFERENCES `comentarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_articulos_tienda_historico` FOREIGN KEY (`historico_id`) REFERENCES `historico_precios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_articulos_tienda_oferta` FOREIGN KEY (`oferta_id`) REFERENCES `ofertas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_articulos_tienda_registro` FOREIGN KEY (`registro_id`) REFERENCES `registro_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_articulos_tienda_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `articulo_etiquetas`
--
ALTER TABLE `articulo_etiquetas`
  ADD CONSTRAINT `fk_articulo_etiquetas_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_articulo_etiquetas_etiqueta` FOREIGN KEY (`etiqueta_id`) REFERENCES `etiquetas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `avisos`
--
ALTER TABLE `avisos`
  ADD CONSTRAINT `fk_avisos_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_avisos_comentario` FOREIGN KEY (`comentario_id`) REFERENCES `comentarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_avisos_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_avisos_usuario_destino` FOREIGN KEY (`usuario_destino_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_avisos_usuario_origen` FOREIGN KEY (`usuario_origen_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `fk_categorias_padre` FOREIGN KEY (`categoria_padre_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `fk_comentarios_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comentarios_padre` FOREIGN KEY (`comentario_padre_id`) REFERENCES `comentarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comentarios_registro` FOREIGN KEY (`registro_id`) REFERENCES `registro_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comentarios_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `duenos`
--
ALTER TABLE `duenos`
  ADD CONSTRAINT `fk_duenos_tienda` FOREIGN KEY (`id_tienda`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_duenos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historico_precios`
--
ALTER TABLE `historico_precios`
  ADD CONSTRAINT `fk_historico_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_historico_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `moderador`
--
ALTER TABLE `moderador`
  ADD CONSTRAINT `fk_moderador_region` FOREIGN KEY (`region_id`) REFERENCES `regiones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD CONSTRAINT `fk_ofertas_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ofertas_registro` FOREIGN KEY (`registro_id`) REFERENCES `registro_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ofertas_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `regiones`
--
ALTER TABLE `regiones`
  ADD CONSTRAINT `fk_regiones_padre` FOREIGN KEY (`region_padre_id`) REFERENCES `regiones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `regiones_moderador`
--
ALTER TABLE `regiones_moderador`
  ADD CONSTRAINT `fk_regiones_moderador_mod` FOREIGN KEY (`mod_id`) REFERENCES `moderador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_regiones_moderador_region` FOREIGN KEY (`region_id`) REFERENCES `regiones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `registro_usuarios`
--
ALTER TABLE `registro_usuarios`
  ADD CONSTRAINT `fk_registro_creador` FOREIGN KEY (`creador_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_registro_mod` FOREIGN KEY (`mod_id`) REFERENCES `moderador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD CONSTRAINT `fk_seguimientos_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_seguimientos_oferta` FOREIGN KEY (`oferta_id`) REFERENCES `ofertas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_seguimientos_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_seguimientos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tiendas`
--
ALTER TABLE `tiendas`
  ADD CONSTRAINT `fk_tiendas_articulo_tienda` FOREIGN KEY (`articulo_tienda_id`) REFERENCES `articulos_tienda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tiendas_clasificacion` FOREIGN KEY (`clasificacion_id`) REFERENCES `clasificaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tiendas_comentarios` FOREIGN KEY (`comentarios_id`) REFERENCES `comentarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tiendas_etiquetas` FOREIGN KEY (`etiquetas_id`) REFERENCES `etiquetas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tiendas_region` FOREIGN KEY (`region_id`) REFERENCES `regiones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tiendas_registro` FOREIGN KEY (`registro_id`) REFERENCES `registro_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tiendas_seguimiento` FOREIGN KEY (`seguimiento_id`) REFERENCES `seguimientos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tiendas_etiquetas`
--
ALTER TABLE `tiendas_etiquetas`
  ADD CONSTRAINT `fk_tiendas_etiquetas_etiqueta` FOREIGN KEY (`etiqueta_id`) REFERENCES `etiquetas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tiendas_etiquetas_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tiendas_moderador`
--
ALTER TABLE `tiendas_moderador`
  ADD CONSTRAINT `fk_tiendas_moderador_mod` FOREIGN KEY (`mod_id`) REFERENCES `moderador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tiendas_moderador_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_region` FOREIGN KEY (`region_id`) REFERENCES `regiones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
