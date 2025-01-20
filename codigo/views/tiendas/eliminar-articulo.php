<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var array $articulos */
/** @var app\models\Articulo $model */

$this->title = Yii::t('app', 'Eliminar Artículo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tiendas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articulo-delete">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="usuario-form"> 
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id')->dropDownList($articulos, ['prompt' => 'Seleccione un artículo']) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Eliminar'), ['class' => 'btn btn-danger']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
