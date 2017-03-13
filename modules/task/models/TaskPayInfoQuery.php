<?php

namespace app\modules\task\models;

/**
 * This is the ActiveQuery class for [[TaskPayInfo]].
 *
 * @see TaskPayInfo
 */
class TaskPayInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TaskPayInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TaskPayInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
