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
     * Login action. Ahora tiene en cuenta los intentos fallidos, fechas de acceso, etc...
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
						// Si está bloqueado, mostramos un mensaje con el tiempo restante
						$tiempoRestante = $usuario->obtenerTiempoRestanteBloqueo();
						$horas = floor($tiempoRestante / 3600);
						$minutos = floor(($tiempoRestante % 3600) / 60);
						Yii::$app->session->setFlash('error', "Tu cuenta está bloqueada. Intenta nuevamente en $horas horas y $minutos minutos.");
						return $this->render('login', ['model' => $model]);
					}
					// Verificar si el usuario está aceptado
					if( $usuario->registro_confirmado == Usuario::ESTADO_REGISTRO_PENDIENTE) {
						Yii::$app->session->setFlash('error', "Tu cuenta no ha sido verificada.");
						return $this->render('login', ['model' => $model]);
					}

					// Si la contraseña es correcta, realizamos el login
					if ($model->login()) {
						// Reseteamos los intentos fallidos
						$usuario->reiniciarIntentosFallidos();
                        			$usuario->fecha_acceso = date('Y-m-d\TH:i:sP');
                        			$usuario->save();
						Yii::$app->session->setFlash('success', 'Inicio de sesión exitoso.');
						return $this->goBack();
					} else {
						// Si la contraseña es incorrecta, incrementamos los intentos fallidos
						$usuario->aumentarIntentosFallidos();

						// Si el número de intentos fallidos supera el límite
						if ($usuario->accesos_fallidos >= Yii::$app->params['loginAttemptLimit']) {
							$usuario->bloquearUsuario(); // Bloqueamos al usuario
							$usuario->motivo_bloqueo='Intentos máximos de loggeo sobrepasados'; 
							
							// Guardamos el modelo para persistir el cambio en la base de datos
							if ($usuario->save()) {
								Yii::$app->session->setFlash('error', 'Demasiados intentos fallidos. Tu cuenta está bloqueada temporalmente.');
							} else {
								// Si hay algún error al guardar, muestra un mensaje
								Yii::$app->session->setFlash('error', 'Hubo un error al intentar bloquear tu cuenta.');
							}

						}

						// Si aún no se supera el límite, informamos de los intentos restantes
						$intentosRestantes = Yii::$app->params['loginAttemptLimit'] - $usuario->accesos_fallidos;
						Yii::$app->session->setFlash('error', "Intento fallido. Te quedan $intentosRestantes intentos.");

						// Registrar en el log
						Yii::info('Intento fallido de login para el usuario: ' . $usuario->email, 'login_attempts');
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
}
