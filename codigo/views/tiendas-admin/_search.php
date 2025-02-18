<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TiendaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tienda-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'nombre') ?>
    <?= $form->field($model, 'descripcion') ?>
    <?= $form->field($model, 'lugar') ?>
    <?= $form->field($model, 'url') ?>
    <?= $form->field($model, 'region_id') ?>
    <?= $form->field($model, 'clasificacion_id') ?>
    <?= $form->field($model, 'etiquetas_id') ?>
    <?= $form->field($model, 'visible')->checkbox() ?>
    <?= $form->field($model, 'cerrada')->checkbox() ?>
    <?= $form->field($model, 'denuncias') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
