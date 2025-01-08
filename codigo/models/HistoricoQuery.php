<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Historico]].
 *
 * @see Historico
 */
class HistoricoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Historico[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Historico|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
