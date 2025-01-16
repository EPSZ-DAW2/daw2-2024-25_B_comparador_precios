<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Usuario $usuario */

$this->title = 'Perfil de Usuario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-perfil">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><strong>Nombre:</strong> <?= Html::encode($usuario->nombre) ?></p>
    <p><strong>Apellidos:</strong> <?= Html::encode($usuario->apellidos) ?></p>
    <p><strong>Email:</strong> <?= Html::encode($usuario->email) ?></p>
    <p><strong>Nick:</strong> <?= Html::encode($usuario->nick) ?></p>
    <p><strong>Teléfono:</strong> <?= Html::encode($usuario->telefono) ?></p>
    <p><strong>Fecha de Nacimiento:</strong> <?= Html::encode($usuario->fecha_nacimiento) ?></p>
    <p><strong>Dirección:</strong> <?= Html::encode($usuario->direccion) ?></p>

    <!-- Mostrar las regiones asociadas -->
    <?php if ($usuario->region): ?>
        <?php
            // Obtenemos la jerarquía completa de la región
            $regionHierarchy = $usuario->region->getFullRegion();
        ?>
        <p><strong>Región:</strong> <?= Html::encode(implode(' > ', $regionHierarchy)) ?></p>
    <?php else: ?>
        <p><strong>Región:</strong> Sin región asignada</p>
    <?php endif; ?>

    <p><strong>Fecha de Registro:</strong> <?= Html::encode($usuario->fecha_registro) ?></p>
</div>

<!-- Botones del usuario -->
<?= Html::a('Editar Perfil', ['usuarios/update-profile'], ['class' => 'btn btn-primary']) ?>
<br>
<?= Html::a('Seguimientos', ['seguimientos/seguimientos'], ['class' => 'btn btn-primary']) ?>
<br>
<?= Html::a('Tus Comentarios', ['comentarios/comentarios-usuario'], ['class' => 'btn btn-primary']) ?>
<br>
<!-- Botón para los avisos enviados -->
<?= Html::a('Avisos Enviados', ['avisos/enviados', 'id' => $usuario->id], ['class' => 'btn btn-primary']) ?>
<br>
<!-- Botón para los avisos recibidos -->
<?= Html::a('Avisos Recibidos', ['avisos/recibidos', 'id' => $usuario->id], ['class' => 'btn btn-primary']) ?>

<!-- Enviar un aviso -->
<?= Html::a('Enviar Aviso', ['avisos/enviar'], ['class' => 'btn btn-primary']) ?>

<?= Html::a(
    'Darse de baja', 
    ['usuarios/baja'], 
    [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => '¿Está seguro de que desea darse de baja? Tu cuenta será eliminada.',
        ],
    ]
) ?>

