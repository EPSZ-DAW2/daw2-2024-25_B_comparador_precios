<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Aviso[] $avisos */

$this->title = 'Avisos Recibidos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="avisos-recibidos">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (empty($avisos)): ?>
        <p>No has recibido ningún aviso aún.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($avisos as $aviso): ?>
                <li class="list-group-item">
                    <strong>Clase:</strong> <?= Html::encode($aviso->clase) ?><br>
                    <strong>Texto:</strong> <?= Html::encode($aviso->texto) ?><br>
                    <strong>Fecha de Recepción:</strong> <?= Html::encode($aviso->fecha_lectura ?? 'No Leído') ?><br>
                    <strong>Remitente:</strong> <?= Html::encode($aviso->usuarioOrigen->nombre) ?><br>

                    <p>
                        <?= Html::a('Marcar como Leído', ['avisos/marcar-leido', 'id' => $aviso->id], [
                            'class' => 'btn btn-success',
                            'data-method' => 'post',
                        ]) ?>
                    </p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</div>
