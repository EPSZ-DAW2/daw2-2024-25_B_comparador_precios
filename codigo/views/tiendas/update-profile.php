<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var  yii\web\View $this*/
/**  @var  app\models\Tienda $model*/
/**  @var  yii\widgets\ActiveForm $form*/

$this->title = 'Update Profile: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Tiendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view-profile', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update Profile';
?>
<div class="tiendas-update-profile">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="tiendas-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'Url')->textInput(['maxlength' => true]) ?>
        <!-- Add other profile fields as needed -->

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
