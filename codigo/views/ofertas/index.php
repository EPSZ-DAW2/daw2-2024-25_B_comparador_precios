<?php

use yii\widgets\ListView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\OfertasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Ofertas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ofertas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Renderiza el formulario de búsqueda -->
    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <!-- ListView para mostrar los resultados como fichas -->
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_oferta_card', // Vista parcial para cada ficha
		'layout' => "<div class='tienda-list'>{items}</div>\n{pager}", // Estructura de la lista
        'emptyText' => '<p>No se encontraron ofertas.</p>',
    ]) ?>

</div>
