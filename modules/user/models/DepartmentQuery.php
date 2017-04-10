<?php

namespace app\modules\user\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Department]].
 *
 * @see Department
 */
class DepartmentQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Department[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Department|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $company_id
     * @return array
     */
    public function downList($company_id)
    {
        $res = Department::find()->select(['name', 'id'])->where(['status'=>0,'company_id'=>$company_id])->indexBy('id')->column();

        //decrypt
        foreach ($res as $id=>$name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
        }
        return $res;
    }

    /**
     * @param $id
     * @return array
     */
    public function getChildren($id)
    {
        $self = Department::findOne(['id'=>$id,'status'=>0]);

        /*$sql = 'select id,superior_department_id,name from
                  (select * from '.Department::tableName().' where superior_department_id>0 order by id desc) real_name_sorted,
                  (select @pv :='.$id.') initialisation 
                  where (find_in_set(superior_department_id,@pv)>0 and @pv := concat(@pv,",",id))';
        $children = [] + Department::getDb()->createCommand($sql)->queryAll();*/

        $real_name_sorted = Department::find()->where(['>','superior_department_id',0])->orderBy(['id'=>SORT_DESC]);
        $initialisation = Department::find()->select('@pv :='.$id);
        $children = [] + Department::find()->select(['id','superior_department_id','name'])
                ->from(['real_name_sorted'=>$real_name_sorted,'initialisation'=>$initialisation])
                ->where('find_in_set(superior_department_id,@pv)>0 and @pv := concat(@pv,",",id)');

        array_unshift($children, $self);

        return $children;
    }
}
