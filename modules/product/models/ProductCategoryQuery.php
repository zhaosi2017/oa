<?php

namespace app\modules\product\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ProductCategory]].
 *
 * @see ProductCategory
 */
class ProductCategoryQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProductCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $first_category_id
     * @return array
     */
    public function getChildren($first_category_id)
    {
        if(!$first_category_id){
            return [];
        }
        $res = ProductCategory::find()
            ->select(['name','id'])
            ->where(['superior_id'=>$first_category_id])
            ->indexBy('id')
            ->column();
        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
        }
        return $res;
    }
}
