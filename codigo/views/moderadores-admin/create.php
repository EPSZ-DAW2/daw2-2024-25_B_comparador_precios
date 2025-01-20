<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Create Moderador');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Moderadores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="moderador-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Formulario dentro del contenedor con la clase usuario-form -->
    <div class="usuario-form"> 
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
