<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ofertas $model */

$this->title = Yii::t('app', 'Create Ofertas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ofertas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ofertas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
