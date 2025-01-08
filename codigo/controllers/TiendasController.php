<?php

namespace app\controllers;

use Yii;

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
use yii\helpers\ArrayHelper;
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
    $modelArticulosTienda = new ArticulosTienda();
    $model = new Articulo();
    $categorias = Categorias::find()->all();
    $etiquetas = Etiquetas::find()->all();
    
    // Convierte el array de objetos Categorias en un array de pares clave-valor
    $categoriasList = ArrayHelper::map($categorias, 'id', 'nombre');
    $etiquetasList = ArrayHelper::map($etiquetas, 'id', 'nombre');
    
    if ($model->load(Yii::$app->request->post()) && $modelArticulosTienda->load(Yii::$app->request->post())) {
        $DatosArticulos = Yii::$app->request->post('Articulo');
        
        if (isset($DatosArticulos['categoria_id']) && isset($DatosArticulos['etiqueta_id'])) {
            $categoria = Categorias::findOne(['id' => $DatosArticulos['categoria_id']]); 
            $etiqueta = Etiquetas::findOne(['id' => $DatosArticulos['etiqueta_id']]);
            
            // Busca si el artículo ya existe en los artículos comunes
            if (isset($DatosArticulos['id']) && !empty($DatosArticulos['id'])) {
                $comun = Articulo::findOne(['id' => $DatosArticulos['id'], 'tipo_marcado' => 'comun']);
                if ($comun) {
                    // Si el artículo común existe, crea una relación con la tienda
                    $ArticuloTienda = new ArticulosTienda();
                    $historico = new Historico();
                    $ArticuloTienda->tienda_id = $Tienda_id;
                    $ArticuloTienda->articulo_id = $comun->id;
                    if (isset($DatosArticulos['precio_actual'])) {
                        $ArticuloTienda->precio_actual = $DatosArticulos['precio_actual'];
                        $historico->precio = $DatosArticulos['precio_actual'];
                    } else {
                        $ArticuloTienda->precio_actual = 0; // o algún valor por defecto
                        $historico->precio = 0; // o algún valor por defecto
                    }
                    $historico->tienda_id = $Tienda_id;
                    $historico->articulo_id = $comun->id;
                    $historico->fecha = date('Y-m-d H:i:s');
                    $historico->save();
                    $ArticuloTienda->save();
                }
            } else {
                // Si el artículo no existe, crea un nuevo artículo específico para la tienda
                $Articulo = new Articulo();
                $Articulo->categoria_id = $categoria->id; // Asegúrate de usar una propiedad del objeto
                $Articulo->etiqueta_id = $etiqueta->id; // Asegúrate de usar una propiedad del objeto
                $Articulo->nombre = $DatosArticulos['nombre'];
                $Articulo->descripcion = $DatosArticulos['descripcion'];
                $Articulo->imagen_principal = $DatosArticulos['imagen_principal'];
                $Articulo->visible = $DatosArticulos['visible'];
                $Articulo->cerrado = $DatosArticulos['cerrado'];
                $Articulo->tipo_marcado = $DatosArticulos['tipo_marcado'];
                $Articulo->save();

                // Guarda el precio en ArticulosTienda
                $ArticuloTienda = new ArticulosTienda();
                $ArticuloTienda->tienda_id = $Tienda_id;
                $ArticuloTienda->articulo_id = $Articulo->id;
                if (isset($DatosArticulos['precio_actual'])) {
                    $ArticuloTienda->precio_actual = $DatosArticulos['precio_actual'];
                } else {
                    $ArticuloTienda->precio_actual = 0; // o algún valor por defecto
                }
                $ArticuloTienda->save();
            }
        }
    }

    return $this->render('crear-articulo', [
        'model' => $model,
        'modelArticulosTienda' => $modelArticulosTienda,
        'categoriasList' => $categoriasList,
        'etiquetasList' => $etiquetasList,
    ]);
}


   public function actionModificarArticulo($Tienda_id)
{
    // Obtiene todos los artículos de la tienda
    $articulosTienda = ArticulosTienda::find()->where(['tienda_id' => $Tienda_id])->all();
    $articulos = ArrayHelper::map($articulosTienda, 'articulo_id', function ($model) {
        return $model->articulo->nombre; // Asumiendo relación 'articulo' en ArticulosTienda
    });

    $categorias = Categorias::find()->all();
    $categorias = ArrayHelper::map($categorias, 'id', 'nombre');
    $etiquetas = Etiquetas::find()->all();
    $etiquetas = ArrayHelper::map($etiquetas, 'id', 'nombre');
    $modeltienda = ArticulosTienda::findOne($Tienda_id); // Asegúrate de que $modeltienda esté definido


    if (Yii::$app->request->post()) {
        $Articulo_id = Yii::$app->request->post('Articulo')['id'];
        $ArticuloTienda = ArticulosTienda::findOne(['tienda_id' => $Tienda_id, 'articulo_id' => $Articulo_id]);
        if (!$ArticuloTienda) {
            throw new NotFoundHttpException('El artículo no existe en esta tienda.');
        }
        $model = Articulo::findOne($Articulo_id);
        if ($model->load(Yii::$app->request->post()) && $modeltienda->load(Yii::$app->request->post())) {
            $DatosArticulos = Yii::$app->request->post('Articulo');
            $DatosArticulosTienda = Yii::$app->request->post('ArticulosTienda');

            // Guardar histórico de los datos actuales del artículo antes de modificarlos
            $historico = new Historico();
            $historico->articulo_id = $model->id;
            $historico->tienda_id = $Tienda_id;
            $historico->fecha = date('Y-m-d H:i:s');
            $historico->precio= $DatosArticulosTienda['precio_actual'];

            if (!$historico->save()) {
                Yii::$app->session->setFlash('error', 'No se pudo guardar el histórico del artículo.');
                return $this->refresh();
            }

            // Actualizar el artículo con los nuevos datos
            $model->nombre = $DatosArticulos['nombre'];
            $model->descripcion = $DatosArticulos['descripcion'];
            $model->categoria_id = $DatosArticulos['categoria_id'];
            $model->etiqueta_id = $DatosArticulos['etiqueta_id'];
            $model->imagen_principal = $DatosArticulos['imagen_principal'];
            $model->visible = isset($DatosArticulos['visible']) ? 1 : 0;
            $model->cerrado = isset($DatosArticulos['cerrado']) ? 1 : 0;
            $model->tipo_marcado = $DatosArticulos['tipo_marcado'];

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
        'modeltienda' => $modeltienda,
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
    $model = new Articulo();
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
            $Articulo->visible = 0; // Oculta el artículo
            $ArticuloTienda->save();
            $Articulo->save();  
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
        'model' => $model,
        'articulos' => $articulos,
    ]);
}
   /**
 * Displays the price history of a specific article in a store.
 * @param int $Tienda_id
 * @return string
 * @throws NotFoundHttpException if the model cannot be found
 */

    public function actionVerHistorico($Tienda_id, $Articulo_id = null)
    {
        $articulos = ArticulosTienda::find()
            ->where(['tienda_id' => $Tienda_id])
            ->all();

        $articulosList = ArrayHelper::map($articulos, 'id', 'nombre');

        $historico = [];
        if ($Articulo_id) {
            $historico = Historico::find()
                ->where(['articulo_id' => $Articulo_id])
                ->orderBy(['fecha' => SORT_DESC])
                ->asArray()
                ->all();
        }

        return $this->render('ver-historico', [
            'tiendaId' => $Tienda_id, // Aseguramos pasar la variable a la vista
            'articulos' => $articulosList,
            'historico' => $historico,
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
            $Articulo_id = Yii::$app->request->post('Ofertas')['articulo_id'];
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
                $oferta->precio_og = $articulo->precio_actual; // Precio original del artículo en la tienda
                $oferta->registro_id = Yii::$app->user->id; // Usuario que creó la oferta
                $oferta->notas= "Oferta creada por el usuario";
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
    $ofertaSeleccionada = new Ofertas(); // Inicializar la variable
    $ofertas = Ofertas::find()->where(['tienda_id' => $Tienda_id])->all();
    $ofertasList = ArrayHelper::map($ofertas, 'id', function ($model) {
        return $model->articulo->nombre . ' - ' . $model->precio_oferta;
    });

    if (Yii::$app->request->post()) {
        $ofertaId = Yii::$app->request->post('oferta_id'); // Obtener ID de la oferta seleccionada
        $ofertaSeleccionada = Ofertas::findOne($ofertaId);

        if (!$ofertaSeleccionada) {
            throw new NotFoundHttpException('La oferta seleccionada no existe.');
        }

        if ($ofertaSeleccionada->load(Yii::$app->request->post())) {
            $articuloId = $ofertaSeleccionada->articulo_id; // Obtener el artículo asociado a la oferta

            if ($ofertaSeleccionada->save()) {
                // Guardar en el histórico
                $historico = new Historico();
                $historico->tienda_id = $Tienda_id;
                $historico->articulo_id = $articuloId;
                $historico->precio = $ofertaSeleccionada->precio_oferta;
                $historico->fecha = date('Y-m-d H:i:s');
                $historico->save();

                Yii::$app->session->setFlash('success', 'Oferta modificada con éxito.');
                return $this->redirect(['view-store', 'id' => $Tienda_id]);
            } else {
                Yii::$app->session->setFlash('error', 'Error al guardar la oferta.');
            }
        }
    }

    return $this->render('modificar-oferta', [
        'ofertasList' => $ofertasList,
        'ofertaSeleccionada' => $ofertaSeleccionada,
        'Tienda_id' => $Tienda_id,
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
    $ofertasList = ArrayHelper::map($ofertas, 'id', function ($model) {
        return $model->articulo->nombre . ' - ' . $model->precio_oferta;
    });

    $ofertaSeleccionada = new Ofertas(); // Inicializamos como un modelo vacío

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
        'ofertaSeleccionada' => $ofertaSeleccionada,
        'Tienda_id' => $Tienda_id,
    ]);
}

 public function actionAdminTienda()
{
    $usuarioId = Yii::$app->user->id; // Obtiene el ID del usuario logueado
    $usuario = Usuario::findOne($usuarioId);

    // Verificar si el usuario tiene rol 'Usuario Tienda'
    if ($usuario && $usuario->rol === 'Usuario Tienda') {
        // Buscar si el usuario es dueño de alguna tienda
        $tiendas = Dueno::find()->where(['id_usuario' => $usuarioId])->all();

        if ($tiendas) {
            // Si es dueño de alguna tienda, generar la vista del panel
            return $this->render('admin-tienda', [
                'tiendas' => $tiendas,
            ]);
        } else {
            // Mensaje de error si no es dueño de ninguna tienda
            Yii::$app->session->setFlash('error', 'No eres dueño de ninguna tienda.');
            return $this->redirect(['site/index']);
        }
    } else {
        // Redirigir si no tiene el rol adecuado
        Yii::$app->session->setFlash('error', 'No tienes permiso para acceder a esta sección.');
        return $this->redirect(['site/index']);
    }
}

public function actionViewArticulo($id)
{
    // Encuentra el modelo de artículo por ID
    $model = Articulo::findOne($id); 
    if ($model === null) {
        throw new NotFoundHttpException("El artículo solicitado no existe.");
    }

    // Crear un nuevo modelo de comentario
    $comentario = new Comentario();
    
    // Obtener los comentarios asociados al artículo, si existen
    $comentarios = Comentario::find()
        ->where(['articulo_id' => $id])
        ->orderBy(['fecha_primera_denuncia' => SORT_DESC]) // Ordenar comentarios por fecha
        ->all();

    // Si el formulario de comentario se envía correctamente
    if ($comentario->load(Yii::$app->request->post()) && $comentario->save()) {
        // Redirigir a la misma vista para mostrar el nuevo comentario
        return $this->refresh();
    }

    // Renderizar la vista con los comentarios y el artículo
    return $this->render('view-articulo', [
        'model' => $model,
        'comentario' => $comentario,  // Enviar el formulario de comentario
        'comentarios' => $comentarios,  // Enviar los comentarios existentes
    ]);
}

public function actionActualizarPrecios($tienda_id)
{
    // Obtener todos los artículos de la tienda
    $articulosTienda = ArticulosTienda::find()->where(['tienda_id' => $tienda_id])->all();
    $articulos = ArrayHelper::map($articulosTienda, 'articulo_id', function($model) {
        return $model->articulo->nombre; // Asumiendo que hay una relación 'articulo' en ArticulosTienda
    });

    if (Yii::$app->request->post()) {
        $postData = Yii::$app->request->post('ArticulosTienda');
        foreach ($postData as $articuloTiendaData) {
            $articuloTienda = ArticulosTienda::findOne(['tienda_id' => $tienda_id, 'articulo_id' => $articuloTiendaData['articulo_id']]);
            if ($articuloTienda) {
                $oldPrice = $articuloTienda->precio;
                $newPrice = $articuloTiendaData['precio'];
                if ($oldPrice != $newPrice) {
                    // Actualizar el precio en ArticulosTienda
                    $articuloTienda->precio = $newPrice;
                    if ($articuloTienda->save()) {
                        // Registrar el cambio en Historico
                        $historico = new Historico();
                        $historico->tienda_id = $tienda_id;
                        $historico->articulo_id = $articuloTienda->articulo_id;
                        $historico->precio = $newPrice;
                        $historico->fecha = date('Y-m-d H:i:s');
                        $historico->save();
                    }
                }
            }
        }
        Yii::$app->session->setFlash('success', 'Precios actualizados con éxito.');
        return $this->refresh();
    }

    return $this->render('actualizar-precios', [
        'articulosTienda' => $articulosTienda,
        'articulos' => $articulos,
    ]);
}

}
