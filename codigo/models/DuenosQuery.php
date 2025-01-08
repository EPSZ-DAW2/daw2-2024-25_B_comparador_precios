<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Dueno]].
 *
 * @see Dueno
 */
class DuenosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Dueno[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Dueno|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
