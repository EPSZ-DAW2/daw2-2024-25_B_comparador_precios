<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Create Articulo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articulos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="articulo-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Formulario dentro del contenedor con la clase articulo-form -->
    <div class="articulo-form usuario-form"> 
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
