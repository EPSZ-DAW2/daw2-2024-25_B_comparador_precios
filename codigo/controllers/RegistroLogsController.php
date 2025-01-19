<?php

namespace app\controllers;

use Yii;
use app\models\RegistroLogs;
use app\models\RegistroLogsSearch;
use app\models\Usuario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RegistroLogsController implementa las acciones CRUD para el modelo RegistroLogs.
 */
class RegistroLogsController extends Controller
{
    /**
     * Define el comportamiento de control de acceso para el controlador.
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Permitir acceso solo a usuarios autenticados
                        'matchCallback' => function ($rule, $action) {
                            // Comprobar si el usuario tiene el rol de administrador o superadministrador
                            return Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR) || 
                                   Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR);
                        },
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('No tienes permiso para acceder a esta página.');
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'], // La acción delete solo puede ser invocada mediante POST
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
     * Actualiza un modelo existente de RegistroLogs.
     * Si la actualización es exitosa, el navegador será redirigido a la página 'view'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'El registro de log se ha actualizado correctamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Crea un nuevo modelo de RegistroLogs.
     * Si la creación es exitosa, el navegador será redirigido a la página 'view'.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegistroLogs();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'El nuevo registro de log se ha creado correctamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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
