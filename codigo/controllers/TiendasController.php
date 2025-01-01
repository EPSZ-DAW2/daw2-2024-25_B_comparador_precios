<?php

namespace app\controllers;

use app\models\Tiendas;
use app\models\Articulo;
use app\models\ArticulosTienda;
use app\models\TiendasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TiendasController implements the CRUD actions for Tiendas model.
 */
class TiendasController extends Controller
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
     * Lists all Tiendas models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TiendasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tiendas model.
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
     * Creates a new Tiendas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Tiendas();

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
     * Updates an existing Tiendas model.
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
     * Deletes an existing Tiendas model.
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
     * Finds the Tiendas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tiendas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tiendas::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
 * Displays the profile of the Tiendas model.
 * @param int $id ID
 * @return mixed
 * @throws NotFoundHttpException if the model cannot be found
 */
public function actionViewProfile($id)
{
    return $this->render('view-profile', [
        'model' => $this->findModel($id),
    ]);
}

/**
 * Updates the profile of an existing Tiendas model.
 * If update is successful, the browser will be redirected to the 'view-profile' page.
 * @param int $id ID
 * @return mixed
 * @throws NotFoundHttpException if the model cannot be found
 */
public function actionUpdateProfile($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view-profile', 'id' => $model->id]);
    }

    return $this->render('update-profile', [
        'model' => $model,
    ]);
}

/**
 * Requests the deletion of the Tiendas profile by marking it as hidden.
 * If request is successful, the browser will be redirected to the 'index' page.
 * @param int $id ID
 * @return \yii\web\Response
 * @throws NotFoundHttpException if the model cannot be found
 */
public function actionDarDeBaja($id)
{
    $model = $this->findModel($id);
    $model->visible = 0; 

    if ($model->save()) {
        Yii::$app->session->setFlash('success', 'perfil ocultado.');
    } else {
        Yii::$app->session->setFlash('error', 'Tha habido un error.');
    }

    return $this->redirect(['view-profile', 'id' => $model->id]);
}

/**
 * Activates the Tiendas profile by marking it as visible.
 * If activation is successful, the browser will be redirected to the 'index' page.
 * @param int $id ID
 * @return \yii\web\Response
 * @throws NotFoundHttpException if the model cannot be found
 */
public function actionDarDeAlta($id)
{
    $model = $this->findModel($id);
    $model->visible = 1; // Assuming 1 means visible and 0 means hidden

    if ($model->save()) {
        Yii::$app->session->setFlash('success', 'Perfil activado.');
    } else {
        Yii::$app->session->setFlash('error', 'Ha habido un error.');
    }

    return $this->redirect(['view-profile', 'id' => $model->id]);
}

/**
 * Creates a new article for the store if it doesn't exist in the common articles.
 * If it exists, links the article with the store.
 * @param int $Tienda_id
 * @param array $DatosArticulos
 * @return \yii\web\Response
 */
public function actionCrearArticulo($Tienda_id, $DatosArticulos)
{
    // Busca si el artículo ya existe en los artículos comunes
    $comun = Articulo::findOne(['id' => $DatosArticulos['id'], 'tipo_marcado' => 'comun']);
    if ($comun) {
        // Si el artículo común existe, crea una relación con la tienda
        $ArticuloTienda = new ArticulosTienda();
        $ArticuloTienda->tienda_id = $Tienda_id;
        $ArticuloTienda->articulo_id = $comun->id;
        $ArticuloTienda->precio = $DatosArticulos['precio'];
    } else {
        // Si el artículo no existe, crea un nuevo artículo específico para la tienda
        $Articulo = new Articulo();
        $Articulo->nombre = $DatosArticulos['nombre'];
        $Articulo->descripcion = $DatosArticulos['descripcion'];
        $Articulo->categoria_id = $DatosArticulos['categoria_id'];
        $Articulo->etiqueta_id = $DatosArticulos['etiqueta_id'];
        $Articulo->imagen_ppal = $DatosArticulos['imagen_ppal'];
        $Articulo->visible = 1;
        $Articulo->cerrado = 0;
        $Articulo->tipo_marcado = 'particular'; // Es un artículo particular de la tienda
        $Articulo->registro_id = Yii::$app->user->id;

        if ($Articulo->save()) {
            $ArticuloTienda = new ArticulosTienda();
            $ArticuloTienda->tienda_id = $Tienda_id;
            $ArticuloTienda->articulo_id = $Articulo->id;
            $ArticuloTienda->precio = $DatosArticulos['precio'];
        } else {
            Yii::$app->session->setFlash('error', 'Ha habido un error al crear el artículo.');
            return $this->redirect(['view-store', 'id' => $Tienda_id]);
        }
    }

    // Guarda la relación del artículo con la tienda
    if ($ArticuloTienda->save()) {
        Yii::$app->session->setFlash('success', 'Artículo creado o vinculado con éxito.');
    } else {
        Yii::$app->session->setFlash('error', 'Ha habido un error.');
    }

    return $this->redirect(['view-store', 'id' => $Tienda_id]);
}


}
