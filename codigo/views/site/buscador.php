<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Buscador';
?>
<div class="buscador-page">
    <div class="buscador-container">
        <div class="buscador-info text-center mb-5">
            <h1>Elige tu opción de búsqueda</h1>
            <p>Tenemos tres opciones para ayudarte a encontrar lo que buscas. Puedes buscar:</p>
            <ul class="list-unstyled">
                <li><strong>Por Tiendas:</strong> Encuentra las tiendas disponibles en nuestro sistema.</li>
                <li><strong>Por Artículos:</strong> Busca los artículos específicos que deseas.</li>
                <li><strong>Por Ofertas:</strong> Descubre las mejores ofertas disponibles.</li>
            </ul>
            <p>Elige una de las siguientes opciones para comenzar tu búsqueda.</p>
        </div>

        <!-- Botones de búsqueda -->
        <div class="buscador-buttons text-center">
            <?= Html::a('Buscar por Tiendas', ['tiendas/index'], ['class' => 'btn btn-secondary m-2']) ?>
            <?= Html::a('Buscar por Artículos', ['public-articulos/public-index'], ['class' => 'btn btn-secondary m-2']) ?>
            <?= Html::a('Buscar por Ofertas', ['ofertas/index'], ['class' => 'btn btn-secondary m-2']) ?>
        </div>
    </div>
</div>

