<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tienda $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Editar Tienda: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Revisar Tiendas', 'url' => ['revisar-tiendas']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['ver-tienda', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>

<div class="tienda-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="tienda-form usuario-form"> <!-- Se añadió la clase 'usuario-form' para los estilos -->

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'descripcion')->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'region_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Regiones::find()->all(), 'id', 'nombre'),
            ['prompt' => 'Seleccione una Región']
        ) ?>
        <?= $form->field($model, 'visible')->dropDownList([1 => 'Sí', 0 => 'No']) ?>
        <?= $form->field($model, 'cerrada')->dropDownList([1 => 'Sí', 0 => 'No']) ?>
        <?= $form->field($model, 'imagen_principal')->textInput(['maxlength' => true]) ?>

        <!-- Cambiar seguimiento_id a un campo de texto numérico -->
        <?= $form->field($model, 'seguimiento_id')->textInput(['type' => 'number', 'min' => 1, 'placeholder' => 'Ingrese un valor entero para Seguimiento']) ?>
        <?php if ($model->hasErrors('seguimiento_id')): ?>
            <div class="invalid-feedback">
                <?= implode(', ', $model->getErrors('seguimiento_id')) ?>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Cancelar', ['ver-tienda', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
