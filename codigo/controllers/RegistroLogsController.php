<?php

namespace app\controllers;

use Yii;
use app\models\RegistroLogs;
use app\models\RegistroLogsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegistroLogsController implementa las acciones CRUD para el modelo RegistroLogs.
 */
class RegistroLogsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lista todos los modelos de RegistroLogs.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegistroLogsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un único modelo de RegistroLogs.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Elimina un modelo existente de RegistroLogs.
     * Si la eliminación es exitosa, el navegador será redirigido a la página 'index'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Elimina todos los modelos de RegistroLogs.
     * @return mixed
     */
    public function actionDeleteAll()
    {
        RegistroLogs::deleteAll();
        Yii::$app->session->setFlash('success', 'Todos los registros de logs han sido eliminados.');
        return $this->redirect(['index']);
    }

    /**
     * Encuentra el modelo RegistroLogs basado en su valor de clave primaria.
     * Si no se encuentra el modelo, se lanzará una excepción HTTP 404.
     * @param integer $id
     * @return RegistroLogs el modelo cargado
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    protected function findModel($id)
    {
        if (($model = RegistroLogs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
