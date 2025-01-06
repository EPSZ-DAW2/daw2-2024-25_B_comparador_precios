<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var  yii\web\View $this */
/** @var  array $ofertasList */

$this->title = 'Eliminar Oferta';
$this->params['breadcrumbs'][] = ['label' => 'Tiendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Ver Tienda', 'url' => ['view-store', 'id' => $Tienda_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="oferta-eliminar">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="oferta-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id')->dropDownList($ofertasList, ['prompt' => 'Seleccione una oferta', 'name' => 'oferta_id']) ?>

        <div class="form-group">
            <?= Html::submitButton('Eliminar Oferta', ['class' => 'btn btn-danger']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>