<?php

namespace app\controllers;

use Yii;
use app\models\Historico;
use app\models\HistoricoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Usuario;

/**
 * HistoricoController implements the CRUD actions for Historico model.
 */
class HistoricoController extends Controller
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
     * Lists all Historico models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new HistoricoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Historico model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Historico model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Historico();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Historico model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Historico model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Historico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Historico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Historico::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Limpia todos los registros de la tabla `historico_precios`.
     * Esta acción elimina todos los históricos de la base de datos y redirige al usuario a la página de índice
     * con un mensaje de confirmación.
     * 
     * @return \yii\web\Response
     */
    public function actionLimpiezaHistoricos()
    {
        // Eliminar todos los registros de la tabla historico_precios
        Historico::deleteAll();

        // Redirigir a la página de índice con un mensaje de éxito
        Yii::$app->session->setFlash('success', 'Todos los históricos han sido eliminados.');
        return $this->redirect(['index']);
    }

}
