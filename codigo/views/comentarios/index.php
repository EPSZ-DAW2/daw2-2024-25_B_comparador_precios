<?php

use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ComentariosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Comentarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comentarios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a(Yii::t('app', 'Create Comentario'), ['create'], ['class' => 'btn btn-success']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // Columna para ID con placeholder personalizado
            [
                'attribute' => 'id',
                'label' => 'ID',
                'value' => 'id',
                'filter' => Html::activeTextInput($searchModel, 'id', [
                    'class' => 'form-control',
                    'placeholder' => 'Buscar por ID...', // Placeholder aquí
                ]),
            ],

            // Columna para Contenido con placeholder
            [
                'attribute' => 'texto',
                'label' => 'Contenido',
                'value' => function ($model) {
                    return substr($model->texto, 0, 50) . '...';
                },
                'filter' => Html::activeTextInput($searchModel, 'contenido', [
                    'class' => 'form-control',
                    'placeholder' => 'Buscar contenido...',
                ]),
            ],

            'denuncias',
            [
                'attribute' => 'bloqueado',
                'label' => 'Estado',
                'value' => function ($model) {
                    return $model->bloqueado ? 'Bloqueado' : 'Activo';
                },
                'filter' => [0 => 'Activo', 1 => 'Bloqueado'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {gestion-denuncias}',
                'buttons' => [
                    'gestion-denuncias' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa fa-warning"></i> Denuncias',
                            ['comentarios/gestion-denuncias', 'id' => $model->id],
                            ['class' => 'btn btn-warning btn-sm']
                        );
                    },
                ],
            ],
        ],
    ]); ?>

</div>