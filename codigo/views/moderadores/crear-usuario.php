<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = Yii::t('app', 'Crear Usuario');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuarios de mi Región'), 'url' => ['revisar-usuarios']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="usuario-create">

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
