<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ArticulosTienda $model */

$this->title = Yii::t('app', 'Eliminar Artículo: {name}', [
    'name' => $model->articulo->nombre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tiendas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->articulo->nombre, 'url' => ['view', 'id' => $model->articulo_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Eliminar');
?>
<div class="articulo-delete">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::t('app', '¿Estás seguro de que deseas eliminar este artículo?') ?>
    </p>

    <?= Html::beginForm(['eliminar-articulo', 'Tienda_id' => $model->tienda_id, 'Articulo_id' => $model->articulo_id], 'post') ?>
        <?= Html::submitButton(Yii::t('app', 'Eliminar'), ['class' => 'btn btn-danger']) ?>
        <?= Html::a(Yii::t('app', 'Cancelar'), ['view-store', 'id' => $model->tienda_id], ['class' => 'btn btn-secondary']) ?>
    <?= Html::endForm() ?>

</div>