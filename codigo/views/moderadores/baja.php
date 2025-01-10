<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Solicitar Baja';
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>¿Estás seguro de que deseas solicitar tu baja como moderador?</p>

<?php $form = ActiveForm::begin(); ?>
    <?= Html::submitButton('Solicitar Baja', ['class' => 'btn btn-danger']) ?>
<?php ActiveForm::end(); ?>
