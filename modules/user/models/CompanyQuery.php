<?php

namespace app\modules\user\models;
use app\modules\finance\models\Statement;
use app\modules\task\models\TaskCollectionInfo;
use app\modules\task\models\TaskDealPrice;
use app\modules\task\models\TaskPayInfo;
use yii\db\ActiveQuery;

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
        return Company::find()->select(['name','id'])->where(['status' => 0])->indexBy('id')->column();
    }

    public function statistic()
    {
        $statistic = [];

        $company_tasks = TaskCollectionInfo::find()->select(['group_concat(task_id) as task_ids','company_id'])
            ->where(['status'=>2])
            ->groupBy('company_id')->indexBy('company_id')->column();

        $pay_company_tasks = TaskPayInfo::find()->select(['group_concat(task_id) as task_ids','pay_company_id'])->where(['status'=>2])
            ->groupBy('pay_company_id')->indexBy('pay_company_id')->column();
        $deal_query = TaskDealPrice::find();

        foreach ($company_tasks as $company_id => $task_ids){
            $statistic[$company_id]['collection'] = $deal_query->select(['sum(price) as sum_collection','money_id'])
                ->where(['in','task_id',$task_ids])->groupBy('money_id')->indexBy('money_id')->column();
        }

        foreach ($pay_company_tasks as $cid => $tasks){
            $statistic[$cid]['pay'] = $deal_query->select(['sum(price) as sum_collection','money_id'])
                ->where(['in','task_id',$tasks])->groupBy('money_id')->indexBy('money_id')->column();
        }


        $statement_query = Statement::find();
        $statement = $statement_query->distinct('company_id')->select(['company_id'])->where(['status'=>0])->asArray()->all();
        foreach ($statement as $item){
            $statistic[$item['company_id']]['statement'] = Statement::find()->select([
                'sum(case when direction=2 then amount end) as gross',
                'sum(case when direction=1 then amount end) as spending','money_id'
            ])->where(['company_id'=>$item['company_id']])->groupBy('money_id')->indexBy('money_id')->asArray()->all();
        }

        return $statistic;
    }
}
