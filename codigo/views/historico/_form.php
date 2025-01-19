<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('@web/css/formulario.css'); // Registrar el archivo CSS

/** @var yii\web\View $this */
/** @var app\models\Historico $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="historico-form usuario-form"> <!-- Agregada la clase usuario-form para los estilos -->

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'articulo_id')->textInput() ?>

    <?= $form->field($model, 'tienda_id')->textInput() ?>

    <!-- Cambiar el tipo de input para 'fecha' a datetime-local -->
    <?= $form->field($model, 'fecha')->textInput(['type' => 'datetime-local']) ?>

    <?= $form->field($model, 'precio')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
