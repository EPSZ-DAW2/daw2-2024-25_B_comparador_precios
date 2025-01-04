<?php
use yii\helpers\Html;

$this->title = $model->nombre;
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
        <th>Razón Social</th>
        <td><?= Html::encode($model->razon_social) ?></td>
    </tr>
</table>
