<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Sobre Nosotros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Bienvenido a <strong>VAMAR</strong>, tu comparador de precios confiable. Nuestro objetivo es revolucionar la forma en la que compras en línea, 
        ayudándote a tomar decisiones inteligentes y a encontrar las mejores ofertas disponibles en múltiples tiendas.
    </p>

    <h2>¿Quiénes Somos?</h2>
    <p>
        Somos un equipo apasionado por la tecnología y las compras en línea. Creemos que todos merecen acceder a información transparente, precisa y 
        actualizada para ahorrar tiempo y dinero en sus compras. Desde productos electrónicos hasta artículos para el hogar, nuestra plataforma recopila 
        datos de múltiples fuentes para que compares precios con facilidad.
    </p>

    <h2>Nuestra Misión</h2>
    <p>
        Empoderar a los usuarios a tomar decisiones de compra informadas proporcionándoles una herramienta fácil de usar y confiable para comparar precios 
        y encontrar ofertas en línea.
    </p>

    <h2>Características Clave</h2>
    <ul>
        <li><strong>Comparación en Tiempo Real:</strong> Acceso a precios actualizados de diversas tiendas.</li>
        <li><strong>Opiniones de Usuarios:</strong> Descubre experiencias reales para tomar decisiones confiables.</li>
        <li><strong>Interfaz Intuitiva:</strong> Encuentra productos y compara precios en pocos clics.</li>
        <li><strong>Ahorro Garantizado:</strong> Encuentra las mejores ofertas y promociones del mercado.</li>
    </ul>

    <h2>Contáctanos</h2>
    <p>
        ¿Tienes alguna pregunta o sugerencia? Nos encantaría escucharte. 
        Puedes contactarnos a través de nuestro <a href="<?= Yii::$app->urlManager->createUrl(['site/contact']) ?>">formulario de contacto</a>.
    </p>

    <p>
        ¡Gracias por elegir VAMAR como tu herramienta de comparación de precios!
    </p>
</div>
