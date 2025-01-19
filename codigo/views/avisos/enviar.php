<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Aviso $aviso */
/** @var app\models\Usuario[] $usuarios */

$this->title = 'Enviar Aviso';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aviso-enviar">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php elseif (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <!-- Dropdown para la clase con los valores solicitados -->
    <?= $form->field($aviso, 'clase')->dropDownList([
        'Aviso' => 'Aviso',
        'Denuncia' => 'Denuncia',
        'Consulta' => 'Consulta',
        'Mensaje Generico' => 'Mensaje Generico',
        'Bloqueo' => 'Bloqueo',
    ], ['prompt' => 'Selecciona una clase']) ?>

    <!-- Campo de texto para el mensaje -->
    <?= $form->field($aviso, 'texto')->textarea(['rows' => 6]) ?>

    <!-- Campo de texto para buscar el usuario destino por nick -->
    <?= $form->field($aviso, 'usuario_destino_nick')->textInput(['placeholder' => 'Buscar por nick del usuario']) ?>

    <div class="form-group">
        <?= Html::submitButton('Enviar Aviso', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
