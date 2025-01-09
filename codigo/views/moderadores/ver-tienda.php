<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var app\models\Tienda $model */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Revisar Tiendas', 'url' => ['revisar-tiendas']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tienda-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
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
                'value' => $model->region_id ?? 'Sin región',
            ],
            'telefono',
            'clasificacion_id',
            'etiquetas_id',
            'imagen_principal',
            'suma_valoraciones',
            'suma_votos',
            [
                'attribute' => 'visible',
                'value' => $model->visible ? 'Yes' : 'No',
            ],
            [
                'attribute' => 'cerrada',
                'value' => $model->cerrada ? 'Yes' : 'No',
            ],
            'denuncias',
            'fecha_primera_denuncia',
            'motivo_denuncia:ntext',
            [
                'attribute' => 'bloqueada',
                'value' => $model->bloqueada ? 'Yes' : 'No',
            ],
            'fecha_bloqueo',
            'motivo_bloqueo:ntext',
            'comentarios_id',
            [
                'attribute' => 'cerrado_comentar',
                'value' => $model->cerrado_comentar ? 'Yes' : 'No',
            ],
            'propietario_usuario_id',
            'seguimiento_id',
            'registro_id',
            'articulo_tienda_id',
        ],
    ]) ?>

    <h2>Artículos</h2>
    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getArticulosTiendas()->with('articulo'),
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
</div>
