<?php

use app\models\Backup;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BackupSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Gestión de Backups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backup-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Backup', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Limpiar Backups', ['clean'], ['class' => 'btn btn-danger', 'data-confirm' => '¿Estás seguro de limpiar backups antiguos?']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nombre_archivo',
            'ruta_archivo',
            [
                'attribute' => 'fecha_creacion',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'tamaño',
                'value' => function ($model) {
                    return Yii::$app->formatter->asShortSize($model->tamaño);
                },
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{download} {delete}',
                'buttons' => [
                    'download' => function ($url, $model) {
                        return Html::a('Descargar', ['download', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('Eliminar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data-confirm' => '¿Estás seguro de eliminar este backup?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>