<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tienda $model */

$this->title = Yii::t('app', 'Create Tienda');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tiendas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tienda-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
