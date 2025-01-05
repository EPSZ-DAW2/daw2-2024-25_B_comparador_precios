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

class SeguimientosController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSeguimientos()
    {
        $usuario = Yii::$app->user->identity;
    
        if ($usuario === null) {
            throw new \yii\web\NotFoundHttpException('Usuario no encontrado.');
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
    

}
