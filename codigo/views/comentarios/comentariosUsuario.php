<?php

/** @var yii\web\View $this */
/** @var array $comentariosTienda */
/** @var array $comentariosArticulo */

use yii\helpers\Html;


$this->title = 'Comentarios del Usuario';
?>

<div class="comentarios-usuario">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (empty($comentariosTienda) && empty($comentariosArticulo)): ?>
        <p>No tienes comentarios registrados.</p>
    <?php else: ?>

        <?php if (!empty($comentariosTienda)): ?>
            <h2>Comentarios sobre Tiendas</h2>
            <ul>
                <?php foreach ($comentariosTienda as $comentario): ?>
                    <?php $comentario::findOne($comentario->tienda_id);  ?>
                    <li>
                        <strong>Nombre de la tienda:</strong> <?= Html::encode($comentario->tienda->nombre) ?><br>
                        <strong>Comentario:</strong> <?= Html::encode($comentario->texto) ?><br>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($comentariosArticulo)): ?>
            <h2>Comentarios sobre Artículos</h2>
            <ul>
                <?php foreach ($comentariosArticulo as $comentario): ?>
                    <li>
                        <strong>Nombre del artículo:</strong> <?= Html::encode($comentario->articulo->nombre) ?><br>
                        <strong>Comentario:</strong> <?= Html::encode($comentario->texto) ?><br>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <?php endif; ?>
</div>
