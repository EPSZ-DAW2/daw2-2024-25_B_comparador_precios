<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var app\models\ArticulosTienda $articuloTienda */
/** @var yii\data\ActiveDataProvider $comentariosDataProvider */

$this->title = $articuloTienda->articulo ? $articuloTienda->articulo->nombre : 'Artículo sin nombre';
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Tienda'),
    'url' => ['ver-tienda', 'id' => $articuloTienda->tienda_id],
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="articulo-tienda-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $articuloTienda->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $articuloTienda->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Estás seguro de que deseas eliminar este registro?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <h2>Detalles del Artículo</h2>
    <?= DetailView::widget([
        'model' => $articuloTienda->articulo,
        'attributes' => [
            'id',
            'nombre',
            'descripcion:ntext',
        ],
    ]) ?>

    <h2>Detalles del Artículo en la Tienda</h2>
    <?= DetailView::widget([
        'model' => $articuloTienda,
        'attributes' => [
            'id',
            'articulo_id',
            'tienda_id',
            'precio_actual',
            'historico_id',
            'oferta_id',
            'suma_valoraciones',
            'suma_votos',
            'visible:boolean',
            'cerrado:boolean',
            'denuncias',
            'fecha_primera_denuncia',
            'motivo_denuncia:ntext',
            'bloqueado:boolean',
            'fecha_bloqueo',
            'motivo_bloqueo:ntext',
            'cerrado_comentar:boolean',
            'registro_id',
            'comentario_id',
        ],
    ]) ?>

    <!-- Lista de Comentarios -->
    <p>
        <?= Html::a('Crear Comentario', ['crear-comentario-articulo', 'articuloId' => $articuloTienda->articulo->id], ['class' => 'btn btn-success']) ?>
    </p>

    <h2>Comentarios</h2>
    <?= GridView::widget([
        'dataProvider' => $comentariosDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'valoracion',
            [
                'attribute' => 'texto',
                'format' => 'ntext',
            ],
            [
                'attribute' => 'registro_id',
                'label' => 'Usuario',
                'value' => function ($model) {
                    return $model->usuario->nombre ?? 'Anónimo';
                },
            ],
            [
                'attribute' => 'bloqueado',
                'value' => function ($model) {
                    return $model->bloqueado ? 'Sí' : 'No';
                },
            ],
            [
                'attribute' => 'fecha_bloqueo',
                'format' => ['date', 'php:Y-m-d'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Ver', ['ver-comentario-articulo', 'id' => $model->id], ['class' => 'btn btn-info btn-sm']);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('Editar', ['editar-comentario-articulo', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('Eliminar', ['eliminar-comentario-articulo', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => '¿Estás seguro de eliminar este comentario?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>

</div>
