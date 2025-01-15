<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Regiones;

/** @var yii\web\View $this */
/** @var app\models\Moderador $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="moderador-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nif')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccion')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'region_id')->dropDownList(
        ArrayHelper::map(Regiones::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Selecciona una Región']
    ) ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'razon_social')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'baja_solicitada')->checkbox([
        'label' => '¿Solicitar baja?',
        'uncheck' => 0,
        'checked' => 1,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
