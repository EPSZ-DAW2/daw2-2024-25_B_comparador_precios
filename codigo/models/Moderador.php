<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Clase modelo para la tabla `moderador`.
 */
class Moderador extends ActiveRecord
{
    /**
     * Define el nombre de la tabla asociada en la base de datos.
     */
    public static function tableName()
    {
        return 'moderador';
    }

    /**
     * Define las reglas de validación para los datos del modelo.
     */
    public function rules()
    {
        return [
            [['usuario_id', 'region_id'], 'integer'], // Campos numéricos
            [['nombre', 'razon_social'], 'string', 'max' => 255], // Longitud máxima de texto
            [['telefono'], 'string', 'max' => 20], // Longitud máxima de teléfono
            [['nif'], 'string', 'length' => 9], // NIF de 9 caracteres
            [['direccion'], 'string'], // Dirección como texto largo
            [['baja_solicitada'], 'boolean'], // Campo booleano para baja solicitada
        ];
    }

    /**
     * Etiquetas descriptivas para los campos del modelo.
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'ID Usuario',
            'nif' => 'NIF',
            'nombre' => 'Nombre',
            'direccion' => 'Dirección',
            'region_id' => 'Región',
            'telefono' => 'Teléfono',
            'razon_social' => 'Razón Social',
            'baja_solicitada' => 'Baja Solicitada',
        ];
    }

    /**
     * Relación con la tabla `region`.
     */
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }

    /**
     * Relación con las tiendas de la región del moderador.
     */
    public function getTiendas()
    {
        return $this->hasMany(Tienda::class, ['region_id' => 'region_id']);
    }

    /**
     * Relación con los usuarios de la región del moderador.
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::class, ['region_id' => 'region_id']);
    }

    /**
     * Relación con las incidencias de los usuarios de su región.
     */
    public function getIncidencias()
    {
        return $this->hasMany(Incidencia::class, ['usuario_id' => 'id'])->via('usuarios');
    }
}
