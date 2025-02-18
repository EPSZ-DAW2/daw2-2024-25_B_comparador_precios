<?php

use app\models\Historico;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\HistoricoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Historicos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historico-index">

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a(Yii::t('app', 'Create Historico'), ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a(Yii::t('app', 'Limpieza Historicos'), ['limpieza-historicos'], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => '¿Estás seguro de que deseas eliminar todos los históricos?',
            'method' => 'post',
        ],
    ]) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'articulo_id',
        'tienda_id',
        'fecha',
        'precio',
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, Historico $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
             }
        ],
    ],
]); ?>

</div>

