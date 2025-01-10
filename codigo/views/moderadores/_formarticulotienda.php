<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Articulo $model */
/** @var yii\widgets\ActiveForm $form */
/** @var app\models\ArticulosTienda $articuloTienda */

?>

<div class="articulo-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Campos del modelo Articulo -->
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'imagen_principal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visible')->checkbox() ?>

    <?= $form->field($model, 'cerrado')->checkbox() ?>

    <!-- Campos del modelo ArticulosTienda -->
    <?= $form->field($articuloTienda, 'precio_actual')->textInput(['maxlength' => true]) ?>
    <?= $form->field($articuloTienda, 'denuncias')->textInput(['maxlength' => true]) ?>
    <?= $form->field($articuloTienda, 'motivo_denuncia')->textarea(['rows' => 3]) ?>
    <?= $form->field($articuloTienda, 'bloqueado')->checkbox() ?>
    <?= $form->field($articuloTienda, 'motivo_bloqueo')->textarea(['rows' => 3]) ?>
    <?= $form->field($articuloTienda, 'cerrado_comentar')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
