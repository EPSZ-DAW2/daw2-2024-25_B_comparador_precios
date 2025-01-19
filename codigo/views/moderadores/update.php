<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Regiones; // Importamos la clase Regiones para el dropdown

/** @var yii\web\View $this */
/** @var app\models\Moderador $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Actualizar Perfil';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="moderador-form usuario-form"> <!-- Se agregó la clase 'usuario-form' para los estilos -->

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'region_id')->dropDownList(
        ArrayHelper::map(Regiones::find()->all(), 'id', 'nombre'), // Cambié Region por Regiones
        ['prompt' => 'Selecciona una Región']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
