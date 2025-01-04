<?php
use yii\helpers\Html;

$this->title = 'Tiendas';
?>

<h1><?= Html::encode($this->title) ?></h1>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Región</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tiendas as $tienda): ?>
            <tr>
                <td><?= Html::encode($tienda->id) ?></td>
                <td><?= Html::encode($tienda->nombre) ?></td>
                <td><?= Html::encode($tienda->region->nombre) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
