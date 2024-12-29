<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ArticulosTienda]].
 *
 * @see ArticulosTienda
 */
class ArticulosTiendaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ArticulosTienda[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ArticulosTienda|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
