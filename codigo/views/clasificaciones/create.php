<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Create Clasificaciones');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clasificaciones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clasificaciones-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Contenedor del formulario con clase usuario-form -->
    <div class="clasificaciones-form usuario-form"> 
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
