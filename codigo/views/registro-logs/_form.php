<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var app\models\RegistroLogs $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="registro-logs-form usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha_log')->input('datetime-local') ?>
    <?= $form->field($model, 'mensaje')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'nivel')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'usuario')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'accion')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
