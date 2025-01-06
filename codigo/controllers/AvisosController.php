<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Aviso; // Modelo Aviso
use app\models\Usuario; // Modelo Usuario

class AvisosController extends Controller
{
    // Acción para mostrar los avisos enviados por el usuario
    public function actionEnviados($id)
    {
        // Verifica si el usuario está autenticado
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Debes iniciar sesión para ver tus avisos.');
            return $this->redirect(['site/login']);
        }

        // Verifica si el id de usuario es válido
        $usuario = Usuario::findOne($id);
        if (!$usuario) {
            Yii::$app->session->setFlash('error', 'El usuario no existe.');
            return $this->redirect(['site/index']);
        }

        // Obtener los avisos enviados por el usuario
		$avisosEnviados = Aviso::find()
			->where(['usuario_origen_id' => Yii::$app->user->id]) // Usar el usuario logueado
			->orderBy(['fecha_aceptado' => SORT_DESC]) // Ordenar por fecha de aceptación
			->all();


        // Renderizar la vista de los avisos enviados
        return $this->render('enviados', [
            'usuario' => $usuario,
            'avisos' => $avisosEnviados,
        ]);
    }

    // Acción para mostrar los avisos recibidos por el usuario
    public function actionRecibidos($id)
    {
        // Verifica si el usuario está autenticado
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Debes iniciar sesión para ver tus avisos.');
            return $this->redirect(['site/login']);
        }

        // Verifica si el id de usuario es válido
        $usuario = Usuario::findOne($id);
        if (!$usuario) {
            Yii::$app->session->setFlash('error', 'El usuario no existe.');
            return $this->redirect(['site/index']);
        }

        // Obtener los avisos recibidos por el usuario
        $avisosRecibidos = Aviso::find()
            ->where(['usuario_destino_id' => $id])
            ->orderBy(['fecha_aceptado' => SORT_DESC]) // Ordenar por fecha de aceptación (puedes ajustar este criterio)
            ->all();

        // Renderizar la vista de los avisos recibidos
        return $this->render('recibidos', [
            'usuario' => $usuario,
            'avisos' => $avisosRecibidos,
        ]);
    }
	
		public function actionMarcarLeido($id)
	{
		// Verifica si el usuario está autenticado
		if (Yii::$app->user->isGuest) {
			Yii::$app->session->setFlash('error', 'Debes iniciar sesión para realizar esta acción.');
			return $this->redirect(['site/login']);
		}

		// Buscar el aviso por ID
		$aviso = Aviso::findOne($id);
		if (!$aviso) {
			Yii::$app->session->setFlash('error', 'El aviso no existe.');
			return $this->redirect(['avisos/enviados']); // Redirige a la página de avisos enviados si el aviso no existe
		}

		// Verificar si el aviso ya fue leído
		if ($aviso->fecha_lectura === null) {
			$aviso->fecha_lectura = date('Y-m-d H:i:s'); // Establecer la fecha de aceptación
			if ($aviso->save()) {
				Yii::$app->session->setFlash('success', 'El aviso ha sido marcado como leído.');
			} else {
				Yii::$app->session->setFlash('error', 'No se pudo marcar el aviso como leído.');
			}
		} else {
			Yii::$app->session->setFlash('info', 'Este aviso ya está marcado como leído.');
		}

			return $this->redirect(['avisos/recibidos', 'id' => Yii::$app->user->id]); // Redirige nuevamente a la página de avisos enviados
	}


			public function actionMarcarAceptado($id)
	{
		// Verifica si el usuario está autenticado
		if (Yii::$app->user->isGuest) {
			Yii::$app->session->setFlash('error', 'Debes iniciar sesión para realizar esta acción.');
			return $this->redirect(['site/login']);
		}

		// Buscar el aviso por ID
		$aviso = Aviso::findOne($id);
		if (!$aviso) {
			Yii::$app->session->setFlash('error', 'El aviso no existe.');
			return $this->redirect(['avisos/enviados']); // Redirige a la página de avisos enviados si el aviso no existe
		}

		// Verificar si el aviso ya fue aceptado
		if ($aviso->fecha_aceptado === null) { // Si la fecha_aceptado es NULL, significa que no está aceptado
			$aviso->fecha_aceptado = date('Y-m-d H:i:s'); // Establecer la fecha de aceptación
			if ($aviso->save()) {
				Yii::$app->session->setFlash('success', 'El aviso ha sido marcado como aceptado.');
			} else {
				Yii::$app->session->setFlash('error', 'No se pudo marcar el aviso como aceptado.');
			}
		} else {
			Yii::$app->session->setFlash('info', 'Este aviso ya está marcado como aceptado.');
		}

		return $this->redirect(['avisos/enviados', 'id' => Yii::$app->user->id]); // Redirige a la página de avisos enviados
	}

	// Enviar un aviso/mensaje a otro usuario.
	public function actionEnviar()
	{
		// Verifica si el usuario está autenticado
		if (Yii::$app->user->isGuest) {
			Yii::$app->session->setFlash('error', 'Debes iniciar sesión para enviar un aviso.');
			return $this->redirect(['site/login']);
		}

		// Crear un nuevo modelo de Aviso
		$aviso = new Aviso();
		$usuarios = Usuario::find()->all(); // Obtener todos los usuarios

		// Si el formulario es enviado
		if ($aviso->load(Yii::$app->request->post())) {
			// Buscar al usuario destino por su nick
			$usuarioDestino = Usuario::findOne(['nick' => $aviso->usuario_destino_nick]);

			// Si el usuario destino no existe
			if (!$usuarioDestino) {
				Yii::$app->session->setFlash('error', 'El usuario con ese nick no existe.');
				return $this->render('enviar', ['aviso' => $aviso, 'usuarios' => $usuarios]);
			}

			// Asignar el id del usuario destino al campo usuario_destino_id
			$aviso->usuario_destino_id = $usuarioDestino->id;
			$aviso->usuario_origen_id = Yii::$app->user->id; // El id del usuario que envía el aviso
			$aviso->fecha_envio = date('Y-m-d H:i:s'); // Asignar la fecha de envío

			// Guardar el aviso
			if ($aviso->save()) {
				Yii::$app->session->setFlash('success', 'Aviso enviado correctamente.');
				return $this->redirect(['avisos/enviados', 'id' => Yii::$app->user->id]);
			} else {
				Yii::$app->session->setFlash('error', 'No se pudo enviar el aviso.');
			}
		}

		// Renderizar el formulario
		return $this->render('enviar', [
			'aviso' => $aviso,
			'usuarios' => $usuarios,
		]);
	}

}
