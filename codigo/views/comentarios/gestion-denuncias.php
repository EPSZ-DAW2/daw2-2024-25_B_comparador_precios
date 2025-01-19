<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Comentario $model */

$this->title = 'Gestión de Denuncias para Comentario: ' . Html::encode($model->id);
$this->params['breadcrumbs'][] = ['label' => 'Comentarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comentarios-gestion-denuncias">

    <h1><?= Html::encode($this->title) ?></h1>

    <h3>Detalles del Comentario</h3>
    <p><strong>ID:</strong> <?= $model->id ?></p>
    <p><strong>Contenido:</strong></p>
    <pre><?= Html::encode($model->texto) ?></pre>
    <p><strong>Denuncias:</strong> <?= $model->denuncias ?></p>
    <p><strong>Motivos de Denuncia:</strong></p>
    <pre><?= Html::encode($model->motivo_denuncia) ?: 'Sin denuncias registradas.' ?></pre>
    <p><strong>Estado:</strong> <?= $model->bloqueado ? 'Bloqueado' : 'Activo' ?></p>

    <?php if ($model->bloqueado): ?>
        <p><strong>Motivo de Bloqueo:</strong> <?= Html::encode($model->motivo_bloqueo) ?></p>
        <p><strong>Fecha de Bloqueo:</strong> <?= Html::encode($model->fecha_bloqueo) ?></p>
    <?php endif; ?>

    <?php if (!$model->bloqueado): ?>
        <h3>Bloquear Comentario</h3>
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'motivo_bloqueo')->textarea([
                'rows' => 3,
                'name' => 'motivo_bloqueo',
            ])->label('Motivo del Bloqueo') ?>
            <?= Html::submitButton('Bloquear', [
                'class' => 'btn btn-danger',
                'name' => 'accion',
                'value' => 'bloquear',
            ]) ?>
        <?php ActiveForm::end(); ?>
    <?php else: ?>
        <h3>Desbloquear Comentario</h3>
        <?php $form = ActiveForm::begin(); ?>
            <?= Html::submitButton('Desbloquear', [
                'class' => 'btn btn-success',
                'name' => 'accion',
                'value' => 'desbloquear',
            ]) ?>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>

</div>