<?php

namespace app\modules\finance\models;

use app\modules\task\models\TaskSearch;
use app\modules\user\models\UserSearch;
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
        $query = Statement::find();
        $query->where([
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

        $taskSearch = new TaskSearch();
        $this->search_type ==1 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'secondFinanceSubject.id', (new FinanceSubjectSearch())->searchIds($this->search_keywords)]);
        $this->search_type ==2 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'task.id', $taskSearch->searchIds($this->search_keywords)])->orFilterWhere(['in', 'task.id', $taskSearch->searchIds($this->search_keywords,'number')]);
        $this->search_type ==3 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'creator.id', (new UserSearch())->searchIds($this->search_keywords)]);
        $this->search_type ==4 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'updater.id', (new UserSearch())->searchIds($this->search_keywords)]);
        $this->search_type ==5 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'statement.id', $this->searchIds($this->search_keywords)]);
        return $dataProvider;
    }

    public function searchIds($searchWords, $field='remark')
    {
        $ids = [0];
        $query = $this::find()->select([$field,'id'])->all();
        foreach ($query as $row)
        {
            $pos = strpos($row[$field],$searchWords);
            if(is_int($pos)){
                $ids[] = $row['id'];
            }
        }
        return $ids;
    }


}
