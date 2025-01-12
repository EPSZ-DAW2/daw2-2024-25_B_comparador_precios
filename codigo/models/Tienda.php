<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tiendas".
 *
 * @property int $id
 * @property string|null $nombre
 * @property string|null $descripcion
 * @property string|null $lugar
 * @property string|null $url
 * @property string|null $direccion
 * @property int|null $region_id
 * @property string|null $telefono
 * @property int|null $clasificacion_id
 * @property int|null $etiquetas_id
 * @property string|null $imagen_principal
 * @property int|null $suma_valoraciones
 * @property int|null $suma_votos
 * @property int|null $visible
 * @property int|null $cerrada
 * @property int|null $denuncias
 * @property string|null $fecha_primera_denuncia
 * @property string|null $motivo_denuncia
 * @property int|null $bloqueada
 * @property string|null $fecha_bloqueo
 * @property string|null $motivo_bloqueo
 * @property int|null $comentarios_id
 * @property int|null $cerrado_comentar
 * @property int $seguimiento_id
 * @property int $registro_id
 * @property int|null $articulo_tienda_id
 *
 * @property ArticulosTienda $articuloTienda
 * @property ArticulosTienda[] $articulosTiendas
 * @property Avisos[] $avisos
 * @property Clasificaciones $clasificacion
 * @property Comentarios[] $comentarios
 * @property Comentarios $comentarios0
 * @property Duenos[] $duenos
 * @property Etiquetas $etiquetas
 * @property Etiquetas[] $etiquetas0
 * @property Historico[] $historicoPrecios
 * @property Moderador[] $mods
 * @property Ofertas[] $ofertas
 * @property Regiones $region
 * @property RegistroUsuarios $registro
 * @property Seguimientos $seguimiento
 * @property Seguimientos[] $seguimientos
 * @property TiendasEtiquetas[] $tiendasEtiquetas
 * @property TiendasModerador[] $tiendasModeradors
 */
