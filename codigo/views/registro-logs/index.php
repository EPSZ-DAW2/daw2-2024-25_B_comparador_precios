<?php

use app\models\RegistroLogs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RegistroLogsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Registro de Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-logs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Nuevo Log'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Limpiar los Logs'), ['delete-all'], [
            'class' => 'btn btn-danger',
            'data-confirm' => '¿Está seguro de que desea eliminar todos los registros?',
            'data-method' => 'post',
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'fecha_log',
            'mensaje:ntext',
            'nivel',
            'usuario',
            'accion', // Campo acción agregado
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, RegistroLogs $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>
