<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RegistroLogsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="registro-logs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'fecha_log') ?>
    <?= $form->field($model, 'mensaje') ?>
    <?= $form->field($model, 'nivel') ?>
    <?= $form->field($model, 'usuario') ?>
    <?= $form->field($model, 'accion') // Campo acción agregado ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reiniciar'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

