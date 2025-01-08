<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historico_precios".
 *
 * @property int $id
 * @property int|null $articulo_id
 * @property int|null $tienda_id
 * @property string|null $fecha
 * @property float|null $precio
 *
 * @property Articulo $articulo
 * @property ArticulosTienda[] $articulosTiendas
 * @property Tienda $tienda
 */
class Historico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'historico_precios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['articulo_id', 'tienda_id'], 'integer'],
            [['fecha'], 'safe'],
            [['precio'], 'number'],
            [['articulo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articulo::class, 'targetAttribute' => ['articulo_id' => 'id']],
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
            'fecha' => 'Fecha',
            'precio' => 'Precio',
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
        return $this->hasMany(ArticulosTienda::class, ['historico_id' => 'id']);
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
     * @return HistoricoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HistoricoQuery(get_called_class());
    }
}
