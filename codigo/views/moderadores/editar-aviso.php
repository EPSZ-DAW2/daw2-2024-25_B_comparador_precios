<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Aviso $aviso */

$this->title = 'Editar Aviso: ' . $aviso->id;
$this->params['breadcrumbs'][] = ['label' => 'Avisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Aviso #' . $aviso->id, 'url' => ['ver-aviso', 'id' => $aviso->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>

<div class="aviso-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Formulario dentro del contenedor con la clase aviso-form -->
    <div class="aviso-form usuario-form">
        <?= $this->render('_formaviso', [
            'aviso' => $aviso,
        ]) ?>
    </div>
</div>
