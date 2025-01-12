<?php

namespace app\controllers;

use Yii;
use app\models\Moderador;
use app\models\ModeradoresSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Usuario; 

/**
 * ModeradoresAdminController implementa las acciones CRUD para el modelo Moderador.
 */
class ModeradoresAdminController extends Controller
{
    /**
     * Configuración de comportamientos.
     * Incluye reglas de acceso para restringir el acceso a usuarios con rol administrador 
     * y configura los métodos permitidos para ciertas acciones.
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
                            return Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR);
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
     * Lista todos los modelos de Moderador.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ModeradoresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un único modelo de Moderador.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Crea un nuevo modelo de Moderador.
     * Si la creación es exitosa, el navegador será redirigido a la página 'view'.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Moderador();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Actualiza un modelo existente de Moderador.
     * Si la actualización es exitosa, el navegador será redirigido a la página 'view'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Elimina un modelo existente de Moderador.
     * Si la eliminación es exitosa, el navegador será redirigido a la página 'index'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Encuentra el modelo de Moderador basado en su clave primaria.
     * Si no se encuentra el modelo, se lanza una excepción HTTP 404.
     * @param integer $id
     * @return Moderador el modelo cargado
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    protected function findModel($id)
    {
        if (($model = Moderador::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
