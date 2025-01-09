<?php

/** @var yii\web\View $this */
use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">VAMAR</h1>

        <p class="lead">Empieza tu busqueda:</p>
    </div>

    <div class="text-center">
        <?php echo Html::a('Buscar por tiendas', ['tiendas/index'], [
            'class' => 'btn btn-primary btn-lg', // btn-lg hace el botón más grande
            'role' => 'button',
        ]); ?>
    </div>

</div>



