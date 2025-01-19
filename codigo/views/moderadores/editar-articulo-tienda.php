<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Articulo $model */
/** @var app\models\ArticulosTienda $articuloTienda */

$this->title = 'Editar Artículo: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Artículos', 'url' => ['ver-tienda', 'id' => $articuloTienda->tienda_id]];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['ver-articulo-tienda', 'id' => $model->id, 'tienda_id' => $articuloTienda->tienda_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="articulo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formarticulotienda', [
        'model' => $model,
        'articuloTienda' => $articuloTienda, // Se pasa correctamente a la vista parcial
    ]) ?>

</div>
