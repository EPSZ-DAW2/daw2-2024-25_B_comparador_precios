<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Articulo $model */
/** @var app\models\ArticulosTienda $articuloTienda */
/** @var int $tiendaId */

$this->title = 'Crear Artículo';
$this->params['breadcrumbs'][] = ['label' => 'Artículos', 'url' => ['ver-tienda', 'id' => $tiendaId]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articulo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formarticulotienda', [
        'model' => $model,
        'articuloTienda' => $articuloTienda, // Pasar $articuloTienda aquí
    ]) ?>

</div>

