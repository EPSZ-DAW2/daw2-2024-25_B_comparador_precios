<?php

namespace app\controllers;

use app\models\Moderador;
use app\models\Usuario;
use app\models\Tienda;
use app\models\Regiones;
use app\models\Seguimiento;
use app\models\Comentario;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider; 

/**
 * Controlador para que un moderador gestione su propio perfil.
 */
class ModeradoresController extends Controller
{
    /**
     * Configuración de permisos.
     * Solo los usuarios con el rol de moderador pueden acceder a las acciones de este controlador.
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Solo usuarios autenticados
                        'matchCallback' => function ($rule, $action) {
                            return Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_MODERADOR);
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Muestra una vista general con el perfil del moderador en un formato de lista.
     */
    public function actionIndex()
    {
        if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_MODERADOR)) {
            throw new ForbiddenHttpException('No tienes permiso para acceder a esta acción.');
        }

        $model = $this->findModelByUsuario();

        // Creamos un ArrayDataProvider para pasar el modelo como una lista
        $dataProvider = new ArrayDataProvider([
            'allModels' => [$model], // Pasamos el modelo como un array
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra los detalles completos del perfil del moderador logueado.
     */
    public function actionView($id)
    {
        if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_MODERADOR)) {
            throw new ForbiddenHttpException('No tienes permiso para acceder a esta acción.');
        }

        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Permite al moderador actualizar su propio perfil.
     */
    public function actionUpdate()
    {
        if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_MODERADOR)) {
            throw new ForbiddenHttpException('No tienes permiso para acceder a esta acción.');
        }

        $model = $this->findModelByUsuario();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Perfil actualizado con éxito.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Permite al moderador solicitar su baja.
     */
    public function actionBaja()
    {
        if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_MODERADOR)) {
            throw new ForbiddenHttpException('No tienes permiso para acceder a esta acción.');
        }

        $model = $this->findModelByUsuario();

        if (Yii::$app->request->post()) {
            $model->baja_solicitada = true;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Solicitud de baja enviada correctamente.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('baja', [
            'model' => $model,
        ]);
    }

    /**
     * Busca el modelo del moderador asociado al usuario autenticado.
     */
    protected function findModelByUsuario()
    {
        $usuarioId = Yii::$app->user->id;

        if (($model = Moderador::findOne(['usuario_id' => $usuarioId])) !== null) {
            if (Usuario::tieneRol($usuarioId, Usuario::ROL_MODERADOR)) {
                return $model;
            }
        }

        throw new NotFoundHttpException('No se encontró el perfil del moderador.');
    }

    /**
     * Busca el modelo del moderador por su ID.
     */
    protected function findModel($id)
    {
        if (($model = Moderador::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('No se encontró el perfil del moderador.');
    }

    public function actionRevisarTiendas()
    {
        $moderador = Moderador::findOne(['usuario_id' => Yii::$app->user->id]);

        if (!$moderador) {
            throw new ForbiddenHttpException('No tienes permiso para acceder a esta acción.');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $moderador->getTiendas(), // Relación con las tiendas del moderador
        ]);

        return $this->render('revisar-tiendas', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra los detalles de una tienda asignada.
     */
    public function actionVerTienda($id)
    {
        $tienda = Tienda::findOne($id);
        if (!$tienda) {
            throw new \yii\web\NotFoundHttpException('La tienda no existe.');
        }

        $comentariosDataProvider = new ActiveDataProvider([
            'query' => $tienda->getComentarios()->andWhere(['or', ['articulo_id' => 0], ['articulo_id' => null]]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('ver-tienda', [
            'tienda' => $tienda,
            'comentariosDataProvider' => $comentariosDataProvider,
        ]);
    }

    /**
     * Edita los detalles de una tienda asignada.
     */
    public function actionEditarTienda($id)
    {
        $tienda = $this->findTienda($id);

        if ($tienda->load(Yii::$app->request->post()) && $tienda->validate()) {
            if ($tienda->save()) {
                Yii::$app->session->setFlash('success', 'La tienda ha sido actualizada con éxito.');
                return $this->redirect(['revisar-tiendas']);
            } else {
                Yii::$app->session->setFlash('error', 'Error al guardar la tienda.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Errores de validación: ' . json_encode($tienda->getErrors()));
        }        

        return $this->render('editar-tienda', [
            'model' => $tienda,
        ]);
    }

    /**
     * Elimina una tienda asignada.
     */
    public function actionEliminarTienda($id)
    {
        $tienda = $this->findTienda($id);

        $tienda->delete();
        Yii::$app->session->setFlash('success', 'La tienda ha sido eliminada con éxito.');

        return $this->redirect(['revisar-tiendas']);
    }

    /**
     * Busca y valida una tienda específica asociada al moderador actual.
     */
    protected function findTienda($id)
    {
        $moderador = Moderador::findOne(['usuario_id' => Yii::$app->user->id]);

        if (!$moderador) {
            throw new ForbiddenHttpException('No tienes permiso para acceder a esta acción.');
        }

        // Encuentra la tienda y verifica que pertenece a la región del moderador
        $tienda = Tienda::findOne($id);

        if (!$tienda || $tienda->region_id !== $moderador->region_id) {
            throw new NotFoundHttpException('No se encontró la tienda o no tienes permiso para acceder a ella.');
        }

        return $tienda;
    }

    /**
     * Crea una nueva tienda asociada al moderador actual.
     */
    public function actionCrearTienda()
    {
        $moderador = Moderador::findOne(['usuario_id' => Yii::$app->user->id]);

        if (!$moderador) {
            throw new ForbiddenHttpException('No tienes permiso para realizar esta acción.');
        }

        $model = new Tienda();
        $model->region_id = $moderador->region_id; // Asignar automáticamente la región del moderador

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) { // Validación y guardado automático
                Yii::$app->session->setFlash('success', 'Tienda creada con éxito.');
                return $this->redirect(['revisar-tiendas']);
            } else {
                Yii::$app->session->setFlash('error', 'Errores de validación: ' . json_encode($model->getErrors()));
            }
        }

        return $this->render('crear-tienda', [
            'model' => $model,
        ]);
    }

    /**
     * Lista los usuarios de la misma región del moderador.
     */
    public function actionRevisarUsuarios()
    {
        $moderador = Moderador::findOne(['usuario_id' => Yii::$app->user->id]);

        if (!$moderador) {
            throw new ForbiddenHttpException('No tienes permiso para acceder a esta acción.');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Usuario::find()->where(['region_id' => $moderador->region_id]),
        ]);

        return $this->render('revisar-usuarios', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra los detalles de un usuario asignado.
     */
    public function actionVerUsuario($id)
    {
        $usuario = $this->findUsuario($id);

        return $this->render('ver-usuario', [
            'model' => $usuario,
        ]);
    }

    /**
     * Edita los detalles de un usuario asignado.
     */
    public function actionEditarUsuario($id)
    {
        $usuario = $this->findUsuario($id);

        if ($usuario->load(Yii::$app->request->post()) && $usuario->validate()) {
            if ($usuario->save()) {
                Yii::$app->session->setFlash('success', 'El usuario ha sido actualizado con éxito.');
                return $this->redirect(['revisar-usuarios']);
            } else {
                Yii::$app->session->setFlash('error', 'Error al guardar el usuario.');
            }
        }

        return $this->render('_formusuarios', [
            'model' => $usuario, // Cambiado para usar la vista _formusuarios.php
        ]);
    }

    /**
     * Elimina un usuario asignado.
     */
    public function actionEliminarUsuario($id)
    {
        $usuario = $this->findUsuario($id);

        $usuario->delete();
        Yii::$app->session->setFlash('success', 'El usuario ha sido eliminado con éxito.');

        return $this->redirect(['revisar-usuarios']);
    }

    /**
     * Crea un nuevo usuario asignado a la región del moderador.
     */
    public function actionCrearUsuario()
    {
        $moderador = Moderador::findOne(['usuario_id' => Yii::$app->user->id]);

        if (!$moderador) {
            throw new ForbiddenHttpException('No tienes permiso para realizar esta acción.');
        }

        $model = new Usuario();
        $model->region_id = $moderador->region_id; // Asignar automáticamente la región del moderador

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Usuario creado con éxito.');
                return $this->redirect(['revisar-usuarios']);
            } else {
                Yii::$app->session->setFlash('error', 'Errores de validación: ' . json_encode($model->getErrors()));
            }
        }

        return $this->render('_formusuarios', [
            'model' => $model, // Cambiado para usar la vista _formusuarios.php
        ]);
    }

    /**
     * Busca y valida un usuario específico asignado al moderador actual.
     */
    protected function findUsuario($id)
    {
        $moderador = Moderador::findOne(['usuario_id' => Yii::$app->user->id]);

        if (!$moderador) {
            throw new ForbiddenHttpException('No tienes permiso para acceder a esta acción.');
        }

        // Encuentra el usuario y verifica que pertenece a la región del moderador
        $usuario = Usuario::findOne($id);

        if (!$usuario || $usuario->region_id !== $moderador->region_id) {
            throw new NotFoundHttpException('No se encontró el usuario o no tienes permiso para acceder a él.');
        }

        return $usuario;
    }
}
