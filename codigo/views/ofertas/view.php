<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ofertas $model */
/** @var app\models\Comentario[] $comentarios */
/** @var app\models\Comentario $comentario */

$this->title = $model->articulo->nombre ?? 'Oferta sin título';
$this->params['breadcrumbs'][] = ['label' => 'Ofertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oferta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Detalles de la oferta -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Artículo',
                'value' => $model->articulo->nombre ?? 'Sin artículo asociado',
            ],
            [
                'label' => 'Descripción',
                'value' => $model->articulo->descripcion ?? 'Sin descripción',
            ],
            'precio_oferta:currency',
            'precio_og:currency',
            [
                'label' => 'Tienda',
                'value' => $model->tienda->nombre ?? 'Sin tienda asociada',
            ],
            [
                'label' => 'Categoría',
                'value' => $model->articulo->categoria->nombre ?? 'Sin categoría',
            ],
            [
                'label' => 'Etiquetas',
                'value' => !empty($model->articulo->etiquetas)
                    ? implode(', ', array_map(fn($etiqueta) => Html::encode($etiqueta->nombre), $model->articulo->etiquetas))
                    : 'Sin etiquetas',
            ],
			[
				'label' => 'Imagen del Artículo',
				'format' => 'raw',
				'value' => Html::img(
					Url::to('@web/img/' . ($model->articulo->imagen_principal ?? 'placeholder.jpg')),
					[
						'alt' => Html::encode($model->articulo->nombre ?? 'Sin artículo'),
						'style' => 'max-width: 200px;',
						'onerror' => "this.onerror=null;this.src='" . Url::to('@web/img/placeholder.jpg') . "';",
					]
				),
			],
            [
                'label' => 'Valoración Media',
                'value' => $model->getValoracionMedia(),
            ],
        ],
    ]) ?>

    <!-- Comentarios -->
    <h3>Comentarios</h3>
    <?php if (!empty($comentarios)): ?>
        <ul class="list-group">
            <?php foreach ($comentarios as $comentario): ?>
                <li class="list-group-item">
                    <strong><?= Html::encode($comentario->usuario->nick ?? 'Anónimo') ?>:</strong>
                    <?= Html::encode($comentario->texto) ?>
                    <span class="badge bg-info"><?= $comentario->valoracion ?>/5</span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay comentarios disponibles para esta oferta.</p>
    <?php endif; ?>

    <!-- Formulario para añadir un comentario -->
        <h3>Añadir un Comentario</h3>
        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($comentario, 'texto')->textarea([
                'rows' => 4,
                'value' => '',
            ]) ?>

            <?= $form->field($comentario, 'valoracion')->dropDownList([
                5 => '5 - Excelente',
                4 => '4 - Muy Bueno',
                3 => '3 - Bueno',
                2 => '2 - Regular',
                1 => '1 - Malo',
            ], ['prompt' => 'Seleccionar Valoración',
				'value' => null,
			]) ?>

            <?= Html::submitButton('Enviar Comentario', ['class' => 'btn btn-primary']) ?>

        <?php ActiveForm::end(); ?>

    <!-- Botones de Acciones -->
    <p>
        <?= Html::a('Denunciar Oferta', ['denunciar', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>

        <?php
        $seguimiento = !Yii::$app->user->isGuest
            ? \app\models\Seguimiento::findOne(['usuario_id' => Yii::$app->user->id, 'oferta_id' => $model->id])
            : null;
        ?>
        <?= Html::a(
            $seguimiento ? 'Dejar de Seguir' : 'Seguir Oferta',
            ['seguimiento', 'id' => $model->id],
            [
                'class' => $seguimiento ? 'btn btn-danger' : 'btn btn-success',
                'data' => [
                    'confirm' => $seguimiento
                        ? '¿Estás seguro de que quieres dejar de seguir esta oferta?'
                        : '¿Quieres seguir esta oferta?',
                ],
            ]
        ) ?>
    </p>
</div>

