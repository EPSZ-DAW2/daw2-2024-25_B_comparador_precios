<?php

use yii\helpers\Html;

$this->title = 'Gestión de Backups';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= Html::a('Crear Backup', ['create'], ['class' => 'btn btn-success']) ?>
<?= Html::a('Limpiar Backups', ['clean'], ['class' => 'btn btn-danger', 'data-confirm' => '¿Estás seguro de limpiar backups antiguos?']) ?>

<h2>Backups Disponibles</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre del Archivo</th>
            <th>Fecha de Creación</th>
            <th>Tamaño</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($backups as $backup): ?>
            <tr>
                <td><?= $backup->id ?></td>
                <td><?= Html::encode($backup->nombre_archivo) ?></td>
                <td><?= $backup->fecha_creacion ?></td>
                <td><?= Yii::$app->formatter->asShortSize($backup->tamaño) ?></td>
                <td>
                    <?= Html::a('Descargar', ['download', 'id' => $backup->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Eliminar', ['delete', 'id' => $backup->id], [
                        'class' => 'btn btn-danger',
                        'data-confirm' => '¿Estás seguro de eliminar este backup?',
                        'data-method' => 'post',
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
