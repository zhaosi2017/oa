<?php

namespace app\modules\task\models;

use Yii;
use app\modules\customer\models\Customer;
use app\modules\customer\models\GroupRate;
use app\modules\user\models\Company;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Task]].
 *
 * @see Task
 */
class TaskQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Task[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Task|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function companyDownList()
    {
        $res = Company::find()->select(['name','id'])->where(['status'=>0])->indexBy('id')->column();
        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
        }
        return $res;
    }

    public function getRatedCompany($company_id)
    {
        $company_in_ids = GroupRate::find()->select('company_id')->where(['rate_company_id'=>$company_id])->column();
        $res = Company::find()->select(['name','id'])->where(['status'=>0])->andWhere(['in','id',$company_in_ids])->indexBy('id')->column();
        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
        }
        return $res;
    }

    public function customerDownList($company_id)
    {
        $res = Customer::find()->select(['name','id'])->where(['company_id'=>$company_id,'status'=>0])->indexBy('id')->column();
        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
        }
        return $res;
    }

    /**
     * @param $customer_category
     * @param $company_customer_id
     * @param $current_company_id
     * @return int|mixed
     */
    public function getGrade($customer_category, $company_customer_id, $current_company_id)
    {
        $grade = 0;
        switch ($customer_category){
            case 1:
                $grade = Customer::findOne(['id' => $company_customer_id])->getAttribute('grade');
                break;
            case 2:
                $groupRate = GroupRate::findOne(['company_id'=>$company_customer_id, 'rate_company_id'=>$current_company_id]);
                $groupRate && ($grade = $groupRate->getAttribute('grade'));
                break;
        }
        return $grade;
    }
}
