<?php

namespace app\controllers;

use Yii;
use app\models\Comentario;
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
                'comentariosTienda' => [],
                'comentariosArticulo' => [],
            ]);
        }

        // Clasificar los comentarios por tipo
        $comentariosTienda = [];
        $comentariosArticulo = [];

        foreach ($comentarios as $comentario) {
            if (!empty($comentario->tienda_id) && $comentario->tienda !== null) {
                $comentariosTienda[] = $comentario;
            }
            if (!empty($comentario->articulo_id) && $comentario->articulo !== null) {
                $comentariosArticulo[] = $comentario;
            }
        }

        // Renderizar la vista con los datos clasificados
        return $this->render('comentariosUsuario', [
            'comentariosTienda' => $comentariosTienda,
            'comentariosArticulo' => $comentariosArticulo,
        ]);
    }
}
