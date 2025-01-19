<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Crear Nuevo Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registro de Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-logs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Contenedor del formulario con clase usuario-form -->
    <div class="registro-logs-form usuario-form"> 
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
