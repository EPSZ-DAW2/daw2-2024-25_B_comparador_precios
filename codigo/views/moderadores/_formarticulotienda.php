<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Articulo $model */
/** @var yii\widgets\ActiveForm $form */
/** @var app\models\ArticulosTienda $articuloTienda */

?>

<div class="articulo-form">

    <?php $form = ActiveForm::begin(); ?>

    <h2>Información del Artículo</h2>
    <!-- Campos del modelo Articulo -->
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'placeholder' => 'Ingrese el nombre del artículo'])->label('Nombre del Artículo') ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6, 'placeholder' => 'Descripción detallada del artículo'])->label('Descripción') ?>

    <?= $form->field($model, 'imagen_principal')->textInput(['maxlength' => true, 'placeholder' => 'URL de la imagen principal'])->label('Imagen Principal (URL)') ?>

    <?= $form->field($model, 'visible')->checkbox()->label('¿Visible para los usuarios?') ?>

    <?= $form->field($model, 'cerrado')->checkbox()->label('¿El artículo está cerrado?') ?>

    <h2>Configuración en la Tienda</h2>
    <!-- Campos del modelo ArticulosTienda -->
    <?= $form->field($articuloTienda, 'precio_actual')->textInput(['maxlength' => true, 'placeholder' => 'Precio del artículo'])->label('Precio Actual') ?>

    <?= $form->field($articuloTienda, 'denuncias')->textInput(['maxlength' => true, 'placeholder' => 'Número de denuncias'])->label('Denuncias Recibidas') ?>

    <?= $form->field($articuloTienda, 'motivo_denuncia')->textarea(['rows' => 3, 'placeholder' => 'Motivo de las denuncias'])->label('Motivos de Denuncia') ?>

    <?= $form->field($articuloTienda, 'bloqueado')->checkbox()->label('¿El artículo está bloqueado?') ?>

    <?= $form->field($articuloTienda, 'motivo_bloqueo')->textarea(['rows' => 3, 'placeholder' => 'Motivo del bloqueo'])->label('Motivo del Bloqueo') ?>

    <?= $form->field($articuloTienda, 'cerrado_comentar')->checkbox()->label('¿Comentarios cerrados?') ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Crear' : 'Actualizar',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
