<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articulos".
 *
 * @property int $id
 * @property string|null $nombre nombre del articulo
 * @property string|null $descripcion descripcion del articulo
 * @property int|null $categoria_id id de la categoria del producto
 * @property int|null $etiqueta_id id de la etiqueta del producto
 * @property string|null $imagen_principal imagen del articulo
 * @property int|null $visible si el articulo esta visible o no, por defecto si
 * @property int|null $cerrado si el articulo esta cerrado a la venta, por defecto no
 * @property string|null $tipo_marcado tipo de articulo
 * @property int|null $registro_id id del usuario creador
 * @property int|null $articulo_tienda_id id relacionado con tabla articulo-tienda
 *
 * @property ArticuloEtiquetas[] $articuloEtiquetas
 * @property ArticulosTienda $articuloTienda
 * @property ArticulosTienda[] $articulosTiendas
 * @property Avisos[] $avisos
 * @property Categorias $categoria
 * @property Comentarios[] $comentarios
 * @property Etiquetas $etiqueta
 * @property Etiquetas[] $etiquetas
 * @property HistoricoPrecios[] $historicoPrecios
 * @property Ofertas[] $ofertas
 * @property RegistroUsuarios $registro
 * @property Seguimientos[] $seguimientos
 */
class Articulo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articulos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'tipo_marcado'], 'string'],
            [['categoria_id', 'etiqueta_id', 'visible', 'cerrado', 'registro_id', 'articulo_tienda_id'], 'integer'],
            [['nombre', 'imagen_principal'], 'string', 'max' => 255],
            [['articulo_tienda_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticulosTienda::class, 'targetAttribute' => ['articulo_tienda_id' => 'id']],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['etiqueta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Etiquetas::class, 'targetAttribute' => ['etiqueta_id' => 'id']],
            [['registro_id'], 'exist', 'skipOnError' => true, 'targetClass' => RegistroUsuarios::class, 'targetAttribute' => ['registro_id' => 'id']],
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
            'categoria_id' => 'Categoria ID',
            'etiqueta_id' => 'Etiqueta ID',
            'imagen_principal' => 'Imagen Principal',
            'visible' => 'Visible',
            'cerrado' => 'Cerrado',
            'tipo_marcado' => 'Tipo Marcado',
            'registro_id' => 'Registro ID',
            'articulo_tienda_id' => 'Articulo Tienda ID',
        ];
    }

    /**
     * Gets query for [[ArticuloEtiquetas]].
     *
     * @return \yii\db\ActiveQuery|ArticuloEtiquetasQuery
     */
    public function getArticuloEtiquetas()
    {
        return $this->hasMany(ArticuloEtiquetas::class, ['articulo_id' => 'id']);
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
        return $this->hasMany(ArticulosTienda::class, ['articulo_id' => 'id']);
    }

    /**
     * Gets query for [[Avisos]].
     *
     * @return \yii\db\ActiveQuery|AvisosQuery
     */
    public function getAvisos()
    {
        return $this->hasMany(Avisos::class, ['articulo_id' => 'id']);
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery|CategoriasQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categorias::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery|ComentariosQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::class, ['articulo_id' => 'id']);
    }

    /**
     * Gets query for [[Etiqueta]].
     *
     * @return \yii\db\ActiveQuery|EtiquetasQuery
     */
    public function getEtiqueta()
    {
        return $this->hasOne(Etiquetas::class, ['id' => 'etiqueta_id']);
    }

    /**
     * Gets query for [[Etiquetas]].
     *
     * @return \yii\db\ActiveQuery|EtiquetasQuery
     */
    public function getEtiquetas()
    {
        return $this->hasMany(Etiquetas::class, ['id' => 'etiqueta_id'])->viaTable('articulo_etiquetas', ['articulo_id' => 'id']);
    }

    /**
     * Gets query for [[HistoricoPrecios]].
     *
     * @return \yii\db\ActiveQuery|HistoricoPreciosQuery
     */
    public function getHistoricoPrecios()
    {
        return $this->hasMany(HistoricoPrecios::class, ['articulo_id' => 'id']);
    }

    /**
     * Gets query for [[Ofertas]].
     *
     * @return \yii\db\ActiveQuery|OfertasQuery
     */
    public function getOfertas()
    {
        return $this->hasMany(Ofertas::class, ['articulo_id' => 'id']);
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
        return $this->hasMany(Seguimientos::class, ['articulo_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ArticulosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticulosQuery(get_called_class());
    }
}
