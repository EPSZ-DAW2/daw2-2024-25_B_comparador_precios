<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articulos_tienda".
 *
 * @property int $id id del registro
 * @property int|null $articulo_id id del articulo
 * @property int|null $tienda_id id de la tienda
 * @property float|null $precio_actual precio del producto
 * @property int|null $historico_id id del historico
 * @property int|null $oferta_id id de la oferta
 * @property int|null $suma_valoraciones suma de valoraciones
 * @property int|null $suma_votos suma de los votos
 * @property int|null $visible si esta visible o no
 * @property int|null $cerrado si esta cerrado o no
 * @property int|null $denuncias numero de denuncias
 * @property string|null $fecha_primera_denuncia fecha primera denuncia
 * @property string|null $motivo_denuncia motivo de denuncia
 * @property int|null $bloqueado si esta bloqueado o no
 * @property string|null $fecha_bloqueo fecha del bloqueo
 * @property string|null $motivo_bloqueo motivo del bloqueo
 * @property int|null $cerrado_comentar si puede recibir comentarios
 * @property int|null $registro_id id del usuario creador
 * @property int|null $comentario_id id de comentarios relacionado
 *
 * @property Articulo $articulo
 * @property Articulo[] $articulos
 * @property Comentarios $comentario
 * @property Historico $historico
 * @property Ofertas $oferta
 * @property RegistroUsuarios $registro
 * @property Tienda $tienda
 * @property Tienda[] $tiendas
 */
class ArticulosTienda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articulos_tienda';
    }

    /**
     * {@inheritdoc}
     */
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['articulo_id', 'tienda_id'], 'required'], 
            [['articulo_id', 'tienda_id', 'historico_id', 'oferta_id', 'suma_valoraciones', 'suma_votos', 'visible', 'cerrado', 'denuncias', 'bloqueado', 'cerrado_comentar', 'registro_id', 'comentario_id'], 'integer'],
            [['precio_actual'], 'number'], 
            [['precio_actual'], 'required'], 
            [['fecha_primera_denuncia', 'fecha_bloqueo'], 'safe'], 
            [['motivo_denuncia', 'motivo_bloqueo'], 'string'],
            [['id'], 'unique'], 
            [['articulo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articulo::class, 'targetAttribute' => ['articulo_id' => 'id']],
            [['comentario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comentarios::class, 'targetAttribute' => ['comentario_id' => 'id']],
            [['historico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Historico::class, 'targetAttribute' => ['historico_id' => 'id']],
            [['oferta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ofertas::class, 'targetAttribute' => ['oferta_id' => 'id']],
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
            'id' => 'ID',
            'articulo_id' => 'Articulo ID',
            'tienda_id' => 'Tienda ID',
            'precio_actual' => 'Precio Actual',
            'historico_id' => 'Historico ID',
            'oferta_id' => 'Oferta ID',
            'suma_valoraciones' => 'Suma Valoraciones',
            'suma_votos' => 'Suma Votos',
            'visible' => 'Visible',
            'cerrado' => 'Cerrado',
            'denuncias' => 'Denuncias',
            'fecha_primera_denuncia' => 'Fecha Primera Denuncia',
            'motivo_denuncia' => 'Motivo Denuncia',
            'bloqueado' => 'Bloqueado',
            'fecha_bloqueo' => 'Fecha Bloqueo',
            'motivo_bloqueo' => 'Motivo Bloqueo',
            'cerrado_comentar' => 'Cerrado Comentar',
            'registro_id' => 'Registro ID',
            'comentario_id' => 'Comentario ID',
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
     * Gets query for [[Articulos]].
     *
     * @return \yii\db\ActiveQuery|ArticulosQuery
     */
    public function getArticulos()
    {
        return $this->hasMany(Articulo::class, ['articulo_tienda_id' => 'id']);
    }

    /**
     * Gets query for [[Comentario]].
     *
     * @return \yii\db\ActiveQuery|ComentariosQuery
     */
    public function getComentario()
    {
        return $this->hasOne(Comentarios::class, ['id' => 'comentario_id']);
    }

    /**
     * Gets query for [[Historico]].
     *
     * @return \yii\db\ActiveQuery|HistoricoQuery
     */
    public function getHistorico()
    {
        return $this->hasOne(Historico::class, ['id' => 'historico_id']);
    }

    /**
     * Gets query for [[Oferta]].
     *
     * @return \yii\db\ActiveQuery|OfertasQuery
     */
    public function getOferta()
    {
        return $this->hasOne(Ofertas::class, ['id' => 'oferta_id']);
    }

    /**
     * Gets query for [[Registro]].
     *
     * @return \yii\db\ActiveQuery|RegistroUsuariosQuery
     */
    public function getRegistro()
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
        return $this->hasMany(Tienda::class, ['articulo_tienda_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ArticulosTiendaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticulosTiendaQuery(get_called_class());
    }

    //funcion para obtener comentarios
    public function getComentarios()
    {
        return $this->hasMany(Comentario::class, ['articulo_id' => 'articulo_id'])
            ->andWhere(['tienda_id' => $this->tienda_id]);
    }
	
	public function agregarMotivoDenuncia($nuevoMotivo)
	{
		// Obtener los motivos existentes
		$motivosExistentes = $this->motivo_denuncia;

		// Calcular el número de la nueva denuncia
		$contador = 1;
		if (!empty($motivosExistentes)) {
			$lineas = explode("\n", $motivosExistentes);
			$contador = count($lineas) + 1;
		}

		// Concatenar el nuevo motivo con un formato numerado
		$nuevoMotivoFormateado = $contador . ': ' . $nuevoMotivo;
		$this->motivo_denuncia = empty($motivosExistentes)
			? $nuevoMotivoFormateado
			: $motivosExistentes . "\n" . $nuevoMotivoFormateado;

		// Incrementar el contador de denuncias
		$this->denuncias = $this->denuncias + 1;

		// Registrar la fecha de la primera denuncia si no existe
		if (!$this->fecha_primera_denuncia) {
			$this->fecha_primera_denuncia = date('Y-m-d H:i:s');
		}
	}
	
	public function bloquear($motivoBloqueo)
	{
		$this->bloqueado = 1;
		$this->motivo_bloqueo = $motivoBloqueo;
		$this->fecha_bloqueo = date('Y-m-d H:i:s');
	}

	public function desbloquear()
	{
		$this->bloqueado = 0;
		$this->motivo_bloqueo = null;
		$this->fecha_bloqueo = null;
	}

	
}