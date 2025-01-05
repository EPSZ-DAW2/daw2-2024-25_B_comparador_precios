<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\Moderador;
use app\models\UsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\aviso;
use app\models\Articulo;
use app\models\RegistroUsuarios;

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
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $mod = new Moderador();
        $mod = Moderador::findOne(['usuario_id' => Yii::$app->user->id]);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save() && $mod) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if( $mod )
        return $this->render('update', [
            'model' => $model,
            'modid' => $mod->id,
        ]);
        else 
        return $this->redirect(['index']); // Redirige después de completar la acción

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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
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
        // Obtener al usuario autenticado
        $usuario = Yii::$app->user->identity;

        if ($usuario === null) {
            return $this->redirect(['site/login']); // Redirigir si no está autenticado
        }

        return $this->render('perfil', [
            'usuario' => $usuario,
        ]);
    }


    public function actionUpdateProfile()
    {
        $model = Yii::$app->user->identity;
    
        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('Usuario no encontrado.');
        }
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Perfil actualizado correctamente.');
            return $this->redirect(['update-profile']);
        }
    
        return $this->render('update-profile', [
            'model' => $model,
        ]);
    }


    public function actionBaja()
    {
        $model = Yii::$app->user->identity;
    
        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('Usuario no encontrado.');
        }

        $aviso = new aviso();
        if($aviso->load(Yii::$app->request->post()) && $aviso->validate()) {
            $aviso->clase = 'mensaje';
            $aviso->texto = 'Solicitud de baja del usuario ' . $model->id;
            $aviso->usuario_origen_id = $model->id;
            //$aviso->usuario_destino_id = ;  
        
        $aviso->save();
        }

    }

    public function actionVerificar($modid, $usrid)
    {
        $mod = Moderador::findOne($modid); // Encuentra el modelo del moderador
        $usuario = Usuario::findOne($usrid); // Encuentra el modelo del usuario
        $reg = new RegistroUsuarios();
    
        if ($mod && $usuario) { // Verifica que ambos modelos existan
            if($usuario->registro_confirmado == 1)
                Yii::$app->session->setFlash('warning', 'El usuario ya está verificado');
            
            else{
                $usuario->registro_confirmado = 1;            
                if ($usuario->save()) {
                    $reg->fecha_creacion = date('Y-m-d\TH:i:sP');
                    $reg->creador_id = $usrid; // Asigna el ID del usuario
                    $reg->fecha_mod = date('Y-m-d\TH:i:sP');
                    $reg->mod_id = $modid; // Asigna el ID del moderador
                    $reg->save();
                }
            }
        } else {
            throw new NotFoundHttpException('Moderador o Usuario no encontrado.');
        }
    
        return $this->redirect(['index']); // Redirige después de completar la acción
    }
    


}
