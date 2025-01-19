<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Aviso[] $avisos */

$this->title = 'Avisos Enviados';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="avisos-enviados">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (empty($avisos)): ?>
        <p>No has enviado ningún aviso aún.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($avisos as $aviso): ?>
                <li class="list-group-item">
                    <strong>Clase:</strong> <?= Html::encode($aviso->clase) ?><br>
                    <strong>Texto:</strong> <?= Html::encode($aviso->texto) ?><br>
                    <strong>Fecha de Envío:</strong> <?= Html::encode($aviso->fecha_aceptado ?? 'No Aceptado') ?><br>
                    <strong>Destinatario:</strong> <?= Html::encode($aviso->usuarioDestino->nombre) ?><br>

                    <p>
					<?= Html::a('Marcar como Aceptado', ['avisos/marcar-aceptado', 'id' => $aviso->id], [
						'class' => 'btn btn-primary', // Estilo para el botón
						'data-method' => 'post', // Usar el método POST
					]) ?>

                    </p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
