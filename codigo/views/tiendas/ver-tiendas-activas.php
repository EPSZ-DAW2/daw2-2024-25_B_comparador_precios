<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**  @var yii\web\View $this */
/**  @var app\models\Tienda[] $tiendas */

$this->title = 'Tiendas Activas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tiendas-activas">
    <h1><?= Html::encode($this->title) ?></h1>
    <ul>
        <?php foreach ($tiendas as $tienda): ?>
            <li>
                <?= Html::encode($tienda->nombre) ?>
                <?= Html::a('Ver Tienda', ['view-store', 'id' => $tienda->id], ['class' => 'btn btn-primary']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>