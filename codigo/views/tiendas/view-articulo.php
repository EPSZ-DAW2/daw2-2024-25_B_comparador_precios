<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tienda $model */
/** @var app\models\Comentario $comentario */
/** @var app\models\Comentario[] $comentarios */

$this->title = $model->nombre; // Nombre del articulo
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tiendas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="tienda-view">

    <!-- Título de la tienda -->
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Detalles de la tienda -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'descripcion:ntext',
            'lugar',
            'url:url',
            'direccion:ntext',
            'telefono',
            'clasificacion_id',
            'etiquetas_id',
            'imagen_principal',
            'visible:boolean',
            'cerrada:boolean',
            'registro_id',
        ],
    ]) ?>

    <h2>Comentarios</h2>

    <!-- Formulario para añadir un comentario -->
    <div class="comentario-form">
        <?php $form = ActiveForm::begin([
            'action' => yii\helpers\Url::to([
                'comentarios/comentar',
            ]),
            'method' => 'get',
        ]); ?>

        <!-- Campo para el texto del comentario -->
        <?= $form->field($comentario, 'texto', [
            'options' => ['tag' => false], // Desactiva el contenedor <div>
        ])->textarea([
            'rows' => 6,
            'placeholder' => 'Escribe tu comentario aquí...',
            'name' => 'texto'  // Personaliza el nombre del campo
        ])->label('Comentario') ?>

        <!-- Campo oculto para el ID de la tienda -->
        <?= $form->field($comentario, 'tienda_id', [
            'options' => ['tag' => false], // Desactiva el contenedor <div>
        ])->hiddenInput([
            'value' => $tienda_id,
            'name' => 'tieid'  // Personaliza el nombre del campo
        ])->label(false) ?>

        <!-- Campo oculto para el ID del artículo -->
        <?= $form->field($comentario, 'articulo_id', [
            'options' => ['tag' => false], // Desactiva el contenedor <div>
        ])->hiddenInput([
            'value' => $model->id,
            'name' => 'artid'  // Personaliza el nombre del campo
        ])->label(false) ?>

        <!-- Campo opcional para la valoración -->
        <?= $form->field($comentario, 'valoracion', [
            'options' => ['tag' => false], // Desactiva el contenedor <div>
        ])->dropDownList(
            [1, 2, 3, 4, 5],
            [
                'prompt' => 'Selecciona una valoración (opcional)',
                'name' => 'valor'  // Personaliza el nombre del campo
            ]
        )->label('Valor') ?>

        <!-- Botón para enviar el formulario -->
        <div class="form-group">
            <?php if (!Yii::$app->user->isGuest): ?>
                <?= Html::submitButton(Yii::t('app', 'Comentar'), [
                    'class' => 'btn btn-primary',
                ]) ?>
                
            <?php else: ?>
                <p><?= Yii::t('app', 'Por favor, inicie sesión para comentar.') ?></p>
            <?php endif; ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>

        </div>


    <h3>Comentarios Existentes</h3>

    <!-- Lista de comentarios -->
    <?php if (!empty($comentarios)): ?>
        <ul class="list-group">
            <?php foreach ($comentarios as $comentario): ?>
                <li class="list-group-item">
                    <strong><?= Html::encode($comentario->usuario->nick ?? 'Usuario desconocido') ?></strong>
                    <p><?= Html::encode($comentario->texto) ?></p>
                    <div class="comentario-valoracion">
                        <strong>Valoración:</strong>
                        <?= str_repeat('★', $comentario->valoracion) ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay comentarios disponibles para esta tienda.</p>
    <?php endif; ?>

</div>
