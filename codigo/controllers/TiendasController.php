<?php

namespace app\controllers;

use app\models\Tienda;
use app\models\TiendasSearch;
use app\models\Articulos;
use app\models\ArticulosTienda;
use app\models\ArticulosSearch;
use app\models\ArticulosTiendaSearch;
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
        $model = $this->findModel($id);
        if($model->propietario_usuario_id != \Yii::$app->user->id){
            throw new \yii\web\ForbiddenHttpException('No tienes permiso para ver esta tienda');
        }
        return $this->render('view', [ 'model'=> $model,]);
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

        // Verificar si el usuario autenticado es el propietario de la tienda
    if ($model->propietario_usuario_id !== \Yii::$app->user->id) {
        throw new \yii\web\ForbiddenHttpException("No tienes permiso para modificar esta tienda.");
    }
     
    if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
        \Yii::$app->session->setFlash('success', 'Perfil actualizado exitosamente.');
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

    public function actionDesactivate($id){ //desactiva la tienda
        $model = $this->findModel($id);
        if ($model->propietario_usuario_id !== \Yii::$app->user->id){
            throw new \yii\web\ForbiddenHttpException("No tienes permiso para desactivar esta tienda.");
        }
        $model->visible = 0;
        $model->cerrada = 1;

        if($model->save()){
            \Yii::$app->session->setFlash('success', 'Tienda desactivada exitosamente.');
        }else{
            \Yii::$app->session->setFlash('error', 'No se pudo desactivar la tienda, intentelo mas tarde');
        }
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

    public function actionVote($id)
    {
        $model = $this->findModel($id);

        $model->suma_votos += 1;

        if ($model->save()) {
            \Yii::$app->session->setFlash('success', 'Voto registrado exitosamente.');
        } else {
            \Yii::$app->session->setFlash('error', 'No se pudo registrar el voto, intentelo más tarde.');
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionValoration($id)
    {
        $model = $this->findModel($id);

        $model->suma_valoraciones += 1;

        if ($model->save()) {
            \Yii::$app->session->setFlash('success', 'Valoracion registrada exitosamente.');
        } else {
            \Yii::$app->session->setFlash('error', 'No se pudo registrar la valoracion, intentelo más tarde.');
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        if ($model->propietario_usuario_id !== \Yii::$app->user->id){
            throw new \yii\web\ForbiddenHttpException("No tienes permiso para activar esta tienda.");
        }
        $model->visible = 1;
        $model->cerrada = 0;

        if($model->save()){
            \Yii::$app->session->setFlash('success', 'Tienda activada exitosamente.');
        }else{
            \Yii::$app->session->setFlash('error', 'No se pudo activar la tienda, intentelo mas tarde');
        }
        return $this->redirect(['index']);

    }

    public function actionToggleStatus($id)
    {
        $model = $this->findModel($id);

        if ($model->propietario_usuario_id !== \Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException("No tienes permiso para modificar esta tienda.");
        }

        if ($model->denuncias >= 5) {
            $model->cerrada = 1;
            $model->visible = 0;
            $message = 'Tienda cerrada debido a múltiples denuncias.';
            $model->motivo_denuncia = $message;

        } else {
            $model->cerrada = 0;
            $model->visible = 1;
            $message = 'Tienda abierta.';
        }

        if ($model->save()) {
            \Yii::$app->session->setFlash('success', $message);
        } else {
            \Yii::$app->session->setFlash('error', 'No se pudo cambiar el estado de la tienda, intentelo más tarde.');
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionDenounce($id)
    {
        $model = $this->findModel($id);

        if ($model->propietario_usuario_id === \Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException("No puedes denunciar tu propia tienda.");
        }

        if ($this->request->isPost) {
            $denuncia = $this->request->post('motivo_denuncia'); 
            $model->denuncias += 1;
            $model->motivo_denuncia = $denuncia;
            if ($model->denuncias == 1) {
                $model->fecha_primera_denuncia = date('Y-m-d H:i:s');
            }

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', 'Denuncia registrada exitosamente.');
            } else {
                \Yii::$app->session->setFlash('error', 'No se pudo registrar la denuncia, intentelo más tarde.');
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('denounce', [
            'model' => $model,
        ]);
    }
   
    public function actionMantenerArticulos($tiendaId)
{
    $tienda = $this->findModel($tiendaId);

    if ($this->request->isPost) {
        $accion = $this->request->post('accion');
        $articuloId = $this->request->post('articulo_id');
        $articulo = Articulo::findOne($articuloId);

        switch ($accion) {
            case 'crear':
                if (!$articulo) {
                    $articulo = new Articulo();
                    $articulo->attributes = $this->request->post('Articulo');
                    $articulo->comun_o_propio = 'propio';
                    if ($articulo->save()) {
                        $articuloTienda = new ArticulosTienda();
                        $articuloTienda->tienda_id = $tiendaId;
                        $articuloTienda->articulo_id = $articulo->id;
                        $articuloTienda->precio = $this->request->post('precio');
                        $articuloTienda->save();
                        \Yii::$app->session->setFlash('success', 'Artículo creado y vinculado exitosamente.');
                    } else {
                        \Yii::$app->session->setFlash('error', 'No se pudo crear el artículo.');
                    }
                } else {
                    $articuloTienda = new ArticulosTienda();
                    $articuloTienda->tienda_id = $tiendaId;
                    $articuloTienda->articulo_id = $articulo->id;
                    $articuloTienda->precio = $this->request->post('precio');
                    $articuloTienda->save();
                    \Yii::$app->session->setFlash('success', 'Artículo vinculado exitosamente.');
                }
                break;

            case 'modificar':
                if ($articulo->comun_o_propio === 'propio') {
                    $articulo->attributes = $this->request->post('Articulo');
                    if ($articulo->save()) {
                        \Yii::$app->session->setFlash('success', 'Artículo modificado exitosamente.');
                    } else {
                        \Yii::$app->session->setFlash('error', 'No se pudo modificar el artículo.');
                    }
                } else {
                    $articuloTienda = ArticulosTienda::findOne(['tienda_id' => $tiendaId, 'articulo_id' => $articuloId]);
                    $articuloTienda->precio = $this->request->post('precio');
                    if ($articuloTienda->save()) {
                        \Yii::$app->session->setFlash('success', 'Precio del artículo modificado exitosamente.');
                    } else {
                        \Yii::$app->session->setFlash('error', 'No se pudo modificar el precio del artículo.');
                    }
                }
                break;

            case 'eliminar':
                $articuloTienda = ArticulosTienda::findOne(['tienda_id' => $tiendaId, 'articulo_id' => $articuloId]);
                if ($articuloTienda->hasHistoricalPrices()) {
                    $articuloTienda->visible = 0;
                    $articuloTienda->save();
                    \Yii::$app->session->setFlash('success', 'Artículo ocultado exitosamente.');
                } else {
                    $articuloTienda->delete();
                    \Yii::$app->session->setFlash('success', 'Artículo desvinculado exitosamente.');
                }
                break;

            case 'ocultar':
                $articuloTienda = ArticulosTienda::findOne(['tienda_id' => $tiendaId, 'articulo_id' => $articuloId]);
                $articuloTienda->visible = 0;
                if ($articuloTienda->save()) {
                    \Yii::$app->session->setFlash('success', 'Artículo ocultado exitosamente.');
                } else {
                    \Yii::$app->session->setFlash('error', 'No se pudo ocultar el artículo.');
                }
                break;
        }

        return $this->redirect(['view', 'id' => $tiendaId]);
    }

    return $this->render('mantener-articulos', [
        'tienda' => $tienda,
    ]);
}

    public function actionTiendasAbiertas(){
        $tiendas = Tienda::find()->where(['cerrada' => 0, 'visible' => 1])->all();
        return $this->render('tiendas-abiertas', ['tiendas' => $tiendas]);
    }
    
    public function actionMostrarProductosPorTienda()
{
    // Obtener todas las tiendas
    $tiendas = Tienda::find()->all();

    // Array para almacenar los datos de las tiendas y sus productos
    $tiendasConProductos = [];

    foreach ($tiendas as $tienda) {
        // Obtener los artículos relacionados con la tienda a través de la tabla articulos_tienda
        $articulosTienda = ArticulosTienda::find()->where(['tienda_id' => $tienda->id])->all();

        // Array para almacenar los datos de los productos de la tienda actual
        $productos = [];

        foreach ($articulosTienda as $articuloTienda) {
            // Obtener el artículo
            $articulo = Articulo::findOne($articuloTienda->articulo_id);

            // Agregar los datos del producto al array
            $productos[] = [
                'nombre' => $articulo->nombre,
                'descripcion' => $articulo->descripcion,
                'precio' => $articuloTienda->precio,
                'imagen_principal' => $articulo->imagen_principal,
                'categoria_id' => $articulo->categoria_id,
                'etiqueta_id' => $articulo->etiqueta_id,
                'visible' => $articulo->visible,
                'cerrado' => $articulo->cerrado,
                'comun_o_propio' => $articulo->comun_o_propio,
            ];
        }

        // Agregar los datos de la tienda y sus productos al array principal
        $tiendasConProductos[] = [
            'tienda' => $tienda,
            'productos' => $productos,
        ];
    }

    // Renderizar la vista con los datos de las tiendas y sus productos
    return $this->render('mostrar-productos-por-tienda', [
        'tiendasConProductos' => $tiendasConProductos,
    ]);
}
}

