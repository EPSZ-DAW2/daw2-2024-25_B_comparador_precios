<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Create Etiquetas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Etiquetas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiquetas-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Contenedor del formulario con clase usuario-form -->
    <div class="etiquetas-form usuario-form"> 
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
