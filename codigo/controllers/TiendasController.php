<?php

namespace app\controllers;

use app\models\Tienda;
use app\models\Articulo;
use app\models\Categorias;
use app\models\ArticulosTienda;
use app\models\Etiquetas;
use app\models\Historico;
use app\models\RegistroUsuarios;
use app\models\Ofertas;
use app\models\Comentario;
use app\models\TiendasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TiendasController implements the CRUD actions for Tienda model.
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
     * Lists all Tienda models.
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
     * Displays a single Tienda model.
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
     * Creates a new Tienda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Tienda();

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
     * Updates an existing Tienda model.
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
     * Deletes an existing Tienda model.
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
     * Finds the Tienda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tienda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tienda::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
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
        $categoria = Categorias::findOne(['id' => $DatosArticulos['categoria_id']]); 
        $etiqueta =  Etiquetas::findOne( ['id' => $DatosArticulos['etiqueta_id']]);
        // Busca si el artículo ya existe en los artículos comunes
        $comun = Articulo::findOne(['id' => $DatosArticulos['id'], 'tipo_marcado' => 'comun']);
        if ($comun) {
            // Si el artículo común existe, crea una relación con la tienda
            $ArticuloTienda = new ArticulosTienda();
            $historico = new Historico();
            $ArticuloTienda->tienda_id = $Tienda_id;
            $ArticuloTienda->articulo_id = $comun->id;
            $ArticuloTienda->precio = $DatosArticulos['precio'];
            $historico->tienda_id = $Tienda_id;
            $historico->articulo_id = $comun->id;
            $historico->precio = $DatosArticulos['precio'];
            $historico->fecha = date('Y-m-d H:i:s');
            $historico->save();
            
        } else {
            // Si el artículo no existe, crea un nuevo artículo específico para la tienda
            $Articulo = new Articulo();
            $registro = new RegistroUsuarios();
            $Articulo->nombre = $DatosArticulos['nombre'];
            $Articulo->descripcion = $DatosArticulos['descripcion'];
            $Articulo->categoria_id = $categoria->id;
            $Articulo->etiqueta_id = $etiqueta->id;
            $Articulo->imagen_ppal = $DatosArticulos['imagen_ppal'];
            $Articulo->visible = 1;
            $Articulo->cerrado = 0;
            $Articulo->tipo_marcado = 'particular'; // Es un artículo particular de la tienda
            $Articulo->registro_id = Yii::$app->user->id;
            $registro->fecha_creacion = date('Y-m-d H:i:s');
            $registro->creador_id = Yii::$app->user->id;
            $registro->notas_admin = 'Artículo creado por el usuario';
            $registro->save();
            

            if ($Articulo->save()) {
                $ArticuloTienda = new ArticulosTienda();
                $historico = new Historico();
                $ArticuloTienda->tienda_id = $Tienda_id;
                $ArticuloTienda->articulo_id = $Articulo->id;
                $ArticuloTienda->precio = $DatosArticulos['precio'];
                $Articulo->Articulo_tienda_id= $ArticuloTienda->id;
                $historico->tienda_id = $Tienda_id;
                $historico->articulo_id = $Articulo->id;
                $historico->precio = $DatosArticulos['precio'];
                $historico->fecha = date('Y-m-d H:i:s');
                $Articulo->save();
                $historico->save();
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

    public function actionModificarArticulo($Tienda_id, $Articulo_id, $DatosArticulos)
    {
        // Busca la relación del artículo con la tienda
        $ArticuloTienda = ArticulosTienda::findOne(['tienda_id' => $Tienda_id, 'articulo_id' => $Articulo_id]);
        if (!$ArticuloTienda) {
            throw new NotFoundHttpException('El artículo no existe en esta tienda.');
        }
        $categoria = Categorias::findOne( $DatosArticulos['categoria_id']); 
        $etiqueta =  Etiquetas::findOne( $DatosArticulos['etiqueta_id']);

        // Verifica si el artículo es común
        $Articulo = Articulo::findOne($Articulo_id);
        $historico = new Historico();
        if ($Articulo->tipo_marcado == 'comun') {
            // Solo permite la modificación del precio para artículos comunes
            $ArticuloTienda->precio = $DatosArticulos['precio'];
            $historico->tienda_id = $Tienda_id;
            $historico->articulo_id = $Articulo->id;
            $historico->precio = $ArticuloTienda->precio;
            $historico->fecha = date('Y-m-d H:i:s');
            $historico->save();

        } else {
            // Permite la modificación completa para artículos específicos de la tienda
            $Articulo->nombre = $DatosArticulos['nombre'];
            $Articulo->descripcion = $DatosArticulos['descripcion'];
            $Articulo->categoria_id = $categoria->id;
            $Articulo->etiqueta_id = $etiqueta->id;
            $Articulo->imagen_ppal = $DatosArticulos['imagen_ppal'];

            if (!$Articulo->save()) {
                Yii::$app->session->setFlash('error', 'Ha habido un error al modificar el artículo.');
                return $this->redirect(['view-store', 'id' => $Tienda_id]);
            }
        }

        // Guarda los cambios en la relación del artículo con la tienda
        if ($ArticuloTienda->save()) {
            Yii::$app->session->setFlash('success', 'Artículo modificado con éxito.');
        } else {
            Yii::$app->session->setFlash('error', 'Ha habido un error.');
        }

        return $this->redirect(['view-store', 'id' => $Tienda_id]);
    }

    /**
     * Deletes or unlinks an article from the store.
     * If the article has price history, it will be hidden instead of deleted.
     * @param int $Tienda_id
     * @param int $Articulo_id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEliminarArticulo($Tienda_id, $Articulo_id)
    {
        // Busca la relación del artículo con la tienda
        $ArticuloTienda = ArticulosTienda::findOne(['tienda_id' => $Tienda_id, 'articulo_id' => $Articulo_id]);
        if (!$ArticuloTienda) {
            throw new NotFoundHttpException('El artículo no existe en esta tienda.');
        }

        $historico = Historico::find()->where(['tienda_id' => $Tienda_id, 'articulo_id' => $Articulo_id])->all();

        if(!$historico){
            throw new NotFoundHttpException('El artículo no tiene historico de precios para esta tienda.');
        }
        // Verifica si el artículo tiene histórico de precios
        if ($historico) {
            $ArticuloTienda->visible = 0; // Oculta el artículo
            $message = 'Artículo ocultado con éxito.';
        } else {
            // Verifica si el artículo es común
            $Articulo = Articulo::findOne($Articulo_id);
            if ($Articulo->tipo_marcado == 'comun') {
                // Desvincula el artículo común de la tienda
                $ArticuloTienda->delete();
                $message = 'Artículo desvinculado con éxito.';
            } else {
                // Elimina el artículo particular de la tienda
                $ArticuloTienda->delete();
                $Articulo->delete();
                $Articulo->save();
                $message = 'Artículo eliminado con éxito.';
            }
        }

        // Guarda los cambios
        if ($ArticuloTienda->save()) {
            Yii::$app->session->setFlash('success', $message);
        } else {
            Yii::$app->session->setFlash('error', 'Ha habido un error.');
        }

        return $this->redirect(['view-store', 'id' => $Tienda_id]);

    }

    /**
     * Displays the price history of a specific article in a store.
     * @param int $Tienda_id
     * @param int $Articulo_id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionVerHistorico($Tienda_id, $Articulo_id)
    {
        $historico = Historico::find()->where(['tienda_id' => $Tienda_id, 'articulo_id' => $Articulo_id])->all();

        if (!$historico) {
            throw new NotFoundHttpException('No se ha encontrado el histórico de precios para este artículo en esta tienda.');
        }

        return $this->render('ver-historico', [
            'historico' => $historico,
        ]);
    }

    
}

