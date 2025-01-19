<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Comentarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comentarios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'texto',
                'label' => 'Contenido',
                'value' => function ($model) {
                    return substr($model->texto, 0, 50) . '...';
                },
            ],
            'denuncias',
            [
                'attribute' => 'bloqueado',
                'label' => 'Estado',
                'value' => function ($model) {
                    return $model->bloqueado ? 'Bloqueado' : 'Activo';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {gestion-denuncias}',
                'buttons' => [
                    'gestion-denuncias' => function ($url, $model) {
                        return Html::a('Denuncias', ['gestion-denuncias', 'id' => $model->id], [
                            'class' => 'btn btn-warning btn-sm',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>