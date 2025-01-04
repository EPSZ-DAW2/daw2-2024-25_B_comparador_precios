<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Ofertas]].
 *
 * @see Ofertas
 */
class OfertasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Ofertas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Ofertas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
