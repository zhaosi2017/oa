<?php

namespace app\modules\system\models;

/**
 * This is the ActiveQuery class for [[SerialNumber]].
 *
 * @see SerialNumber
 */
class SerialNumberQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SerialNumber[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SerialNumber|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
