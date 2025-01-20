<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Create Categorias');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Contenedor del formulario con clase usuario-form -->
    <div class="categorias-form usuario-form"> 
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
