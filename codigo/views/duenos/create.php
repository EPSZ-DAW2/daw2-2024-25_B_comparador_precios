<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Dueno $model */

$this->title = Yii::t('app', 'Create Dueno');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Duenos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dueno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
