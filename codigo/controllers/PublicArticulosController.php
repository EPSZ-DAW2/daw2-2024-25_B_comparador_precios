<?php

namespace app\controllers;

use Yii;
use app\models\ArticulosSearch;
use app\models\Articulo;
use app\models\Comentario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PublicArticulosController extends Controller
{
	
    public function actionPublicIndex()
    {
        $searchModel = new ArticulosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('public-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionView($id)
    {
        $model = Articulo::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('El artículo solicitado no existe.');
        }

        // Cargar comentarios existentes
        $comentarios = Comentario::find()
            ->where(['articulo_id' => $id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        // Crear modelo para agregar un nuevo comentario
        $comentario = new Comentario();
        $comentario->articulo_id = $id;

        // Guardar comentario si el formulario se envía
        if (Yii::$app->request->isPost) {
            if (Yii::$app->user->isGuest) {
                Yii::$app->session->setFlash('error', 'Debes iniciar sesión para comentar.');
                return $this->redirect(['site/login']);
            }
            $comentario->usuario_id = Yii::$app->user->identity->id; // Usuario autenticado
            if ($comentario->load(Yii::$app->request->post()) && $comentario->save()) {
                Yii::$app->session->setFlash('success', 'Comentario añadido con éxito.');
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('view', [
            'model' => $model,
            'comentarios' => $comentarios,
            'comentario' => $comentario,
        ]);
    }

    public function actionDenunciar($id)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Debes iniciar sesión para denunciar.');
            return $this->redirect(['site/login']);
        }

        $model = Articulo::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('El artículo solicitado no existe.');
        }

        $model->denuncias += 1;
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Denuncia registrada con éxito.');
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo registrar la denuncia.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionSeguimiento($id)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Debes iniciar sesión para seguir un artículo.');
            return $this->redirect(['site/login']);
        }

        $usuarioId = Yii::$app->user->identity->id;

        $seguimiento = Seguimiento::findOne(['usuario_id' => $usuarioId, 'articulo_id' => $id]);

        if ($seguimiento) {
            $seguimiento->delete();
            Yii::$app->session->setFlash('success', 'Has dejado de seguir este artículo.');
        } else {
            $seguimiento = new Seguimiento();
            $seguimiento->usuario_id = $usuarioId;
            $seguimiento->articulo_id = $id;
            $seguimiento->fecha = date('Y-m-d H:i:s');
            if ($seguimiento->save()) {
                Yii::$app->session->setFlash('success', 'Ahora sigues este artículo.');
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo seguir este artículo.');
            }
        }

        return $this->redirect(['view', 'id' => $id]);
    }
}

