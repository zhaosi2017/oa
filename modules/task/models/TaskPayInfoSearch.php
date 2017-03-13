<?php

namespace app\modules\task\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TaskPayInfoSearch represents the model behind the search form about `app\modules\task\models\TaskPayInfo`.
 */
class TaskPayInfoSearch extends TaskPayInfo
{
    public $search_type;

    public $search_keywords;

    public $pay_company_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'task_id', 'pay_company_id', 'execute_company_id', 'status', 'type', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['pay_bill_no', 'create_time', 'update_time', 'search_keywords','pay_company_name'], 'safe'],
            [['search_type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TaskPayInfo::find();

        $identity = (Object)Yii::$app->user->identity;

        if(Yii::$app->controller->module->id!='system'){
            $query->where(['task_pay_info.pay_company_id'=>$identity->company_id]);
            $query->orWhere(['task_pay_info.execute_company_id'=>$identity->company_id]);
            Yii::$app->requestedAction->id=='index' && $query->andWhere(['!=','task_pay_info.status',1]);
            Yii::$app->requestedAction->id=='trash' && $query->andWhere(['task_pay_info.status'=>1]);
        }

        // add conditions that should always apply here
        $query->joinWith('task')->joinWith('executeCompany')->joinWith('payCompany');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'task_id' => $this->task_id,
            'pay_company_id' => $this->pay_company_id,
            'execute_company_id' => $this->execute_company_id,
            'task_pay_info.status' => $this->status,
            'payCompany.id' => $this->pay_company_name,
            'type' => $this->type,
            'create_author_uid' => $this->create_author_uid,
            'update_author_uid' => $this->update_author_uid,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $this->search_type == 1 && $query->andFilterWhere(['like', 'task_pay_info.pay_bill_no', $this->search_keywords]);
        $this->search_type == 2 && $query->andFilterWhere(['like', 'task.number', $this->search_keywords]);
        $this->search_type == 3 && $query->andFilterWhere(['like', 'executeCompany.name', $this->search_keywords]);
        $this->search_type == 4 && $query->andFilterWhere(['like', 'payCompany.name', $this->search_keywords]);

        return $dataProvider;
    }
}
