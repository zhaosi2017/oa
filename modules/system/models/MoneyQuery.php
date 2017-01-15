<?php

namespace app\modules\system\models;

/**
 * This is the ActiveQuery class for [[Money]].
 *
 * @see Money
 */
class MoneyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Money[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Money|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
