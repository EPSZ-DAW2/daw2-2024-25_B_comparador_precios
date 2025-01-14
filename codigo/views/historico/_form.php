<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Historico $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="historico-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'articulo_id')->textInput() ?>

    <?= $form->field($model, 'tienda_id')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'precio')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
