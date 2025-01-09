<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ArrayDataProvider $dataProvider */

$this->title = 'Mi Perfil de Moderador';
?>
<div class="moderador-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'telefono',
            [
                'attribute' => 'region_id',
                'value' => function ($model) {
                    return $model->region->nombre ?? 'Sin región';
                },
            ],
            [
                'attribute' => 'baja_solicitada',
                'value' => function ($model) {
                    return $model->baja_solicitada ? 'Sí' : 'No';
                },
            ],

            // Columnas de acción: Ver, Actualizar, Baja
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {baja}',
                'buttons' => [
                    'baja' => function ($url, $model, $key) {
                        return Html::a('Solicitar Baja', ['baja', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data-confirm' => '¿Estás seguro de que deseas solicitar tu baja?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
            ],
        ],
    ]); ?>
</div>

