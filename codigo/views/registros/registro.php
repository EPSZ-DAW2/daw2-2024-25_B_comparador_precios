<?php use yii\widgets\ActiveForm; 
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

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
    <?= $form->field($model, 'region_id')->dropDownList(
		\yii\helpers\ArrayHelper::map($regionesPadre, 'id', 'nombre'),
		[
			'prompt' => 'Selecciona tu continente',
			'id' => 'region-continent'
		]
	)
	 ?>

    <?= $form->field($model, 'region_id')->dropDownList(
        [],
        [
            'prompt' => 'Selecciona tu país',
            'id' => 'region-country',
            'disabled' => true
        ]
    ) ?>

    <?= $form->field($model, 'region_id')->dropDownList(
        [],
        [
            'prompt' => 'Selecciona tu provincia',
            'id' => 'region-province',
            'disabled' => true
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Registrarme', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<< JS
    $('#region-continent').change(function() {
        var continentId = $(this).val();
        if (continentId) {
            $.ajax({
                url: '/path/to/your/controller/action', // Cambiar al endpoint correcto
                type: 'GET',
                data: {id: continentId},
                success: function(data) {
                    var countries = JSON.parse(data);
                    $('#region-country').html('');
                    $.each(countries, function(index, value) {
                        $('#region-country').append('<option value="'+index+'">'+value+'</option>');
                    });
                    $('#region-country').prop('disabled', false);
                }
            });
        }
    });

    $('#region-country').change(function() {
        var countryId = $(this).val();
        if (countryId) {
            $.ajax({
                url: '/path/to/your/controller/action', // Cambiar al endpoint correcto
                type: 'GET',
                data: {id: countryId},
                success: function(data) {
                    var provinces = JSON.parse(data);
                    $('#region-province').html('');
                    $.each(provinces, function(index, value) {
                        $('#region-province').append('<option value="'+index+'">'+value+'</option>');
                    });
                    $('#region-province').prop('disabled', false);
                }
            });
        }
    });
JS;

$this->registerJs($script);
?>
