<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ofertas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ofertas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'articulo_id')->textInput() ?>

    <?= $form->field($model, 'tienda_id')->textInput() ?>

    <?= $form->field($model, 'fecha_inicio')->textInput() ?>

    <?= $form->field($model, 'fecha_fin')->textInput() ?>

    <?= $form->field($model, 'precio_oferta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precio_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registro_id')->textInput() ?>

    <?= $form->field($model, 'notas')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
