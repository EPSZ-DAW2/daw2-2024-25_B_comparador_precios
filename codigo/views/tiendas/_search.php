<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TiendasSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tienda-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'], // Acción donde procesas la búsqueda
        'method' => 'get',
    ]); ?>

    <!-- Campo para buscar por nombre de la tienda -->
    <?= $form->field($model, 'nombre')->textInput(['placeholder' => 'Buscar por nombre de la tienda']) ?>

    <!-- Campo para buscar por clasificación -->
    <?= $form->field($model, 'clasificacion_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Clasificaciones::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Selecciona una clasificación']
    ) ?>

    <!-- Campo para buscar por etiquetas -->
    <?= $form->field($model, 'etiquetas_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Etiquetas::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Selecciona una etiqueta']
    ) ?>

    <!-- Campo para buscar por ubicación -->
    <?= $form->field($model, 'lugar')->textInput(['placeholder' => 'Buscar por ubicación']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Resetear'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

