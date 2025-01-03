<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Clasificaciones]].
 *
 * @see Clasificaciones
 */
class ClasificacionesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Clasificaciones[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Clasificaciones|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
