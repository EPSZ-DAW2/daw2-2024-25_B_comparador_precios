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
use app\models\Dueno;
use app\models\Usuario;
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
     * @return \yii\web\Response
     */
    public function actionCrearArticulo($Tienda_id)
    {
        $model = new Articulo();
        $categorias = Categorias::find()->all();
        $etiquetas = Etiquetas::find()->all();
    
        if ($model->load(Yii::$app->request->post())) {
            $DatosArticulos = Yii::$app->request->post('Articulo');
            $categoria = Categorias::findOne(['id' => $DatosArticulos['categoria_id']]); 
            $etiqueta = Etiquetas::findOne(['id' => $DatosArticulos['etiqueta_id']]);
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
                    $Articulo->Articulo_tienda_id = $ArticuloTienda->id;
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
    
        return $this->render('crear-articulo', [
            'model' => $model,
            'categorias' => $categorias,
            'etiquetas' => $etiquetas,
        ]);
    }

    public function actionModificarArticulo($Tienda_id)
    {
        // Obtiene todos los artículos de la tienda
        $articulosTienda = ArticulosTienda::find()->where(['tienda_id' => $Tienda_id])->all();
        $articulos = ArrayHelper::map($articulosTienda, 'articulo_id', function($model) {
            return $model->articulo->nombre; // Asumiendo que hay una relación 'articulo' en ArticulosTienda
        });
    
        $categorias = Categorias::find()->all();
        $categorias = ArrayHelper::map($categorias, 'id', 'nombre');
        $etiquetas = Etiquetas::find()->all();
        $etiquetas = ArrayHelper::map($etiquetas, 'id', 'nombre');
    
        if (Yii::$app->request->post()) {
            $Articulo_id = Yii::$app->request->post('Articulo')['id'];
            $ArticuloTienda = ArticulosTienda::findOne(['tienda_id' => $Tienda_id, 'articulo_id' => $Articulo_id]);
            if (!$ArticuloTienda) {
                throw new NotFoundHttpException('El artículo no existe en esta tienda.');
            }
    
            $model = Articulo::findOne($Articulo_id);
            if ($model->load(Yii::$app->request->post())) {
                $DatosArticulos = Yii::$app->request->post('Articulo');
                $categoria = Categorias::findOne(['id' => $DatosArticulos['categoria_id']]);
                $etiqueta = Etiquetas::findOne(['id' => $DatosArticulos['etiqueta_id']]);
                $historico = new Historico();
    
                // Aquí puedes agregar la lógica para actualizar el artículo y guardar el histórico
    
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Artículo modificado con éxito.');
                    return $this->redirect(['view-store', 'id' => $Tienda_id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Ha habido un error al modificar el artículo.');
                }
            }
        } else {
            $model = new Articulo();
        }
    
        return $this->render('modificar-articulo', [
            'model' => $model,
            'articulos' => $articulos,
            'categorias' => $categorias,
            'etiquetas' => $etiquetas,
        ]);
    }
    /**
     * Deletes or unlinks an article from the store.
     * If the article has price history, it will be hidden instead of deleted.
     * @param int $Tienda_id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEliminarArticulo($Tienda_id)
{
    // Obtiene todos los artículos de la tienda
    $articulosTienda = ArticulosTienda::find()->where(['tienda_id' => $Tienda_id])->all();
    $articulos = ArrayHelper::map($articulosTienda, 'articulo_id', function($model) {
        return $model->articulo->nombre; // Asumiendo que hay una relación 'articulo' en ArticulosTienda
    });
    if (Yii::$app->request->post()) {
        $Articulo_id = Yii::$app->request->post('Articulo')['id'];
        $ArticuloTienda = ArticulosTienda::findOne(['tienda_id' => $Tienda_id, 'articulo_id' => $Articulo_id]);
        if (!$ArticuloTienda) {
            throw new NotFoundHttpException('El artículo no existe en esta tienda.');
        }

        $Articulo = Articulo::findOne($Articulo_id);
        $historico = Historico::find()->where(['tienda_id' => $Tienda_id, 'articulo_id' => $Articulo_id])->all();

        if (!$historico) {
            throw new NotFoundHttpException('El artículo no tiene historico de precios para esta tienda.');
        }

        // Verifica si el artículo tiene histórico de precios
        if ($historico) {
            $ArticuloTienda->visible = 0; // Oculta el artículo
            $ArticuloTienda->save();
            Yii::$app->session->setFlash('success', 'Artículo ocultado con éxito.');
        } else {
            // Verifica si el artículo es común
            if ($Articulo->tipo_marcado == 'comun') {
                // Desvincula el artículo común de la tienda
                $ArticuloTienda->delete();
                Yii::$app->session->setFlash('success', 'Artículo desvinculado con éxito.');
            } else {
                // Elimina el artículo particular de la tienda
                $ArticuloTienda->delete();
                $Articulo->delete();
                Yii::$app->session->setFlash('success', 'Artículo eliminado con éxito.');
            }
        }

        return $this->redirect(['view-store', 'id' => $Tienda_id]);
    }

    return $this->render('eliminar-articulo', [
        'articulos' => $articulos,
    ]);
}
   /**
 * Displays the price history of a specific article in a store.
 * @param int $Tienda_id
 * @return string
 * @throws NotFoundHttpException if the model cannot be found
 */
public function actionVerHistorico($Tienda_id, $Articulo_id)
{
    // Obtiene todos los artículos de la tienda
    $articulosTienda = ArticulosTienda::find()->where(['tienda_id' => $Tienda_id])->all();
    $articulos = ArrayHelper::map($articulosTienda, 'articulo_id', function($model) {
        return $model->articulo->nombre; // Asumiendo que hay una relación 'articulo' en ArticulosTienda
    });

    // Obtiene el histórico de precios del artículo en la tienda
    $historico = Historico::find()->where(['tienda_id' => $Tienda_id, 'articulo_id' => $Articulo_id])->all();

    if (!$historico) {
        throw new NotFoundHttpException('No se ha encontrado el histórico de precios para este artículo en esta tienda.');
    }

    return $this->render('ver-historico', [
        'historico' => $historico,
        'articulos' => $articulos,
        'selectedArticulo' => $Articulo_id,
    ]);
}

    public function actionVerTiendasActivas()
    {
        $tiendas = Tienda::find()->where(['visible' => 1])->all();

        return $this->render('ver-tiendas-activas', [
            'tiendas' => $tiendas,
        ]);
    }
    
    public function actionViewStore($id)
    {
        $model = Tienda::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('La tienda no existe.');
        }

        return $this->render('view-store', [
            'model' => $model,
        ]);
    }

    public function actionCrearOferta($Tienda_id)
    {
        $oferta = new Ofertas();
        $articulosTienda = ArticulosTienda::find()->where(['tienda_id' => $Tienda_id])->all();
        $articulos = ArrayHelper::map($articulosTienda, 'articulo_id', function($model) {
            return $model->articulo->nombre; // Asumiendo que hay una relación 'articulo' en ArticulosTienda
        });
    
        if (Yii::$app->request->post()) {
            $Articulo_id = Yii::$app->request->post('Ofertas')['id'];
            $articulo = ArticulosTienda::findOne(['tienda_id' => $Tienda_id, 'articulo_id' => $Articulo_id]);
    
            if (!$articulo) {
                throw new NotFoundHttpException('El artículo no está asociado a esta tienda.');
            }
    
            if ($oferta->load(Yii::$app->request->post())) {
                $oferta->articulo_id = $Articulo_id;
                $oferta->tienda_id = $Tienda_id;
                $oferta->precio_oferta = Yii::$app->request->post('Ofertas')['precio_oferta'];
                $oferta->fecha_inicio = Yii::$app->request->post('Ofertas')['fecha_inicio'];
                $oferta->fecha_fin = Yii::$app->request->post('Ofertas')['fecha_fin'];
                $oferta->precio_og = $articulo->precio; // Precio original del artículo en la tienda
                $oferta->registro_id = Yii::$app->user->id; // Usuario que creó la oferta
    
                if ($oferta->save()) {
                    // Registrar el histórico
                    $historico = new Historico();
                    $historico->tienda_id = $Tienda_id;
                    $historico->articulo_id = $Articulo_id;
                    $historico->precio = $oferta->precio_oferta;
                    $historico->fecha = date('Y-m-d H:i:s');
                    $historico->save();
    
                    Yii::$app->session->setFlash('success', 'Oferta creada con éxito.');
                    return $this->redirect(['view-store', 'id' => $Tienda_id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Ha habido un error al crear la oferta.');
                }
            }
        }
    
        return $this->render('crear-oferta', [
            'model' => $oferta,
            'articulos' => $articulos,
        ]);
    }

/**
 * Updates an existing offer for a specific article in the store.
 * @param int $Tienda_id
 * @return \yii\web\Response
 */
public function actionModificarOferta($Tienda_id)
{
    $ofertas = Ofertas::find()->where(['tienda_id' => $Tienda_id])->all();
    $ofertasList = ArrayHelper::map($ofertas, 'id', function($model) {
        return $model->articulo->nombre . ' - ' . $model->precio_oferta; // Asumiendo que hay una relación 'articulo' en Ofertas
    });

    $ofertaSeleccionada = null;

    if (Yii::$app->request->post('oferta_id')) {
        $ofertaSeleccionada = Ofertas::findOne(Yii::$app->request->post('oferta_id'));

        if (!$ofertaSeleccionada) {
            throw new NotFoundHttpException('La oferta no existe.');
        }

        if ($ofertaSeleccionada->load(Yii::$app->request->post()) && $ofertaSeleccionada->save()) {
            // Registrar el histórico si se actualizó el precio de oferta
            if (Yii::$app->request->post('Ofertas')['precio_oferta'] !== null) {
                $historico = new Historico();
                $historico->tienda_id = $Tienda_id;
                $historico->articulo_id = $ofertaSeleccionada->articulo_id;
                $historico->precio = $ofertaSeleccionada->precio_oferta;
                $historico->fecha = date('Y-m-d H:i:s');
                $historico->save();
            }

            Yii::$app->session->setFlash('success', 'Oferta modificada con éxito.');
            return $this->redirect(['view-store', 'id' => $Tienda_id]);
        } else {
            Yii::$app->session->setFlash('error', 'Ha habido un error al modificar la oferta.');
        }
    }

    return $this->render('modificar-oferta', [
        'ofertasList' => $ofertasList,
        'ofertaSeleccionada' => $ofertaSeleccionada,
    ]);
}

/**
 * Deletes an offer for a specific article in the store.
 * @param int $Tienda_id
 * @return \yii\web\Response
 * @throws NotFoundHttpException if the offer cannot be found
 */
public function actionEliminarOferta($Tienda_id)
{
    $ofertas = Ofertas::find()->where(['tienda_id' => $Tienda_id])->all();
    $ofertasList = ArrayHelper::map($ofertas, 'id', function($model) {
        return $model->articulo->nombre . ' - ' . $model->precio_oferta;
    });

    if (Yii::$app->request->post('oferta_id')) {
        $ofertaSeleccionada = Ofertas::findOne(Yii::$app->request->post('oferta_id'));

        if (!$ofertaSeleccionada) {
            throw new NotFoundHttpException('La oferta no existe.');
        }

        if ($ofertaSeleccionada->delete()) {
            Yii::$app->session->setFlash('success', 'Oferta eliminada con éxito.');
        } else {
            Yii::$app->session->setFlash('error', 'Ha habido un error al eliminar la oferta.');
        }

        return $this->redirect(['view-store', 'id' => $Tienda_id]);
    }

    return $this->render('eliminar-oferta', [
        'ofertasList' => $ofertasList,
    ]);
}

    
}

