<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RegistroLogs $model */

$this->title = Yii::t('app', 'Crear Nuevo Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registro de Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-logs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

