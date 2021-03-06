<?php

namespace app\modules\user\models;
use yii\db\ActiveQuery;
use Yii;

/**
 * This is the ActiveQuery class for [[Company]].
 *
 * @see Company
 */
class CompanyQuery extends ActiveQuery
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
        $res = Company::find()->select(['name','id'])->where(['status' => 0])->indexBy('id')->column();

        foreach ($res as $i=>$d){
            $res[$i] = Yii::$app->security->decryptByKey(base64_decode($d), Yii::$app->params['inputKey']);
        }
        return $res;
    }

}
