<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tienda[] $tiendas*/

$this->title = 'Panel de Administración de Tiendas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tienda-admin">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($tiendas)): ?>
        <div class="panel-group" id="accordion">
            <?php foreach ($tiendas as $tienda): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $tienda->id ?>">
                                <?= Html::encode($tienda->razon_social) ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-<?= $tienda->id ?>" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p>
                            <?= Html::a('Ver Tienda', ['view-store', 'id' => $tienda->id], ['class' => 'btn btn-info']) ?>
                                <?= Html::a('Crear Oferta', ['crear-oferta', 'Tienda_id' => $tienda->id], ['class' => 'btn btn-success']) ?>
                                <?= Html::a('Modificar Oferta', ['modificar-oferta', 'Tienda_id' => $tienda->id], ['class' => 'btn btn-primary']) ?>
                                <?= Html::a('Eliminar Oferta', ['eliminar-oferta', 'Tienda_id' => $tienda->id], ['class' => 'btn btn-danger']) ?>
                                <?= Html::a('Crear Artículo', ['crear-articulo', 'Tienda_id' => $tienda->id], ['class' => 'btn btn-success']) ?>
                                <?= Html::a('Eliminar Artículo', ['eliminar-articulo', 'Tienda_id' => $tienda->id], ['class' => 'btn btn-danger']) ?>
                                <?= Html::a('Modificar Artículo', ['modificar-articulo', 'Tienda_id' => $tienda->id], ['class' => 'btn btn-primary']) ?>
                                <?= Html::a('Actualizar Tienda', ['update', 'id' => $tienda->id], ['class' => 'btn btn-warning']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No eres dueño de ninguna tienda.</p>
    <?php endif; ?>
</div>
