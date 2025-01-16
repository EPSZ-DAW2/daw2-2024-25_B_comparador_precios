<?php
// EPSZ-DAW2: Adaptación para cargar "vendor" en una ubicación compartida.

// Comentar las siguientes dos líneas cuando se despliegue en producción
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'prod');  

// Ruta base para cargar las dependencias compartidas
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
