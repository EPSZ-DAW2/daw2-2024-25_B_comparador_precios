<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "duenos".
 *
 * @property int $id
 * @property int $id_tienda
 * @property int $id_usuario
 * @property string|null $razon_social
 * @property string|null $nif
 *
 * @property Tiendas $tienda
 * @property Usuarios $usuario
 */
class Dueno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'duenos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tienda', 'id_usuario'], 'required'],
            [['id_tienda', 'id_usuario'], 'integer'],
            [['razon_social'], 'string', 'max' => 255],
            [['nif'], 'string', 'max' => 9],
            [['id_tienda'], 'exist', 'skipOnError' => true, 'targetClass' => Tiendas::class, 'targetAttribute' => ['id_tienda' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tienda' => 'Id Tienda',
            'id_usuario' => 'Id Usuario',
            'razon_social' => 'Razon Social',
            'nif' => 'Nif',
        ];
    }

    /**
     * Gets query for [[Tienda]].
     *
     * @return \yii\db\ActiveQuery|TiendasQuery
     */
    public function getTienda()
    {
        return $this->hasOne(Tiendas::class, ['id' => 'id_tienda']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery|UsuariosQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'id_usuario']);
    }

    /**
     * {@inheritdoc}
     * @return DuenosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DuenosQuery(get_called_class());
    }
}
