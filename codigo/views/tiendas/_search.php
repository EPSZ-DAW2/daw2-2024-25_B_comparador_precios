<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TiendasSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tienda-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'lugar') ?>

    <?= $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'direccion') ?>

    <?php // echo $form->field($model, 'region_id') ?>

    <?php // echo $form->field($model, 'telefono') ?>

    <?php // echo $form->field($model, 'clasificacion_id') ?>

    <?php // echo $form->field($model, 'etiquetas_id') ?>

    <?php // echo $form->field($model, 'imagen_principal') ?>

    <?php // echo $form->field($model, 'suma_valoraciones') ?>

    <?php // echo $form->field($model, 'suma_votos') ?>

    <?php // echo $form->field($model, 'visible') ?>

    <?php // echo $form->field($model, 'cerrada') ?>

    <?php // echo $form->field($model, 'denuncias') ?>

    <?php // echo $form->field($model, 'fecha_primera_denuncia') ?>

    <?php // echo $form->field($model, 'motivo_denuncia') ?>

    <?php // echo $form->field($model, 'bloqueada') ?>

    <?php // echo $form->field($model, 'fecha_bloqueo') ?>

    <?php // echo $form->field($model, 'motivo_bloqueo') ?>

    <?php // echo $form->field($model, 'comentarios_id') ?>

    <?php // echo $form->field($model, 'cerrado_comentar') ?>

    <?php // echo $form->field($model, 'propietario_usuario_id') ?>

    <?php // echo $form->field($model, 'seguimiento_id') ?>

    <?php // echo $form->field($model, 'registro_id') ?>

    <?php // echo $form->field($model, 'articulo_tienda_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
