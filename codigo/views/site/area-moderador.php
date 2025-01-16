<?php
use yii\helpers\Html;

$this->title = 'Panel de Mantenimiento del Moderador';
?>

<div class="container">
    <h2>Bienvenido al Panel de Moderador</h2>

    <p>
        Como moderador, tienes acceso a diversas secciones para gestionar las tiendas y los usuarios de tu región.
    </p>

    <h3>Gestión de Perfil</h3>

    <p>
        <?= Html::a('Administrar Perfil como Moderador', ['moderadores/index'], ['class' => 'btn btn-primary', 'style' => 'margin-right: 10px;']) ?>
    </p>

    <h3>Gestión de Tiendas de su region</h3>

    <p>
        <?= Html::a('Administrar Tiendas de tu Región', ['moderadores/revisar-tiendas'], ['class' => 'btn btn-primary', 'style' => 'margin-right: 10px;']) ?>
    </p>

    <h3>Gestión de Usuarios de su region</h3>

    <p>
        <?= Html::a('Administrar Usuarios de tu Región', ['moderadores/revisar-usuarios'], ['class' => 'btn btn-primary', 'style' => 'margin-right: 10px;']) ?>
    </p>

    <p>
        <!-- Agrega aquí otras opciones que el moderador pueda necesitar -->
    </p>
</div>
