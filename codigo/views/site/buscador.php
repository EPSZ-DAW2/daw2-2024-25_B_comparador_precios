<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Buscador';
$this->registerCssFile('@web/css/buscador.css');
?>
<div class="buscador-container">
    <!-- Botones de búsqueda -->
    <div class="buscador-buttons text-center">
        <?= Html::a('Buscar por Tiendas', ['tiendas/index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::a('Buscar por Artículos', ['public-articulos/public-index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::a('Buscar por Ofertas', ['ofertas/index'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>