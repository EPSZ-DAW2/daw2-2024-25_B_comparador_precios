<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Moderador $model */

$this->title = 'Detalle del Moderador: ' . $model->nombre;
?>
<div class="moderador-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?= Html::encode($model->id) ?></td>
        </tr>
        <tr>
            <th>Nombre</th>
            <td><?= Html::encode($model->nombre) ?></td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td><?= Html::encode($model->telefono) ?></td>
        </tr>
        <tr>
            <th>Región</th>
            <td><?= Html::encode($model->region->nombre ?? 'Sin región') ?></td>
        </tr>
        <tr>
            <th>Dirección</th>
            <td><?= Html::encode($model->direccion) ?></td>
        </tr>
        <tr>
            <th>Razón Social</th>
            <td><?= Html::encode($model->razon_social) ?></td>
        </tr>
        <tr>
            <th>NIF</th>
            <td><?= Html::encode($model->nif) ?></td>
        </tr>
        <tr>
            <th>Baja Solicitada</th>
            <td><?= $model->baja_solicitada ? 'Sí' : 'No' ?></td>
        </tr>
    </table>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Solicitar Baja', ['baja', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data-confirm' => '¿Estás seguro de que deseas solicitar tu baja?',
            'data-method' => 'post',
        ]) ?>
    </p>
</div>

