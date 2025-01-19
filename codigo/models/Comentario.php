<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentarios".
 *
 * @property int $id
 * @property int|null $tienda_id id de la tienda
 * @property int|null $articulo_id id del articulo, 0 si es comentario de tienda
 * @property int|null $valoracion valoracion del comentario
 * @property string|null $texto texto del comentario
 * @property int|null $comentario_padre_id id del comentario padre
 * @property int|null $cerrado si permite o no respuestas
 * @property int|null $denuncias numero de denuncias al comentario
 * @property string|null $fecha_primera_denuncia fecha de la primera denuncia
 * @property string|null $motivo_denuncia motivo de la denuncia
 * @property int|null $bloqueado si esta bloqueado el comentario
 * @property string|null $fecha_bloqueo fecha de bloqueo
 * @property string|null $motivo_bloqueo motivo del bloqueo
 * @property int|null $registro_id id del creador del comentario
 *
 * @property Articulo $articulo
 * @property ArticulosTienda[] $articulosTiendas
 * @property Avisos[] $avisos
 * @property Comentario $comentarioPadre
 * @property Comentario[] $comentarios
 * @property RegistroUsuarios $registro
 * @property Tiendas $tienda
 * @property Tiendas[] $tiendas
 */
class Comentario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tienda_id', 'articulo_id', 'valoracion', 'comentario_padre_id', 'cerrado', 'denuncias', 'bloqueado', 'registro_id'], 'integer'],
            [['texto', 'motivo_denuncia', 'motivo_bloqueo'], 'string'],
            [['fecha_primera_denuncia', 'fecha_bloqueo'], 'safe'],
            [['articulo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articulo::class, 'targetAttribute' => ['articulo_id' => 'id']],
            [['comentario_padre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comentario::class, 'targetAttribute' => ['comentario_padre_id' => 'id']],
            [['registro_id'], 'exist', 'skipOnError' => true, 'targetClass' => RegistroUsuarios::class, 'targetAttribute' => ['registro_id' => 'id']],
            [['tienda_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tienda::class, 'targetAttribute' => ['tienda_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tienda_id' => Yii::t('app', 'Tienda ID'),
            'articulo_id' => Yii::t('app', 'Articulo ID'),
            'valoracion' => Yii::t('app', 'Valoracion'),
            'texto' => Yii::t('app', 'Texto'),
            'comentario_padre_id' => Yii::t('app', 'Comentario Padre ID'),
            'cerrado' => Yii::t('app', 'Cerrado'),
            'denuncias' => Yii::t('app', 'Denuncias'),
            'fecha_primera_denuncia' => Yii::t('app', 'Fecha Primera Denuncia'),
            'motivo_denuncia' => Yii::t('app', 'Motivo Denuncia'),
            'bloqueado' => Yii::t('app', 'Bloqueado'),
            'fecha_bloqueo' => Yii::t('app', 'Fecha Bloqueo'),
            'motivo_bloqueo' => Yii::t('app', 'Motivo Bloqueo'),
            'registro_id' => Yii::t('app', 'registro ID'),
        ];
    }

    /**
     * Gets query for [[Articulo]].
     *
     * @return \yii\db\ActiveQuery|ArticulosQuery
     */
    public function getArticulo()
    {
        return $this->hasOne(Articulo::class, ['id' => 'articulo_id']);
    }

    /**
     * Gets query for [[ArticulosTiendas]].
     *
     * @return \yii\db\ActiveQuery|ArticulosTiendaQuery
     */
    public function getArticulosTiendas()
    {
        return $this->hasMany(ArticulosTienda::class, ['comentario_id' => 'id']);
    }

    /**
     * Gets query for [[Avisos]].
     *
     * @return \yii\db\ActiveQuery|AvisosQuery
     */
    public function getAvisos()
    {
        return $this->hasMany(Avisos::class, ['comentario_id' => 'id']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'registro_id']);
    }
    


    /**
     * Gets query for [[ComentarioPadre]].
     *
     * @return \yii\db\ActiveQuery|ComentarioQuery
     */
    public function getComentarioPadre()
    {
        return $this->hasOne(Comentario::class, ['id' => 'comentario_padre_id']);
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery|ComentarioQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::class, ['comentario_padre_id' => 'id']);
    }

    /**
     * Gets query for [[registro]].
     *
     * @return \yii\db\ActiveQuery|RegistroUsuariosQuery
     */
    public function getregistro()
    {
        return $this->hasOne(RegistroUsuarios::class, ['id' => 'registro_id']);
    }

    /**
     * Gets query for [[Tienda]].
     *
     * @return \yii\db\ActiveQuery|TiendasQuery
     */
    public function getTienda()
    {
        return $this->hasOne(Tienda::class, ['id' => 'tienda_id']);
    }

    /**
     * Gets query for [[Tiendas]].
     *
     * @return \yii\db\ActiveQuery|TiendasQuery
     */
    public function getTiendas()
    {
        return $this->hasMany(Tienda::class, ['comentarios_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ComentariosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComentariosQuery(get_called_class());
    }
	
	/**
	 * Bloquea el comentario.
	 *
	 * @param string $motivo El motivo del bloqueo.
	 */
	public function bloquear($motivo)
	{
		$this->bloqueado = 1;
		$this->fecha_bloqueo = date('Y-m-d H:i:s');
		$this->motivo_bloqueo = $motivo;
		$this->save(false); // Guardar sin validar nuevamente los datos
	}

	/**
	 * Desbloquea el comentario.
	 */
	public function desbloquear()
	{
		$this->bloqueado = 0;
		$this->fecha_bloqueo = null;
		$this->motivo_bloqueo = null;
		$this->save(false); // Guardar sin validar nuevamente los datos
	}

}
