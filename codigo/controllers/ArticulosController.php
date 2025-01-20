<?php

namespace app\controllers;

use Yii;
use app\models\Articulo;
use app\models\ArticulosSearch;
use app\models\ArticulosTienda;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Usuario; 

/**
 * ArticulosController implements the CRUD actions for Articulo model.
 */
class ArticulosController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            // Configuración de control de acceso
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        // Permitir acceso solo a usuarios autenticados
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // Comprobar si el usuario tiene el rol de administrador
                            return Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR) ||
                                   Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR);
                        },
                    ],
                ],
                // Acción a realizar si el usuario no tiene permiso
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('No tienes permiso para acceder a esta página.');
                },
            ],
            // Configuración de verbos HTTP permitidos para las acciones
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'], // La acción delete solo puede ser invocada mediante POST
                ],
            ],
        ];
    }


    /**
     * Lists all Articulo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticulosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Articulo model.
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
     * Creates a new Articulo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Articulo();

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
     * Updates an existing Articulo model.
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
     * Deletes an existing Articulo model.
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
     * Finds the Articulo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Articulo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articulo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
	
	public function actionGestionDenuncias($id)
	{
		$articuloTienda = ArticulosTienda::findOne($id);

		if (!$articuloTienda) {
			throw new NotFoundHttpException('El artículo no fue encontrado.');
		}

		if (Yii::$app->request->isPost) {
			$accion = Yii::$app->request->post('accion');

			// Bloquear el artículo
			if ($accion === 'bloquear') {
				$motivoBloqueo = Yii::$app->request->post('motivo_bloqueo');
				$articuloTienda->bloquear($motivoBloqueo);

				if ($articuloTienda->save(false)) {
					Yii::$app->session->setFlash('success', 'El artículo ha sido bloqueado.');
				} else {
					Yii::$app->session->setFlash('error', 'No se pudo bloquear el artículo.');
				}
			}

			// Desbloquear el artículo
			if ($accion === 'desbloquear') {
				$articuloTienda->desbloquear();

				if ($articuloTienda->save(false)) {
					Yii::$app->session->setFlash('success', 'El artículo ha sido desbloqueado.');
				} else {
					Yii::$app->session->setFlash('error', 'No se pudo desbloquear el artículo.');
				}
			}

			return $this->redirect(['gestion-denuncias', 'id' => $id]);
		}

		return $this->render('gestion-denuncias', [
			'model' => $articuloTienda,
		]);
	}

}