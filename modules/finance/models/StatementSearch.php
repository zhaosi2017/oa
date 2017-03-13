<?php

namespace app\modules\finance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StatementSearch represents the model behind the search form about `app\modules\finance\models\Statement`.
 */
class StatementSearch extends Statement
{

    public $search_type;

    public $search_keywords;

    public $accounting_start_date;

    public $accounting_end_date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'first_subject_id', 'second_subject_id', 'type', 'associate_id', 'status', 'direction', 'money_id', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['amount'], 'number'],
            [['accounting_date', 'remark', 'create_time', 'update_time', 'search_type', 'search_keywords', 'accounting_start_date', 'accounting_end_date'], 'safe'],
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
        $query = Statement::find()->where([
            'statement.status'=>Yii::$app->requestedAction->id == 'index' ? 0 : 1,
        ]);
        if(Yii::$app->controller->module->id!='system'){
            $identity = (Object) Yii::$app->user->identity;
            $query->andWhere(['statement.company_id'=>$identity->company_id]);
        }

        $query->joinWith('creator')->joinWith('updater')->joinWith('secondFinanceSubject')->joinWith('task');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'create_time' => SORT_DESC,
                ]
            ],
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
            'company_id' => $this->company_id,
            'first_subject_id' => $this->first_subject_id,
            'second_subject_id' => $this->second_subject_id,
            'statement.type' => $this->type,
            'associate_id' => $this->associate_id,
            'status' => $this->status,
            'statement.direction' => $this->direction,
            'money_id' => $this->money_id,
            'amount' => $this->amount,
            'accounting_date' => $this->accounting_date,
            'create_author_uid' => $this->create_author_uid,
            'update_author_uid' => $this->update_author_uid,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        if($this->accounting_start_date <= $this->accounting_end_date){
            $query->andFilterWhere(['between','statement.accounting_date', $this->accounting_start_date, $this->accounting_end_date]);
        }

        $this->search_type==1 && $query->andFilterWhere(['like', 'secondFinanceSubject.subject_name', $this->search_keywords]);
        $this->search_type==2 && $query->andFilterWhere(['like', 'task.name', $this->search_keywords])->orFilterWhere(['like', 'task.number', $this->search_keywords]);
        $this->search_type==3 && $query->andFilterWhere(['like', 'creator.account', $this->search_keywords]);
        $this->search_type==4 && $query->andFilterWhere(['like', 'updater.account', $this->search_keywords]);
        $this->search_type==5 && $query->andFilterWhere(['like', 'statement.remark', $this->search_keywords]);

        return $dataProvider;
    }
}
