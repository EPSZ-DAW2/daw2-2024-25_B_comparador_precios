<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Usuario; // Importamos la clase Usuario

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="usuario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>

        <?php if (Yii::$app->user->identity->rol === Usuario::ROL_SUPERADMINISTRADOR): ?>
            <?= Html::a(Yii::t('app', 'Trabajar en Nombre de este Usuario'), 
                ['usuarios/trabajar-en-nombre-de', 'usuario_id' => $model->id], 
                ['class' => 'btn btn-warning']) ?>
        <?php endif; ?>
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
            'direccion:ntext',
            'region_id',
            'telefono',
            'fecha_nacimiento',
            'fecha_registro',
            'registro_confirmado:boolean', // Si es booleano, lo formateamos así
            'fecha_acceso',
            'accesos_fallidos',
            'bloqueado:boolean', // También como booleano
            'fecha_bloqueo',
            'motivo_bloqueo:ntext',
        ],
    ]) ?>

</div>
