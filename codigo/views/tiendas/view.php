<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Tienda $model */
/** @var app\models\Comentario $comentario */
/** @var app\models\Comentario[] $comentarios */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tiendas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tienda-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Detalles de la Tienda -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'descripcion:ntext',
            'lugar',
            [
                'attribute' => 'url',
                'format' => 'url',
                'value' => $model->url,
            ],
            [
                'attribute' => 'clasificacion_id',
				'label' => 'Clasificación',
                'value' => $model->clasificacion ? $model->clasificacion->nombre : 'No definida',
            ],
            [
                'attribute' => 'etiquetas_id',
				'label' => 'Etiquetas',
                'value' => $model->etiquetas ? $model->etiquetas->nombre : 'No definida',
            ],
            [
                'attribute' => 'imagen_principal',
                'format' => 'raw',
                'value' => Html::img(Url::to('@web/img/' . $model->imagen_principal), [
                    'alt' => Html::encode($model->nombre),
                    'style' => 'max-width: 200px;',
                ]),
            ],
            'telefono',
            [
				'label' => 'Valoración Media',
				'value' => $model->valoracionMedia,
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
        <p>No hay comentarios disponibles.</p>
    <?php endif; ?>

    <!-- Formulario para Añadir Comentarios -->
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
		
	<p>
		<?= Html::a('Denunciar Tienda', ['denunciar', 'id' => $model->id], [
			'class' => 'btn btn-warning',
		]) ?>

	</p>

    <p>        
         <?= Html::a(
				 'Ir a la tienda',
				['tiendas/view-store', 'id' => $model->id],
				[
					'class' => 'btn btn-primary',
				]
			) ?>
    </p>

		<?php
		$seguimiento = !Yii::$app->user->isGuest
			? app\models\Seguimiento::find()
				->where(['usuario_id' => Yii::$app->user->identity->id, 'tienda_id' => $model->id])
				->one()
			: null;
		?>
		<div class="seguimiento">
			<?= Html::a(
				$seguimiento ? 'Dejar de Seguir' : 'Seguir Tienda',
				['tiendas/seguimiento', 'id' => $model->id],
				[
					'class' => $seguimiento ? 'btn btn-danger' : 'btn btn-success',
					'data' => !Yii::$app->user->isGuest ? [
						'confirm' => $seguimiento
							? '¿Estás seguro de que quieres dejar de seguir esta tienda?'
							: '¿Quieres seguir esta tienda?',
					] : [],
				]
			) ?>
		</div>
        

	
    <?php ActiveForm::end(); ?>

</div>