class Tienda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tiendas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'direccion', 'motivo_denuncia', 'motivo_bloqueo'], 'string'],
            [['region_id', 'clasificacion_id', 'etiquetas_id', 'suma_valoraciones', 'suma_votos', 'visible', 'cerrada', 'denuncias', 'bloqueada', 'comentarios_id', 'cerrado_comentar', 'seguimiento_id', 'registro_id', 'articulo_tienda_id'], 'integer'],
            [['fecha_primera_denuncia', 'fecha_bloqueo'], 'safe'],
            [['seguimiento_id', 'registro_id'], 'required'],
            [['nombre', 'lugar', 'url', 'imagen_principal'], 'string', 'max' => 255],
            [['telefono'], 'string', 'max' => 20],
            [['articulo_tienda_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticulosTienda::class, 'targetAttribute' => ['articulo_tienda_id' => 'id']],
            [['clasificacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clasificaciones::class, 'targetAttribute' => ['clasificacion_id' => 'id']],
            [['comentarios_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comentarios::class, 'targetAttribute' => ['comentarios_id' => 'id']],
            [['etiquetas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Etiquetas::class, 'targetAttribute' => ['etiquetas_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regiones::class, 'targetAttribute' => ['region_id' => 'id']],
            [['registro_id'], 'exist', 'skipOnError' => true, 'targetClass' => RegistroUsuarios::class, 'targetAttribute' => ['registro_id' => 'id']],
            [['seguimiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Seguimiento::class, 'targetAttribute' => ['seguimiento_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'lugar' => 'Lugar',
            'url' => 'Url',
            'direccion' => 'Direccion',
            'region_id' => 'Region ID',
            'telefono' => 'Telefono',
            'clasificacion_id' => 'Clasificacion ID',
            'etiquetas_id' => 'Etiquetas ID',
            'imagen_principal' => 'Imagen Principal',
            'suma_valoraciones' => 'Suma Valoraciones',
            'suma_votos' => 'Suma Votos',
            'visible' => 'Visible',
            'cerrada' => 'Cerrada',
            'denuncias' => 'Denuncias',
            'fecha_primera_denuncia' => 'Fecha Primera Denuncia',
            'motivo_denuncia' => 'Motivo Denuncia',
            'bloqueada' => 'Bloqueada',
            'fecha_bloqueo' => 'Fecha Bloqueo',
            'motivo_bloqueo' => 'Motivo Bloqueo',
            'comentarios_id' => 'Comentarios ID',
            'cerrado_comentar' => 'Cerrado Comentar',
            'seguimiento_id' => 'Seguimiento ID',
            'registro_id' => 'Registro ID',
            'articulo_tienda_id' => 'Articulo Tienda ID',
        ];
    }

    /**
     * Gets query for [[ArticuloTienda]].
     *
     * @return \yii\db\ActiveQuery|ArticulosTiendaQuery
     */
    public function getArticuloTienda()
    {
        return $this->hasOne(ArticulosTienda::class, ['id' => 'articulo_tienda_id']);
    }

    /**
     * Gets query for [[ArticulosTiendas]].
     *
     * @return \yii\db\ActiveQuery|ArticulosTiendaQuery
     */
    public function getArticulosTiendas()
    {
        return $this->hasMany(ArticulosTienda::class, ['tienda_id' => 'id']);
    }

    /**
     * Gets query for [[Avisos]].
     *
     * @return \yii\db\ActiveQuery|AvisosQuery
     */
    public function getAvisos()
    {
        return $this->hasMany(Avisos::class, ['tienda_id' => 'id']);
    }

    /**
     * Gets query for [[Clasificacion]].
     *
     * @return \yii\db\ActiveQuery|ClasificacionesQuery
     */
    public function getClasificacion()
    {
        return $this->hasOne(Clasificaciones::class, ['id' => 'clasificacion_id']);
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery|ComentariosQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::class, ['tienda_id' => 'id']);
    }

    /**
     * Gets query for [[Comentarios0]].
     *
     * @return \yii\db\ActiveQuery|ComentariosQuery
     */
    public function getComentarios0()
    {
        return $this->hasOne(Comentario::class, ['id' => 'comentarios_id']);
    }

    /**
     * Gets query for [[Duenos]].
     *
     * @return \yii\db\ActiveQuery|DuenosQuery
     */
    public function getDuenos()
    {
        return $this->hasMany(Duenos::class, ['id_tienda' => 'id']);
    }

    /**
     * Gets query for [[Etiquetas]].
     *
     * @return \yii\db\ActiveQuery|EtiquetasQuery
     */
    public function getEtiquetas()
    {
        return $this->hasOne(Etiquetas::class, ['id' => 'etiquetas_id']);
    }

    /**
     * Gets query for [[Etiquetas0]].
     *
     * @return \yii\db\ActiveQuery|EtiquetasQuery
     */
    public function getEtiquetas0()
    {
        return $this->hasMany(Etiquetas::class, ['id' => 'etiqueta_id'])->viaTable('tiendas_etiquetas', ['tienda_id' => 'id']);
    }

    /**
     * Gets query for [[HistoricoPrecios]].
     *
     * @return \yii\db\ActiveQuery|HistoricoQuery
     */
    public function getHistoricoPrecios()
    {
        return $this->hasMany(Historico::class, ['tienda_id' => 'id']);
    }

    /**
     * Gets query for [[Mods]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getMods()
    {
        return $this->hasMany(Moderador::class, ['id' => 'mod_id'])->viaTable('tiendas_moderador', ['tienda_id' => 'id']);
    }

    /**
     * Gets query for [[Ofertas]].
     *
     * @return \yii\db\ActiveQuery|OfertasQuery
     */
    public function getOfertas()
    {
        return $this->hasMany(Ofertas::class, ['tienda_id' => 'id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Regiones::class, ['id' => 'region_id']);
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
     * Gets query for [[Seguimiento]].
     *
     * @return \yii\db\ActiveQuery|SeguimientosQuery
     */
    public function getSeguimiento()
    {
        return $this->hasOne(Seguimiento::class, ['id' => 'seguimiento_id']);
    }

    /**
     * Gets query for [[Seguimientos]].
     *
     * @return \yii\db\ActiveQuery|SeguimientosQuery
     */
    public function getSeguimientos()
    {
        return $this->hasMany(Seguimientos::class, ['tienda_id' => 'id']);
    }

    /**
     * Gets query for [[TiendasEtiquetas]].
     *
     * @return \yii\db\ActiveQuery|TiendasEtiquetasQuery
     */
    public function getTiendasEtiquetas()
    {
        return $this->hasMany(TiendasEtiquetas::class, ['tienda_id' => 'id']);
    }

    /**
     * Gets query for [[TiendasModeradors]].
     *
     * @return \yii\db\ActiveQuery|TiendasModeradorQuery
     */
    public function getTiendasModeradors()
    {
        return $this->hasMany(TiendasModerador::class, ['tienda_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TiendasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TiendasQuery(get_called_class());
    }

    public function getTotalVotos()
    {
        return $this->suma_votos;
    }

    /**
     * Gets the total number of ratings.
     * @return int
     */
    public function getTotalValoraciones()
    {
        return $this->suma_valoraciones;
    }
    /**
	 * Obtiene la valoración media de la tienda basada en los comentarios.
	 * @return string
	 */
	public function getValoracionMedia()
	{
		$totalValoraciones = $this->getComentarios()->sum('valoracion');
		$totalComentarios = $this->getComentarios()->count();

		if ($totalComentarios > 0) {
			return round($totalValoraciones / $totalComentarios, 1) . ' / 5';
		}

		return 'Sin valoraciones aún.';
	}
	
	/**
     * Gets the ID of the store.
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the name of the store.
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Gets the description of the store.
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Gets the location of the store.
     * @return string
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Gets the phone number of the store.
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Checks if the store is visible.
     * @return bool
     */
    public function isVisible()
    {
        return (bool)$this->visible;
    }

    /**
     * Checks if the store is closed.
     * @return bool
     */
    public function isCerrada()
    {
        return (bool)$this->cerrada;
    }

    /**
     * Gets the number of complaints.
     * @return int
     */
    public function getDenuncias()
    {
        return $this->denuncias;
    }

    /**
     * Gets the date of the first complaint, if any.
     * @return string|null
     */
    public function getFechaPrimeraDenuncia()
    {
        return $this->fecha_primera_denuncia;
    }

    /**
     * Gets the reason for the complaint, if any.
     * @return string|null
     */
    public function getMotivoDenuncia()
    {
        return $this->motivo_denuncia;
    }

    /**
     * Checks if the store is blocked.
     * @return bool
     */
    public function isBloqueada()
    {
        return (bool)$this->bloqueada;
    }

    /**
     * Gets the date of the block, if any.
     * @return string|null
     */
    public function getFechaBloqueo()
    {
        return $this->fecha_bloqueo;
    }

    /**
     * Gets the reason for the block, if any.
     * @return string|null
     */
    public function getMotivoBloqueo()
    {
        return $this->motivo_bloqueo;
    }

    /**
     * Checks if commenting is closed.
     * @return bool
     */
    public function isCerradoComentar()
    {
        return (bool)$this->cerrado_comentar;
    }

    public function getArticuloTiendaId()
    {
        return $this->articulo_tienda_id;
    }

	/**
	 * Agrega un nuevo motivo de denuncia al campo `motivo_denuncia`.
	 *
	 * @param string $nuevoMotivo El motivo de la nueva denuncia.
	 */
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

}
