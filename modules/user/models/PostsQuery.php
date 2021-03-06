<?php

namespace app\modules\user\models;

use yii\db\ActiveQuery;
use Yii;

/**
 * This is the ActiveQuery class for [[Posts]].
 *
 * @see Posts
 */
class PostsQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Posts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Posts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function downList($department_id)
    {
        $res = Posts::find()->select(['name', 'id'])->where(['status'=>0,'department_id'=>$department_id])->indexBy('id')->column();
        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
        }
        return $res;
    }
}
