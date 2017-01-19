<?php

namespace app\modules\user\models;

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
        return Department::find()->select(['name', 'id'])->where(['status'=>0,'company_id'=>$company_id])->indexBy('id')->column();
    }

    /**
     * @param $id
     * @return array
     */
    public function getChildren($id)
    {
        $self = Department::findOne(['id'=>$id,'status'=>0]);

        $sql = 'select id,superior_department_id,name from 
                  (select * from '.Department::tableName().' where superior_department_id>0 order by id desc) realname_sorted, 
                  (select @pv :='.$id.') initialisation 
                  where (find_in_set(superior_department_id,@pv)>0 and @pv := concat(@pv,",",id))';
        $children = [] + Department::getDb()->createCommand($sql)->queryAll();

        array_unshift($children, $self);

        return $children;
    }
}
