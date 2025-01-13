<?php
use yii\grid\GridView;
use yii\helpers\Html;

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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{ver-tienda} {editar-tienda} {eliminar-tienda}', // Añadido eliminar-tienda
                'buttons' => [
                    'ver-tienda' => function ($url, $model, $key) {
                        return Html::a(
                            'Ver',
                            ['moderadores/ver-tienda', 'id' => $model->id], // Redirige a la acción verTienda
                            ['class' => 'btn btn-primary btn-sm']
                        );
                    },
                    'editar-tienda' => function ($url, $model, $key) {
                        return Html::a(
                            'Editar',
                            ['moderadores/editar-tienda', 'id' => $model->id], // Redirige a la acción editarTienda
                            ['class' => 'btn btn-warning btn-sm']
                        );
                    },
                    'eliminar-tienda' => function ($url, $model, $key) {
                        return Html::a(
                            'Eliminar',
                            ['moderadores/eliminar-tienda', 'id' => $model->id], // Redirige a la acción eliminarTienda
                            [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => '¿Estás seguro de que deseas eliminar esta tienda?',
                                    'method' => 'post', // Asegura que se utilice el método POST
                                ],
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

</div>
