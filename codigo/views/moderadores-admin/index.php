<?php

use app\models\Moderador;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ModeradoresSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Moderadores');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moderador-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Moderador'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'usuario_id',
            'nif',
            'nombre',
            'direccion:ntext',
            'region_id',
            'telefono',
            'razon_social',
            'baja_solicitada:boolean',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Moderador $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>

