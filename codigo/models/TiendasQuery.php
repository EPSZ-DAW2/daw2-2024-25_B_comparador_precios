<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Tienda]].
 *
 * @see Tienda
 */
class TiendasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tienda[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tienda|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
