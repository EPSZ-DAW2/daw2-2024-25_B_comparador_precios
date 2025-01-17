<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Aviso $aviso */

$this->title = 'Aviso #' . $aviso->id; // Se usa 'id' porque no hay 'titulo'
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Avisos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="aviso-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['editar-aviso', 'id' => $aviso->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $aviso->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Estás seguro de que deseas eliminar este aviso?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $aviso,
        'attributes' => [
            'id',
            'clase',
            'texto:ntext',
            'usuario_origen_id',
            'usuario_destino_id',
            'tienda_id',
            'articulo_id',
            'comentario_id',
            'fecha_lectura',
            'fecha_aceptado',
        ],
    ]) ?>

</div>
