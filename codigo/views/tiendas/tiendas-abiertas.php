<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Tienda[] */ 

$this->title = 'Tiendas Abiertas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tiendas-abiertas">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="list-group">
        <?php foreach ($tiendas as $tienda): ?>
            <div class="list-group-item">
                <h4 class="list-group-item-heading"><?= Html::encode($tienda->nombre) ?></h4>
                <p class="list-group-item-text"><?= Html::encode($tienda->descripcion) ?></p>
                <?= Html::a('Ver Tienda', Url::to(['tienda/view', 'id' => $tienda->id]), ['class' => 'btn btn-primary']) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>