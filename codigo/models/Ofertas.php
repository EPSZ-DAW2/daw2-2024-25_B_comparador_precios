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
}
