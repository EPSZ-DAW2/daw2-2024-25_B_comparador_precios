<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Articulo $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = Yii::t('app', 'Modificar Artículo: {name}', [
    'name' => $model->nombre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tiendas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Modificar');
?>
<div class="articulo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="articulo-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'categoria_id')->dropDownList($categorias) ?>

        <?= $form->field($model, 'etiqueta_id')->dropDownList($etiquetas) ?>

        <?= $form->field($model, 'imagen_ppal')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'visible')->checkbox() ?>

        <?= $form->field($model, 'cerrado')->checkbox() ?>

        <?= $form->field($model, 'tipo_marcado')->dropDownList(['comun' => 'Común', 'particular' => 'Particular']) ?>


        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>