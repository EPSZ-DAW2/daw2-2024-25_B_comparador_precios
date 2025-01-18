<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Usuario;
use app\models\RegistroLogs;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     * Modificada para incluir un registro en el log al iniciar sesión correctamente.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {
            $usuario = Usuario::findOne(['nick' => $model->username]);

            if ($usuario) {
                // Verificar si el usuario está bloqueado
                if ($usuario->estaBloqueado()) {
                    $tiempoRestante = $usuario->obtenerTiempoRestanteBloqueo();
                    $horas = floor($tiempoRestante / 3600);
                    $minutos = floor(($tiempoRestante % 3600) / 60);
                    Yii::$app->session->setFlash('error', "Tu cuenta está bloqueada. Intenta nuevamente en $horas horas y $minutos minutos.");
                    return $this->render('login', ['model' => $model]);
                }

                // Verificar si el usuario está aceptado
                if ($usuario->registro_confirmado == Usuario::ESTADO_REGISTRO_PENDIENTE) {
                    Yii::$app->session->setFlash('error', "Tu cuenta no ha sido verificada.");
                    return $this->render('login', ['model' => $model]);
                }

                // Si la contraseña es correcta, realizamos el login
                if ($model->login()) {
                    // Reseteamos los intentos fallidos
                    $usuario->reiniciarIntentosFallidos();
                    $usuario->fecha_acceso = date('Y-m-d\TH:i:sP');
                    $usuario->save();

                    // Registrar en el log el inicio de sesión exitoso
                    $this->actionLog(
                        'Inicio de Sesión',
                        "El usuario {$usuario->nick} ha iniciado sesión correctamente.",
                        'Login'
                    );

                    Yii::$app->session->setFlash('success', 'Inicio de sesión exitoso.');
                    return $this->goBack();
                } else {
                    // Incrementamos los intentos fallidos si la contraseña es incorrecta
                    $usuario->aumentarIntentosFallidos();

                    if ($usuario->accesos_fallidos >= Yii::$app->params['loginAttemptLimit']) {
                        $usuario->bloquearUsuario();
                        $usuario->motivo_bloqueo = 'Intentos máximos de logueo sobrepasados';
						$usuario->fecha_bloqueo = date('Y-m-d\TH:i:sP');
                        $usuario->save();
                        Yii::$app->session->setFlash('error', 'Demasiados intentos fallidos. Tu cuenta está bloqueada temporalmente.');
                    } else {
                        $intentosRestantes = Yii::$app->params['loginAttemptLimit'] - $usuario->accesos_fallidos;
                        Yii::$app->session->setFlash('error', "Intento fallido. Te quedan $intentosRestantes intentos.");
                    }

                    // Registrar intento fallido en el log
                    Yii::info("Intento fallido de login para el usuario: {$usuario->nick}", 'login_attempts');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Usuario no encontrado.');
            }
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        // Registrar en el log el cierre de sesión
        $this->actionLog(
            'Cierre de Sesión',
            "El usuario " . Yii::$app->user->identity->username . " ha cerrado sesión.",
            'Logout'
        );

        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Función protegida para registrar logs.
     *
     * @param string $accion
     * @param string $detalles
     * @param string $tipoAccion
     */
    protected function actionLog($accion, $detalles, $tipoAccion)
    {
        $log = new RegistroLogs();
        $log->usuario = Yii::$app->user->isGuest ? 'Invitado' : Yii::$app->user->identity->username;
        $log->nivel = 'INFO';
        $log->mensaje = $detalles;
        $log->accion = $tipoAccion;
        $log->fecha_log = date('Y-m-d H:i:s');

        if (!$log->save()) {
            Yii::error('Error al guardar el registro de log: ' . json_encode($log->errors));
        } else {
            Yii::info("Log registrado correctamente: {$accion}");
        }
    }

    /**
     * Acción para el área de Administración.
     * Verifica que el usuario tiene el rol de Administrador o Superadministrador.
     * Si no tiene el rol adecuado, lanza una excepcion.
     */
    public function actionAreaAdministracion()
    {
        if (!Yii::$app->user->isGuest && (Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR) || Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR))) {
            return $this->render('area-administracion');
        }

        throw new \yii\web\ForbiddenHttpException('No tienes permiso para realizar esta acción.');
    }

    /**
     * Acción para el área de Moderador.
     * Verifica que el usuario tiene el rol de Moderador o Superadministrador.
     * Si no tiene el rol adecuado, lanza una excepcion.
     */
    public function actionAreaModerador()
    {
        if (!Yii::$app->user->isGuest && (Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_MODERADOR) || Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR))) {
            return $this->render('area-moderador');
        }

        throw new \yii\web\ForbiddenHttpException('No tienes permiso para realizar esta acción.');
    }

    public function actionRegistros()
    {
        // Redirige a la acción 'index' del controlador 'RegistrosController'
        return $this->redirect(['registros/registro']);
    }

    /**
     * Acción para el área de Usuario Tienda.
     * Verifica que el usuario tiene el rol de Usuario Tienda o Superadministrador.
     * Si no tiene el rol adecuado, lanza una excepcion.
     */
    public function actionAreaUsuarioTienda()
    {
        if (!Yii::$app->user->isGuest && (Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_USUARIO_TIENDA) || Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR))) {
            return $this->render('area-usuario-tienda');
        }

        throw new \yii\web\ForbiddenHttpException('No tienes permiso para realizar esta acción.');
    }

    public function actionAvisoLegal()
    {
        return $this->render('aviso-legal');
    }

    public function actionPoliticaPrivacidad()
    {
        return $this->render('politica-privacidad');
    }

    public function actionPoliticaCookies()
    {
        return $this->render('politica-cookies');
    }

    public function actionBuscador()
    {
        return $this->render('buscador');
    }

    /**
     * Acción para el área Superadministrador.
     * Verifica si el usuario tiene el rol de Superadministrador antes de mostrar la vista.
     * Si no tiene el rol adecuado, lanza una excepcion.
     */
    public function actionAreaSuperadministrador()
    {
        if (!Yii::$app->user->isGuest && Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR)) {
            return $this->render('area-superadministrador');
        }

        throw new \yii\web\ForbiddenHttpException('No tienes permiso para realizar esta acción.');
    }
}
