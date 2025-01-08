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

        <?php if (!empty($comentariosArticulo)): ?>
            <h2>Comentarios sobre Artículos</h2>
            <ul>
                <?php foreach ($comentariosArticulo as $comentario): ?>
                    <li>
                        <h4><strong>Artículo:</strong> <?= Html::encode($comentario->articulo->nombre) ?></h4>
                        <strong>Tienda:</strong> <?= Html::encode($comentario->tienda->nombre) ?><br>
                        <strong>Comentario:</strong> <?= Html::encode($comentario->texto) ?><br>
                        <br>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <?php endif; ?>
</div>
