<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categorias".
 *
 * @property int $id
 * @property string|null $nombre
 * @property string|null $descripcion
 * @property string|null $icono
 * @property int|null $categoria_padre_id
 *
 * @property Articulos[] $articulos
 * @property Categorias $categoriaPadre
 * @property Categorias[] $categorias
 */
class Categorias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['categoria_padre_id'], 'integer'],
            [['nombre', 'icono'], 'string', 'max' => 255],
            [['categoria_padre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::class, 'targetAttribute' => ['categoria_padre_id' => 'id']],
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
            'categoria_padre_id' => 'Categoria Padre ID',
        ];
    }

    /**
     * Gets query for [[Articulos]].
     *
     * @return \yii\db\ActiveQuery|ArticulosQuery
     */
    public function getArticulos()
    {
        return $this->hasMany(Articulos::class, ['categoria_id' => 'id']);
    }

    /**
     * Gets query for [[CategoriaPadre]].
     *
     * @return \yii\db\ActiveQuery|CategoriasQuery
     */
    public function getCategoriaPadre()
    {
        return $this->hasOne(Categorias::class, ['id' => 'categoria_padre_id']);
    }

    /**
     * Gets query for [[Categorias]].
     *
     * @return \yii\db\ActiveQuery|CategoriasQuery
     */
    public function getCategorias()
    {
        return $this->hasMany(Categorias::class, ['categoria_padre_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoriasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriasQuery(get_called_class());
    }
}
