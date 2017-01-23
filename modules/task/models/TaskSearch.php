<?php

namespace app\modules\task\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\task\models\Task;

/**
 * TaskSearch represents the model behind the search form about `app\modules\task\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'company_customer_id', 'execute_type', 'fee_settlement', 'customer_category', 'customer_grate', 'product_id', 'status', 'superior_task_id', 'create_author_uid', 'update_author_uid', 'create_time', 'update_time'], 'integer'],
            [['name', 'requirement', 'attachment'], 'safe'],
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
        $query = Task::find();

        // add conditions that should always apply here

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
            'execute_type' => $this->execute_type,
            'fee_settlement' => $this->fee_settlement,
            'customer_category' => $this->customer_category,
            'customer_grate' => $this->customer_grate,
            'product_id' => $this->product_id,
            'status' => $this->status,
            'superior_task_id' => $this->superior_task_id,
            'create_author_uid' => $this->create_author_uid,
            'update_author_uid' => $this->update_author_uid,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'requirement', $this->requirement])
            ->andFilterWhere(['like', 'attachment', $this->attachment]);

        return $dataProvider;
    }
}
