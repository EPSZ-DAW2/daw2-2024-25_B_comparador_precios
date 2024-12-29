<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Articulo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="articulo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'categoria_id')->textInput() ?>

    <?= $form->field($model, 'etiqueta_id')->textInput() ?>

    <?= $form->field($model, 'imagen_principal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visible')->textInput() ?>

    <?= $form->field($model, 'cerrado')->textInput() ?>

    <?= $form->field($model, 'tipo_marcado')->dropDownList([ 'comun' => 'Comun', 'particular' => 'Particular', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'registro_id')->textInput() ?>

    <?= $form->field($model, 'articulo_tienda_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
