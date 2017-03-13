<?php

namespace app\modules\task\models;

/**
 * This is the ActiveQuery class for [[TaskFeedback]].
 *
 * @see TaskFeedback
 */
class TaskFeedbackQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TaskFeedback[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TaskFeedback|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
