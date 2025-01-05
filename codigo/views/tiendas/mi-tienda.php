<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Tienda $tienda */
/** @var yii\web\View $this */

$this->title = 'Mi Tienda: ' . Html::encode($tienda->nombre);
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>Bienvenido a la administración de tu tienda. Selecciona una de las siguientes opciones:</p>

<ul>
    <li><?= Html::a('Crear Articulo', Url::to(['tiendas/crear-articulo', 'id' => $tienda->id])) ?></li>
    <li><?= Html::a('modificar Artículo', Url::to(['tiendas/modificar-articulo', 'Tienda_id' => $tienda->id])) ?></li>
    <li><?= Html::a('Ver Histórico de Precios', Url::to(['tiendas/ver-historico', 'Tienda_id' => $tienda->id])) ?></li>
    <li><?= Html::a('Modificar Perfil', Url::to(['tiendas/update-profile', 'id' => $tienda->id])) ?></li>
    <li><?= Html::a('Dar de Baja Tienda', Url::to(['tiendas/dar-de-baja', 'id' => $tienda->id])) ?></li>
</ul>
