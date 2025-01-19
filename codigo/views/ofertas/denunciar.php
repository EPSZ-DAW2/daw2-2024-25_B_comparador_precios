<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ArticulosTienda $model */

$this->title = 'Denunciar Oferta';
$this->params['breadcrumbs'][] = ['label' => 'Ofertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->articulo->nombre, 'url' => ['view', 'id' => $model->articulo_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oferta-denunciar">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>¿Por qué deseas denunciar esta oferta?</p>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'motivo_denuncia')->textarea([
            'value' => '',
            'rows' => 5,
            'name' => 'motivo_denuncia'
        ])->label('Motivo de la denuncia') ?>

        <div class="form-group">
            <?= Html::submitButton('Enviar Denuncia', ['class' => 'btn btn-danger']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>

