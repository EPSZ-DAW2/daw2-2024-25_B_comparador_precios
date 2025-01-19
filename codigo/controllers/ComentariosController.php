<?php

namespace app\controllers;

use Yii;
use app\models\Comentario;
use app\models\RegistroUsuarios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

class ComentariosController extends Controller
{
    public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Comentario::find()->with(['tienda', 'articulo']),
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
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
	
	public function actionGestionDenuncias($id)
	{
		$model = Comentario::findOne($id);

		if (!$model) {
			throw new NotFoundHttpException('Comentario no encontrado.');
		}

		if (Yii::$app->request->isPost) {
			$accion = Yii::$app->request->post('accion');
			$motivoBloqueo = Yii::$app->request->post('motivo_bloqueo', null);

			if ($accion === 'bloquear') {
				if (!empty($motivoBloqueo)) {
					$model->bloquear($motivoBloqueo);
					if ($model->save()) {
						Yii::$app->session->setFlash('success', 'El comentario ha sido bloqueado correctamente.');
					} else {
						Yii::$app->session->setFlash('error', 'Hubo un error al bloquear el comentario.');
					}
				} else {
					Yii::$app->session->setFlash('error', 'Debe proporcionar un motivo para bloquear el comentario.');
				}
			} elseif ($accion === 'desbloquear') {
				$model->desbloquear();
				if ($model->save()) {
					Yii::$app->session->setFlash('success', 'El comentario ha sido desbloqueado correctamente.');
				} else {
					Yii::$app->session->setFlash('error', 'Hubo un error al desbloquear el comentario.');
				}
			}

			return $this->redirect(['gestion-denuncias', 'id' => $id]);
		}

		return $this->render('gestion-denuncias', [
			'model' => $model,
		]);
	}

    public function actionView($id)
    {
        $model = Comentario::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Comentario no encontrado.');
        }

        return $this->render('view', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = Comentario::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Comentario no encontrado.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Comentario actualizado correctamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Comentario::findOne($id);
        if ($model) {
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'Comentario eliminado correctamente.');
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo eliminar el comentario.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Comentario no encontrado.');
        }

        return $this->redirect(['index']);
    }
}