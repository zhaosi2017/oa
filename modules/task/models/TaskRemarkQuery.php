<?php

namespace app\modules\task\models;

/**
 * This is the ActiveQuery class for [[TaskRemark]].
 *
 * @see TaskRemark
 */
class TaskRemarkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TaskRemark[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TaskRemark|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
