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

            <!-- Mapa o enlace de Google Maps -->
            <div class="col-md-4 text-center mb-3">
                <h5 class="text-white">Visítanos</h5>
                <p class="text-light">
                    <!-- Enlace a Google Maps -->
                    <?= Html::a(
                        'Campus Viriato, Zamora (Google Maps)', 
                        'https://www.google.es/maps/search/campus+viriato+zamora/@41.5130966,-5.7371131,17z/data=!3m1!4b1?hl=es&entry=ttu&g_ep=EgoyMDI1MDExNS4wIKXMDSoASAFQAw%3D%3D', 
                        ['class' => 'text-light', 'target' => '_blank']
                    ) ?>
                </p>
                <!-- Google Maps iframe para Campus Viriato -->
                <iframe 
                    class="google-maps-iframe"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2993.935801234193!2d-5.746570884228013!3d41.509038979253926!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd390733c9e928cf%3A0x77b5a4a1b5a4d48f!2sCampus%20Viriato%2C%20Zamora!5e0!3m2!1ses!2ses!4v1691234567890!5m2!1ses!2ses" 
                    width="300" 
                    height="200" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
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
