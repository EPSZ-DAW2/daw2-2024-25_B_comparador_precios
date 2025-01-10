<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Articulo $model */

$this->title = 'Crear Artículo';
$this->params['breadcrumbs'][] = ['label' => 'Artículos', 'url' => ['ver-tienda', 'id' => $model->tienda_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articulo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formarticulotienda', [
        'model' => $model,
    ]) ?>

</div>
