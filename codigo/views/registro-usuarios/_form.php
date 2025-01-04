<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RegistroUsuarios $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="registro-usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha_creacion')->textInput() ?>

    <?= $form->field($model, 'creador_id')->textInput() ?>

    <?= $form->field($model, 'fecha_mod')->textInput() ?>

    <?= $form->field($model, 'mod_id')->textInput() ?>

    <?= $form->field($model, 'notas_admin')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
