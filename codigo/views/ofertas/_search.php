<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\OfertasSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ofertas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'nombre_articulo')->textInput(['placeholder' => 'Buscar por nombre del artículo']) ?>
    <?= $form->field($model, 'descripcion_articulo')->textInput(['placeholder' => 'Buscar por descripción del artículo']) ?>

    <?= $form->field($model, 'categoria_id')->dropDownList(
        ArrayHelper::map(\app\models\Categorias::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Selecciona una categoría']
    ) ?>

    <?= $form->field($model, 'etiqueta_id')->dropDownList(
        ArrayHelper::map(\app\models\Etiquetas::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Selecciona una etiqueta']
    ) ?>

    <?= $form->field($model, 'clasificacion_tienda')->dropDownList(
        ArrayHelper::map(\app\models\Clasificaciones::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Selecciona una clasificación']
    ) ?>

    <?= $form->field($model, 'region_id')->dropDownList(
        ArrayHelper::map(\app\models\Regiones::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Selecciona una región']
    ) ?>

    <?= $form->field($model, 'fecha_inicio')->input('date') ?>
    <?= $form->field($model, 'fecha_fin')->input('date') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Resetear'), ['index'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



