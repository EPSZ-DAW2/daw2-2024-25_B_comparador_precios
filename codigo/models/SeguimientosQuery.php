<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Seguimiento]].
 *
 * @see Seguimiento
 */
class SeguimientosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Seguimiento[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Seguimiento|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
