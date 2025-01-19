<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Comentario $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="comentario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'texto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'denuncias')->textInput() ?>

    <?= $form->field($model, 'bloqueado')->checkbox() ?>

    <?= $form->field($model, 'motivo_denuncia')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'motivo_bloqueo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fecha_bloqueo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>