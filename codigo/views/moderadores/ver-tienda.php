<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Tienda $tienda */
/** @var yii\data\ActiveDataProvider $comentariosDataProvider */

$this->title = $tienda->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Revisar Tiendas', 'url' => ['revisar-tiendas']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moderador-tienda-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Detalles de la Tienda -->
    <?= DetailView::widget([
        'model' => $tienda,
        'attributes' => [
            'id',
            'nombre',
            'descripcion:ntext',
            'lugar',
            'url:url',
            'direccion:ntext',
            [
                'attribute' => 'region_id',
                'value' => $tienda->region->nombre ?? 'Sin región',
            ],
            'telefono',
            [
                'attribute' => 'clasificacion_id',
                'value' => $tienda->clasificacion->nombre ?? 'Sin clasificación',
            ],
            'imagen_principal',
            'suma_valoraciones',
            'suma_votos',
            [
                'attribute' => 'visible',
                'value' => $tienda->visible ? 'Sí' : 'No',
            ],
            [
                'attribute' => 'cerrada',
                'value' => $tienda->cerrada ? 'Sí' : 'No',
            ],
            'denuncias',
            'fecha_primera_denuncia',
            'motivo_denuncia:ntext',
            [
                'attribute' => 'bloqueada',
                'value' => $tienda->bloqueada ? 'Sí' : 'No',
            ],
            'fecha_bloqueo',
            'motivo_bloqueo:ntext',
            [
                'attribute' => 'cerrado_comentar',
                'value' => $tienda->cerrado_comentar ? 'Sí' : 'No',
            ],
            [
                'attribute' => 'propietario_usuario_id',
                'value' => $tienda->propietario->nombre ?? 'Desconocido',
            ],
        ],
    ]) ?>

    <!-- Lista de Artículos -->
    <h2>Artículos</h2>

    <p>
        <?= Html::a('Crear Artículo', ['crear-articulo-tienda', 'tiendaId' => $tienda->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $tienda->getArticulosTiendas()->with('articulo'),
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'nombre',
                'value' => function ($model) {
                    return $model->articulo->nombre ?? 'Sin nombre';
                },
            ],
            'precio_actual',
            [
                'attribute' => 'visible',
                'value' => function ($model) {
                    return $model->visible ? 'Sí' : 'No';
                },
            ],
            [
                'class' => \yii\grid\ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    $customActions = [
                        'view' => 'ver-articulo-tienda',
                        'update' => 'editar-articulo-tienda',
                        'delete' => 'eliminar-articulo-tienda',
                    ];
                    return Url::toRoute([$customActions[$action], 'id' => $model->articulo_id]);
                },
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]) ?>

    <!-- Lista de Comentarios -->
    <h2>Comentarios</h2>

    <p>
        <?= Html::a('Crear Comentario', ['crear-comentario-tienda', 'tiendaId' => $tienda->id], ['class' => 'btn btn-success']) ?>
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
                        'view' => 'ver-comentario-tienda',
                        'update' => 'editar-comentario-tienda',
                        'delete' => 'eliminar-comentario-tienda',
                    ];
                    return Url::toRoute([$customActions[$action], 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]) ?>

</div>
