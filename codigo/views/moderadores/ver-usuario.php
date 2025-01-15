<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = Yii::t('app', 'Usuario: {name}', ['name' => $model->nick]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuarios de mi Región'), 'url' => ['revisar-usuarios']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['editar-usuario', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['eliminar-usuario', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Estás seguro de que deseas eliminar este usuario?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'email:email',
            'password',
            'nick',
            'nombre',
            'apellidos',
            'direccion',
            'region_id',
            'telefono',
            'fecha_nacimiento:date',
            'fecha_registro:datetime',
            'registro_confirmado:boolean',
            'fecha_acceso:datetime',
            'accesos_fallidos',
            'bloqueado:boolean',
            'fecha_bloqueo:datetime',
            'motivo_bloqueo:ntext',
        ],
    ]) ?>

    <!-- Botón Crear Aviso -->
    <div style="margin-bottom: 20px;">
        <?= Html::a(Yii::t('app', 'Crear Aviso'), ['crear-aviso', 'usuarioDestinoNick' => $model->nick], ['class' => 'btn btn-success']) ?>
    </div>

    <!-- Título de Avisos -->
    <h2>Avisos</h2>

    <!-- Lista de Avisos -->
    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => \app\models\Aviso::find()->where(['usuario_destino_id' => $model->id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'clase',
            [
                'attribute' => 'texto',
                'format' => 'ntext',
            ],
            [
                'attribute' => 'usuario_origen_id',
                'label' => 'Usuario Origen',
                'value' => function ($model) {
                    return \app\models\Usuario::findOne($model->usuario_origen_id)->nick ?? 'Desconocido';
                },
            ],
            'fecha_lectura:datetime',
            'fecha_aceptado:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Ver', ['ver-aviso', 'id' => $model->id], ['class' => 'btn btn-info btn-sm']);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('Editar', ['editar-aviso', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('Eliminar', ['eliminar-aviso', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => '¿Estás seguro de eliminar este aviso?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>

</div>

