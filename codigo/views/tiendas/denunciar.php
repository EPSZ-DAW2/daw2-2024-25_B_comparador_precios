<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tienda $model */

$this->title = 'Denunciar Tienda';
$this->params['breadcrumbs'][] = ['label' => 'Tiendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tienda-denunciar">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>¿Por qué deseas denunciar esta tienda?</p>

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'motivo_denuncia')->textarea([
		'value' => '',
		'rows' => 5,
		'name' => 'motivo_denuncia'
	])->label('Motivo de la denuncia') ?>

	<div class="form-group">
		<?= Html::submitButton('Enviar Denuncia', ['class' => 'btn btn-danger']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
