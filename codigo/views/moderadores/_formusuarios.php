<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Regiones;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuario-form" style="width: 100%; max-width: 1200px; margin: 80px auto 0; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

    <!-- Título del formulario -->
    <h1 style="text-align: center; font-size: 2rem; color: #333; margin-bottom: 30px;">Gestión de Usuarios</h1>

    <?php $form = ActiveForm::begin([
        'options' => [
            'style' => 'display: flex; flex-wrap: wrap; gap: 20px;',
        ],
    ]); ?>

    <!-- Email -->
    <div style="flex: 1 1 calc(50% - 20px);">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>


    <!-- Password -->
    <div style="flex: 1 1 calc(50% - 20px);">
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    </div>

    <!-- Nick -->
    <div style="flex: 1 1 calc(50% - 20px);">
        <?= $form->field($model, 'nick')->textInput(['maxlength' => true]) ?>
    </div>

    <!-- Nombre -->
    <div style="flex: 1 1 calc(50% - 20px);">
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    </div>

    <!-- Apellidos -->
    <div style="flex: 1 1 calc(50% - 20px);">
        <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>
    </div>

    <!-- Dirección -->
    <div style="flex: 1 1 100%;">
        <?= $form->field($model, 'direccion')->textarea(['rows' => 3]) ?>
    </div>

    <!-- Región -->
    <div style="flex: 1 1 calc(50% - 20px);">
        <?= $form->field($model, 'region_id')->dropDownList(
            ArrayHelper::map(Regiones::find()->all(), 'id', 'nombre'),
            ['prompt' => 'Selecciona una Región']
        ) ?>
    </div>

    <!-- Teléfono -->
    <div style="flex: 1 1 calc(50% - 20px);">
        <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
    </div>

    <!-- Fecha de Nacimiento -->
    <div style="flex: 1 1 calc(50% - 20px);">
        <?= $form->field($model, 'fecha_nacimiento')->textInput(['type' => 'date']) ?>
    </div>

    <!-- Fecha de Registro (readonly) -->
    <div style="flex: 1 1 calc(50% - 20px);">
        <?= $form->field($model, 'fecha_registro')->textInput(['readonly' => true]) ?>
    </div>

    <!-- Fecha de Acceso (readonly) -->
    <div style="flex: 1 1 calc(50% - 20px);">
        <?= $form->field($model, 'fecha_acceso')->textInput(['readonly' => true]) ?>
    </div>

    <!-- Accesos Fallidos (readonly) -->
    <div style="flex: 1 1 calc(50% - 20px);">
        <?= $form->field($model, 'accesos_fallidos')->textInput(['readonly' => true]) ?>
    </div>

    <!-- Bloqueado (checkbox) -->
    <div style="flex: 1 1 calc(50% - 20px);">
        <?= $form->field($model, 'bloqueado')->checkbox() ?>
    </div>

    <!-- Fecha de Bloqueo (readonly) -->
    <div style="flex: 1 1 calc(50% - 20px);">
        <?= $form->field($model, 'fecha_bloqueo')->textInput(['readonly' => true]) ?>
    </div>

    <!-- Motivo de Bloqueo -->
    <div style="flex: 1 1 100%;">
        <?= $form->field($model, 'motivo_bloqueo')->textarea(['rows' => 3]) ?>
    </div>

    <!-- Botón Guardar -->
    <div style="flex: 1 1 100%; text-align: center;">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
