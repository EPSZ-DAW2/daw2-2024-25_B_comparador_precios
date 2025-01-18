<?php

namespace app\controllers;

use Yii;
use app\models\Etiquetas;
use app\models\EtiquetasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Usuario;

/**
 * EtiquetasController implements the CRUD actions for Etiquetas model.
 */
class EtiquetasController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Etiquetas models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR) &&
            !Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR)) {
            throw new \yii\web\ForbiddenHttpException('No tienes permiso para realizar esta acción.');
        }

        $searchModel = new EtiquetasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Etiquetas model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR) &&
            !Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR)) {
            throw new \yii\web\ForbiddenHttpException('No tienes permiso para realizar esta acción.');
        }
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Etiquetas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR) &&
            !Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR)) {
            throw new \yii\web\ForbiddenHttpException('No tienes permiso para realizar esta acción.');
        }

        $model = new Etiquetas();

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
     * Updates an existing Etiquetas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR) &&
            !Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR)) {
            throw new \yii\web\ForbiddenHttpException('No tienes permiso para realizar esta acción.');
        }

        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Etiquetas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR) &&
            !Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR)) {
            throw new \yii\web\ForbiddenHttpException('No tienes permiso para realizar esta acción.');
        }
        
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Etiquetas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Etiquetas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Etiquetas::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    /**
     * Lists all Categorias models with specific view.
     *
     * @return string
     */
    public function actionIndexEtiquetas()
    {
        $searchModel = new EtiquetasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index-etiquetas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categorias model with specific view.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewEtiquetas($id)
    {
        $model = $this->findModel($id);
        $articulos = $model->articulos; // Obtiene los artículos relacionados con la etiqueta.

        return $this->render('view-etiquetas', [
            'model' => $model,
            'articulos' => $articulos, // Pasa los artículos a la vista
        ]);
    }
}