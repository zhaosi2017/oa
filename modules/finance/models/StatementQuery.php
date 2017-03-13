<?php

namespace app\modules\finance\models;

/**
 * This is the ActiveQuery class for [[Statement]].
 *
 * @see Statement
 */
class StatementQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Statement[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Statement|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
