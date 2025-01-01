<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Usuario;
use app\models\Regiones;
use yii\web\BadRequestHttpException;

class RegistrosController extends Controller
{
    public function actionRegister()
    {
        $model = new Usuario();

        // Obtenemos todas las regiones de nivel superior (continentes, por ejemplo)
        $regionesPadre = Regiones::find()->where(['region_padre_id' => null])->all();
        $regionesProvincia = []; // Por defecto, no hay provincias seleccionadas.
        $regionesPais = [];
        $regionesEstado = [];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Te has registrado correctamente. Para poder usar tu cuenta deberá activarla un moderador.');
                return $this->redirect(['site/login']);
            }
        }

        // Obtenemos las subregiones si se pasa un region_id en el POST
        if ($model->region_id) {
            $selectedRegion = Regiones::findOne($model->region_id);
            if ($selectedRegion) {
                if ($selectedRegion->region_padre_id == 1) {
                    $regionesPais = Regiones::find()->where(['region_padre_id' => $selectedRegion->id])->all();
                }
                if ($selectedRegion->region_padre_id == 24) {
                    $regionesEstado = Regiones::find()->where(['region_padre_id' => $selectedRegion->id])->all();
                }
            }
        }

        return $this->render('registro', [
            'model' => $model,
            'regionesPadre' => $regionesPadre,
            'regionesProvincia' => $regionesProvincia,
            'regionesPais' => $regionesPais,
            'regionesEstado' => $regionesEstado,
        ]);
    }
}
?>