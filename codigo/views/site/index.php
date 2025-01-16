<?php

/** @var yii\web\View $this */
use yii\helpers\Html;

$this->title = 'Comparador de Precios';
$this->registerCssFile('@web/css/home.css');
?>
<div class="site-index" style="margin-top: 10px;">
    <div class="jumbotron">
        <!-- Título y Logo -->
        <div class="header">
            <img src="<?= Yii::getAlias('@web') ?>/img/logo.jpg" alt="Logo VAMAR" class="logo">
            <h1 class="display-4">COMPARADOR DE PRECIOS</h1>
        </div>
        
        <!-- Información del comparador -->
        <div class="info-section">
            <h2 style="text-align: center;">¿Qué es VAMAR?</h2>
            <p>
                VAMAR es una plataforma diseñada para facilitar tus compras online. Nuestra herramienta permite comparar precios de productos en diversas tiendas, 
                encontrar las mejores ofertas y realizar compras más informadas. Nos aseguramos de brindarte información precisa, actualizada y relevante para 
                que tomes las mejores decisiones de compra. Ya sea que busques productos electrónicos, ropa, o artículos del hogar, VAMAR te ayudará a ahorrar tiempo y dinero.
            </p>
            
            <!-- Sección de características -->
            <div class="feature-container">
                <!-- Búsqueda Rápida -->
                <div class="feature">
                    <img src="<?= Yii::getAlias('@web') ?>/img/busquedas.jpg" alt="Búsqueda de productos" class="feature-image">
                    <div>
                        <h3>Búsqueda Rápida</h3>
                        <p>Encuentra productos de manera sencilla con nuestra poderosa herramienta de búsqueda.</p>
                    </div>
                </div>
                
                <!-- Comparación Inteligente -->
                <div class="feature">
                    <img src="<?= Yii::getAlias('@web') ?>/img/comparar.jpg" alt="Comparación de precios" class="feature-image">
                    <div>
                        <h3>Comparación Inteligente</h3>
                        <p>Compara precios entre múltiples tiendas para elegir la mejor opción.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Nueva sección: ¿Por qué elegirnos? -->
        <div class="why-choose-us">
            <h2>¿Por qué elegirnos?</h2>
            <ul>
                <li>Fácil de usar: Una interfaz intuitiva para que encuentres lo que necesitas sin complicaciones.</li>
                <li>Gran variedad: Acceso a miles de productos y ofertas de diferentes tiendas.</li>
                <li>Actualizado: Información de precios y ofertas en tiempo real.</li>
                <li>Confiable: Opiniones verificadas y reseñas de otros usuarios.</li>
            </ul>
        </div>

        <!-- Mensaje y botones de inicio de sesión y registro -->
        <div class="call-to-action">
            <h3>¿A qué esperas? ¡Inicia sesión o regístrate ahora!</h3>
            <div class="action-buttons">
                <?= Html::a('Inicia sesión', ['site/login'], ['class' => 'btn btn-secondary']) ?>
                <?= Html::a('Regístrate', ['registros/register'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        
        <!-- Botón de búsqueda -->
        <div class="text-center">
            <?= Html::a('Buscar por tiendas', ['tiendas/index'], [
                'class' => 'btn btn-primary btn-lg',
                'role' => 'button',
            ]) ?>
        </div>
    </div>
</div>
