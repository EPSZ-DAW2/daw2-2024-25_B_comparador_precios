<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\base\DynamicModel;

/** @var yii\web\View $this */
/** @var app\models\Tienda $model */

// Obtener el ID de la tienda desde la URL
if (isset($_GET['id'])) {
    $tiendaId = $_GET['id'];
} else {
    die('ID de tienda no proporcionado');
}

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Tiendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
            'region_id',
            'telefono',
            'clasificacion_id',
            'etiquetas_id',
            'imagen_principal',
            'suma_valoraciones',
            'suma_votos',
            'visible:boolean',
            'cerrada:boolean',
            'denuncias',
            'fecha_primera_denuncia',
            'motivo_denuncia:ntext',
            'bloqueada:boolean',
            'fecha_bloqueo',
            'motivo_bloqueo:ntext',
            'comentarios_id',
            'cerrado_comentar:boolean',
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
            'value' => function ($data) {
                return $data->articulo->nombre ?? 'Sin nombre'; // Accede al nombre del artículo
            },
        ],
        [
            'attribute' => 'descripcion',
            'value' => function ($data) {
                return $data->articulo->descripcion ?? 'Sin descripción'; // Accede a la descripción del artículo
            },
        ],
        'precio_actual',
        'historico_id',
        'oferta_id',
        'suma_valoraciones',
        'suma_votos',
        'visible:boolean',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view-articulo}', // Permite solo la vista
            
            'buttons' => [
                'view-articulo' => function ($url, $model) {
                    return Html::a(
                        'Ver Artículo',
                        [
                            'tiendas/view-articulo', // Acción viewArticulo
                            'id' => $model->articulo_id, // Pasar el ID del artículo
                        ],
                        [
                            'class' => 'btn btn-primary',
                            'title' => 'Ver Artículo',
                        ]
                    );
                },
            ],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{ver-historico}',
            'buttons' => [
                'ver-historico' => function ($url, $model, $key) use ($tiendaId) {
                    return Html::a(
                        'Ver Histórico',
                        [
                            'ver-historico',
                            'Tienda_id' => $tiendaId, // Pasar el ID de la tienda
                            'Articulo_id' => $model->articulo_id, // Pasar el ID del artículo correspondiente
                        ],
                        [
                            'title' => 'Ver Histórico de Precios',
                            'class' => 'btn btn-primary',
                        ]
                    );
                },
            ],
        ],
    ],
]) ?>
