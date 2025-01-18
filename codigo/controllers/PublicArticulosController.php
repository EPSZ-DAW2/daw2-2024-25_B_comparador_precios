<?php

namespace app\controllers;

use Yii;
use app\models\ArticulosSearch;
use app\models\Articulo;
use app\models\ArticulosTienda;
use app\models\Comentario;
use app\models\Seguimiento;
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
		$model = $this->findModel($id);

		$comentario = new Comentario();
		$comentario->articulo_id = $id;

		if (Yii::$app->request->isPost) {
			// Verificar si el usuario está autenticado al intentar enviar un comentario
			if (Yii::$app->user->isGuest) {
				Yii::$app->session->setFlash('error', 'Debes iniciar sesión para comentar.');
				return $this->redirect(['site/login']);
			}

			// Asociar el comentario al usuario autenticado
			$comentario->registro_id = Yii::$app->user->identity->id;

			if ($comentario->load(Yii::$app->request->post()) && $comentario->save()) {
				Yii::$app->session->setFlash('success', 'Tu comentario ha sido guardado.');
				return $this->redirect(['view', 'id' => $id]);
			} else {
				Yii::$app->session->setFlash('error', 'Hubo un problema al guardar el comentario.');
			}
		}

		$comentarios = $model->getComentarios()->orderBy(['id' => SORT_DESC])->all();

		return $this->render('view', [
			'model' => $model,
			'comentario' => $comentario,
			'comentarios' => $comentarios,
		]);
	}

	/*protected function findModel($id)
	{
		if (($model = Articulo::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('El artículo solicitado no existe.');
	}*/
	
	protected function findModel($id)
	{
		if (($model = Articulo::find()->with('articuloTienda')->where(['id' => $id])->one()) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('El artículo solicitado no existe.');
	}


    public function actionDenunciar($id)
	{
		if (Yii::$app->user->isGuest) {
			Yii::$app->session->setFlash('error', 'Debes iniciar sesión para denunciar un artículo.');
			return $this->redirect(['site/login']);
		}

		// Buscar el registro en articulos_tienda
		$articuloTienda = ArticulosTienda::findOne($id);

		if (!$articuloTienda) {
			throw new NotFoundHttpException('El artículo no se encontró en esta tienda.');
		}

		if (Yii::$app->request->isPost) {
			// Capturar el motivo desde el formulario
			$nuevoMotivo = Yii::$app->request->post('motivo_denuncia');

			// Agregar el nuevo motivo de denuncia al artículo
			$articuloTienda->agregarMotivoDenuncia($nuevoMotivo);

			if ($articuloTienda->save(false)) {
				Yii::$app->session->setFlash('success', 'Denuncia registrada exitosamente.');
				return $this->redirect(['view', 'id' => $id]);
			} else {
				Yii::$app->session->setFlash('error', 'No se pudo registrar la denuncia. Por favor, inténtalo de nuevo.');
			}
		}

		return $this->render('denunciar', [
			'model' => $articuloTienda,
		]);
	}

    public function actionSeguimiento($id)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Debes iniciar sesión para seguir un artículo.');
            return $this->redirect(['site/login']);
        }

        $usuarioId = Yii::$app->user->identity->id;

        // Buscar seguimiento existente
		$seguimiento = Seguimiento::find()
			->where(['usuario_id' => $usuarioId, 'articulo_id' => $id])
			->one();

        if ($seguimiento) {
			// Si existe el seguimiento, elimínalo (desactivar seguimiento)
			$seguimiento->delete();
			Yii::$app->session->setFlash('success', 'Has dejado de seguir esta tienda.');
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
	
	public function actionVerHistorico($id)
	{
		// Obtener todos los registros relacionados con el artículo en ArticulosTienda
		$articulosTienda = ArticulosTienda::find()
			->where(['articulo_id' => $id])
			->all();

		$articulosList = ArrayHelper::map($articulosTienda, 'id', function ($model) {
			return $model->articulo->nombre ?? 'Sin nombre'; // Usamos la relación con el modelo Articulo
		});

		$historico = [];
		if (!empty($articulosTienda)) {
			$historico = HistoricoPrecios::find()
				->where(['articulo_id' => $id])
				->orderBy(['fecha' => SORT_DESC])
				->asArray()
				->all();
		}

		return $this->render('//tiendas/ver-historico', [
			'articulos' => $articulosList,
			'historico' => $historico,
			'selectedArticulo' => $id,
		]);
	}

}
