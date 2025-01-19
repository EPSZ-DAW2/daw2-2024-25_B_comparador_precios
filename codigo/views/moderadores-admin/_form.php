<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('@web/css/formulario.css'); // Registrar el archivo CSS

/** @var yii\web\View $this */
/** @var app\models\Moderador $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="moderador-form usuario-form"> 

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usuario_id')->textInput() ?>
    <?= $form->field($model, 'nif')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'direccion')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'region_id')->textInput() ?>
    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'razon_social')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'baja_solicitada')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
