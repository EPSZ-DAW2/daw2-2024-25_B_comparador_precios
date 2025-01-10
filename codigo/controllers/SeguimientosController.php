<?php

namespace app\controllers;

use Yii;
use app\models\Seguimiento;
use app\models\Articulo;
use app\models\Tienda;
use app\models\Oferta;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SeguimientosController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSeguimientos()
    {
        $usuario = Yii::$app->user->identity;
    
        if ($usuario === null) {
            throw new NotFoundHttpException('Usuario no encontrado.');
        }
    
        // Buscar seguimientos del usuario autenticado
        $seguimientos = Seguimiento::find()
            ->where(['usuario_id' => $usuario->id])
            ->all();
    
        if (empty($seguimientos)) {
            return $this->render('seguimientos', [
                'seguimientosTienda' => [],
                'seguimientosArticulo' => [],
                'seguimientosOferta' => [],
            ]);
        }
    
        // Clasificar los seguimientos por tipo
        $seguimientosTienda = [];
        $seguimientosArticulo = [];
        $seguimientosOferta = [];
    
        foreach ($seguimientos as $seguimiento) {
            if ($seguimiento->tienda_id && $seguimiento->tienda) {
                $seguimientosTienda[] = $seguimiento->tienda;
            }
            if ($seguimiento->articulo_id && $seguimiento->articulo) {
                $seguimientosArticulo[] = $seguimiento->articulo;
            }
            if ($seguimiento->oferta_id && $seguimiento->oferta) {
                $seguimientosOferta[] = $seguimiento->oferta;
            }
        }
    
        // Renderizar la vista con los datos
        return $this->render('seguimientos', [
            'seguimientosTienda' => $seguimientosTienda,
            'seguimientosArticulo' => $seguimientosArticulo,
            'seguimientosOferta' => $seguimientosOferta,
        ]);
    }

    /*public function actionSeguimiento($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $usuarioId = Yii::$app->user->identity->id;

        // Buscar seguimiento existente
        $seguimiento = Seguimiento::find()
            ->where(['usuario_id' => $usuarioId, 'tienda_id' => $id])
            ->one();

        if ($seguimiento) {
            // Si existe el seguimiento, elimínalo (desactivar seguimiento)
            $seguimiento->delete();
            Yii::$app->session->setFlash('success', 'Has dejado de seguir esta tienda.');
        } else {
            // Si no existe, crea uno nuevo (activar seguimiento)
            $seguimiento = new Seguimiento();
            $seguimiento->usuario_id = $usuarioId;
            $seguimiento->tienda_id = $id;
            $seguimiento->fecha = date('Y-m-d H:i:s');
            if ($seguimiento->save()) {
                Yii::$app->session->setFlash('success', 'Ahora sigues esta tienda.');
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo seguir la tienda.');
            }
        }

        return $this->redirect(['tiendas/view', 'id' => $id]);
    }*/
    

}
