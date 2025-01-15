<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Aviso $aviso */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="aviso-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($aviso, 'clase')->dropDownList([
        'Aviso' => 'Aviso',
        'Denuncia' => 'Denuncia',
        'Consulta' => 'Consulta',
        'Mensaje Generico' => 'Mensaje Generico',
        'Bloqueo' => 'Bloqueo',
    ], ['prompt' => 'Seleccione una clase']) ?>

    <?= $form->field($aviso, 'texto')->textarea(['rows' => 6]) ?>

    <?= $form->field($aviso, 'usuario_destino_nick')->textInput() ?>

    <?= $form->field($aviso, 'tienda_id')->textInput() ?>

    <?= $form->field($aviso, 'articulo_id')->textInput() ?>

    <?= $form->field($aviso, 'comentario_id')->textInput() ?>

    <?= $form->field($aviso, 'fecha_lectura')->textInput(['type' => 'datetime-local']) ?>

    <?= $form->field($aviso, 'fecha_aceptado')->textInput(['type' => 'datetime-local']) ?>

    <div class="form-group">
        <?= Html::submitButton($aviso->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $aviso->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

