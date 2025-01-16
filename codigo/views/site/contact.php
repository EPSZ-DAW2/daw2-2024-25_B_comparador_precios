<?php

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Contacto';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Si tienes preguntas, comentarios o necesitas ayuda, no dudes en ponerte en contacto con nosotros. Completa el formulario a continuación y te responderemos lo antes posible.
    </p>

    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label('Nombre') ?>

                <?= $form->field($model, 'email')->input('email')->label('Correo Electrónico') ?>

                <?= $form->field($model, 'subject')->textInput()->label('Asunto') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6])->label('Mensaje') ?>

                <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::class, [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ])->label('Verificación') ?>

                <div class="form-group">
                    <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-lg-6">
            <h2>Información de Contacto</h2>
            <p>
                Puedes también contactarnos directamente por los siguientes medios:
            </p>
            <ul>
                <li><strong>Correo Electrónico:</strong> soporte@vamar.com</li>
                <li><strong>Teléfono:</strong> +34 123 456 789</li>
                <li><strong>Dirección:</strong> Calle Comparador, 123, 28001 Madrid, España</li>
            </ul>

            <h3>Síguenos en Redes Sociales</h3>
            <p>
                Mantente al día con las últimas noticias y ofertas siguiendo nuestras cuentas:
            </p>
            <ul>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>
        </div>
    </div>
</div>
