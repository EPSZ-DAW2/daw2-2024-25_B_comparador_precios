<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Etiquetas $model */

$this->title = Yii::t('app', 'Create Etiquetas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Etiquetas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiquetas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
