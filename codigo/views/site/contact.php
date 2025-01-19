<?php
use yii\helpers\Html;

$this->title = 'Contacto';
?>

<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Si necesitas ponerte en contacto con nosotros, aquí tienes nuestros datos de contacto:</p>
    <ul>
        <li>
            <strong>Teléfono:</strong> 
            <?= Html::a('+34 123 456 789', 'tel:+34123456789', ['class' => 'text-dark']) ?>
        </li>
        <li>
            <strong>Email:</strong> 
            <?= Html::mailto('contacto@comparadorprecios.com', 'contacto@comparadorprecios.com', ['class' => 'text-dark']) ?>
        </li>
        <li>
            <strong>Dirección:</strong> 
            <?= Html::encode('Campus Viriato, Zamora, España') ?>
        </li>
        <li>
            <strong>Más información:</strong> 
            <?= Html::a('Politécnica Zamora (USAL)', 'https://politecnicazamora.usal.es', ['class' => 'text-dark', 'target' => '_blank']) ?>
        </li>
    </ul>
    <p>Estamos disponibles de lunes a viernes de 9:00 a 18:00. ¡No dudes en comunicarte con nosotros para cualquier consulta o sugerencia!</p>
</div>
