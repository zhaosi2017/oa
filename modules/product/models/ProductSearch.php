<?php

namespace app\modules\product\models;

//use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//use app\modules\product\models\Product;

/**
 * ProductSearch represents the model behind the search form about `app\modules\product\models\Product`.
 */
class ProductSearch extends Product
{
    public $creator_account;

    public $updater_account;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'second_category_id', 'enable', 'status', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['name', 'number', 'description', 'create_time', 'update_time', 'creator_account', 'updater_account'], 'safe'],
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
        $query = Product::find()->select([
            'product.id',
            'product.name',
            'product.number',
            'product.second_category_id',
            'product.enable',
            'product.status',
            'product.company_id',
            'product.description',
            'product.create_author_uid',
            'product.create_time',
            'product.update_author_uid',
            'product.update_time',
            'creator.account as creator_account',
            'updater.account as updater_account',
            'category.name',
        ])->where([
            'product.status'=>\Yii::$app->requestedAction->id == 'index' ? 0 : 1,
        ]);

        $query->joinWith('creator')->joinWith('updater')->joinWith('company')->joinWith('category');
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
            'second_category_id' => $this->second_category_id,
            'enable' => $this->enable,
            'status' => $this->status,
            'create_author_uid' => $this->create_author_uid,
            'update_author_uid' => $this->update_author_uid,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'product.name', $this->name])
              ->andFilterWhere(['like', 'creator.account', $this->creator_account])
              ->andFilterWhere(['like', 'updater.account', $this->updater_account]);

        return $dataProvider;
    }
}
