<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Articulo $model */
/** @var app\models\Comentario[] $comentarios */
/** @var app\models\Comentario $comentario */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Artículos', 'url' => ['public-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articulo-view">

    <h1 class="page-title"><?= Html::encode($this->title) ?></h1>

    <!-- Detalles del Artículo -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
            'descripcion:ntext',
            [
                'attribute' => 'categoria_id',
                'label' => 'Categoría',
                'value' => $model->categoria->nombre ?? 'Sin categoría',
            ],
            [
                'attribute' => 'etiqueta_id',
                'label' => 'Etiqueta',
                'value' => $model->etiqueta->nombre ?? 'Sin etiqueta',
            ],
            [
                'attribute' => 'imagen_principal',
                'format' => 'raw',
                'value' => Html::img(
                    Url::to('@web/img/' . ($model->imagen_principal ?: 'placeholder.jpg')),
                    [
                        'alt' => Html::encode($model->nombre),
                        'class' => 'detail-image',
                        'onerror' => "this.onerror=null;this.src='".Url::to('@web/img/placeholder.jpg')."';"
                    ]
                ),
            ],
            [
                'label' => 'Valoración Media',
                'value' => $model->valoracionMedia,
            ],
        ],
    ]) ?>

    <!-- Comentarios -->
    <h3 class="section-title">Comentarios</h3>
    <?php if (!empty($comentarios)): ?>
        <ul class="comment-list">
            <?php foreach ($comentarios as $comentario): ?>
                <li class="comment-item">
                    <strong><?= Html::encode($comentario->usuario->nick ?? 'Anónimo') ?>:</strong>
                    <?= Html::encode($comentario->texto) ?>
                    <span class="badge bg-info"><?= $comentario->valoracion ?>/5</span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="no-comments">No hay comentarios disponibles.</p>
    <?php endif; ?>

    <!-- Formulario para añadir un comentario -->
    <h3 class="section-title">Añadir un Comentario</h3>
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($comentario, 'texto')->textarea(['rows' => 4, 'value' => '', 'class' => 'form-control']) ?>
        <?= $form->field($comentario, 'valoracion')->dropDownList([
            5 => '5 - Excelente',
            4 => '4 - Muy Bueno',
            3 => '3 - Bueno',
            2 => '2 - Regular',
            1 => '1 - Malo',
        ], ['prompt' => 'Seleccionar Valoración', 'class' => 'form-control']) ?>
        <?= Html::submitButton('Enviar Comentario', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

    <!-- Botones de Acciones -->
    <div class="action-buttons">
        <?= Html::a('Denunciar Tienda', ['denunciar', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>

        <?= Html::a('Ir a la Tienda', ['tiendas/view-store', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?php
        $seguimiento = !Yii::$app->user->isGuest ? app\models\Seguimiento::findOne([
            'usuario_id' => Yii::$app->user->identity->id,
            'tienda_id' => $model->id
        ]) : null;
        ?>
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


</div>
