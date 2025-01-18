<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "etiquetas".
 *
 * @property int $id
 * @property string|null $nombre
 * @property string|null $descripcion
 *
 * @property ArticuloEtiquetas[] $articuloEtiquetas
 * @property Articulos[] $articulos
 * @property Articulos[] $articulos0
 * @property Tiendas[] $tiendas
 * @property Tiendas[] $tiendas0
 * @property TiendasEtiquetas[] $tiendasEtiquetas
 */
class Etiquetas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'etiquetas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['nombre'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * Gets query for [[ArticuloEtiquetas]].
     *
     * @return \yii\db\ActiveQuery|ArticuloEtiquetasQuery
     */
    public function getArticuloEtiquetas()
    {
        return $this->hasMany(ArticuloEtiquetas::class, ['etiqueta_id' => 'id']);
    }

    /**
     * Gets query for [[Articulos]].
     *
     * @return \yii\db\ActiveQuery|ArticulosQuery
     */
    public function getArticulos()
    {
        return $this->hasMany(Articulo::class, ['etiqueta_id' => 'id']);
    }

    /**
     * Gets query for [[Articulos0]].
     *
     * @return \yii\db\ActiveQuery|ArticulosQuery
     */
    public function getArticulos0()
    {
        return $this->hasMany(Articulo::class, ['id' => 'articulo_id'])->viaTable('articulo_etiquetas', ['etiqueta_id' => 'id']);
    }

    /**
     * Gets query for [[Tiendas]].
     *
     * @return \yii\db\ActiveQuery|TiendasQuery
     */
    public function getTiendas()
    {
        return $this->hasMany(Tienda::class, ['etiquetas_id' => 'id']);
    }

    /**
     * Gets query for [[Tiendas0]].
     *
     * @return \yii\db\ActiveQuery|TiendasQuery
     */
    public function getTiendas0()
    {
        return $this->hasMany(Tienda::class, ['id' => 'tienda_id'])->viaTable('tiendas_etiquetas', ['etiqueta_id' => 'id']);
    }

    /**
     * Gets query for [[TiendasEtiquetas]].
     *
     * @return \yii\db\ActiveQuery|TiendasEtiquetasQuery
     */
    public function getTiendasEtiquetas()
    {
        return $this->hasMany(TiendasEtiquetas::class, ['etiqueta_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return EtiquetasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EtiquetasQuery(get_called_class());
    }

    /**
     * Gets URL for viewing tiendas associated with this etiqueta.
     *
     * @return string
     */
    public function getViewTiendasUrl()
    {
        return Yii::$app->urlManager->createUrl(['tiendas/view', 'id' => $this->id]);
    }

    /**
     * Gets URL for viewing articulos associated with this etiqueta.
     *
     * @return string
     */
    public function getViewArticulosUrl()
    {
        return Yii::$app->urlManager->createUrl(['public-articulos/view', 'id' => $this->id]);
    }
}