<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ComentarioSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="comentario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'texto') ?>

    <?= $form->field($model, 'denuncias') ?>

    <?= $form->field($model, 'bloqueado') ?>

    <?= $form->field($model, 'motivo_denuncia') ?>

    <?= $form->field($model, 'motivo_bloqueo') ?>

    <?= $form->field($model, 'fecha_bloqueo') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>