<?php

namespace app\modules\task\models;

use app\modules\product\models\ProductCategory;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TaskSearch represents the model behind the search form about `app\modules\task\models\Task`.
 */
class TaskSearch extends Task
{
    public $first_product_category;

    public $second_product_category;

    public $top_level_task;

    public $search_type;

    public $search_keywords;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'company_customer_id', 'execute_type', 'fee_settlement', 'customer_category', 'customer_grate', 'product_id', 'status', 'superior_task_id', 'create_author_uid', 'update_author_uid', 'create_time', 'update_time'], 'integer'],
            [['name', 'requirement', 'attachment'], 'safe'],
            [['second_product_category','top_level_task','search_type'], 'integer'],
            [['search_keywords'], 'safe'],
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
        $identity = (Object) Yii::$app->user->identity;

        //$productExecuteCompany = $query->where('find_in_set('.$execute_cid.',recipient_uid)');
        switch (Yii::$app->requestedAction->id){
            case 'sent-index':
                $query->where(['!=', 'task.status', 1]);
                $query->andWhere(['task.company_id' => $identity->company_id]);
                break;
            case 'sent-trash':
                $query->where(['=', 'task.status', 1]);
                $query->andWhere(['task.company_id' => $identity->company_id]);
                break;
            case 'trash':
                $query->where(['=', 'task.status', 1]);
                break;
            case 'wait-index':
                $query->where(['=', 'task.status', 3]);
                $query->andWhere(['in','task.product_id',$this->whereExecuteProductIds($identity->company_id)]);
                break;
            case 'received-index':
                $query->where(['between', 'task.status', 4, 9]);
                $query->andWhere(['in','task.product_id',$this->whereExecuteProductIds($identity->company_id)]);
                break;
        }

        $query->joinWith('product')
            ->joinWith('superior')
            ->joinWith('company')
            ->joinWith('executeCompany')
            ->joinWith('customer')
            ->joinWith('group')
            ->joinWith('creator')
            ->joinWith('updater');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
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
            'task.execute_type' => $this->execute_type,
            'task.fee_settlement' => $this->fee_settlement,
            'customer_category' => $this->customer_category,
            'customer_grate' => $this->customer_grate,
            'product_id' => $this->product_id,
            'task.status' => $this->status,
            'superior_task_id' => $this->superior_task_id,
            'create_author_uid' => $this->create_author_uid,
            'update_author_uid' => $this->update_author_uid,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'product.second_category_id' => $this->second_product_category,
            'task.superior_task_id' => $this->top_level_task,
        ]);

        $this->search_type == 1 && $query->andFilterWhere(['like', 'task.name', $this->search_keywords])->orFilterWhere(['like', 'task.number', $this->search_keywords]);

        $this->search_type == 2 && $query->andFilterWhere(['like', 'task.requirement', $this->search_keywords]);

        $this->search_type == 3 && $query->andFilterWhere(['like', 'superior.name', $this->search_keywords])->orFilterWhere(['like', 'superior.number', $this->search_keywords]);

        $this->search_type == 4 && $query->andFilterWhere(['like', 'customer.name', $this->search_keywords])->orFilterWhere(['like', 'group.name', $this->search_keywords]);

        $this->search_type == 5 && $query->andFilterWhere(['like', 'executeCompany.name', $this->search_keywords]);

        $this->search_type == 6 && $query->andFilterWhere(['like', 'creator.account', $this->search_keywords]);

        $this->search_type == 7 && $query->andFilterWhere(['like', 'updater.account', $this->search_keywords]);

        return $dataProvider;
    }

    public function getFirstProductCategory()
    {
        return
        ProductCategory::find()
            ->select(['name','id'])
            ->where(['status'=>0,'superior_id'=>0])->indexBy('id')->column();
    }

}
