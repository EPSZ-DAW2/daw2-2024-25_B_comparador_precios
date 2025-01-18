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
                <h4><?= Html::a(Html::encode($tienda->nombre), ['tiendas/view','id' => $tienda->id]) ?></h4>
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
                <h4><?= Html::a(Html::encode($articulo->nombre), ['public-articulos/view','id' => $articulo->id]) ?></h4>
                    <?= Html::encode($articulo->descripcion) ?>
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
                <h4><?=Html::a(Html::encode($oferta->articulo->nombre), ['public-articulos/view','id' => $oferta->articulo->id]) ?></h4>
                <strong><?= Html::encode($oferta->tienda->nombre ) ?></strong><br>
                <strong>Oferta actual: <?= Html::encode($oferta->precio_oferta ) ?></strong><br>
                
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No tienes seguimientos de ofertas.</p>
<?php endif; ?>


