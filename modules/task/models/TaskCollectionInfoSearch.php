<?php

namespace app\modules\task\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TaskCollectionInfoSearch represents the model behind the search form about `app\modules\task\models\TaskCollectionInfo`.
 */
class TaskCollectionInfoSearch extends TaskCollectionInfo
{

    public $search_type;

    public $search_keywords;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'task_id', 'company_id', 'status', 'type', 'company_customer_id', 'customer_category', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['receipt_no', 'create_time', 'update_time', 'search_type', 'search_keywords'], 'safe'],
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
        $query = TaskCollectionInfo::find();

        if(Yii::$app->requestedAction->id=='index'){
            $query->where(['!=','task_collection_info.status',1]);
        }
        if(Yii::$app->requestedAction->id=='trash'){
            $query->where(['=','task_collection_info.status',1]);
        }

        $identity = (Object) Yii::$app->user->identity;
        Yii::$app->controller->module->id!='system' && $query->andWhere(['task_collection_info.company_id'=>$identity->company_id]);

        // add conditions that should always apply here
        $query->joinWith('task')->joinWith('customer')->joinWith('group');

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
            'company_id' => $this->company_id,
            'task_collection_info.status' => $this->status,
            'task_collection_info.type' => $this->type,
            'company_customer_id' => $this->company_customer_id,
            'customer_category' => $this->customer_category,
            'create_author_uid' => $this->create_author_uid,
            'update_author_uid' => $this->update_author_uid,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $this->search_type == 1 && $query->andFilterWhere(['like', 'task_collection_info.receipt_no', $this->search_keywords]);
        $this->search_type == 2 && $query->andFilterWhere(['like', 'task.number', $this->search_keywords]);
        $this->search_type == 3 && $query->andFilterWhere(['like', 'customer.name', $this->search_keywords])->orFilterWhere(['like', 'group.name', $this->search_keywords]);

        return $dataProvider;
    }
}
