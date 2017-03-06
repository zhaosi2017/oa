<?php

namespace app\modules\product\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//use app\modules\product\models\ProductCategory;

/**
 * ProductCategorySearch represents the model behind the search form about `app\modules\product\models\ProductCategory`.
 */
class ProductCategorySearch extends ProductCategory
{

    public $search_type;

    public $search_keywords;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'superior_id', 'company_id', 'status', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['name', 'create_time', 'avisible', 'update_time', 'search_type', 'search_keywords'], 'safe'],
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
        $query = ProductCategory::find()
        ->where([
            'product_category.status'=>\Yii::$app->requestedAction->id == 'index' ? 0 : 1,
        ]);

        if(Yii::$app->controller->module->id != 'system'){
            $identity = (Object) Yii::$app->user->identity;
            $identity->company_id && $query->andWhere(['product_category.company_id'=>$identity->company_id]);
        }

        $query->joinWith('superior')->joinWith('creator')->joinWith('updater');
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
            'superior_id' => $this->superior_id,
            'company_id' => $this->company_id,
            // 'product_category.avisible' => $this->avisible,
            'status' => $this->status,
            'create_author_uid' => $this->create_author_uid,
            'update_author_uid' => $this->update_author_uid,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        if(is_array($this->avisible)){
            $visible = (array) $this->avisible;
            $bit_num = array_sum($visible);
            $query->andFilterWhere(['>=', 'product_category.avisible', $bit_num]);
        }
        $this->search_type==1 && $query->andFilterWhere(['like', 'product_category.name', $this->search_keywords]);

        return $dataProvider;
    }
}
