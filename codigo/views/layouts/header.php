<?php

use yii\bootstrap5\NavBar;
use yii\bootstrap5\Nav;
use yii\bootstrap5\Html;
use app\models\Usuario;

?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => 'COMPARADOR DE PRECIOS',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);

    // Menú a la izquierda (Inicio y Sobre Nosotros)
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto'], // me-auto para alinear a la izquierda
        'items' => [
            ['label' => 'Inicio', 'url' => ['/site/index']],
            ['label' => 'Sobre Nosotros', 'url' => ['/site/about']],
        ]
    ]);

    // Menú a la derecha (Tu Perfil, Login, Registro)
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'], // ms-auto para alinear a la derecha
        'items' => [
            ['label' => 'Tu Perfil', 'url' => ['/usuarios/perfil'], 'visible' => !Yii::$app->user->isGuest],
            ['label' => 'Registrar', 'url' => ['/registros/register'], 'visible' => Yii::$app->user->isGuest],
            Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['/site/login']]
                : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>',
            // Mostrar los botones según el rol
            Yii::$app->user->isGuest ? '' :
            (Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_USUARIO_TIENDA) ? 
                ['label' => 'Mi Tienda', 'url' => ['site/area-usuario-tienda']] : ''),

            Yii::$app->user->isGuest ? '' :
            (Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_MODERADOR) ? 
                ['label' => 'Área Moderador', 'url' => ['site/area-moderador']] : ''),

            Yii::$app->user->isGuest ? '' :
            (Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR) ? 
                ['label' => 'Área Administrador', 'url' => ['/site/area-administracion']] : ''),

            Yii::$app->user->isGuest ? '' :
            (Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR) ? 
                ['label' => 'Área Administrador', 'url' => ['site/area-administracion']] : ''),

            Yii::$app->user->isGuest ? '' :
            (Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR) ? 
                ['label' => 'Área Moderador', 'url' => ['site/area-moderador']] : ''),
        ]
    ]);

    NavBar::end();
    ?>
</header>