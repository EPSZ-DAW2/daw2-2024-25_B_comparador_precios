<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\Moderador;
use app\models\UsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\Aviso;
use app\models\Regiones;
use app\models\Articulo;
use app\models\RegistroUsuarios;
use app\models\RegistroLogs; // Importamos el modelo para los logs

/**
 * UsuariosController implements the CRUD actions for Usuario model.
 */
class UsuariosController extends Controller
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
     * Lists all Usuario models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
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
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Usuario();

        // Cargar las regiones desde la base de datos
        $regiones = \yii\helpers\ArrayHelper::map(
            Regiones::find()->all(),
            'id',
            'nombre'
        );

        // Aquí defines $modid
        $modid = Yii::$app->user->identity->id ?? null; // Por ejemplo, asignar el ID del usuario actual

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'regiones' => $regiones,
            'modid' => $modid, // Pasamos $modid a la vista
        ]);
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $mod = Moderador::findOne(['usuario_id' => Yii::$app->user->id]);

        // Obtener las regiones para el dropdown
        $regiones = \yii\helpers\ArrayHelper::map(
            Regiones::find()->all(),
            'id',
            'nombre'
        );

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            // Registrar el log después de actualizar el perfil
            $this->actionLog('Actualización de Perfil', "El usuario {$model->username} actualizó su perfil.", 'Perfil');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        if ($mod) {
            return $this->render('update', [
                'model' => $model,
                'modid' => $mod->id,
                'regiones' => $regiones,
            ]);
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Handles user profile updates.
     * @return string|\yii\web\Response
     */
    public function actionUpdateProfile()
    {
        $model = Yii::$app->user->identity;
    
        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('Usuario no encontrado.');
        }
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Registrar el log después de actualizar el perfil
            $this->actionLog('Actualización de Perfil', "El usuario {$model->username} actualizó su perfil.", 'Perfil');
            
            Yii::$app->session->setFlash('success', 'Perfil actualizado correctamente.');
            return $this->redirect(['update-profile']);
        }
    
        return $this->render('update-profile', [
            'model' => $model,
        ]);
    }

    /**
     * Handles user deactivation requests.
     * @return \yii\web\Response
     */
    public function actionBaja()
    {
        $model = Yii::$app->user->identity;

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('Usuario no encontrado.');
        }

        $aviso = new Aviso();

        // Obtener las jerarquías de regiones con verificaciones de existencia
        $provincia = Regiones::findOne($model->region_id);
        if (!$provincia) {
            Yii::$app->session->setFlash('error', 'La región del usuario no es válida.');
            return $this->redirect(['usuarios/perfil']);
        }

        $estado = Regiones::findOne($provincia->region_padre_id);
        if (!$estado) {
            Yii::$app->session->setFlash('error', 'La región padre no es válida.');
            return $this->redirect(['usuarios/perfil']);
        }

        $pais = Regiones::findOne($estado->region_padre_id);
        if (!$pais) {
            Yii::$app->session->setFlash('error', 'El país no es válido.');
            return $this->redirect(['usuarios/perfil']);
        }

        $continente = Regiones::findOne($pais->region_padre_id);
        if (!$continente) {
            Yii::$app->session->setFlash('error', 'El continente no es válido.');
            return $this->redirect(['usuarios/perfil']);
        }

        // Crear el aviso
        $aviso->clase = 'Aviso';
        $aviso->texto = 'Nueva Solicitud de Baja';
        $aviso->usuario_origen_id = $model->id;

        // Buscar moderador en la región correspondiente
        $moderador = Moderador::find()
            ->where(['region_id' => $continente->id])
            ->one();

        if ($moderador) {
            $usuarioDestino = Usuario::findOne($moderador->usuario_id);
            $aviso->usuario_destino_id = $usuarioDestino->id;
            $aviso->usuario_destino_nick = $usuarioDestino->nick;
        }

        if ($aviso->save()) {
            // Registrar el log después de solicitar la baja
            $this->actionLog('Solicitud de Baja', "El usuario {$model->username} solicitó su baja.", 'Baja');
            
            Yii::$app->session->setFlash('success', 'Un moderador te dará de baja en breves');
        } else {
            Yii::$app->session->setFlash('error', 'Ha ocurrido un error al guardar el aviso.');
        }

        return $this->redirect(['usuarios/perfil']);
    }

    /**
     * Logs actions in the RegistroLogs model.
     * @param string $accion
     * @param string $detalles
     * @param string $tipoAccion
     */
    protected function actionLog($accion, $detalles, $tipoAccion)
    {
        $log = new RegistroLogs();
        $log->usuario = Yii::$app->user->isGuest ? 'Invitado' : Yii::$app->user->identity->username;
        $log->nivel = 'INFO';
        $log->mensaje = $detalles;
        $log->accion = $tipoAccion;
        $log->fecha_log = date('Y-m-d H:i:s');

        if (!$log->save()) {
            Yii::error('Error al guardar el registro de log: ' . json_encode($log->errors));
        } else {
            Yii::info('Log registrado correctamente: ' . $accion);
        }
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * @param int $id ID
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionPerfil()
    {
        $usuario = Yii::$app->user->identity;

        if ($usuario === null) {
            return $this->redirect(['site/login']);
        }

        return $this->render('perfil', [
            'usuario' => $usuario,
        ]);
    }

    public function actionTrabajarEnNombreDe($usuario_id)
    {
        // Verifica si el usuario actual es Superadministrador
        if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR)) {
            throw new ForbiddenHttpException('No tienes permiso para realizar esta acción.');
        }

        // Valida si el usuario objetivo existe y está activo (no está bloqueado)
        $usuario = Usuario::findOne($usuario_id);
        if (!$usuario || $usuario->bloqueado == 1) {  // Verifica si el usuario está bloqueado
            throw new NotFoundHttpException('El usuario especificado no existe o está bloqueado.');
        }

        // Cambia el contexto del usuario en la sesión
        Yii::$app->session->set('usuario_original', Yii::$app->user->id); // Guarda el ID original
        Yii::$app->user->switchIdentity($usuario); // Cambia al usuario objetivo

        Yii::$app->session->setFlash('success', "Ahora estás trabajando en nombre del usuario: {$usuario->nombre}.");
        
        // Redirige a site/index usando Yii::app->response
        return Yii::$app->response->redirect(['site/index']);
    }

    public function actionVolverAOriginal()
    {
        // Verifica si el usuario actual es Superadministrador
        if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR)) {
            throw new ForbiddenHttpException('No tienes permiso para realizar esta acción.');
        }
        
        $usuario_original_id = Yii::$app->session->get('usuario_original');
        if ($usuario_original_id) {
            // Restaura el contexto original
            $usuario_original = Usuario::findOne($usuario_original_id);
            if ($usuario_original) {
                Yii::$app->user->switchIdentity($usuario_original);
                Yii::$app->session->remove('usuario_original'); // Elimina la referencia
                Yii::$app->session->setFlash('success', 'Has vuelto a tu rol original.');
                return $this->redirect(['index']); // Redirige al índice de usuarios o la página que prefieras
            }
        }

        throw new ForbiddenHttpException('No tienes un usuario original para volver.');
    }

}
