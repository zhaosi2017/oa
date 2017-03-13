<?php

namespace app\modules\task\models;

/**
 * This is the ActiveQuery class for [[TaskCollectionInfo]].
 *
 * @see TaskCollectionInfo
 */
class TaskCollectionInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TaskCollectionInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TaskCollectionInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
