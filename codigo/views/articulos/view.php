<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Tienda $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tiendas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tienda-view">

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
    </p>

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
            'visible',
            'cerrada',
            'denuncias',
            'fecha_primera_denuncia',
            'motivo_denuncia:ntext',
            'bloqueada',
            'fecha_bloqueo',
            'motivo_bloqueo:ntext',
            'comentarios_id',
            'cerrado_comentar',
            'seguimiento_id',
            'registro_id',
            'articulo_tienda_id',
        ],
    ]) ?>

</div>
