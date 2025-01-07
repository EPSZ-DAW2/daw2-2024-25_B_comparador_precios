<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var  yii\web\View $this */
/** @var  app\models\ArticulosTienda[] $articulosTienda */
/** @var array $articulos */

$this->title = 'Actualizar Precios';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tienda-update-prices">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Artículo</th>
                <th>Precio Actual</th>
                <th>Nuevo Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articulosTienda as $articuloTienda): ?>
                <tr>
                    <td>
                        <?= Html::dropDownList("ArticulosTienda[{$articuloTienda->articulo_id}][articulo_id]", $articuloTienda->articulo_id, $articulos, ['class' => 'form-control']) ?>
                    </td>
                    <td><?= Html::encode($articuloTienda->precio) ?></td>
                    <td>
                        <?= Html::input('number', "ArticulosTienda[{$articuloTienda->articulo_id}][precio]", $articuloTienda->precio, ['class' => 'form-control']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="form-group">
        <?= Html::submitButton('Actualizar Precios', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>