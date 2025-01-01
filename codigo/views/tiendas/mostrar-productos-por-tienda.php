<?php
/**  @var yii\web\View $this */
/**  @var array $tiendasConProductos  */

use yii\helpers\Html;

$this->title = 'Productos por Tienda';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tiendas-productos">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php foreach ($tiendasConProductos as $tiendaConProductos): ?>
        <div class="tienda">
            <h2><?= Html::encode($tiendaConProductos['tienda']->nombre) ?></h2>
            <p><?= Html::encode($tiendaConProductos['tienda']->descripcion) ?></p>

            <h3>Productos:</h3>
            <ul>
                <?php foreach ($tiendaConProductos['productos'] as $producto): ?>
                    <li>
                        <strong>Nombre:</strong> <?= Html::encode($producto['nombre']) ?><br>
                        <strong>Descripción:</strong> <?= Html::encode($producto['descripcion']) ?><br>
                        <strong>Precio:</strong> <?= Html::encode($producto['precio']) ?><br>
                        <strong>Imagen:</strong> <img src="<?= Html::encode($producto['imagen_principal']) ?>" alt="<?= Html::encode($producto['nombre']) ?>" width="100"><br>
                        <strong>Categoría ID:</strong> <?= Html::encode($producto['categoria_id']) ?><br>
                        <strong>Etiqueta ID:</strong> <?= Html::encode($producto['etiqueta_id']) ?><br>
                        <strong>Visible:</strong> <?= Html::encode($producto['visible']) ?><br>
                        <strong>Cerrado:</strong> <?= Html::encode($producto['cerrado']) ?><br>
                        <strong>Tipo:</strong> <?= Html::encode($producto['comun_o_propio']) ?><br>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>