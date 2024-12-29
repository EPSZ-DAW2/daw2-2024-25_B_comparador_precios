<?php use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Registro de Usuario';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="usuario-register">
    <?php $form = ActiveForm::begin([
        'id' => 'usuario-register-form',
        'method' => 'post',
    ]); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nick')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccion')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>

    <!-- Opción para la región -->
    <?= $form->field($model, 'region_id')->dropDownList([
        1 => 'Región 1', 
        2 => 'Región 2', 
        3 => 'Región 3',
    ], ['prompt' => 'Selecciona tu región']) ?>

    <div class="form-group">
        <?= Html::submitButton('Registrarme', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
