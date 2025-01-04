<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Clase modelo para la tabla `moderador`.
 * Representa los datos y lógica de negocio relacionados con los moderadores.
 */
class Moderador extends ActiveRecord
{
    /**
     * Define el nombre de la tabla asociada en la base de datos.
     * @return string Nombre de la tabla
     */
    public static function tableName()
    {
        return 'moderador'; // Nombre de la tabla en la base de datos
    }

    /**
     * Define las reglas de validación para los datos del modelo.
     * @return array Reglas de validación
     */
    public function rules()
    {
        return [
            [['usuario_id', 'region_id'], 'integer'], // Campos numéricos
            [['nombre', 'razon_social'], 'string', 'max' => 255], // Longitud máxima de texto
            [['telefono'], 'string', 'max' => 20], // Longitud máxima de teléfono
            [['nif'], 'string', 'length' => 9], // NIF de 9 caracteres
            [['direccion'], 'string'], // Dirección como texto largo
        ];
    }

    /**
     * Etiquetas descriptivas para los campos del modelo.
     * @return array Etiquetas para los atributos
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
        ];
    }

    /**
     * Relación con la tabla `region`.
     * @return yii\db\ActiveQuery Relación definida
     */
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }

    /**
     * Relación con las tiendas de la región del moderador.
     * Incluye tiendas de regiones inferiores si no tienen moderador.
     * @return yii\db\ActiveQuery
     */
    public function getTiendas()
    {
        return $this->hasMany(Tienda::class, ['region_id' => 'region_id']);
    }

    /**
     * Relación con los usuarios de la región del moderador.
     * @return yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::class, ['region_id' => 'region_id']);
    }

    /**
     * Relación con las incidencias de los usuarios de su región.
     * @return yii\db\ActiveQuery
     */
    public function getIncidencias()
    {
        return $this->hasMany(Incidencia::class, ['usuario_id' => 'id'])->via('usuarios');
    }
}
