<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Tienda $model */
?>

<div class="tienda-card">
    <div class="row g-0">
        <div class="col-md-4">
            <!-- Muestra una imagen si existe, o un marcador de posición si no -->
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
                    <small class="text-muted">
                        <strong>Clasificación:</strong> <?= $model->clasificacion ? Html::encode($model->clasificacion->nombre) : 'No definida' ?>
                    </small>
                </p>
                <p class="card-text">
					<small class="text-muted">
						<strong>Etiqueta:</strong> 
                        <?= !empty($model->etiquetas0) 
                            ? implode(', ', array_map(fn($etiqueta) => Html::encode($etiqueta->nombre), $model->etiquetas0))
                            : 'Sin etiquetas' ?>
					</small>
                </p>				
                <p class="card-text">
                    <small class="text-muted">
						<strong>Ubicación:</strong> <?= Html::encode($model->lugar) ?>
					</small>
                </p>
                <?= Html::a('Ver más', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            </div>
        </div>
    </div>
</div>

