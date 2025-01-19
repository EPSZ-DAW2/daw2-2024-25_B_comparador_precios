<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Revisar Tiendas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moderador-revisar-tiendas">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Tienda', ['crear-tienda'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'direccion',
            'telefono',
            [
                'attribute' => 'region_id',
                'label' => 'Región',
                'value' => function ($model) {
                    return $model->region->nombre ?? '(Sin región)';
                },
            ],

            [
                'class' => \yii\grid\ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    $customActions = [
                        'view' => 'moderadores/ver-tienda',
                        'update' => 'moderadores/editar-tienda',
                        'delete' => 'moderadores/eliminar-tienda',
                    ];
                    return Url::toRoute([$customActions[$action], 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete}', // Botones a mostrar
            ],
        ],
    ]); ?>

</div>
