<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Etiquetas $model */
/** @var app\models\Articulo[] $articulos */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Etiquetas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="etiquetas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
            'descripcion:ntext',
        ],
    ]) ?>

    <h3>Artículos asociados</h3>
    <?php if (!empty($articulos)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articulos as $articulo): ?>
                    <tr>
                        <td><?= Html::encode($articulo->nombre) ?></td>
                        <td>
                            <?= Html::a('Ver más', ['public-articulos/view', 'id' => $articulo->id], ['class' => 'btn btn-info btn-sm']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay artículos asociados a esta etiqueta.</p>
    <?php endif; ?>
</div>