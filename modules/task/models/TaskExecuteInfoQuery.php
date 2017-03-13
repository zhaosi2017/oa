<?php

namespace app\modules\task\models;

/**
 * This is the ActiveQuery class for [[TaskExecuteInfo]].
 *
 * @see TaskExecuteInfo
 */
class TaskExecuteInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TaskExecuteInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TaskExecuteInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
