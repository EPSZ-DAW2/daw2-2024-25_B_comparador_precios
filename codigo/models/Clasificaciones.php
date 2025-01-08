<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clasificaciones".
 *
 * @property int $id
 * @property string|null $nombre
 * @property string|null $descripcion
 * @property string|null $icono
 *
 * @property Tiendas[] $tiendas
 */
class Clasificaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clasificaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['nombre', 'icono'], 'string', 'max' => 255],
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
            'icono' => 'Icono',
        ];
    }

    /**
     * Gets query for [[Tiendas]].
     *
     * @return \yii\db\ActiveQuery|TiendasQuery
     */
    public function getTiendas()
    {
        return $this->hasMany(Tiendas::class, ['clasificacion_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ClasificacionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClasificacionesQuery(get_called_class());
    }
}
