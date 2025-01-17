<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Comentario $comentario */

$this->title = 'Ver Comentario';
?>
<div class="comentario-ver">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><strong>ID:</strong> <?= Html::encode($comentario->id) ?></p>
    <p><strong>ID Tienda:</strong> <?= Html::encode($comentario->tienda_id) ?></p>
    <p><strong>ID Artículo:</strong> <?= Html::encode($comentario->articulo_id) ?></p>
    <p><strong>Valoración:</strong> <?= Html::encode($comentario->valoracion) ?></p>
    <p><strong>Texto:</strong></p>
    <p><?= Html::encode($comentario->texto) ?></p>
    <p><strong>ID Comentario Padre:</strong> <?= Html::encode($comentario->comentario_padre_id) ?></p>
    <p><strong>Cerrado:</strong> <?= $comentario->cerrado ? 'Sí' : 'No' ?></p>
    <p><strong>Denuncias:</strong> <?= Html::encode($comentario->denuncias) ?></p>
    <p><strong>Fecha Primera Denuncia:</strong> <?= Html::encode($comentario->fecha_primera_denuncia) ?></p>
    <p><strong>Motivo Denuncia:</strong> <?= Html::encode($comentario->motivo_denuncia) ?></p>
    <p><strong>Bloqueado:</strong> <?= $comentario->bloqueado ? 'Sí' : 'No' ?></p>
    <p><strong>Fecha Bloqueo:</strong> <?= Html::encode($comentario->fecha_bloqueo) ?></p>
    <p><strong>Motivo Bloqueo:</strong> <?= Html::encode($comentario->motivo_bloqueo) ?></p>
    <p><strong>ID Registro:</strong> <?= Html::encode($comentario->registro_id) ?></p>

    <p>
        <?= Html::a('Editar', ['editar-comentario-tienda', 'id' => $comentario->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['eliminar-comentario-tienda', 'id' => $comentario->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de eliminar este comentario?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
