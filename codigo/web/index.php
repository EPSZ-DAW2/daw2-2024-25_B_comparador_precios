<?php
// EPSZ-DAW2: Adaptación para cargar "vendor" en una ubicación compartida.

// Comentar las siguientes dos líneas cuando se despliegue en producción
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'prod');  
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
            <img src="Logo.jpg" alt="Logo" width="120"> 
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
</body>
</html>
