<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Articulo $model */
/** @var app\models\ArticulosTienda $modeltienda */
/** @var yii\widgets\ActiveForm $form */
/** @var array $articulos */
/** @var array $categorias */
/** @var array $etiquetas */

$this->title = Yii::t('app', 'Modificar Artículo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tiendas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articulo-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="usuario-form"> 
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id')->dropDownList($articulos, ['prompt' => 'Seleccione un artículo']) ?>

        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'categoria_id')->dropDownList($categorias) ?>

        <?= $form->field($model, 'etiqueta_id')->dropDownList($etiquetas) ?>

        <?= $form->field($model, 'imagen_principal')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'visible')->checkbox() ?>

        <?= $form->field($model, 'cerrado')->checkbox() ?>

        <?= $form->field($modeltienda, 'precio_actual')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'tipo_marcado')->dropDownList(['comun' => 'Común', 'particular' => 'Particular']) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
