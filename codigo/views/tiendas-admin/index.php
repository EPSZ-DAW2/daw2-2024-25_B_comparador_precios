<?php

use app\models\Tienda;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TiendaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Tiendas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tienda-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tienda'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'filter' => Html::activeTextInput($searchModel, 'id', ['class' => 'form-control']), 
            ],
            [
                'attribute' => 'nombre',
                'filter' => Html::activeTextInput($searchModel, 'nombre', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'descripcion',
                'format' => 'ntext',
                'filter' => Html::activeTextInput($searchModel, 'descripcion', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'lugar',
                'filter' => Html::activeTextInput($searchModel, 'lugar', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'url',
                'filter' => Html::activeTextInput($searchModel, 'url', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'direccion',
                'format' => 'ntext',
                'filter' => Html::activeTextInput($searchModel, 'direccion', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'region_id',
                'filter' => Html::activeTextInput($searchModel, 'region_id', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'clasificacion_id',
                'filter' => Html::activeTextInput($searchModel, 'clasificacion_id', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'visible',
                'filter' => Html::activeTextInput($searchModel, 'visible', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'cerrada',
                'filter' => Html::activeTextInput($searchModel, 'cerrada', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'suma_valoraciones',
                'filter' => Html::activeTextInput($searchModel, 'suma_valoraciones', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'suma_votos',
                'filter' => Html::activeTextInput($searchModel, 'suma_votos', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'denuncias',
                'label' => 'Denuncias',
                'value' => function ($model) {
                    return $model->denuncias ?: 0;
                },
                'filter' => Html::activeTextInput($searchModel, 'denuncias', ['class' => 'form-control']),
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete} {denuncias}',
                'buttons' => [
                    'denuncias' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa fa-warning"></i> Denuncias',
                            ['tiendas-admin/gestion-denuncias', 'id' => $model->id],
                            ['class' => 'btn btn-warning btn-sm', 'title' => 'Gestionar denuncias']
                        );
                    },
                ],
            ],
        ],
    ]); ?>

</div>
