<?php

namespace app\controllers;

use Yii;
use app\models\Comentario;
use app\models\RegistroUsuarios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ComentariosController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionComentariosUsuario()
    {
        $usuario = Yii::$app->user->identity;
    
        if ($usuario === null) {
            throw new NotFoundHttpException('Usuario no encontrado.');
        }
    
        // Buscar comentarios del usuario autenticado con relaciones
        $comentarios = Comentario::find()
            ->where(['registro_id' => $usuario->id])
            ->with(['tienda', 'articulo']) // Carga las relaciones necesarias
            ->all();
    
        if (empty($comentarios)) {
            return $this->render('comentariosUsuario', [
                'comentarios' => [],
            ]);
        }
    
        // Todos los comentarios los guardamos en un solo array
        $comentariosGenerales = [];
    
        foreach ($comentarios as $comentario) {
            $comentariosGenerales[] = $comentario;
        }
    
        // Renderizar la vista con los comentarios generales
        return $this->render('comentariosUsuario', [
            'comentarios' => $comentariosGenerales,
        ]);
    }
    

    public function actionComentar($artid, $tieid, $valor = null, $texto, $c_padre = null)
    {
    
        $usuario = Yii::$app->user->identity;
        $reg = RegistroUsuarios::find()->where(['creador_id' => $usuario->id])->one();
    
        if ($usuario === null) {
            throw new NotFoundHttpException('Usuario no encontrado.');
        }
    
        $comentario = new Comentario();
        $comentario->tienda_id = $tieid;
        $comentario->articulo_id = $artid;
        $comentario->valoracion = $valor ?? 0;
        $comentario->texto = $texto;
        $comentario->comentario_padre_id = $c_padre;
        $comentario->registro_id = $reg->id;
    
        if ($comentario->save()) {
            Yii::$app->session->setFlash('success', 'Comentario publicado correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Hubo un error al publicar el comentario.');
        }
    
        return $this->redirect(['tiendas/view-articulo', 'id' => $artid, 'tienda_id' => $tieid]);
    }
    


    }
