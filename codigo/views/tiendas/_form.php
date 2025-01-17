<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tienda $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tienda-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'lugar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'region_id')->textInput() ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'clasificacion_id')->textInput() ?>

    <?= $form->field($model, 'etiquetas_id')->textInput() ?>

    <?= $form->field($model, 'imagen_principal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'suma_valoraciones')->textInput() ?>

    <?= $form->field($model, 'suma_votos')->textInput() ?>

    <?= $form->field($model, 'visible')->textInput() ?>

    <?= $form->field($model, 'cerrada')->textInput() ?>

    <?= $form->field($model, 'denuncias')->textInput() ?>

    <?= $form->field($model, 'fecha_primera_denuncia')->textInput() ?>

    <?= $form->field($model, 'motivo_denuncia')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'bloqueada')->textInput() ?>

    <?= $form->field($model, 'fecha_bloqueo')->textInput() ?>

    <?= $form->field($model, 'motivo_bloqueo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'comentarios_id')->textInput() ?>

    <?= $form->field($model, 'cerrado_comentar')->textInput() ?>

    <?= $form->field($model, 'seguimiento_id')->textInput() ?>

    <?= $form->field($model, 'registro_id')->textInput() ?>

    <?= $form->field($model, 'articulo_tienda_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
