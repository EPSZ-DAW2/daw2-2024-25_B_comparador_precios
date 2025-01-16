<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ArticulosSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tienda-search">

    <?php $form = ActiveForm::begin([
        'action' => ['public-index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'nombre')->textInput(['placeholder' => 'Buscar por nombre']) ?>

    <?= $form->field($model, 'descripcion')->textInput(['placeholder' => 'Buscar por descripción']) ?>

    <?= $form->field($model, 'categoria_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Categorias::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Selecciona una categoría']
    ) ?>

    <?= $form->field($model, 'etiqueta_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Etiquetas::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Selecciona una etiqueta']
    ) ?>
	
	<?= $form->field($model, 'clasificacion_tienda')->dropDownList(
		\yii\helpers\ArrayHelper::map(\app\models\Clasificaciones::find()->all(), 'id', 'nombre'),
		['prompt' => 'Selecciona una clasificación']
	) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>
		<?= Html::a(Yii::t('app', 'Resetear'), ['public-index'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
