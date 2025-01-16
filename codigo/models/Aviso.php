<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Esta es la clase modelo para la tabla "avisos".
 *
 * @property int $id
 * @property string $clase
 * @property string|null $texto
 * @property int $usuario_origen_id
 * @property int $usuario_destino_id
 * @property int $tienda_id
 * @property int $articulo_id
 * @property int $comentario_id
 * @property string|null $fecha_lectura
 * @property string|null $fecha_aceptado
 */
class Aviso extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avisos';
    }




    // Campo para buscar el nick del usuario destino
    public $usuario_destino_nick; 



    // Valida si el nick del usuario destino existe
    public function validateUsuarioDestino($attribute, $params)
    {
        $usuarioDestino = Usuario::findOne(['nick' => $this->$attribute]);
        if (!$usuarioDestino) {
            $this->addError($attribute, 'El usuario con ese nick no existe.');
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->usuario_destino_nick)) {
                $usuarioDestino = Usuario::findOne(['nick' => $this->usuario_destino_nick]);
                if ($usuarioDestino) {
                    $this->usuario_destino_id = $usuarioDestino->id;
                } else {
                    $this->addError('usuario_destino_nick', 'El usuario destino no existe.');
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clase', 'usuario_origen_id', 'usuario_destino_id'], 'required'],
            [['usuario_origen_id', 'usuario_destino_id', 'tienda_id', 'articulo_id', 'comentario_id'], 'integer'],
            [['texto'], 'string'],
            [['fecha_lectura', 'fecha_aceptado'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['clase'], 'in', 'range' => ['Aviso', 'Denuncia', 'Consulta', 'Mensaje Generico', 'Bloqueo']],
			
			
			[['clase', 'texto', 'usuario_destino_nick'], 'required'],
            [['clase'], 'string', 'max' => 255],
            [['texto'], 'string'],
            [['usuario_destino_nick'], 'validateUsuarioDestino'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'clase' => 'Clase',
            'texto' => 'Texto',
            'usuario_origen_id' => 'Usuario Origen',
            'usuario_destino_id' => 'Usuario Destino',
            'tienda_id' => 'Tienda',
            'articulo_id' => 'Articulo',
            'comentario_id' => 'Comentario',
            'fecha_lectura' => 'Fecha Lectura',
            'fecha_aceptado' => 'Fecha Aceptado',
        ];
    }

    /**
     * Relación con el modelo Usuario (usuario origen).
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioOrigen()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_origen_id']);
    }

    /**
     * Relación con el modelo Usuario (usuario destino).
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioDestino()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_destino_id']);
    }

    /**
     * Relación con el modelo Tienda.
     * @return \yii\db\ActiveQuery
     */
    public function getTienda()
    {
        return $this->hasOne(Tienda::class, ['id' => 'tienda_id']);
    }

    /**
     * Relación con el modelo Articulo.
     * @return \yii\db\ActiveQuery
     */
    public function getArticulo()
    {
        return $this->hasOne(Articulo::class, ['id' => 'articulo_id']);
    }

    /**
     * Relación con el modelo Comentario.
     * @return \yii\db\ActiveQuery
     */
    public function getComentario()
    {
        return $this->hasOne(Comentario::class, ['id' => 'comentario_id']);
    }

    /**
     * Marca el aviso como leído.
     */
    public function actionMarcarComoLeido()
    {
        $this->fecha_lectura = date('Y-m-d H:i:s');
        return $this->save(false);
    }
	
	

    /**
     * Marca el aviso como aceptado.
     */
    public function actionMarcarComoAceptado()
    {
        $this->fecha_aceptado = date('Y-m-d H:i:s');
        return $this->save(false);
    }

    /**
     * Consulta los avisos enviados por un usuario específico.
     *
     * @param int $usuarioId
     * @return Aviso[]
     */
    public static function obtenerAvisosEnviados($usuarioId)
    {
        return self::find()
            ->where(['usuario_origen_id' => $usuarioId])
            ->orderBy(['fecha_aceptado' => SORT_DESC])
            ->all();
    }

    /**
     * Consulta los avisos recibidos por un usuario específico.
     *
     * @param int $usuarioId
     * @return Aviso[]
     */
    public static function obtenerAvisosRecibidos($usuarioId)
    {
        return self::find()
            ->where(['usuario_destino_id' => $usuarioId])
            ->orderBy(['fecha_aceptado' => SORT_DESC])
            ->all();
    }
}
