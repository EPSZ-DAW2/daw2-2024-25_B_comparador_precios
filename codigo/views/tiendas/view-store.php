<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var app\models\Tienda $model */

// Obtener el ID de la tienda desde la URL
if (isset($_GET['id'])) {
    $tiendaId = $_GET['id'];
} else {
    // Manejar el caso donde no se proporciona el ID de la tienda
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
            // Deshabilitar las opciones de edición
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}', // Solo permitir la vista
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{ver-historico}',
                'buttons' => [
                    'ver-historico' => function ($url, $model, $key) use ($tiendaId) {
                        return Html::a('Ver Histórico', ['ver-historico', 'Tienda_id' => $tiendaId, 'Articulo_id' => $model->id], [
                            'title' => 'Ver Histórico de Precios',
                            'class' => 'btn btn-primary',
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>

</div>

<?php
$dataProviderComentarios = new ActiveDataProvider([
    'query' => \app\models\Comentario::find()->where(['tienda_id' => $tiendaId, 'articulo_id' => null]),
    'pagination' => [
        'pageSize' => 10,
    ],
]);

$comentario = new \app\models\Comentario();
if ($comentario->load(Yii::$app->request->post()) && $comentario->save()) {
    Yii::$app->session->setFlash('success', 'Comentario añadido correctamente.');
    return $this->refresh();
}

?>
