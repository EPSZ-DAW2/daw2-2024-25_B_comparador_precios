<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Moderador $model */

$this->title = Yii::t('app', 'Create Moderador');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Moderadores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moderador-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
