<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Usuario;
use yii\web\BadRequestHttpException;

class RegistrosController extends Controller
{
    public function actionRegister()
    {
        $model = new Usuario();

        // Si el formulario es enviado y es válido
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Guardamos el modelo en la base de datos
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Te has registrado correctamente. Para poder usar tu cuenta deberá activarla un moderador.');
                return $this->redirect(['site/login']);
            }
        }

        return $this->render('registro', [
            'model' => $model,
        ]);
    }


}
?>
