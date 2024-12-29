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
    <?php /*<p><strong>Región:</strong> <?= $usuario->region ? Html::encode($usuario->region->nombre) : 'Sin región asignada' ?></p>*/?>
    <p><strong>Fecha de Registro:</strong> <?= Html::encode($usuario->fecha_registro) ?></p>
</div>

<?= Html::a('Editar Perfil', ['usuarios/update-profile'], ['class' => 'btn btn-primary']) ?>
<br>
<?= Html::a('Seguimientos', ['seguimientos/seguimientos'], ['class' => 'btn btn-primary']) ?>

