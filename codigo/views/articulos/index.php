<?php

use app\models\Tienda;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TiendasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Tiendas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tienda-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tienda'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'lugar',
            'url:url',
            //'direccion:ntext',
            //'region_id',
            //'telefono',
            //'clasificacion_id',
            //'etiquetas_id',
            //'imagen_principal',
            //'suma_valoraciones',
            //'suma_votos',
            //'visible',
            //'cerrada',
            //'denuncias',
            //'fecha_primera_denuncia',
            //'motivo_denuncia:ntext',
            //'bloqueada',
            //'fecha_bloqueo',
            //'motivo_bloqueo:ntext',
            //'comentarios_id',
            //'cerrado_comentar',
            //'seguimiento_id',
            //'registro_id',
            //'articulo_tienda_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Tienda $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
