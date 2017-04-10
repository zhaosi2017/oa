<?php

namespace app\modules\system\models;

//use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MoneySearch represents the model behind the search form about `app\modules\system\models\Money`.
 */
class MoneySearch extends Money
{
    public $search_type;

    public $search_keywords;

    public $start_date;

    public $end_date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'create_time', 'update_time', 'search_type', 'search_keywords', 'start_date', 'end_date'], 'safe'],
            [['enable', 'status', 'create_author_uid', 'update_author_uid'], 'integer'],
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
        $query = Money::find();
        /*if(empty(\Yii::$app->request->get('MoneySearch'))){
            $query->where(['money.id'=>0]);
        }*/

        if(\Yii::$app->requestedAction->id == 'index'){
            $query->andWhere(['money.status'=>0]);
        }
        if(\Yii::$app->requestedAction->id == 'trash'){
            $query->andWhere(['money.status'=>1]);
        }

        $query->joinWith('creator')->joinWith('updater');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'enable' => $this->enable,
            'status' => $this->status,
            'create_author_uid' => $this->create_author_uid,
            'update_author_uid' => $this->update_author_uid,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $this->search_type==1 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'money.id', $this->searchIds($this->search_keywords)]);

        return $dataProvider;
    }

    public function searchIds($searchWords)
    {
        $ids = [0];
        $query = $this::find()->select(['name','id'])->all();
        foreach ($query as $row)
        {
            $pos = strpos($row['name'],$searchWords);
            if(is_int($pos)){
                $ids[] = $row['id'];
            }
        }
        return $ids;
    }
}
