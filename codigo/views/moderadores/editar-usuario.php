<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = Yii::t('app', 'Actualizar Usuario: {name}', ['name' => $model->nick]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuarios de mi Región'), 'url' => ['revisar-usuarios']];
$this->params['breadcrumbs'][] = ['label' => $model->nick, 'url' => ['ver-usuario', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>

<div class="usuario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Formulario dentro del contenedor con la clase usuario-form -->
    <div class="usuario-form"> 
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

    <!-- Botón fuera del formulario, como en los artículos -->
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

</div>
