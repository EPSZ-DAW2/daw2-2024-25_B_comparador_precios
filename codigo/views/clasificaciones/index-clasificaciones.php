<?php

use app\models\Clasificaciones;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ClasificacionesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Clasificaciones');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clasificaciones-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'nombre',
            'descripcion',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{ver-tiendas}',
                'buttons' => [
                    'ver-tiendas' => function ($url, $model) {
						return Html::a(
                            'Ver Tiendas',
                            ['clasificaciones/view', 'id' => $model->id],
                            ['class' => 'btn btn-primary btn-sm']
						);
                    },
                ],
            ],
        ],
    ]); ?>

</div>