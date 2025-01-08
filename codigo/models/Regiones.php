<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Regiones extends \yii\db\ActiveRecord
{
    // Relación con la región padre (continente, país, estado)
    public function getRegionPadre()
    {
        return $this->hasOne(Regiones::class, ['id' => 'region_padre_id']);
    }

    // Método para obtener el nombre del continente, país, estado y provincia
    public function getFullRegion()
    {
        // Iniciamos la cadena de nombres
        $regionNames = [];
        $region = $this;

        // Iteramos a través de la jerarquía de la región, subiendo hasta el continente
        while ($region) {
            $regionNames[] = $region->nombre;
            $region = $region->regionPadre; // Ascendemos al padre
        }

        // Retornamos la jerarquía invertida, es decir, desde el continente hasta la provincia
        return array_reverse($regionNames);
    }
}

?>