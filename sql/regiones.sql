
ALTER TABLE regiones MODIFY COLUMN region_padre_id INT NULL;

INSERT INTO `regiones` (`id`, `clase`, `nombre`, `region_padre_id`) VALUES
(19, 'C', 'África', NULL),
(20, 'C', 'América', NULL),
(21, 'C', 'Asia', NULL),
(22, 'C', 'Oceanía', NULL),
(23, 'C', 'Antártida', NULL),
(24, 'C', 'Europa', NULL);
