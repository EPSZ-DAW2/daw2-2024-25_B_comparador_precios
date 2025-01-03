<?php

namespace app\controllers;

use Yii;
use app\models\Comentario;
use app\models\Articulo;
use app\models\Tienda;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ComentariosController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionComentariosUsuario()
    {
        $usuario = Yii::$app->user->identity;
    
        if ($usuario === null) {
            throw new \yii\web\NotFoundHttpException('Usuario no encontrado.');
        }
    
        // Buscar comentarios del usuario autenticado
        $comentarios = Comentario::find()
            ->where(['registo_id' => $usuario->id])
            ->all();
    
        if (empty($comentarios)) {
            return $this->render('comentariosUsuario', [
                'comentariosTienda' => [],
                'comentariosArticulo' => [],
            ]);
        }
    
        // Clasificar los comentarios por tipo
        $comentariosTienda = [];
        $comentariosArticulo = [];
    
        foreach ($comentarios as $comentario) {
            if ($comentario->tienda_id && $comentario->tienda) {
                $comentariosTienda[] = $comentario;
            }
            if ($comentario->articulo_id && $comentario->articulo) {
                $comentariosArticulo[] = $comentario;
            }
        }
    
        // Renderizar la vista con los datos
        return $this->render('comentariosUsuario', [
            'comentariosTienda' => $comentariosTienda,
            'comentariosArticulo' => $comentariosArticulo,
        ]);
    }
    
    
}
