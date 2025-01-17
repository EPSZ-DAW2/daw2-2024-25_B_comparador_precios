<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var  yii\web\View $this */
/** @var  array $ofertasList */
/** @var  app\models\Ofertas $ofertaSeleccionada */

$this->title = 'Modificar Oferta';
$this->params['breadcrumbs'][] = ['label' => 'Tiendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Ver Tienda', 'url' => ['view-store', 'id' => $Tienda_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="oferta-modificar">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="oferta-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($ofertaSeleccionada, 'id')->dropDownList($ofertasList, [
            'prompt' => 'Seleccione una oferta',
            'name' => 'oferta_id',
            'options' => [
                Yii::$app->request->post('oferta_id') => ['Selected' => true]
            ]
        ]) ?>
        <?php if ($ofertaSeleccionada): ?>
            <?= $form->field($ofertaSeleccionada, 'precio_oferta')->textInput(['maxlength' => true]) ?>
            <?= $form->field($ofertaSeleccionada, 'fecha_inicio')->input('datetime-local') ?>
            <?= $form->field($ofertaSeleccionada, 'fecha_fin')->input('datetime-local') ?>

            <div class="form-group">
                <?= Html::submitButton('Modificar Oferta', ['class' => 'btn btn-success']) ?>
            </div>
        <?php endif; ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>