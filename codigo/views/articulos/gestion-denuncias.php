<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ArticulosTienda $model */

$this->title = 'Gestión de Denuncias para Artículo: ' . Html::encode($model->articulo->nombre ?? 'Sin nombre');
$this->params['breadcrumbs'][] = ['label' => 'Artículos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articulos-gestion-denuncias">

    <h1><?= Html::encode($this->title) ?></h1>

    <h3>Detalles del Artículo</h3>
    <p><strong>Nombre:</strong> <?= Html::encode($model->articulo->nombre ?? 'Sin nombre') ?></p>
    <p><strong>Denuncias:</strong> <?= $model->denuncias ?></p>
    <p><strong>Motivos de Denuncia:</strong></p>
    <pre><?= Html::encode($model->motivo_denuncia) ?: 'Sin denuncias registradas.' ?></pre>
    <p><strong>Estado:</strong> <?= $model->bloqueado ? 'Bloqueado' : 'Activo' ?></p>

    <?php if ($model->bloqueado): ?>
        <p><strong>Motivo de Bloqueo:</strong> <?= Html::encode($model->motivo_bloqueo) ?></p>
        <p><strong>Fecha de Bloqueo:</strong> <?= Html::encode($model->fecha_bloqueo) ?></p>
    <?php endif; ?>

    <!-- Formulario para bloquear artículo -->
    <?php if (!$model->bloqueado): ?>
        <h3>Bloquear Artículo</h3>
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'motivo_bloqueo')->textarea([
                'rows' => 3,
                'name' => 'motivo_bloqueo',
            ])->label('Motivo del Bloqueo') ?>
            <?= Html::submitButton('Bloquear Artículo', [
                'class' => 'btn btn-danger',
                'name' => 'accion',
                'value' => 'bloquear',
            ]) ?>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>

    <!-- Formulario para desbloquear artículo -->
    <?php if ($model->bloqueado): ?>
        <h3>Desbloquear Artículo</h3>
        <?php $form = ActiveForm::begin(); ?>
            <?= Html::submitButton('Desbloquear Artículo', [
                'class' => 'btn btn-success',
                'name' => 'accion',
                'value' => 'desbloquear',
            ]) ?>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>

</div>
