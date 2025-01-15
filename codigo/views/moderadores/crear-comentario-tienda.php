<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Comentario $comentario */

$this->title = 'Crear Comentario';
?>
<div class="comentario-crear">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="comentario-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($comentario, 'tienda_id')->textInput() ?>
        <?= $form->field($comentario, 'articulo_id')->textInput() ?>
        <?= $form->field($comentario, 'valoracion')->textInput() ?>
        <?= $form->field($comentario, 'texto')->textarea(['rows' => 6]) ?>
        <?= $form->field($comentario, 'comentario_padre_id')->textInput() ?>
        <?= $form->field($comentario, 'cerrado')->checkbox() ?>
        <?= $form->field($comentario, 'denuncias')->textInput() ?>
        <?= $form->field($comentario, 'fecha_primera_denuncia')->textInput(['type' => 'datetime-local']) ?>
        <?= $form->field($comentario, 'motivo_denuncia')->textarea(['rows' => 3]) ?>
        <?= $form->field($comentario, 'bloqueado')->checkbox() ?>
        <?= $form->field($comentario, 'fecha_bloqueo')->textInput(['type' => 'datetime-local']) ?>
        <?= $form->field($comentario, 'motivo_bloqueo')->textarea(['rows' => 3]) ?>
        <?= $form->field($comentario, 'registro_id')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
