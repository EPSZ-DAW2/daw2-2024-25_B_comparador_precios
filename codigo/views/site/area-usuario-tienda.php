<!-- views/site/area-usuario-tienda.php -->
<?php

use yii\helpers\Html;

$this->title = 'Área Usuario Tienda';
?>
<div class="site-area-usuario-tienda">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Bienvenido a tu tienda, accede al panel de administración aquí:</p>
    <?= Html::a('Panel de Administración', ['/tiendas/admin-tienda'], ['class' => 'btn btn-primary']) ?>
</div>
