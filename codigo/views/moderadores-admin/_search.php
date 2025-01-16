<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ModeradorSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="moderador-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'usuario_id') ?>
    <?= $form->field($model, 'nif') ?>
    <?= $form->field($model, 'nombre') ?>
    <?= $form->field($model, 'direccion') ?>
    <?= $form->field($model, 'region_id') ?>
    <?= $form->field($model, 'telefono') ?>
    <?= $form->field($model, 'razon_social') ?>
    <?= $form->field($model, 'baja_solicitada') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
