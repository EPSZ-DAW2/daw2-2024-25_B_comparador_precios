<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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

</div>

