<?php

namespace app\modules\product\models;

/**
 * This is the ActiveQuery class for [[RootCategory]].
 *
 * @see RootCategory
 */
class RootCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RootCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RootCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
