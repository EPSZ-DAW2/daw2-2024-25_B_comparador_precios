<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Moderador $moderador */
/** @var app\models\Region[] $regiones */

$this->title = 'Regiones Asignadas: ' . $moderador->nombre;
?>

<h1><?= Html::encode($this->title) ?></h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($regiones as $region): ?>
            <tr>
                <td><?= Html::encode($region->id) ?></td>
                <td><?= Html::encode($region->nombre) ?></td>
                <td>
                    <!-- Enlace para gestionar tiendas -->
                    <?= Html::a('Tiendas', ['tiendas', 'region_id' => $region->id], ['class' => 'btn btn-primary']) ?>
                    <!-- Enlace para gestionar artículos -->
                    <?= Html::a('Artículos', ['articulos', 'region_id' => $region->id], ['class' => 'btn btn-info']) ?>
                    <!-- Enlace para gestionar usuarios -->
                    <?= Html::a('Usuarios', ['usuarios', 'region_id' => $region->id], ['class' => 'btn btn-warning']) ?>
                    <!-- Enlace para gestionar comentarios -->
                    <?= Html::a('Comentarios', ['comentarios', 'region_id' => $region->id], ['class' => 'btn btn-success']) ?>
                    <!-- Enlace para gestionar incidencias -->
                    <?= Html::a('Incidencias', ['incidencias', 'region_id' => $region->id], ['class' => 'btn btn-danger']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>
