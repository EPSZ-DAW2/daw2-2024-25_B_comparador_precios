<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Actualizar Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="usuario-update-profile">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="usuario-form">
        <?php $form = ActiveForm::begin(); ?>

       
        <?= $form->field($model, 'nick')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'direccion')->textarea(['rows' => 3]) ?>
        <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>

        <br>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <br>
        <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-success']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
