<?php
use yii\helpers\Html;

$this->title = 'Moderadores';
?>

<h1><?= Html::encode($this->title) ?></h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Región</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($moderadores as $moderador): ?>
            <tr>
                <td><?= Html::encode($moderador->id) ?></td>
                <td><?= Html::encode($moderador->nombre) ?></td>
                <td><?= Html::encode($moderador->region->nombre ?? 'Sin región') ?></td>
                <td>
                    <?= Html::a('Ver', ['view', 'id' => $moderador->id], ['class' => 'btn btn-primary']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>

    <?= Html::a('Solicitar Baja', ['baja', 'id' => $moderador->id], ['class' => 'btn btn-warning']) ?>
    <?= Html::a('Actualizar', ['update', 'id' => $moderador->id], ['class' => 'btn btn-success']) ?>


</table>
