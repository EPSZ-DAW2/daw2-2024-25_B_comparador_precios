<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Historico[] $historico */

$this->title = 'Histórico de Precios';
$this->params['breadcrumbs'][] = ['label' => 'Tiendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historico-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => $historico,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'tienda_id',
            'articulo_id',
            'precio',
            'fecha',
        ],
    ]) ?>