<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var array $articulos */
/** @var array $historico */
/** @var int|null $selectedArticulo */
/** @var int $tiendaId */ // Ahora recibimos esta variable correctamente

$this->title = Yii::t('app', 'Ver Histórico de Precios');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tiendas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historico-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($selectedArticulo !== null): ?>
        <h2>Histórico de Precios para el Artículo Seleccionado</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historico as $registro): ?>
                    <tr>
                        <td><?= Html::encode($registro['fecha']) ?></td>
                        <td><?= Html::encode($registro['precio']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>
