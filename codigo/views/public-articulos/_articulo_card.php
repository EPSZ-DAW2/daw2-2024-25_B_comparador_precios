<?php

use yii\helpers\Html;

/** @var app\models\Articulo $model */

?>

<div class="articulo-card">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title"><?= Html::encode($model->nombre) ?></h3>
            <p class="card-text"><?= Html::encode($model->descripcion) ?></p>
            <p><strong>Categoría:</strong> <?= Html::encode($model->categoria->nombre ?? 'Sin categoría') ?></p>
            <p><strong>Etiqueta:</strong> <?= Html::encode($model->etiqueta->nombre ?? 'Sin etiqueta') ?></p>
            <p><strong>Clasificación de la Tienda:</strong> <?= Html::encode($model->tienda->clasificacion->nombre ?? 'Sin clasificación') ?></p>
			<p><?= Html::a('Ver más', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?></p>
        </div>
    </div>
</div>
