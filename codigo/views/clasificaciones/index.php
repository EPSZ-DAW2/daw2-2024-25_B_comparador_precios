<?php

use app\models\Clasificaciones;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ClasificacionesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Clasificaciones');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clasificaciones-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Clasificaciones'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'descripcion:ntext',
            'icono',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {tiendas}',
                'buttons' => [
                    'tiendas' => function ($url, $model) {
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

