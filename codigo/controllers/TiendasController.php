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
    public function actionMantenerarticulos($tiendaId, $articulosData)
    {
        $tienda = Tienda::findOne($tiendaId);
        if (!$tienda) {
            throw new NotFoundHttpException("La tienda no existe.");
        }

        foreach ($articulosData as $articuloData) {
            $articulo = Articulos::findOne(['nombre' => $articuloData['nombre']]);
            if (!$articulo) {
                // Crear nuevo artículo si no existe
                $articulo = new Articulos();
                $articulo->nombre = $articuloData['nombre'];
                $articulo->descripcion = $articuloData['descripcion'] ?? null;
                $articulo->imagen_principal = $articuloData['imagen_principal'] ?? null;
                $articulo->visible = $articuloData['visible'] ?? 1;
                $articulo->cerrado = $articuloData['cerrado'] ?? 0;
                $articulo->comun_o_propio = 'propio'; // Artículo propio de la tienda
                
                // Asignar claves foráneas si están presentes
                $articulo->categoria_id = $articuloData['categoria_id'] ?? null;
                $articulo->etiqueta_id = $articuloData['etiqueta_id'] ?? null;
                $articulo->registro_id = $articuloData['registro_id'] ?? null;
                $articulo->articulo_tienda_id = $articuloData['articulo_tienda_id'] ?? null;

                if (!$articulo->save()) {
                    Yii::$app->session->setFlash('error', "Error al crear el artículo: " . implode(", ", $articulo->getFirstErrors()));
                    continue;
                }
            }

            // Vincular el artículo con la tienda
            $articuloTienda = ArticulosTienda::findOne(['tienda_id' => $tiendaId, 'articulo_id' => $articulo->id]);
            if (!$articuloTienda) {
                $articuloTienda = new ArticulosTienda();
                $articuloTienda->tienda_id = $tiendaId;
                $articuloTienda->articulo_id = $articulo->id;
                $articuloTienda->precio = $articuloData['precio'];
                if (!$articuloTienda->save()) {
                    Yii::$app->session->setFlash('error', "Error al vincular el artículo con la tienda: " . implode(", ", $articuloTienda->getFirstErrors()));
                }
            } else {
                // Actualizar el precio si ya está vinculado
                $articuloTienda->precio = $articuloData['precio'];
                $articuloTienda->save();
            }

            // Modificar artículos propios de la tienda
            if ($articulo->comun_o_propio === 'propio') {
                $articulo->descripcion = $articuloData['descripcion'] ?? $articulo->descripcion;
                $articulo->imagen_principal = $articuloData['imagen_principal'] ?? $articulo->imagen_principal;
                $articulo->visible = $articuloData['visible'] ?? $articulo->visible;
                $articulo->cerrado = $articuloData['cerrado'] ?? $articulo->cerrado;
                $articulo->save();
            }

            // Ocultar artículos de la tienda
            if (isset($articuloData['ocultar']) && $articuloData['ocultar']) {
                $articulo->visible = 0;
                $articulo->save();
            }

            // Eliminar o desvincular artículos
            if (isset($articuloData['eliminar']) && $articuloData['eliminar']) {
                if ($articulo->comun_o_propio === 'propio') {
                    // Verificar si tiene histórico de precios
                    $historicoPrecios = ArticulosTienda::find()->where(['articulo_id' => $articulo->id])->count();
                    if ($historicoPrecios > 0) {
                        $articulo->visible = 0; // Ocultar si tiene histórico
                        $articulo->save();
                    } else {
                        $articulo->delete(); // Eliminar si no tiene histórico
                    }
                } else {
                    // Desvincular artículo común
                    $articuloTienda->delete();
                }
            }
        }

        Yii::$app->session->setFlash('success', "Artículos mantenidos correctamente.");
        return $this->redirect(['view', 'id' => $tiendaId]);
    }

    

}

