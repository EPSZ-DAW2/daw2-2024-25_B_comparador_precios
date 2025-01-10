<?php

use app\models\Usuario;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Usuarios de mi Región');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-region-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Usuario'), ['crear-usuario'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'email:email',
            'nick',
            'nombre',
            'telefono',
            'registro_confirmado:boolean',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Usuario $model, $key, $index, $column) {
                    $customActions = [
                        'view' => 'ver-usuario',
                        'update' => 'editar-usuario',
                        'delete' => 'eliminar-usuario',
                    ];
                    return Url::toRoute([$customActions[$action], 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete}', // Botones a mostrar
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
