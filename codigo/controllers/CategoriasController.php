<?php

namespace app\controllers;

use Yii;
use app\models\Categorias;
use app\models\CategoriasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Usuario;

class CategoriasController extends Controller
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
     * Lists all Categorias models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR) &&
            !Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR)) {
            throw new \yii\web\ForbiddenHttpException('No tienes permiso para realizar esta acción.');
        }
        
        $searchModel = new CategoriasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categorias model.
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
     * Creates a new Categorias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     * @throws \yii\web\ForbiddenHttpException if the user is not allowed
     */
    public function actionCreate()
    {
        if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR) &&
            !Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR)) {
            throw new \yii\web\ForbiddenHttpException('No tienes permiso para realizar esta acción.');
        }

        $model = new Categorias();

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
     * Updates an existing Categorias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\web\ForbiddenHttpException if the user is not allowed
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
     * Deletes an existing Categorias model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\web\ForbiddenHttpException if the user is not allowed
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
     * Finds the Categorias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Categorias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categorias::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Lists all Categorias models with specific view.
     *
     * @return string
     */
    public function actionIndexCategorias()
    {
        $searchModel = new CategoriasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index-categorias', [
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
    public function actionViewCategorias($id)
    {
        return $this->render('view-categorias', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewArticulo($id)
    {
        $categorias = Categorias::findOne($id);
        $articulos = $categorias->articulo; // Obtiene los artículos relacionados con la categoría.

        return $this->render('view-articulos', [
            'articulo' => $articulo,
            'categoria' => $categorias,
        ]);
    }
}
