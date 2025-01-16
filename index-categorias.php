<?php

use app\models\Categorias;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CategoriasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Categorias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'nombre',
            'descripcion',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{ver-articulo}',
                'buttons' => [
                    'ver-articulo' => function ($url, $model) {
                        return Html::a(
                            'Ver Artículos',
                            ['categorias/view-categorias', 'id' => $model->id],
                            ['class' => 'btn btn-primary btn-sm']
                        );
                    },
                ],
            ],
        ],
    ]); ?>

</div>