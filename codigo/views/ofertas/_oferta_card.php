<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Ofertas $model */

?>

<div class="tienda-card">
    <div class="row g-0">
        <div class="col-md-4">
            <!-- Muestra una imagen si existe, o un marcador de posición si no -->
            <?= Html::img(Url::to('@web/img/' . ($model->articulo->imagen_principal ?? 'placeholder.png')), [
                'class' => 'img-fluid rounded-start',
                'alt' => Html::encode($model->articulo->nombre ?? 'Sin nombre'),
            ]) ?>
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title"><?= Html::encode($model->articulo->nombre ?? 'Sin nombre') ?></h5>
                <p class="card-text"><?= Html::encode($model->articulo->descripcion ?? 'Sin descripción') ?></p>
                <p class="card-text">
                    <small class="text-muted">
                        <strong>Precio Oferta:</strong> <?= Yii::$app->formatter->asCurrency($model->precio_oferta) ?>
                    </small>
                </p>
                <p class="card-text">
                    <small class="text-muted">
                        <strong>Precio Original:</strong> <?= Yii::$app->formatter->asCurrency($model->precio_og) ?>
                    </small>
                </p>
                <p class="card-text">
                    <small class="text-muted">
                        <strong>Tienda:</strong> <?= Html::encode($model->tienda->nombre ?? 'Sin tienda') ?>
                    </small>
                </p>
                <p class="card-text">
                    <small class="text-muted">
                        <strong>Categoría:</strong> <?= Html::encode($model->articulo->categoria->nombre ?? 'Sin categoría') ?>
                    </small>
                </p>
                <p class="card-text">
                    <small class="text-muted">
                        <strong>Etiquetas:</strong>
                        <?= !empty($model->articulo->etiquetas) 
                            ? implode(', ', array_map(fn($etiqueta) => Html::encode($etiqueta->nombre), $model->articulo->etiquetas))
                            : 'Sin etiquetas' ?>
                    </small>
                </p>
                <p class="card-text">
                    <small class="text-muted">
                        <strong>Clasificación de la Tienda:</strong> <?= Html::encode($model->tienda->clasificacion->nombre ?? 'Sin clasificación') ?>
                    </small>
                </p>
                <p class="card-text">
                    <small class="text-muted">
                        <strong>Región:</strong> <?= Html::encode($model->tienda->region->nombre ?? 'Sin región') ?>
                    </small>
                </p>
                <p class="card-text">
                    <small class="text-muted">
                        <strong>Fechas:</strong> Desde <?= Yii::$app->formatter->asDate($model->fecha_inicio) ?>
                        - Hasta <?= Yii::$app->formatter->asDate($model->fecha_fin) ?>
                    </small>
                </p>
                <?= Html::a('Ver más', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            </div>
        </div>
    </div>
</div>

