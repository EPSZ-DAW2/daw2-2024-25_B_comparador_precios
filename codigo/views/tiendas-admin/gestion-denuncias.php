<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tienda $model */

$this->title = 'Gestión de Denuncias para Tienda: ' . Html::encode($model->nombre ?? 'Sin nombre');
$this->params['breadcrumbs'][] = ['label' => 'Tiendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tiendas-gestion-denuncias">

    <h1><?= Html::encode($this->title) ?></h1>

    <h3>Detalles de la Tienda</h3>
    <p><strong>Nombre:</strong> <?= Html::encode($model->nombre ?? 'Sin nombre') ?></p>
    <p><strong>Denuncias:</strong> <?= $model->denuncias ?></p>
    <p><strong>Motivos de Denuncia:</strong></p>
    <pre><?= Html::encode($model->motivo_denuncia) ?: 'Sin denuncias registradas.' ?></pre>
    <p><strong>Estado:</strong> <?= $model->isBloqueada() ? 'Bloqueada' : 'Activa' ?></p>

    <?php if ($model->isBloqueada()): ?>
        <p><strong>Motivo de Bloqueo:</strong> <?= Html::encode($model->motivo_bloqueo) ?></p>
        <p><strong>Fecha de Bloqueo:</strong> <?= Html::encode($model->fecha_bloqueo) ?></p>
    <?php endif; ?>

    <!-- Formulario para bloquear tienda -->
    <?php if (!$model->isBloqueada()): ?>
        <h3>Bloquear Tienda</h3>
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'motivo_bloqueo')->textarea([
                'rows' => 3,
                'name' => 'motivo_bloqueo',
            ])->label('Motivo del Bloqueo') ?>
            <?= Html::submitButton('Bloquear Tienda', [
                'class' => 'btn btn-danger',
                'name' => 'accion',
                'value' => 'bloquear',
            ]) ?>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>

    <!-- Formulario para desbloquear tienda -->
    <?php if ($model->isBloqueada()): ?>
        <h3>Desbloquear Tienda</h3>
        <?php $form = ActiveForm::begin(); ?>
            <?= Html::submitButton('Desbloquear Tienda', [
                'class' => 'btn btn-success',
                'name' => 'accion',
                'value' => 'desbloquear',
            ]) ?>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>

</div>


