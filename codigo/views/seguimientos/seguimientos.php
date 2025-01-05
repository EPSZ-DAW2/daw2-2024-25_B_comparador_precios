<?php
/** @var yii\web\View $this */
/** @var array $seguimientosTienda */
/** @var array $seguimientosArticulo */
/** @var array $seguimientosOferta */

use yii\helpers\Html;

$this->title = 'Mis Seguimientos';
?>

<h1><?= Html::encode($this->title) ?></h1>

<h2>Seguimientos de Tiendas</h2>
<?php if (!empty($seguimientosTienda)): ?>
    <ul>
        <?php foreach ($seguimientosTienda as $tienda): ?>
            <li>
                <?= Html::encode($tienda->nombre) ?>
                <!-- Agrega más detalles de la tienda aquí -->
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No tienes seguimientos de tiendas.</p>
<?php endif; ?>

<h2>Seguimientos de Artículos</h2>
<?php if (!empty($seguimientosArticulo)): ?>
    <ul>
        <?php foreach ($seguimientosArticulo as $articulo): ?>
            <li>
                <h4><?= Html::encode($articulo->nombre) ?></h4>
                    <?= Html::encode($articulo->descripcion) ?>
                    <!-- Agrega más detalles del artículo aquí -->
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No tienes seguimientos de artículos.</p>
<?php endif; ?>


<h2>Seguimientos de Ofertas</h2>
<?php if (!empty($seguimientosOferta)): ?>
    <ul>
        <?php foreach ($seguimientosOferta as $oferta): ?>
            <li>
                <h4><?= Html::encode($oferta->articulo->nombre ) ?></h4>
                <?= Html::encode($oferta->precio_oferta ) ?>
                <?= Html::encode($oferta->precio_og ) ?>
                <?= Html::encode($oferta->tienda->nombre ) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No tienes seguimientos de ofertas.</p>
<?php endif; ?>


