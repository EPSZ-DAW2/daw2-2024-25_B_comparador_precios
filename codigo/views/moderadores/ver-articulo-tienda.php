<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

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
        <?= Html::a(Yii::t('app', 'Actualizar'), ['editar-articulo-tienda', 'id' => $articuloTienda->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['eliminar-articulo-tienda', 'id' => $articuloTienda->id], [
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
            [
                'attribute' => 'visible',
                'value' => $articuloTienda->visible ? 'Sí' : 'No',
            ],
            [
                'attribute' => 'cerrado',
                'value' => $articuloTienda->cerrado ? 'Sí' : 'No',
            ],
            'denuncias',
            'fecha_primera_denuncia',
            'motivo_denuncia:ntext',
            [
                'attribute' => 'bloqueado',
                'value' => $articuloTienda->bloqueado ? 'Sí' : 'No',
            ],
            'fecha_bloqueo',
            'motivo_bloqueo:ntext',
            [
                'attribute' => 'cerrado_comentar',
                'value' => $articuloTienda->cerrado_comentar ? 'Sí' : 'No',
            ],
            'registro_id',
            'comentario_id',
        ],
    ]) ?>

    <!-- Lista de Comentarios -->
    <h2>Comentarios</h2>
    
    <p>
        <?= Html::a('Crear Comentario', ['crear-comentario-articulo', 'articuloId' => $articuloTienda->articulo->id], ['class' => 'btn btn-success']) ?>
    </p>

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
                'class' => \yii\grid\ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    $customActions = [
                        'view' => 'ver-comentario-articulo',
                        'update' => 'editar-comentario-articulo',
                        'delete' => 'eliminar-comentario-articulo',
                    ];
                    return Url::toRoute([$customActions[$action], 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]) ?>

</div>
