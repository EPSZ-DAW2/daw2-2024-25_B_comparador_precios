<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Regiones extends ActiveRecord
{
    public static function tableName()
    {
        return 'regiones';
    }

    public function getHijos()
    {
        return $this->hasMany(Regiones::className(), ['region_padre_id' => 'id']);
    }

    // Otros métodos o validaciones si es necesario...
}
?>