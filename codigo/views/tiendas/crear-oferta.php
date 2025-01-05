use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ofertas $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = Yii::t('app', 'Crear Oferta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tiendas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oferta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="oferta-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'articulo_id')->hiddenInput(['value' => $Articulo_id])->label(false) ?>

        <?= $form->field($model, 'tienda_id')->hiddenInput(['value' => $Tienda_id])->label(false) ?>

        <?= $form->field($model, 'precio_oferta')->textInput(['type' => 'number', 'step' => '0.01', 'min' => '0']) ?>

        <?= $form->field($model, 'fecha_inicio')->textInput(['type' => 'date']) ?>

        <?= $form->field($model, 'fecha_fin')->textInput(['type' => 'date']) ?>

        <?= $form->field($model, 'notas')->textarea(['rows' => 4]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
