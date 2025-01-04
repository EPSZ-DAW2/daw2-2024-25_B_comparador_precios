<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Region;

/** @var yii\web\View $this */
/** @var app\models\Moderador $model */

$this->title = 'Actualizar Moderador: ' . $model->nombre;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="moderador-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <!-- Reemplaza el campo de texto con un dropdown de regiones válidas -->
    <?= $form->field($model, 'region_id')->dropDownList(
        ArrayHelper::map(Region::find()->all(), 'id', 'nombre'), // Obtiene las regiones
        ['prompt' => 'Selecciona una Región'] // Mensaje predeterminado
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
