<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var  yii\web\View $this */
/** @var  app\models\Ofertas $model */
/** @var  array $articulos */

$this->title = 'Crear Oferta';
$this->params['breadcrumbs'][] = ['label' => 'Tiendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Ver Tienda', 'url' => ['view-store', 'id' => $model->tienda_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oferta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="oferta-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'articulo_id')->dropDownList($articulos, ['prompt' => 'Seleccione un artículo']) ?>

        <?= $form->field($model, 'precio_oferta')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'fecha_inicio')->input('datetime-local') ?>

        <?= $form->field($model, 'fecha_fin')->input('datetime-local') ?>

        <div class="form-group">
            <?= Html::submitButton('Crear Oferta', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>