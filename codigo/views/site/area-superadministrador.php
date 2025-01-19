<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Área Superadministrador';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-area-superadministrador">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1><?= Html::encode($this->title) ?></h1>
                <p>Bienvenido al área del Superadministrador. Desde aquí podrás gestionar todas las funciones del sistema, incluyendo la administración, moderación y la gestión de las tiendas de los usuarios. Selecciona una de las siguientes áreas para continuar:</p>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Botón para el área de administración -->
            <div class="col-md-4 mb-3">
                <?= Html::a('Área Administración', ['/site/area-administracion'], [
                    'class' => 'btn btn-primary btn-block btn-lg',
                    'role' => 'button'
                ]) ?>
            </div>

            <!-- Botón para el área de moderación -->
            <div class="col-md-4 mb-3">
                <?= Html::a('Área Moderación', ['/site/area-moderador'], [
                    'class' => 'btn btn-warning btn-block btn-lg',
                    'role' => 'button'
                ]) ?>
            </div>

            <!-- Botón para el área de usuario tienda -->
            <div class="col-md-4 mb-3">
                <?= Html::a('Área Usuario Tienda', ['/site/area-usuario-tienda'], [
                    'class' => 'btn btn-success btn-block btn-lg',
                    'role' => 'button'
                ]) ?>
            </div>
        </div>
    </div>
</div>
