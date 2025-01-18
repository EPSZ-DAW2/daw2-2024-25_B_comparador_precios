<?php

use app\models\Etiquetas;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\EtiquetasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Etiquetas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiquetas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'nombre',
            'descripcion',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{ver-tiendas} {ver-articulo}',
                'buttons' => [
                    'ver-tiendas' => function ($url, $model) {
                        return Html::a(
                            'Ver Tiendas',
                            ['tiendas/view', 'id' => $model->id],
                            ['class' => 'btn btn-success btn-sm']
                        );
                    },
                    'ver-articulo' => function ($url, $model) {
                        return Html::a(
                            'Ver Artículos',
                            ['etiquetas/view-etiquetas', 'id' => $model->id],
                            ['class' => 'btn btn-primary btn-sm']
                        );
                    },
                ],
            ],
        ],
    ]); ?>

</div>