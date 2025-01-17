use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tienda[] $tiendas */

$this->title = Yii::t('app', 'Panel de Tienda');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-tienda">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>A continuación, encontrarás opciones para gestionar tus tiendas y sus artículos:</p>

    <?php foreach ($tiendas as $tienda): ?>
        <div class="tienda-panel">
            <h2><?= Html::encode($tienda->nombre) ?></h2>
            <ul>
                <li><?= Html::a('Crear Artículo', ['articulos/create', 'tienda_id' => $tienda->id], ['class' => 'btn btn-primary']) ?></li>
                <li><?= Html::a('Modificar Artículos', ['articulos/index', 'tienda_id' => $tienda->id], ['class' => 'btn btn-secondary']) ?></li>
                <li><?= Html::a('Crear Oferta', ['ofertas/create', 'tienda_id' => $tienda->id], ['class' => 'btn btn-success']) ?></li>
                <li><?= Html::a('Modificar Ofertas', ['ofertas/index', 'tienda_id' => $tienda->id], ['class' => 'btn btn-warning']) ?></li>
            </ul>
        </div>
    <?php endforeach; ?>

</div>
