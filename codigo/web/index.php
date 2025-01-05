<?php
// EPSZ-DAW2: Adaptación para cargar "vendor" en una ubicación compartida.

// Comentar las siguientes dos líneas cuando se despliegue en producción
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'prod');  // Asegúrate de estar en el entorno 'prod' en producción

$base = dirname(dirname(__DIR__)) . '/librerias';
$requires = [
    [$base, 'vendor', 'autoload.php'],
    [$base, 'vendor', 'yiisoft', 'yii2', 'Yii.php']
];

// Usar require_once para evitar duplicación de carga
foreach ($requires as $path) {
    $path = implode(DIRECTORY_SEPARATOR, $path);
    require_once $path;  // Usamos require_once para asegurar que no se cargue más de una vez
}

// Carga de la configuración, también usando require_once para evitar la carga duplicada
$config = require_once dirname(__DIR__) . '/config/web.php';

// Inicia la aplicación solo una vez
(new yii\web\Application($config))->run();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Sitio Web Personalizado</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Enlace al archivo CSS existente -->
</head>
<body>
    <header class="header-principal">
    <div class="logo">
            <img src="Logo.jpg" alt="Logo" width="150"> <!-- Asegúrate de colocar la ruta correcta a tu logo -->
        </div>
        <nav class="navegacion">
            <ul class="menu">
                <li><a href="#">Inicio</a></li>
                <li><a href="servicios.php">Servicios</a></li>
                <li><a href="#">Sobre Nosotros</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero-seccion">
        <h1>Bienvenido a Nuestro Espacio</h1>
        <p>Ofrecemos servicios excepcionales para ti.</p>
        <a href="#" class="boton-cta">Descubre Más</a>
    </section>

    <section class="seccion-servicios">
        <h2>Nuestros Servicios</h2>
        <div class="item-servicio">
            <h3>Servicio Personalizado 1</h3>
            <p>Descripción detallada del servicio 1.</p>
        </div>
        <div class="item-servicio">
            <h3>Servicio Personalizado 2</h3>
            <p>Descripción detallada del servicio 2.</p>
        </div>
        <div class="item-servicio">
            <h3>Servicio Personalizado 3</h3>
            <p>Descripción detallada del servicio 3.</p>
        </div>
    </section>

    <footer class="footer-principal">
        <p>© 2025 Mi Sitio Web. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
