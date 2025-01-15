<?php
use yii\helpers\Html;

$this->title = 'Mi Perfil de Moderador';
?>

<h1><?= Html::encode($this->title) ?></h1>

<table class="table">
    <tr>
        <th>ID</th>
        <td><?= Html::encode($model->id) ?></td>
    </tr>
    <tr>
        <th>Nombre</th>
        <td><?= Html::encode($model->nombre) ?></td>
    </tr>
    <tr>
        <th>Región</th>
        <td><?= Html::encode($model->region->nombre ?? 'Sin región') ?></td>
    </tr>
    <tr>
        <th>Teléfono</th>
        <td><?= Html::encode($model->telefono) ?></td>
    </tr>
    <tr>
        <th>Baja Solicitada</th>
        <td><?= $model->baja_solicitada ? 'Sí' : 'No' ?></td>
    </tr>
</table>

<p>
    <?= Html::a('Actualizar Perfil', ['actualizar'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Solicitar Baja', ['solicitar-baja'], [
        'class' => 'btn btn-danger',
        'data-confirm' => '¿Estás seguro de que deseas solicitar la baja?',
    ]) ?>
</p>
