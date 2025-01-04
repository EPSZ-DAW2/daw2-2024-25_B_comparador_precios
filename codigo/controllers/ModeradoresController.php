<?php

namespace app\controllers;

use app\models\Moderador;
use app\models\Region;
use app\models\Tienda;
use app\models\Usuario;
use app\models\Incidencia;
use Yii; // Asegúrate de agregar esta línea
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * ModeradoresController gestiona las operaciones relacionadas con moderadores.
 */
class ModeradoresController extends Controller
{
    /**
     * Lista todos los moderadores.
     * @return string Vista renderizada
     */
    public function actionIndex()
    {
        $moderadores = Moderador::find()->all();
        return $this->render('index', [
            'moderadores' => $moderadores,
        ]);
    }

    /**
     * Muestra los detalles de un moderador específico.
     * @param int $id ID del moderador
     * @return string Vista renderizada
     * @throws NotFoundHttpException Si el modelo no existe
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Solicita la baja del perfil de moderador.
     * @param int $id ID del moderador
     * @return string
     */
    public function actionBaja($id)
    {
        $model = $this->findModel($id);
        if (\Yii::$app->request->post()) {
            // Aquí puedes marcar al moderador como "baja solicitada"
            // Requiere agregar un campo adicional en la tabla
            \Yii::$app->session->setFlash('success', 'Solicitud de baja realizada.');
            return $this->redirect(['index']);
        }

        return $this->render('baja', ['model' => $model]);
    }

    /**
     * Lista las tiendas de la región que modera.
     * @return string Vista renderizada
     */
    public function actionTiendas()
    {
        $moderador = Moderador::findOne(\Yii::$app->user->id);
        $tiendas = Tienda::find()->where(['region_id' => $moderador->region_id])->all();

        return $this->render('tiendas', ['tiendas' => $tiendas]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
             'model' => $model,
        ]);
    }


    /**
     * Encuentra el modelo basado en su ID.
     * @param int $id
     * @return Moderador el modelo cargado
     * @throws NotFoundHttpException si no se encuentra el modelo
     */
    protected function findModel($id)
    {
        if (($model = Moderador::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('El moderador solicitado no existe.');
    }
}
