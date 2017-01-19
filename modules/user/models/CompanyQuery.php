<?php

namespace app\modules\user\models;

/**
 * This is the ActiveQuery class for [[Company]].
 *
 * @see Company
 */
class CompanyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Company[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Company|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function downList()
    {
        return Company::find()->select(['name','id'])->where(['status' => 0])->indexBy('id')->column();
    }
}
