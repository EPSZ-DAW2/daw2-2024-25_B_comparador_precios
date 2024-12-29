<?
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tienda $model */
/** @var $form yii\widgets\ActiveForm */

$this->title = 'Mantener Artículos de la Tienda';
$this->params['breadcrumbs'][] = ['label' => 'Tiendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tienda-mantener-articulos">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="tienda-form">

        <?php $form = ActiveForm::begin([
            'action' => ['mantener-articulos', 'tiendaId' => $tienda->id],
            'method' => 'post',
        ]); ?>

        <div class="form-group">
            <label for="articulos">Artículos</label>
            <div id="articulos">
                <!-- Aquí puedes agregar campos para los datos de los artículos -->
                <!-- Por ejemplo, un campo para el nombre y otro para el precio -->
                <!-- Puedes usar un bucle para generar múltiples campos si es necesario -->
                <?php for ($i = 0; $i < 5; $i++): // Cambia 5 por el número de artículos que deseas manejar ?>
                    <div class="articulo">
                        <h4>Artículo <?= $i + 1 ?></h4>
                        <?= Html::input('text', "articulosData[$i][nombre]", '', ['class' => 'form-control', 'placeholder' => 'Nombre']) ?>
                        <?= Html::input('text', "articulosData[$i][descripcion]", '', ['class' => 'form-control', 'placeholder' => 'Descripción']) ?>
                        <?= Html::input('text', "articulosData[$i][imagen_principal]", '', ['class' => 'form-control', 'placeholder' => 'Imagen Principal']) ?>
                        <?= Html::input('number', "articulosData[$i][precio]", '', ['class' => 'form-control', 'placeholder' => 'Precio']) ?>
                        <?= Html::dropDownList("articulosData[$i][visible]", 1, [1 => 'Visible', 0 => 'Oculto'], ['class' => 'form-control']) ?>
                        <?= Html::dropDownList("articulosData[$i][cerrado]", 0, [0 => 'Abierto', 1 => 'Cerrado'], ['class' => 'form-control']) ?>
                        <?= Html::dropDownList("articulosData[$i][comun_o_propio]", 'propio', ['comun' => 'Común', 'propio' => 'Propio'], ['class' => 'form-control']) ?>
                        <?= Html::input('text', "articulosData[$i][categoria_id]", '', ['class' => 'form-control', 'placeholder' => 'Categoría ID']) ?>
                        <?= Html::input('text', "articulosData[$i][etiqueta_id]", '', ['class' => 'form-control', 'placeholder' => 'Etiqueta ID']) ?>
                        <?= Html::input('text', "articulosData[$i][registro_id]", '', ['class' => 'form-control', 'placeholder' => 'Registro ID']) ?>
                        <?= Html::input('text', "articulosData[$i][articulo_tienda_id]", '', ['class' => 'form-control', 'placeholder' => 'Artículo Tienda ID']) ?>
                        <?= Html::checkbox("articulosData[$i][ocultar]", false, ['label' => 'Ocultar']) ?>
                        <?= Html::checkbox("articulosData[$i][eliminar]", false, ['label' => 'Eliminar']) ?>
                    </div>
                    <hr>
                <?php endfor; ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
