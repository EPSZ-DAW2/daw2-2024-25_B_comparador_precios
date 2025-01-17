<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Aviso; // Modelo Aviso
use app\models\Usuario; // Modelo Usuario
use app\models\Moderador; 

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

	/*
	// Mostrar avisos al administrador
	public function actionAvisosAdministrador()
	{
		// Verifica si el usuario actual es un administrador
		if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR)) {
			Yii::$app->session->setFlash('error', 'No tienes permiso para acceder a esta sección.');
			return $this->redirect(['site/index']);
		}

		// Obtener los avisos pendientes (donde fecha_lectura sea NULL)
		$avisos = Aviso::find()
			->where(['usuario_destino_id' => Yii::$app->user->id]) // Avisos dirigidos al admin logueado
			->andWhere(['fecha_lectura' => null]) // Avisos no leídos
			->orderBy(['id' => SORT_DESC]) // Ordenar por ID descendente
			->all();

		// Renderizar la vista de los avisos
		return $this->render('avisos_administrador', [
			'avisos' => $avisos,
		]);
	}

	
	// Dar de baja a un moderador
	public function actionDarBaja($id)
	{
		// Verifica si el usuario actual es un administrador
		if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR)) {
			Yii::$app->session->setFlash('error', 'No tienes permiso para realizar esta acción.');
			return $this->redirect(['site/index']);
		}

		// Buscar al moderador en la tabla usuarios por su ID
		$moderador = Usuario::findOne($id); // Buscar en la tabla usuarios
		if (!$moderador || $moderador->rol !== Usuario::ROL_MODERADOR) {
			// Verifica si el moderador no existe o si no tiene el rol de moderador
			Yii::$app->session->setFlash('error', 'El moderador no existe.');
			return $this->redirect(['avisos/avisos-administrador']);
		}

		// Marcar al moderador como dado de baja
		$moderador->rol = Usuario::ROL_INVITADO;  // Cambiar el rol a "Invitado" para dar de baja
		$moderador->bloqueado = 1;  // Marcar como bloqueado si es necesario
		$moderador->fecha_bloqueo = date('Y-m-d H:i:s'); // Fecha de bloqueo actual

		// Guardar los cambios
		if ($moderador->save()) {
			Yii::$app->session->setFlash('success', 'El moderador ha sido dado de baja correctamente.');
		} else {
			Yii::$app->session->setFlash('error', 'No se pudo dar de baja al moderador.');
		}

		return $this->redirect(['avisos/avisos-administrador']);
	}

	/*
	// Dar de baja a un moderador
	public function actionDarBaja($id)
	{
		// Verifica si el usuario actual es un administrador
		if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR)) {
			Yii::$app->session->setFlash('error', 'No tienes permiso para realizar esta acción.');
			return $this->redirect(['site/index']);
		}

		// Buscar al moderador por su ID
		$moderador = Moderador::findOne($id); // Cambiado a la tabla Moderador si el moderador está en esta tabla
		if (!$moderador) {
			Yii::$app->session->setFlash('error', 'El moderador no existe.');
			return $this->redirect(['avisos/avisos-administrador']);
		}

		// Eliminar al moderador
		if ($moderador->delete()) {
			// Eliminar avisos relacionados
			$avisos = Aviso::find()
				->where(['usuario_origen_id' => $moderador->id, 'usuario_destino_id' => Yii::$app->user->id])
				->all();

			foreach ($avisos as $aviso) {
				$aviso->delete();
			}

			Yii::$app->session->setFlash('success', 'El moderador y sus avisos relacionados han sido eliminados correctamente.');
		} else {
			Yii::$app->session->setFlash('error', 'No se pudo eliminar al moderador.');
		}

		return $this->redirect(['avisos/avisos-administrador']);
	}
	
	

	// Eliminar un aviso
	public function actionEliminarAviso($id)
	{
		// Verifica si el usuario actual es un administrador
		if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR)) {
			Yii::$app->session->setFlash('error', 'No tienes permiso para realizar esta acción.');
			return $this->redirect(['site/index']);
		}

		// Buscar el aviso por su ID
		$aviso = Aviso::findOne($id);
		if (!$aviso) {
			Yii::$app->session->setFlash('error', 'El aviso no existe.');
			return $this->redirect(['avisos/avisos-administrador']);
		}

		// Eliminar el aviso
		if ($aviso->delete()) {
			Yii::$app->session->setFlash('success', 'El aviso ha sido eliminado correctamente.');
		} else {
			Yii::$app->session->setFlash('error', 'No se pudo eliminar el aviso.');
		}

		return $this->redirect(['avisos/avisos-administrador']);
	}
		*/
	
	
	// Mostrar avisos al administrador
	public function actionAvisosAdministrador()
	{
		// Verifica si el usuario actual es un administrador
		if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR)) {
			Yii::$app->session->setFlash('error', 'No tienes permiso para acceder a esta sección.');
			return $this->redirect(['site/index']);
		}

		// Obtener los avisos pendientes (donde `fecha_lectura` sea NULL)
		$avisos = Aviso::find()
			->where(['usuario_destino_id' => Yii::$app->user->id]) // Avisos dirigidos al admin logueado
			->andWhere(['fecha_lectura' => null]) // Avisos no leídos
			->orderBy(['id' => SORT_DESC]) // Ordenar por ID descendente
			->all();

		// Renderizar la vista de los avisos
		return $this->render('avisos_administrador', [
			'avisos' => $avisos,
		]);
	}

	// Eliminar un aviso
	public function actionEliminarAviso($id)
	{
		// Verifica si el usuario actual es un administrador
		if (!Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR)) {
			Yii::$app->session->setFlash('error', 'No tienes permiso para realizar esta acción.');
			return $this->redirect(['site/index']);
		}

		// Buscar el aviso por su ID
		$aviso = Aviso::findOne($id);
		if (!$aviso) {
			Yii::$app->session->setFlash('error', 'El aviso no existe.');
			return $this->redirect(['avisos/avisos-administrador']);
		}

		// Eliminar el aviso
		if ($aviso->delete()) {
			Yii::$app->session->setFlash('success', 'El aviso ha sido eliminado correctamente.');
		} else {
			Yii::$app->session->setFlash('error', 'No se pudo eliminar el aviso.');
		}

		return $this->redirect(['avisos/avisos-administrador']);
	}

	public function actionLimpiarMensajes()
	{
		// Verifica si el usuario está autenticado
		if (Yii::$app->user->isGuest) {
			Yii::$app->session->setFlash('error', 'Debes iniciar sesión para realizar esta acción.');
			return $this->redirect(['site/login']);
		}

		// Obtener todos los avisos dirigidos al usuario autenticado
		$avisos = Aviso::find()->where(['usuario_destino_id' => Yii::$app->user->id])->all();

		foreach ($avisos as $aviso) {
			// Elimina el aviso de la base de datos
			$aviso->delete();
		}

		// Mensaje de confirmación
		Yii::$app->session->setFlash('success', 'Todos los mensajes han sido eliminados exitosamente.');
		return $this->redirect(['avisos/recibidos', 'id' => Yii::$app->user->id]);
	}
}
