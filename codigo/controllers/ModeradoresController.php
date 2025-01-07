<?php

namespace app\controllers;

use app\models\Moderador;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;

/**
 * Controlador para que un moderador gestione su propio perfil.
 */
class ModeradoresController extends Controller
{
    /**
     * Configuración de permisos.
     * Solo los usuarios autenticados pueden acceder a las acciones de este controlador.
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Solo usuarios autenticados
                    ],
                ],
            ],
        ];
    }

    /**
     * Muestra una vista general con el perfil del moderador en un formato de lista.
     */
    public function actionIndex()
    {
        $model = $this->findModelByUsuario();

        // Creamos un ArrayDataProvider para pasar el modelo como una lista
        $dataProvider = new ArrayDataProvider([
            'allModels' => [$model], // Pasamos el modelo como un array
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra los detalles completos del perfil del moderador logueado.
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Permite al moderador actualizar su propio perfil.
     */
    public function actionUpdate()
    {
        $model = $this->findModelByUsuario();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Perfil actualizado con éxito.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Permite al moderador solicitar su baja.
     */
    public function actionBaja()
    {
        $model = $this->findModelByUsuario();

        if (Yii::$app->request->post()) {
            $model->baja_solicitada = true;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Solicitud de baja enviada correctamente.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('baja', [
            'model' => $model,
        ]);
    }

    /**
     * Busca el modelo del moderador asociado al usuario autenticado.
     */
    protected function findModelByUsuario()
    {
        $usuarioId = Yii::$app->user->id;

        if (($model = Moderador::findOne(['usuario_id' => $usuarioId])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('No se encontró el perfil del moderador.');
    }

    /**
     * Busca el modelo del moderador por su ID.
     */
    protected function findModel($id)
    {
        if (($model = Moderador::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('No se encontró el perfil del moderador.');
    }
}

