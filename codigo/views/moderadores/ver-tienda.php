<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var app\models\Tienda $tienda */
/** @var yii\data\ActiveDataProvider $comentariosDataProvider */

$this->title = $tienda->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Revisar Tiendas', 'url' => ['revisar-tiendas']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tienda-view">

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
                'label' => 'Región ID',
                'value' => $tienda->region_id ?? 'Sin región',
            ],
            'telefono',
            'clasificacion_id',
            'etiquetas_id',
            'imagen_principal',
            'suma_valoraciones',
            'suma_votos',
            [
                'attribute' => 'visible',
                'value' => $tienda->visible ? 'Yes' : 'No',
            ],
            [
                'attribute' => 'cerrada',
                'value' => $tienda->cerrada ? 'Yes' : 'No',
            ],
            'denuncias',
            'fecha_primera_denuncia',
            'motivo_denuncia:ntext',
            [
                'attribute' => 'bloqueada',
                'value' => $tienda->bloqueada ? 'Yes' : 'No',
            ],
            'fecha_bloqueo',
            'motivo_bloqueo:ntext',
            [
                'attribute' => 'cerrado_comentar',
                'value' => $tienda->cerrado_comentar ? 'Yes' : 'No',
            ],
            'propietario_usuario_id',
            'seguimiento_id',
            'registro_id',
            'articulo_tienda_id',
        ],
    ]) ?>

    <!-- Lista de Artículos -->
    <h2>Artículos</h2>
    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $tienda->getArticulosTiendas()->with('articulo'),
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'nombre',
                'value' => function ($rowModel) {
                    return $rowModel->articulo->nombre ?? 'Sin nombre';
                },
            ],
            [
                'attribute' => 'descripcion',
                'value' => function ($rowModel) {
                    return $rowModel->articulo->descripcion ?? 'Sin descripción';
                },
            ],
            'precio_actual',
            'historico_id',
            'oferta_id',
            'suma_valoraciones',
            'suma_votos',
            [
                'attribute' => 'visible',
                'value' => function ($rowModel) {
                    return $rowModel->visible ? 'Yes' : 'No';
                },
            ],
        ],
    ]) ?>

    <!-- Lista de Comentarios -->
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
                'value' => function ($model) {
                    return $model->texto ?? 'Sin texto';
                },
            ],
            [
                'attribute' => 'registro_id',
                'label' => 'Usuario',
                'value' => function ($model) {
                    return $model->usuario->nombre ?? 'Anónimo';
                },
            ],
            'fecha_primera_denuncia',
            'motivo_denuncia:ntext',
            [
                'attribute' => 'bloqueado',
                'value' => function ($model) {
                    return $model->bloqueado ? 'Yes' : 'No';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}', // Opcional si necesitas acciones
            ],
        ],
    ]) ?>

</div>
