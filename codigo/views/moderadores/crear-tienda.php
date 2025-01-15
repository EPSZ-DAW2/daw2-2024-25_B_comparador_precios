<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tienda */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Crear Tienda';
$this->params['breadcrumbs'][] = ['label' => 'Revisar Tiendas', 'url' => ['revisar-tiendas']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tienda-crear">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="tienda-form">

        <?php $form = ActiveForm::begin(); ?>

        <!-- Campo para el nombre -->
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

        <!-- Campo para la descripción -->
        <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

        <!-- Campo para el lugar -->
        <?= $form->field($model, 'lugar')->textInput(['maxlength' => true]) ?>

        <!-- Campo para la URL -->
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

        <!-- Campo para la dirección -->
        <?= $form->field($model, 'direccion')->textarea(['rows' => 2]) ?>

        <!-- Campo para el teléfono -->
        <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

        <!-- Campo para la imagen principal -->
        <?= $form->field($model, 'imagen_principal')->textInput(['maxlength' => true]) ?>

        <!-- Región asignada automáticamente al moderador -->
        <?= Html::activeHiddenInput($model, 'region_id') ?>
        <p>Región asignada: <strong><?= $model->region->nombre ?? 'Sin Región' ?></strong></p>

        <!-- Checkbox para marcar si es visible -->
        <?= $form->field($model, 'visible')->checkbox() ?>

        <!-- Selección del seguimiento -->
        <?= $form->field($model, 'seguimiento_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Seguimiento::find()->all(), 'id', 'nombre'),
            ['prompt' => 'Seleccione un Seguimiento']
        ) ?>

        <!-- Selección del registro -->
        <?= $form->field($model, 'registro_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\RegistroUsuarios::find()->all(), 'id', 'nombre'),
            ['prompt' => 'Seleccione un Registro']
        ) ?>



        <!-- Campos ocultos para inicializar valores predeterminados -->
        <?= Html::activeHiddenInput($model, 'suma_valoraciones', ['value' => 0]) ?>
        <?= Html::activeHiddenInput($model, 'suma_votos', ['value' => 0]) ?>
        <?= Html::activeHiddenInput($model, 'denuncias', ['value' => 0]) ?>
        <?= Html::activeHiddenInput($model, 'bloqueada', ['value' => 0]) ?>
        <?= Html::activeHiddenInput($model, 'comentarios_id', ['value' => null]) ?>
        <?= Html::activeHiddenInput($model, 'cerrada', ['value' => 0]) ?>

        <!-- Botón de envío -->
        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
