<?php

namespace app\modules\product\models;

/**
 * This is the ActiveQuery class for [[ProductExecutePrice]].
 *
 * @see ProductExecutePrice
 */
class ProductExecutePriceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProductExecutePrice[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductExecutePrice|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
