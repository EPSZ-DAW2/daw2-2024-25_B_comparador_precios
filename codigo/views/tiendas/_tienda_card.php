<?php
use yii\helpers\Html;

/** @var app\models\Tienda $model */
?>

<div class="card mb-3" style="max-width: 540px;">
    <div class="row g-0">
        <div class="col-md-4">
            <!-- Muestra una imagen si existe, o un marcador de posición si no -->
            <?= Html::img($model->imagen_principal ? $model->imagen_principal : '/path/to/default-image.jpg', [
                'class' => 'img-fluid rounded-start',
                'alt' => Html::encode($model->nombre),
            ]) ?>
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title"><?= Html::encode($model->nombre) ?></h5>
                <p class="card-text"><?= Html::encode($model->descripcion) ?></p>
                <p class="card-text">
                    <small class="text-muted">
                        Clasificación: <?= $model->clasificacion ? Html::encode($model->clasificacion->nombre) : 'No definida' ?>
                    </small>
                </p>
                <p class="card-text">
                    <small class="text-muted">Ubicación: <?= Html::encode($model->lugar) ?></small>
                </p>
                <?= Html::a('Ver más', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            </div>
        </div>
    </div>
</div>

