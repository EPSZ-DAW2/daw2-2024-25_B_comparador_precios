<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Create Historico');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Historicos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historico-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Contenedor del formulario con clase usuario-form -->
    <div class="historico-form usuario-form"> 
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
