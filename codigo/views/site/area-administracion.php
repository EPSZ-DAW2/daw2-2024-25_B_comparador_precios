<?php 
    use yii\helpers\Html;
    use app\components\User;
    use app\models\Roles;

    $this->title = 'Panel de Mantenimiento del Administrador';
?>

<div class="container">
    <h2>Bienvenido al Panel de Administración</h2>

    <p>
        Como administrador, tienes acceso a diversas secciones para gestionar la aplicación. Aquí podrás gestionar usuarios, moderadores, productos y mucho más.
    </p>

    <h3>Gestión de Elementos Principales</h3>

    <p>
        <?= Html::a('Administrar Usuarios', ['usuarios/index'], ['class' => 'btn btn-success', 'style' => 'margin-right: 10px;']) ?>
        <?= Html::a('Administrar Moderadores', ['moderadores-admin/index'], ['class' => 'btn btn-success', 'style' => 'margin-right: 10px;']) ?>
        <?= Html::a('Gestionar Tiendas', ['tiendas-admin/index'], ['class' => 'btn btn-success', 'style' => 'margin-right: 10px;']) ?>
        <?= Html::a('Gestionar Artículos', ['articulos/index'], ['class' => 'btn btn-success', 'style' => 'margin-right: 10px;']) ?>
    </p>

    <h3>Otras Opciones de Mantenimiento</h3>

    <p>
        <?= Html::a('Administrar Etiquetas de Productos', ['etiquetas/index'], ['class' => 'btn btn-warning', 'style' => 'margin-right: 10px;']) ?>
        <?= Html::a('Gestionar Categorías de Productos', ['categorias/index'], ['class' => 'btn btn-warning', 'style' => 'margin-right: 10px;']) ?>
        <?= Html::a('Gestionar Clasificaciones de Artículos', ['clasificaciones/index'], ['class' => 'btn btn-warning', 'style' => 'margin-right: 10px;']) ?>
    </p>

    <h3>Seguridad y Registros</h3>

    <p>
        <?= Html::a('Ver Registros de Actividades', ['registro-logs/index'], ['class' => 'btn btn-info', 'style' => 'margin-right: 10px;']) ?>
        <?= Html::a('Administrar Copias de Seguridad', ['backup/index'], ['class' => 'btn btn-info', 'style' => 'margin-right: 10px;']) ?>
    </p>
</div>
