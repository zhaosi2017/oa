<?php

namespace app\modules\customer\models;

/**
 * This is the ActiveQuery class for [[GroupRate]].
 *
 * @see GroupRate
 */
class GroupRateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return GroupRate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GroupRate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
