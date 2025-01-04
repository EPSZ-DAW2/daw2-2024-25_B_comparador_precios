<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RegistroUsuariosSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="registro-usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fecha_creacion') ?>

    <?= $form->field($model, 'creador_id') ?>

    <?= $form->field($model, 'fecha_mod') ?>

    <?= $form->field($model, 'mod_id') ?>

    <?php // echo $form->field($model, 'notas_admin') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
