<?php

/** @var yii\web\View $this */
use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">VAMAR</h1>

        <p class="lead">Empieza tu búsqueda de manera fácil, rápida y eficiente con VAMAR. Compara precios, encuentra las mejores ofertas y ahorra tiempo.</p>
        
        <!-- Sección ¿Por qué elegirnos? -->
        <div class="recuadro-texto">
            <h2>¿Por qué elegirnos?</h2>
            <p>
                En VAMAR, tu experiencia de compra es nuestra prioridad. Ofrecemos una plataforma amigable y confiable donde puedes comparar precios de múltiples tiendas en segundos. Con un amplio catálogo y actualizaciones constantes, garantizamos que siempre obtendrás las mejores ofertas. ¡Haz que tu compra sea más inteligente con VAMAR!
            </p>
        </div>
        
        <!-- Sección Ventajas -->
        <div class="recuadro-texto">
            <h2>Ventajas de usar VAMAR</h2>
            <ul>
                <li><strong>Ahorro de tiempo:</strong> Accede a una comparación instantánea de productos en diversas tiendas. ¡Nunca más perderás tiempo buscando precios!</li>
                <li><strong>Ofertas exclusivas:</strong> Encuentra descuentos especiales que solo VAMAR te ofrece, con opciones de ahorro en tus compras.</li>
                <li><strong>Plataforma segura:</strong> Compra con confianza. Trabajamos con tiendas verificadas y seguras, garantizando tu protección en todo momento.</li>
                <li><strong>Actualización constante:</strong> Nuestro sistema se actualiza en tiempo real para brindarte los precios más competitivos del mercado.</li>
            </ul>
        </div>

        <!-- Sección Testimonios -->
        <div class="recuadro-texto">
            <h2>Lo que dicen nuestros usuarios</h2>
            <p>
                "¡VAMAR ha hecho que mis compras sean mucho más fáciles! Ahora encuentro rápidamente las mejores ofertas y me ahorro mucho dinero." <br> - Ana Martínez, usuaria habitual
            </p>
            <p>
                "Gracias a VAMAR, he podido comparar precios y conseguir las mejores ofertas. Es la herramienta perfecta para ahorrar tiempo y dinero." <br> - Luis González, comprador inteligente
            </p>
        </div>

    </div>

    <div class="text-center">
        <?php echo Html::a('Buscar por tiendas', ['tiendas/index'], [
            'class' => 'btn btn-primary btn-lg', // btn-lg hace el botón más grande
            'role' => 'button',
        ]); ?>
    </div>

</div>


