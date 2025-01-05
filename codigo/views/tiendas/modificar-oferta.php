use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ofertas $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = Yii::t('app', 'Modificar Oferta: {name}', [
    'name' => $model->articulo->nombre, // Se asume relación con el modelo de artículo
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tiendas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->articulo->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Modificar');
?>
<div class="oferta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="oferta-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'articulo_id')->hiddenInput(['value' => $model->articulo_id])->label(false) ?>

        <?= $form->field($model, 'tienda_id')->hiddenInput(['value' => $model->tienda_id])->label(false) ?>

        <?= $form->field($model, 'precio_oferta')->textInput(['type' => 'number', 'step' => '0.01', 'min' => '0', 'value' => $model->precio_oferta]) ?>

        <?= $form->field($model, 'fecha_inicio')->textInput(['type' => 'date', 'value' => $model->fecha_inicio]) ?>

        <?= $form->field($model, 'fecha_fin')->textInput(['type' => 'date', 'value' => $model->fecha_fin]) ?>

        <?= $form->field($model, 'notas')->textarea(['rows' => 4, 'value' => $model->notas]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>