<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seguimientos".
 *
 * @property int $id
 * @property int|null $usuario_id id del usuario del seguimiento
 * @property int|null $tienda_id id del usuario de la tienda o 0 si no es tienda
 * @property int|null $articulo_id id del usuario del articulo o 0 si no es articulo
 * @property int|null $oferta_id id de la oferta del seguimiento o 0 si no es oferta
 * @property string|null $fecha
 *
 * @property Articulos $articulo
 * @property Ofertas $oferta
 * @property Tiendas $tienda
 * @property Tiendas[] $tiendas
 * @property Usuarios $usuario
 */
class Seguimiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguimientos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'tienda_id', 'articulo_id', 'oferta_id'], 'integer'],
            [['fecha'], 'safe'],
            [['articulo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articulo::class, 'targetAttribute' => ['articulo_id' => 'id']],
            [['oferta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Oferta::class, 'targetAttribute' => ['oferta_id' => 'id']],
            [['tienda_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tienda::class, 'targetAttribute' => ['tienda_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'tienda_id' => 'Tienda ID',
            'articulo_id' => 'Articulo ID',
            'oferta_id' => 'Oferta ID',
            'fecha' => 'Fecha',
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
     * Gets query for [[Oferta]].
     *
     * @return \yii\db\ActiveQuery|OfertasQuery
     */
    public function getOferta()
    {
        return $this->hasOne(Oferta::class, ['id' => 'oferta_id']);
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
        return $this->hasMany(Tienda::class, ['seguimiento_id' => 'id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery|UsuariosQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }

    /**
     * {@inheritdoc}
     * @return SeguimientosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeguimientosQuery(get_called_class());
    }
}
