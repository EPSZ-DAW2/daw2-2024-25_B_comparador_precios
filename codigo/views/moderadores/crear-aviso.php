<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Aviso $aviso */

$this->title = 'Crear Aviso';
$this->params['breadcrumbs'][] = ['label' => 'Avisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aviso-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formaviso', [
        'aviso' => $aviso,
    ]) ?>

</div>
