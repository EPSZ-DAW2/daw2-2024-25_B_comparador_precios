<?php

/** @var yii\web\View $this */
/** @var array $comentariosTienda */
/** @var array $comentariosArticulo */

use yii\helpers\Html;


$this->title = 'Tus comentarios';
?>

<div class="comentarios-usuario">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (empty($comentariosTienda) && empty($comentariosArticulo)): ?>
        <p>No tienes comentarios registrados.</p>
    <?php else: ?>

        <?php if (!empty($comentariosArticulo)): ?>
            <ul>
                <?php foreach ($comentariosArticulo as $comentario): ?>
                    <li>
                        <strong>Artículo:</strong> <?= Html::encode($comentario->articulo ? $comentario->articulo->nombre : 'Artículo no asociado') ?><br>
                        <strong>Tienda:</strong> <?=Html::encode($comentario->tienda ? $comentario->tienda->nombre : 'Tienda no asociada')  ?><br>
                        <strong>Comentario:</strong> <?= Html::encode($comentario->texto) ?><br>
                        <br>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <?php endif; ?>
</div>
