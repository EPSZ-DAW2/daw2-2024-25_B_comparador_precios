<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RegistroUsuarios $model */

$this->title = Yii::t('app', 'Create Registro Usuarios');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registro Usuarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-usuarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
