<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Articulo $articulo */
/** @var array $historico */

$this->title = 'Histórico de Precios: ' . Html::encode($articulo->nombre);
$this->params['breadcrumbs'][] = ['label' => 'Artículos', 'url' => ['public-index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="historico-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($historico)): ?>
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
                        <td><?= Html::encode(Yii::$app->formatter->asCurrency($registro['precio'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay registros de precios para este artículo.</p>
    <?php endif; ?>
</div>
