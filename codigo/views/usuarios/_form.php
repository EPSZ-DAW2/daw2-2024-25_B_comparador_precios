<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var yii\widgets\ActiveForm $form */
/** @var mixed $modid */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nick')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'region_id')->textInput() ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_nacimiento')->textInput() ?>


    <?= \yii\helpers\Html::a(
        'Verificar Registro', 
        ['usuarios/verificar', 'id' => $model->id], // Cambia 'modid' por 'id'
        [
            'class' => 'btn btn-success',
            'data-method' => 'post', // Usa POST para mayor seguridad
            'data-confirm' => '¿Estás seguro de que deseas verificar este registro?', // Mensaje de confirmación
        ]
    ) ?>


    <?= $form->field($model, 'fecha_acceso')->textInput() ?>

    <?= $form->field($model, 'accesos_fallidos')->textInput() ?>

    <?= $form->field($model, 'bloqueado')->textInput() ?>

    <?= $form->field($model, 'fecha_bloqueo')->textInput() ?>

    <?= $form->field($model, 'motivo_bloqueo')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
