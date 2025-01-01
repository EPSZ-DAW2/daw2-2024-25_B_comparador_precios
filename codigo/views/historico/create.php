<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Historico $model */

$this->title = Yii::t('app', 'Create Historico');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Historicos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historico-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
