<?php

/** @var yii\web\View $this */
/** @var array $comentariosTienda */
/** @var array $comentariosArticulo */

use yii\helpers\Html;


$this->title = 'Comentarios del Usuario';
?>

<div class="comentarios-usuario">
    <h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

    <?php if (empty($comentariosTienda) && empty($comentariosArticulo)): ?>
        <p>No tienes comentarios registrados.</p>
    <?php else: ?>

        <?php if (!empty($comentariosTienda)): ?>
            <h2>Comentarios sobre Tiendas</h2>
            <ul>
                <?php foreach ($comentariosTienda as $tienda): ?>
                    <li>
                        <strong>Nombre de la tienda:</strong> <?= \yii\helpers\Html::encode($tienda->nombre) ?><br>
                        <strong>Comentario:</strong> <?= \yii\helpers\Html::encode($tienda->comentario) ?><br>
                        <strong>Fecha:</strong> <?= Yii::$app->formatter->asDate($tienda->fecha, 'long') ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($comentariosArticulo)): ?>
            <h2>Comentarios sobre Artículos</h2>
            <ul>
                <?php foreach ($comentariosArticulo as $articulo): ?>
                    <li>
                        <strong>Nombre del artículo:</strong> <?= \yii\helpers\Html::encode($articulo->nombre) ?><br>
                        <strong>Comentario:</strong> <?= \yii\helpers\Html::encode($articulo->comentario) ?><br>
                        <strong>Fecha:</strong> <?= Yii::$app->formatter->asDate($articulo->fecha, 'long') ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <?php endif; ?>
</div>