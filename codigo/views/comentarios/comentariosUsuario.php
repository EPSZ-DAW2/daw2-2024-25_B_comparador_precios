<?php

/** @var yii\web\View $this */
/** @var array $comentariosGenerales */

use yii\helpers\Html;

$this->title = 'Tus comentarios';
?>

<div class="seguimientos-comentarios-container">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (empty($comentarios)): ?>
        <p>No tienes comentarios registrados.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($comentarios as $comentario): ?>
                <li>
                    <strong>Artículo:</strong> <?= Html::encode($comentario->articulo ? $comentario->articulo->nombre : 'Artículo no asociado') ?><br>
                    <strong>Tienda:</strong> <?= Html::encode($comentario->tienda ? $comentario->tienda->nombre : 'Tienda no asociada') ?><br>
                    <?php if($comentario->articulo) $enlace = 'public-articulos/view'; else $enlace = 'tiendas/view'; ?>
                    <strong>Comentario:</strong> <?= Html::a(Html::encode($comentario->texto), [$enlace, 'id' => ($comentario->articulo ? $comentario->articulo->id : ($comentario->tienda ? $comentario->tienda->id : '#'))]) ?>
                    <br><br>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>