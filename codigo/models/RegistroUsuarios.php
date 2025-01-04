<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registro_usuarios".
 *
 * @property int $id
 * @property string|null $fecha_creacion
 * @property int $creador_id
 * @property string|null $fecha_mod
 * @property int $mod_id
 * @property string|null $notas_admin
 *
 * @property Articulos[] $articulos
 * @property ArticulosTienda[] $articulosTiendas
 * @property Comentarios[] $comentarios
 * @property Usuarios $creador
 * @property Moderador $mod
 * @property Ofertas[] $ofertas
 * @property Tiendas[] $tiendas
 */
class RegistroUsuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registro_usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_creacion', 'fecha_mod'], 'safe'],
            [['creador_id', 'mod_id'], 'required'],
            [['creador_id', 'mod_id'], 'integer'],
            [['notas_admin'], 'string'],
            [['creador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['creador_id' => 'id']],
            [['mod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Moderador::class, 'targetAttribute' => ['mod_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_creacion' => 'Fecha Creacion',
            'creador_id' => 'Creador ID',
            'fecha_mod' => 'Fecha Mod',
            'mod_id' => 'Mod ID',
            'notas_admin' => 'Notas Admin',
        ];
    }

    /**
     * Gets query for [[Articulos]].
     *
     * @return \yii\db\ActiveQuery|ArticulosQuery
     */
    public function getArticulos()
    {
        return $this->hasMany(Articulos::class, ['registro_id' => 'id']);
    }

    /**
     * Gets query for [[ArticulosTiendas]].
     *
     * @return \yii\db\ActiveQuery|ArticulosTiendaQuery
     */
    public function getArticulosTiendas()
    {
        return $this->hasMany(ArticulosTienda::class, ['registro_id' => 'id']);
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery|ComentariosQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::class, ['registo_id' => 'id']);
    }

    /**
     * Gets query for [[Creador]].
     *
     * @return \yii\db\ActiveQuery|UsuariosQuery
     */
    public function getCreador()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'creador_id']);
    }

    /**
     * Gets query for [[Mod]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getMod()
    {
        return $this->hasOne(Moderador::class, ['id' => 'mod_id']);
    }

    /**
     * Gets query for [[Ofertas]].
     *
     * @return \yii\db\ActiveQuery|OfertasQuery
     */
    public function getOfertas()
    {
        return $this->hasMany(Ofertas::class, ['registro_id' => 'id']);
    }

    /**
     * Gets query for [[Tiendas]].
     *
     * @return \yii\db\ActiveQuery|TiendasQuery
     */
    public function getTiendas()
    {
        return $this->hasMany(Tiendas::class, ['registro_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return RegistroUsuariosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RegistroUsuariosQuery(get_called_class());
    }
}
