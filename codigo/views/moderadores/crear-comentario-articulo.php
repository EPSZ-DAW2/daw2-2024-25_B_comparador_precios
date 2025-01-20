<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ArticulosTienda;

/** @var yii\web\View $this */
/** @var app\models\Comentario $comentario */
/** @var int $articuloId */

$this->title = 'Crear Comentario para Artículo';
?>
<div class="comentario-crear">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="comentario-form usuario-form"> <!-- Añadido 'usuario-form' para los estilos -->
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($comentario, 'articulo_id')->textInput(['value' => $articuloId, 'readonly' => true]) ?>

        <!-- Obtenemos el tiend_id a partir del articulo_id -->
        <?php
        // Obtén el objeto ArticulosTienda relacionado al articulo_id
        $articuloTienda = ArticulosTienda::findOne(['articulo_id' => $articuloId]);

        // Verifica si el articulo tiene una tienda asociada
        $tiendaId = $articuloTienda ? $articuloTienda->tienda_id : null;

        // Si se encuentra el tiend_id, agrégalo como campo oculto
        if ($tiendaId) {
            echo Html::activeHiddenInput($comentario, 'tienda_id', ['value' => $tiendaId]);
        }
        ?>

        <?= $form->field($comentario, 'valoracion')->textInput() ?>
        <?= $form->field($comentario, 'texto')->textarea(['rows' => 6]) ?>
        <?= $form->field($comentario, 'comentario_padre_id')->textInput() ?>
        <?= $form->field($comentario, 'cerrado')->checkbox() ?>
        <?= $form->field($comentario, 'denuncias')->textInput() ?>
        <?= $form->field($comentario, 'fecha_primera_denuncia')->textInput(['type' => 'datetime-local']) ?>
        <?= $form->field($comentario, 'motivo_denuncia')->textarea(['rows' => 3]) ?>
        <?= $form->field($comentario, 'bloqueado')->checkbox() ?>
        <?= $form->field($comentario, 'fecha_bloqueo')->textInput(['type' => 'datetime-local']) ?>
        <?= $form->field($comentario, 'motivo_bloqueo')->textarea(['rows' => 3]) ?>
        <?= $form->field($comentario, 'registro_id')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
