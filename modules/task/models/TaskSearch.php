<?php

namespace app\modules\task\models;

use app\modules\customer\models\CustomerSearch;
use app\modules\product\models\ProductCategory;
use app\modules\user\models\CompanySearch;
use app\modules\user\models\UserSearch;
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
            case 'trashed-index':
                $query->where(['=', 'task.status', 1]);
                break;
            case 'wait-index':
                $query->where(['=', 'task.status', 3]);
                $query->andWhere(['in','task.product_id',$this->whereExecuteProductIds($identity->company_id)]);
                break;
            case 'handle-index':
                $query->where(['=', 'task.status', 4]);
//                $query->andWhere(['in','task.product_id',$this->whereExecuteProductIds($identity->company_id)]);
                break;
            case 'finished-index':
                $query->where(['=', 'task.status', 7]);
//                $query->andWhere(['in','task.product_id',$this->whereExecuteProductIds($identity->company_id)]);
                break;
            case 'received-index':
                $query->where(['between', 'task.status', 4, 9]);
                $query->andWhere(['in','task.product_id',$this->whereExecuteProductIds($identity->company_id)]);
                //执行人=当前ID所属公司的数据
                $query->andWhere(['task.execute_company_id'=>$identity->company_id]);
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

        $searchCompany = new CompanySearch();
        $searchUser = new UserSearch();

        $this->search_type ==1 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'task.id', $this->searchIds($this->search_keywords)])->orFilterWhere(['in', 'task.id', $this->searchIds($this->search_keywords,'number')]);

        $this->search_type ==2 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'task.id', $this->searchIds($this->search_keywords,'requirement')]);

        $this->search_type ==3 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'task.id', $this->searchIds($this->search_keywords)])->orFilterWhere(['in', 'task.id', $this->searchIds($this->search_keywords,'number')]);

        $this->search_type ==4 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'customer.id', (new CustomerSearch())->searchIds($this->search_keywords)])->orFilterWhere(['in', 'group.id', $searchCompany->searchIds($this->search_keywords)]);

        $this->search_type ==5 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'executeCompany.id', $searchCompany->searchIds($this->search_keywords)]);

        $this->search_type ==6 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'creator.id', $searchUser->searchIds($this->search_keywords)]);

        $this->search_type ==7 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'updater.id', $searchUser->searchIds($this->search_keywords)]);

        return $dataProvider;
    }

    public function getFirstProductCategory()
    {
        $res = ProductCategory::find()
            ->select(['name','id'])
            ->where(['status'=>0,'superior_id'=>0])->indexBy('id')->column();
        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
        }
        return $res;
    }

    public function searchIds($searchWords, $field='name')
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
