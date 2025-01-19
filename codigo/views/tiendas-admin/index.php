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
            'id',
            'nombre',
            'descripcion:ntext',
            'lugar',
            'url',
            'direccion:ntext',
            'region_id',
            'clasificacion_id',
            'visible:boolean',
            'cerrada:boolean',
            'suma_valoraciones',
            'suma_votos',
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view} {update} {delete} {denuncias}',
				'buttons' => [
					'denuncias' => function ($url, $model) {
						return Html::a(
							'<i class="fa fa-warning"></i> Gestionar Denuncias',
							['tiendas-admin/gestion-denuncias', 'id' => $model->id],
							['class' => 'btn btn-warning btn-sm']
						);
					},
				],
			],
        ],
    ]); ?>

</div>
