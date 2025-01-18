<?php
use yii\helpers\Html;
?>

<div id="footer" class="container-fluid"> 
    <div class="container">
        <div class="row text-light">
            <!-- Seguimiento de la web -->
            <div class="col-md-4 text-center text-md-start mb-3">
                <h5 class="text-white">Seguimiento de la web</h5>
                <ul class="list-unstyled">
                    <li><?= Html::a('Inicio', ['/site/index'], ['class' => 'text-light']) ?></li>
                    <li><?= Html::a('Sobre nosotros', ['/site/about'], ['class' => 'text-light']) ?></li>
                    <li><?= Html::a('Contacto', ['/site/contact'], ['class' => 'text-light']) ?></li>
                </ul>
            </div>

            <!-- Información de contacto -->
            <div class="col-md-4 text-center mb-3">
                <h5 class="text-white">Información de contacto</h5>
                <p class="text-light">
                    Campus Viriato, Zamora <br>
                    Teléfono: (+34) 980 123 456 <br>
                    <?= Html::a('+ Info: politecnicazamora.usal.es', 'https://politecnicazamora.usal.es', ['class' => 'text-light', 'target' => '_blank']) ?>
                </p>
            </div>

            <!-- Políticas y avisos -->
            <div class="col-md-4 text-center text-md-end mb-3">
                <h5 class="text-white">Políticas y avisos</h5>
                <ul class="list-unstyled">
                    <li><?= Html::a('Aviso Legal', ['/site/aviso-legal'], ['class' => 'text-light']) ?></li>
                    <li><?= Html::a('Política de Privacidad', ['/site/politica-privacidad'], ['class' => 'text-light']) ?></li>
                    <li><?= Html::a('Política de Cookies', ['/site/politica-cookies'], ['class' => 'text-light']) ?></li>
                </ul>
            </div>
        </div>

        <div class="row text-light mt-3">
            <!-- Redes sociales -->
            <div class="col-md-6 text-center text-md-start mb-3">
                <h5 class="text-white">Síguenos</h5>
                <ul class="list-unstyled d-flex justify-content-center justify-content-md-start">
                    <li class="me-3">
                        <?= Html::a('<i class="bi bi-facebook"></i> Facebook', 'https://facebook.com', ['class' => 'text-light', 'target' => '_blank']) ?>
                    </li>
                    <li class="me-3">
                        <?= Html::a('<i class="bi bi-instagram"></i> Instagram', 'https://instagram.com', ['class' => 'text-light', 'target' => '_blank']) ?>
                    </li>
                    <li class="me-3">
                        <?= Html::a('<i class="bi bi-x"></i> X', 'https://x.com', ['class' => 'text-light', 'target' => '_blank']) ?>
                    </li>
                    <li class="me-3">
                        <?= Html::a('<i class="bi bi-tiktok"></i> TikTok', 'https://tiktok.com', ['class' => 'text-light', 'target' => '_blank']) ?>
                    </li>
                </ul>
            </div>

            <!-- Patrocinadores -->
            <div class="col-md-6 text-center text-md-end">
                <h5 class="text-white">Patrocinado por:</h5>
                <?= Html::a(Html::img('@web/img/usal.jpg', ['alt' => 'USAL', 'class' => 'usal-logo']), 'https://politecnicazamora.usal.es', ['target' => '_blank']) ?>
            </div>
        </div>

        <div class="row text-light mt-4">
            <!-- Información adicional -->
            <div class="col-md-6 text-center text-md-start">
                <p>&copy; Comparador de precios y grupo X</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p>Comparador de precios - grupo X</p>
            </div>
        </div>
    </div>
</div>

