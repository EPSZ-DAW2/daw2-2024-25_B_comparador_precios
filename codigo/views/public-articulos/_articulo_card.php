<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Articulo $model */

?>

<div class="tienda-card">
    <div class="row g-0">
        <div class="col-md-4">
            <?= Html::img(Url::to('@web/img/' . $model->imagen_principal), [
                'class' => 'img-fluid rounded-start',
                'alt' => Html::encode($model->nombre),
            ]) ?>
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title"><?= Html::encode($model->nombre) ?></h5>
                <p class="card-text"><?= Html::encode($model->descripcion) ?></p>
                <p class="card-text">
                    <small class="text-muted"><strong>Categoría:</strong> <?= Html::encode($model->categoria->nombre ?? 'Sin categoría') ?></small>
                </p>
                <p class="card-text">
                    <small class="text-muted"><strong>Etiqueta:</strong> <?= Html::encode($model->etiqueta->nombre ?? 'Sin etiqueta') ?></small>
                </p>
                <p class="card-text">
                    <small class="text-muted"><strong>Clasificación de la Tienda:</strong> <?= Html::encode($model->tienda->clasificacion->nombre ?? 'Sin clasificación') ?></small>
                </p>
                <?= Html::a('Ver más', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            </div>
        </div>
    </div>
</div>

