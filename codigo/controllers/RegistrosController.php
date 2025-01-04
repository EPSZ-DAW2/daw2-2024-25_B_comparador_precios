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

        // Obtenemos todas las regiones de nivel superior (continentes)
        $regionesPadre = Regiones::find()->where(['region_padre_id' => null, 'clase' => 'C'])->all();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Procesamos las regiones, si no existen, las creamos
            $continente = $model->region_continente;
            $pais = $model->region_pais;
            $estado = $model->region_estado;
            $provincia = $model->region_provincia;

            // Encontrar o crear el continente
            $continenteRegion = Regiones::findOne(['id' => $continente, 'clase' => 'C']);
            if (!$continenteRegion) {
                throw new BadRequestHttpException("Continente no encontrado.");
            }

            // Encontrar o crear el país
            $paisRegion = Regiones::findOne(['nombre' => $pais, 'region_padre_id' => $continenteRegion->id, 'clase' => 'P']);
            if (!$paisRegion) {
                $paisRegion = new Regiones();
                $paisRegion->nombre = $pais;
                $paisRegion->clase = 'P';
                $paisRegion->region_padre_id = $continenteRegion->id;
                $paisRegion->save();
            }

            // Encontrar o crear el estado
            $estadoRegion = Regiones::findOne(['nombre' => $estado, 'region_padre_id' => $paisRegion->id, 'clase' => 'E']);
            if (!$estadoRegion) {
                $estadoRegion = new Regiones();
                $estadoRegion->nombre = $estado;
                $estadoRegion->clase = 'E';
                $estadoRegion->region_padre_id = $paisRegion->id;
                $estadoRegion->save();
            }

            // Encontrar o crear la provincia
            $provinciaRegion = Regiones::findOne(['nombre' => $provincia, 'region_padre_id' => $estadoRegion->id, 'clase' => 'PR']);
            if (!$provinciaRegion) {
                $provinciaRegion = new Regiones();
                $provinciaRegion->nombre = $provincia;
                $provinciaRegion->clase = 'PR';
                $provinciaRegion->region_padre_id = $estadoRegion->id;
                $provinciaRegion->save();
            }

            // Asignamos la provincia a la región_id del modelo Usuario
            $model->region_id = $provinciaRegion->id;

            // Guardamos el modelo de Usuario
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Te has registrado correctamente. Para poder usar tu cuenta deberá activarla un moderador.');
                return $this->redirect(['site/login']);
            }
        }

        return $this->render('registro', [
            'model' => $model,
            'regionesPadre' => $regionesPadre, // Pasamos los continentes a la vista
        ]);
    }
}


?>