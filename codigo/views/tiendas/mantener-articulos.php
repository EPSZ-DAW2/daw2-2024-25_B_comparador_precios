<?  use yii\helpers\Html;
    use yii\widgets\ActiveForm;

/**  @var yii\web\View $this */
/**  @var app\models\Tienda $tienda  */
/**  @var app\models\Articulo[] $articulos */

$this->title = 'Mantener Artículos de la Tienda';
$this->params['breadcrumbs'][] = ['label' => 'Tiendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tienda->nombre, 'url' => ['view', 'id' => $tienda->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tienda-mantener-articulos">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="articulo-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($articulo, 'nombre')->textInput(['maxlength' => true]) ?>
        <?= $form->field($articulo, 'descripcion')->textarea(['rows' => 6]) ?>
        <?= $form->field($articulo, 'precio')->textInput(['maxlength' => true]) ?>
        <?= $form->field($articulo, 'imagen_principal')->textInput(['maxlength' => true]) ?>
        <?= $form->field($articulo, 'categoria_id')->dropDownList($categorias) ?>
        <?= $form->field($articulo, 'etiqueta_id')->dropDownList($etiquetas) ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <h2>Artículos de la Tienda</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articulos as $articulo): ?>
                <tr>
                    <td><?= Html::encode($articulo->nombre) ?></td>
                    <td><?= Html::encode($articulo->descripcion) ?></td>
                    <td><?= Html::encode($articulo->precio) ?></td>
                    <td>
                        <?= Html::a('Modificar', ['modificar', 'id' => $articulo->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Eliminar', ['eliminar', 'id' => $articulo->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => '¿Estás seguro de que quieres eliminar este artículo?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?= Html::a('Ocultar', ['ocultar', 'id' => $articulo->id], ['class' => 'btn btn-warning']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>