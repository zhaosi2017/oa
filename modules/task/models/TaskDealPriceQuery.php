<?php

namespace app\modules\task\models;

/**
 * This is the ActiveQuery class for [[TaskDealPrice]].
 *
 * @see TaskDealPrice
 */
class TaskDealPriceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TaskDealPrice[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TaskDealPrice|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
