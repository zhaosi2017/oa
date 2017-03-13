<?php

namespace app\modules\system\models;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Notice]].
 *
 * @see Notice
 */
class NoticeQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Notice[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Notice|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
