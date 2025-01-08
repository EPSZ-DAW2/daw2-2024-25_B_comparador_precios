<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Security;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 * @property string|null $nick
 * @property string|null $nombre
 * @property string|null $apellidos
 * @property string|null $direccion
 * @property int|null $region_id
 * @property string|null $telefono
 * @property string|null $fecha_nacimiento
 * @property string|null $fecha_registro
 * @property int|null $registro_confirmado
 * @property string|null $fecha_acceso
 * @property int|null $accesos_fallidos
 * @property int|null $bloqueado
 * @property string|null $fecha_bloqueo
 * @property string|null $motivo_bloqueo
 *
 * @property Avisos[] $avisos
 * @property Avisos[] $avisos0
 * @property Duenos[] $duenos
 * @property Regiones $region
 * @property RegistroUsuarios[] $registroUsuarios
 * @property Seguimientos[] $seguimientos
 */
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

	// Definimos roles como constantes
    const ROL_INVITADO = 'Invitado';
    const ROL_USUARIO_NORMAL = 'Usuario Normal';
    const ROL_USUARIO_TIENDA = 'Usuario Tienda';
    const ROL_MODERADOR = 'Moderador';
    const ROL_ADMINISTRADOR = 'Administrador';
    const ROL_SUPERADMINISTRADOR = 'Superadministrador';  
    
    const ESTADO_REGISTRO_PENDIENTE = 0;
	  const ESTADO_REGISTRO_CONFIRMADO = 1;
	  
	  const SCENARIO_REGISTER = 'register';
	  
      //Atributos para almacenar el control de cambio de la posible contraseña.
      public $password1;
      public $password2;
	  
	     // Propiedades temporales para el formulario (No están en la base de datos)
		public $region_continente;
		public $region_pais;
		public $region_estado;
		public $region_provincia;
	
        public $primer_fallo;
        public $bloqueado_hasta; //Si es un atributo vinculado con la base de datos NO hagas esto
	  
	    public $password_repeat;

    //--->>>
    // Métodos necesarios para configurar el modelo respecto de la tabla a la que representa en la base de datos.
    //--->>>
  

    
    //PENDIENTE: Método "rules".
    //PENDIENTE: Método "attributeLabels".
    //PENDIENTE: Método "scenarios" (opcional).
    //PENDIENTE: Método "find".
    
    //<<<---
    // Métodos necesarios para configurar el modelo respecto de la tabla a la que representa en la base de datos.
    //<<<---
	
	    public function attributes()
    {
        // Devuelve todos los atributos que deben ser gestionados por ActiveRecord
        return array_merge(parent::attributes(), ['primer_fallo', 'bloqueado_hasta']);
    }
    
    //--->>>
    // Métodos necesarios para cumplir con el "IdentityInterface".
    //--->>>
    
        /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'nick', 'nombre', 'apellidos'], 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            ['nick', 'unique'],
            [['email', 'password', 'nick', 'nombre', 'apellidos'], 'string', 'max' => 255],

            [['region_id', 'registro_confirmado', 'accesos_fallidos', 'bloqueado'], 'integer'],
            [['fecha_nacimiento', 'fecha_registro', 'fecha_acceso', 'fecha_bloqueo'], 'safe'],
            ['password_repeat', 'required', 'on' => 'register'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => 'register'],
            [['telefono'], 'string', 'max' => 20],
            [['direccion', 'motivo_bloqueo'], 'string'],
            [['fecha_nacimiento'], 'date', 'format' => 'php:Y-m-d'],
            [['primer_fallo', 'motivo_bloqueo', 'bloqueado_hasta'], 'safe'],

            ['password_repeat', 'required', 'on' => self::SCENARIO_REGISTER],
            ['password_repeat', 'compare', 'compareAttribute' => 'password_hash', 'on' => self::SCENARIO_REGISTER],

            [['registro_confirmado'], 'default', 'value' => self::ESTADO_REGISTRO_PENDIENTE],
            [['fecha_registro'], 'default', 'value' => date('Y-m-d H:i:s')],

            // Validación condicional de los campos de región
            [['region_continente', 'region_pais', 'region_estado', 'region_provincia'], 'required', 
                'when' => function ($model) {
                    return !empty($model->region_continente) || !empty($model->region_pais) || !empty($model->region_estado) || !empty($model->region_provincia);
                }, 
                'whenClient' => "function (attribute, value) {
                    return $('#usuario-region_continente').val() !== '' || 
                        $('#usuario-region_pais').val() !== '' || 
                        $('#usuario-region_estado').val() !== '' || 
                        $('#usuario-region_provincia').val() !== '';
                }"
            ],

            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regiones::class, 'targetAttribute' => ['region_id' => 'id']],

            // Validación para el campo rol (tipo enum)
            ['rol', 'in', 'range' => ['Invitado', 'Usuario Normal', 'Usuario Tienda', 'Moderador', 'Administrador', 'Superadministrador']],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'nick' => 'Nick',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'direccion' => 'Direccion',
            'region_id' => 'Region ID',
            'telefono' => 'Telefono',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'fecha_registro' => 'Fecha Registro',
            'registro_confirmado' => 'Registro Confirmado',
            'fecha_acceso' => 'Fecha Acceso',
            'accesos_fallidos' => 'Accesos Fallidos',
            'bloqueado' => 'Bloqueado',
            'fecha_bloqueo' => 'Fecha Bloqueo',
            'motivo_bloqueo' => 'Motivo Bloqueo',
        ];
    }

    /**
     * Gets query for [[Avisos]].
     *
     * @return \yii\db\ActiveQuery|AvisosQuery
     */
    public function getAvisos()
    {
        return $this->hasMany(Avisos::class, ['usuario_destino_id' => 'id']);
    }

    /**
     * Gets query for [[Avisos0]].
     *
     * @return \yii\db\ActiveQuery|AvisosQuery
     */
    public function getAvisos0()
    {
        return $this->hasMany(Avisos::class, ['usuario_origen_id' => 'id']);
    }

    /**
     * Gets query for [[Duenos]].
     *
     * @return \yii\db\ActiveQuery|DuenosQuery
     */
    public function getDuenos()
    {
        return $this->hasMany(Duenos::class, ['id_usuario' => 'id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery|RegionesQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Regiones::class, ['id' => 'region_id']);
    }


    /**
     * Gets query for [[RegistroUsuarios]].
     *
     * @return \yii\db\ActiveQuery|RegistroUsuariosQuery
     */
    public function getRegistroUsuarios()
    {
        return $this->hasMany(RegistroUsuarios::class, ['creador_id' => 'id']);
    }

    /**
     * Gets query for [[Seguimientos]].
     *
     * @return \yii\db\ActiveQuery|SeguimientosQuery
     */
    public function getSeguimientos()
    {
        return $this->hasMany(Seguimientos::class, ['usuario_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsuariosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsuariosQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
      $model= null;
      
      //Programar aquí la carga de un "Usuario" por su clave primaria.
      if (!empty( $id)) $model= static::findOne( $id);
      
      return $model;
    }
    
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
      $model= null;
      
      //Programar aquí la carga de un "Usuario" por su "token" de acceso 
      //el cual puede ser una variante de su clave primaria o similar para
      //asegurar que sea único en la tabla correspondiente.
      //*** Sustituir "CAMPO_TOKEN" por el nombre correspondiente.
      if (!empty( $token)) $model= static::findOne( ['CAMPO_TOKEN'=>$token]);
      
      return $model;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
      //*** Sustituir "CAMPO_CLAVE_PRIMARIA" por el nombre correspondiente.
      return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
      //*** Sustituir "CAMPO_CLAVE_AUTORIZACION" por el nombre correspondiente
      //o generar un resultado en función del campo "CAMPO_CLAVE_PRIMARIA" si
      //no se implementa un servicio web que necesite mayor seguridad.
      return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
      return $this->getAuthKey() === $authKey;
    }
    
    //<<<---
    // Métodos necesarios para cumplir con el "IdentityInterface".
    //<<<---
    
    /**
     * Buscar un modelo "Usuario" por su nombre de usuario o el típico campo
     * "login" o "email" o similar.
     *
     * Este método no pertenece al "IdentityInterface", se introduce para 
     * delegar el sistema de "login" al "LoginForm".
     *
     * @param string $username
     * @return static|null
     */

     public function getUsername()
     {
         return $this->nick;
     }


    public static function findByUsername($username)
    {
      $model= null;
      
      //Programar aquí la carga de un "Usuario" por su "login" de usuario o similar.
      //*** Sustituir "CAMPO_LOGIN" por el nombre correspondiente.
      //*** Descomentar y sustituir "CAMPO_ACTIVO" por el nombre correspondiente
      //si se utiliza un posible sistema de usuario activo o inactivo.
      //*** Descomentar y sustituir "CAMPO_BLOQUEADO" por el nombre correspondiente
      //si se utiliza un posible sistema de usuario bloqueado o no bloqueado.
      $model= static::findOne([
          'nick' => $username
        //, 'CAMPO_ACTIVO'=>true
        , 'bloqueado'=>false
      ]);
      
      return $model;
    }
  
    /**
     * Validar la contraseña recibida con la que contiene la instancia actual
     * del modelo de usuario.
     *
     * Este método no pertenece al "IdentityInterface", se introduce para 
     * delegar el sistema de "login" al "LoginForm".
     *
     * @param string $password password a validar
     * @return bool Si la clave es válida para el usuario actual.
     */
    public function validatePassword($password)
    {
      //*** Sustituir "CAMPO_PASSWORD" por el nombre correspondiente.
      //*** Si el "CAMPO_PASSWORD" está ofuscado-diversificado por alguna 
      //función HASH se debe aplicar la función HASH a "$password" antes 
      //de comparar, o si se usa el sistema "Security" de Yii2, se debe hacer
      //la comparación usando sus funcionalidades.
      return ($this->password === $password);
      /*---*-/
      $hashPassword= ALGUNA_FUNCION_HASH( $password);
      return ($this->CAMPO_PASSWORD === $hashPassword);
      //---*/
      
    }
	
	
	//funciones de inicio de sesión y bloqueo: -------------------------------------------

    // Método para aumentar el contador de fallos

public function aumentarIntentosFallidos()
{
    $this->accesos_fallidos++;

    // Verifica si es el primer fallo
    if ($this->accesos_fallidos === 1) {
        // Si es el primer fallo, guardar la fecha del primer intento fallido
        $this->primer_fallo = date('Y-m-d H:i:s');
        Yii::info('Primer fallo registrado: ' . $this->primer_fallo, 'login_attempts'); // Log para verificar
    } else {
        Yii::info('No es el primer fallo, intentos fallidos: ' . $this->accesos_fallidos, 'login_attempts');
    }

    // Intentamos guardar los cambios
    if ($this->save()) {
        Yii::info('Intentos fallidos guardados correctamente para el usuario: ' . $this->nick, 'login_attempts');
    } else {
        Yii::error('Error al guardar los intentos fallidos', 'login_attempts');
        // Log adicional de errores en el modelo
        Yii::error(print_r($this->errors, true), 'login_attempts');
    }
}


    // Método para reiniciar los intentos fallidos
    public function reiniciarIntentosFallidos()
    {
        $this->accesos_fallidos = 0;
        $this->primer_fallo = null;
        $this->bloqueado_hasta = null; // Se reinicia la fecha de bloqueo también
        $this->save();
    }

    // Método para verificar si el usuario está bloqueado
    public function estaBloqueado()
    {
        if ($this->bloqueado && strtotime($this->bloqueado_hasta) > time()) {
            return true;
        }
        return false;
    }

    // Método para bloquear al usuario
    public function bloquearUsuario()
    {
        $duracionBloqueo = Yii::$app->params['loginBlockDuration'] * 60; // Tiempo de bloqueo en segundos
        $this->bloqueado_hasta = date('Y-m-d H:i:s', time() + $duracionBloqueo);
        $this->bloqueado = 1;
        $this->save();
    }

    // Método para obtener el tiempo restante de bloqueo
    public function obtenerTiempoRestanteBloqueo()
    {
        $restante = strtotime($this->bloqueado_hasta) - time();
        return max(0, $restante); // Devuelve el tiempo restante en segundos
    }

    // Método para comprobar si el tiempo de bloqueo ha pasado
    public function haPasadoTiempoDeBloqueo()
    {
        return $this->bloqueado_hasta && strtotime($this->bloqueado_hasta) <= time();
    }

    // Método para resetear el bloqueo si ya pasó el tiempo
    public function resetearBloqueo()
    {
        if ($this->haPasadoTiempoDeBloqueo()) {
            $this->bloqueado = 0;
            $this->bloqueado_hasta = null;
            $this->save();
        }
    }


// funciones de autenticación y validación -----------------------------------------------
	
 // Función para generar el enlace de confirmación de registro
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    // Método actualizado para usar constantes
    public static function tieneRol($idUsuario, $rol)
    {
        if (!in_array($rol, [
            self::ROL_INVITADO,
            self::ROL_USUARIO_NORMAL,
            self::ROL_USUARIO_TIENDA,
            self::ROL_MODERADOR,
            self::ROL_ADMINISTRADOR,
            self::ROL_SUPERADMINISTRADOR,
        ])) {
            throw new InvalidArgumentException("Rol no válido: {$rol}");
        }

        if (Yii::$app->user->id === $idUsuario) {
            $usuario = Yii::$app->user->identity;
        } else {
            $usuario = Usuario::findOne(['id' => $idUsuario]);
        }

        return $usuario !== null && strcasecmp($usuario->rol, $rol) === 0;
    }

    
    /*
    Ejemplo para comprobar si un usuario es administrador
    public function actionAdminOnly()
    {
        // Comprueba si el usuario tiene el rol de administrador
        if (Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR)) {
            // Código para usuarios administradores
            return $this->render('admin-page');
        }

        // Lanza una excepción si el usuario no tiene el rol
        throw new ForbiddenHttpException('No tienes permiso para acceder a esta página.');
    }
    */

    /*
    // Función para verificar si un usuario tiene un rol específico
    public static function tieneRol($idUsuario, $rol){
        $usuario = Usuario::findOne(['id' => $idUsuario]);
        if ($usuario !== null && $usuario->rol === $rol) {
            return true;
        }
        return false;
    }
    
    /* Para comprobar un rol especifico como administrador seria asi:
        if (Usuario::tieneRol(Yii::$app->user->id, 'Administrador')) {
        // Permitir acceso
        } else {
            throw new ForbiddenHttpException('No tienes permiso para acceder a esta página.');
        } */

        public function isInvitado()
        {
            return $this->rol === self::ROL_INVITADO;
        }
    
        public function isUsuarioNormal()
        {
            return $this->rol === self::ROL_USUARIO_NORMAL;
        }
    
        public function isUsuarioTienda()
        {
            return $this->rol === self::ROL_USUARIO_TIENDA;
        }
    
        public function isModerador()
        {
            return $this->rol === self::ROL_MODERADOR;
        }

        public function isAdmin()
        {
            return $this->rol === self::ROL_ADMINISTRADOR;
        }

        public function isSuperAdmin()
        {
            return $this->rol === self::ROL_SUPERADMINISTRADOR;
        }

        public function hasRole($rol)
        {
            return $this->rol === $rol;
        }




}//class Usuario
