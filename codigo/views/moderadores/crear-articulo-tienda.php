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

    <div class="articulo-form usuario-form"> <!-- Se añadió la clase 'usuario-form' para aplicar los estilos -->
        <?= $this->render('_formarticulotienda', [
            'model' => $model,
            'articuloTienda' => $articuloTienda, // Pasar $articuloTienda aquí
        ]) ?>
    </div>

</div>
