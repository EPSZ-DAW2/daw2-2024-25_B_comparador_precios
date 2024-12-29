<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ArticulosSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="articulo-search">

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

    <?= $form->field($model, 'categoria_id') ?>

    <?= $form->field($model, 'etiqueta_id') ?>

    <?php // echo $form->field($model, 'imagen_principal') ?>

    <?php // echo $form->field($model, 'visible') ?>

    <?php // echo $form->field($model, 'cerrado') ?>

    <?php // echo $form->field($model, 'tipo_marcado') ?>

    <?php // echo $form->field($model, 'registro_id') ?>

    <?php // echo $form->field($model, 'articulo_tienda_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
