<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ofertas".
 *
 * @property int $id
 * @property int|null $articulo_id
 * @property int|null $tienda_id
 * @property string|null $fecha_inicio
 * @property string|null $fecha_fin
 * @property float|null $precio_oferta
 * @property float|null $precio_og
 * @property int|null $registro_id
 * @property string|null $notas
 *
 * @property Articulo $articulo
 * @property ArticulosTienda[] $articulosTiendas
 * @property RegistroUsuarios $registro
 * @property Seguimientos[] $seguimientos
 * @property Tiendas $tienda
 */
class Ofertas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ofertas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['articulo_id', 'tienda_id', 'registro_id'], 'integer'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['precio_oferta', 'precio_og'], 'number'],
            [['notas'], 'string'],
            [['articulo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articulo::class, 'targetAttribute' => ['articulo_id' => 'id']],
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
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'precio_oferta' => 'Precio Oferta',
            'precio_og' => 'Precio Og',
            'registro_id' => 'Registro ID',
            'notas' => 'Notas',
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
        return $this->hasMany(ArticulosTienda::class, ['oferta_id' => 'id']);
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
     * Gets query for [[Seguimientos]].
     *
     * @return \yii\db\ActiveQuery|SeguimientosQuery
     */
    public function getSeguimientos()
    {
        return $this->hasMany(Seguimientos::class, ['oferta_id' => 'id']);
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
     * {@inheritdoc}
     * @return OfertasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OfertasQuery(get_called_class());
    }
	
	public function getCategoria()
	{
		return $this->hasOne(Categorias::class, ['id' => 'categoria_id'])->via('articulo');
	}

	public function getClasificacion()
	{
		return $this->hasOne(Clasificaciones::class, ['id' => 'clasificacion_id'])->via('tienda');
	}

	public function getRegion()
	{
		return $this->hasOne(Regiones::class, ['id' => 'region_id'])->via('tienda');
	}

	/*public function getEtiquetas()
	{
		return $this->hasMany(Etiquetas::class, ['id' => 'etiqueta_id'])->via('articulo');
	}*/
	
	public function getEtiquetas()
	{
		return $this->hasMany(Etiquetas::class, ['id' => 'etiqueta_id'])
			->viaTable('articulo_etiquetas', ['articulo_id' => 'id']);
	}
	
	public function getComentarios()
	{
		return $this->hasMany(Comentario::class, ['articulo_id' => 'articulo_id']);
	}
	
		public function getValoracionMedia()
	{
		// Sumar todas las valoraciones de los comentarios relacionados con la oferta
		$totalValoraciones = $this->getComentarios()->sum('valoracion');
		
		// Contar el total de comentarios relacionados con la oferta
		$totalComentarios = $this->getComentarios()->count();

		// Si hay comentarios, calcular la media, de lo contrario devolver un mensaje
		if ($totalComentarios > 0) {
			return round($totalValoraciones / $totalComentarios, 1) . ' / 5';
		}

		return 'Sin valoraciones aún.';
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
		$this->denuncias = ($this->denuncias ?? 0) + 1;

		// Registrar la fecha de la primera denuncia si no existe
		if (!$this->fecha_primera_denuncia) {
			$this->fecha_primera_denuncia = date('Y-m-d H:i:s');
		}
	}


}
