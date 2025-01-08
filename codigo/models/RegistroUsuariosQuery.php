<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[RegistroUsuarios]].
 *
 * @see RegistroUsuarios
 */
class RegistroUsuariosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return RegistroUsuarios[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RegistroUsuarios|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
