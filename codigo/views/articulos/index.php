<?php

use app\models\Articulo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ArticulosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Articulos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articulo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Articulo'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nombre',
            'descripcion:ntext',
            [
                'attribute' => 'denuncias',
                'label' => 'Denuncias',
                'value' => function ($model) {
                    // Mostrar el número de denuncias del artículo desde la relación `articuloTienda`
                    return $model->articuloTienda->denuncias ?? 0;
                },
            ],
			[
				'class' => ActionColumn::className(),
				'template' => '{view} {update} {delete} {denuncias}', // Asegúrate de incluir {denuncias} en el template
				'buttons' => [
					'denuncias' => function ($url, $model) {
						// Mostrar el botón Gestionar Denuncias para todos los artículos
						return Html::a(
							'<i class="fa fa-warning"></i> Gestionar denuncias',
							['articulos/gestion-denuncias', 'id' => $model->id],
							['class' => 'btn btn-warning btn-sm']
						);
					},
				],
			],

        ],
    ]); ?>

</div>
