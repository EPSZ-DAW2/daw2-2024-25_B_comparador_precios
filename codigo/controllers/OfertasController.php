<?php

namespace app\controllers;

use Yii;
use app\models\Ofertas;
use app\models\OfertasSearch;
use yii\web\Controller;
use app\models\Seguimiento;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OfertasController implements the CRUD actions for Ofertas model.
 */
class OfertasController extends Controller
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
     * Lists all Ofertas models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OfertasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ofertas model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
	{
		$model = $this->findModel($id);

		// Crear un nuevo modelo para los comentarios
		$comentario = new \app\models\Comentario();
		$comentario->articulo_id = $model->articulo_id;

		if (\Yii::$app->request->isPost) {
			// Verificar si el usuario está autenticado al intentar enviar un comentario
			if (\Yii::$app->user->isGuest) {
				\Yii::$app->session->setFlash('error', 'Debes iniciar sesión para comentar.');
				return $this->redirect(['site/login']);
			}

			// Asociar el comentario al usuario autenticado
			$comentario->registro_id = \Yii::$app->user->identity->id;

			if ($comentario->load(\Yii::$app->request->post()) && $comentario->save()) {
				\Yii::$app->session->setFlash('success', 'Tu comentario ha sido guardado.');
				return $this->redirect(['view', 'id' => $id]);
			} else {
				\Yii::$app->session->setFlash('error', 'Hubo un problema al guardar el comentario.');
			}
		}

		// Cargar todos los comentarios relacionados con la oferta
		$comentarios = $model->getComentarios()->orderBy(['id' => SORT_DESC])->all();

		return $this->render('view', [
			'model' => $model,
			'comentario' => $comentario,
			'comentarios' => $comentarios,
		]);
	}

    /**
     * Creates a new Ofertas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Ofertas();

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
     * Updates an existing Ofertas model.
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
     * Deletes an existing Ofertas model.
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
     * Finds the Ofertas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Ofertas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ofertas::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
	
	public function actionDenunciar($id)
	{
		if (Yii::$app->user->isGuest) {
			Yii::$app->session->setFlash('error', 'Debes iniciar sesión para denunciar una oferta.');
			return $this->redirect(['site/login']);
		}

		// Buscar la oferta y obtener la relación con ArticulosTienda
		$oferta = Ofertas::findOne($id);
		if (!$oferta || !$oferta->articulo || !$oferta->articulo->articuloTienda) {
			throw new NotFoundHttpException('No se encontró la oferta o la relación con el artículo.');
		}

		$articuloTienda = $oferta->articulo->articuloTienda;

		if (Yii::$app->request->isPost) {
			// Capturar el motivo desde el formulario
			$nuevoMotivo = Yii::$app->request->post('motivo_denuncia');

			// Agregar el nuevo motivo de denuncia
			$articuloTienda->agregarMotivoDenuncia($nuevoMotivo);

			if ($articuloTienda->save(false)) {
				Yii::$app->session->setFlash('success', 'Denuncia registrada exitosamente.');
				return $this->redirect(['view', 'id' => $id]);
			} else {
				Yii::$app->session->setFlash('error', 'No se pudo registrar la denuncia. Por favor, inténtalo de nuevo.');
			}
		}

		return $this->render('denunciar', [
			'model' => $oferta,
		]);
	}

	public function actionSeguimiento($id)
	{
		if (Yii::$app->user->isGuest) {
			Yii::$app->session->setFlash('error', 'Debes iniciar sesión para seguir una oferta.');
			return $this->redirect(['site/login']);
		}

		$usuarioId = Yii::$app->user->identity->id;

		// Buscar seguimiento existente
		$seguimiento = Seguimiento::find()
			->where(['usuario_id' => $usuarioId, 'oferta_id' => $id])
			->one();

		if ($seguimiento) {
			// Si existe el seguimiento, elimínalo (desactivar seguimiento)
			$seguimiento->delete();
			Yii::$app->session->setFlash('success', 'Has dejado de seguir esta oferta.');
		} else {
			$seguimiento = new Seguimiento();
			$seguimiento->usuario_id = $usuarioId;
			$seguimiento->oferta_id = $id;
			$seguimiento->fecha = date('Y-m-d H:i:s');
			if ($seguimiento->save()) {
				Yii::$app->session->setFlash('success', 'Ahora sigues esta oferta.');
			} else {
				Yii::$app->session->setFlash('error', 'No se pudo seguir esta oferta.');
			}
		}

		return $this->redirect(['view', 'id' => $id]);
	}

}
