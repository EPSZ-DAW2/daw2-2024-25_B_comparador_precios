<?php
use yii\helpers\Html;

/**  @var yii\web\View $this */
/** @var  app\models\Tiendas $model */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Tiendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tiendas-view-profile">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a('Actualizar perfil', ['update-profile', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Solicitar dar de baja', ['request-delete-profile', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => '¿seguro que quieres dar de baja tu perfil?',
            'method' => 'post',
        ],
    ]) ?>

    <!-- Display profile details here -->
    <p>nombre: <?= Html::encode($model->nombre) ?></p>
    <p>Url: <?= Html::encode($model->url) ?></p>
    <!-- Add other profile fields as needed -->

</div>