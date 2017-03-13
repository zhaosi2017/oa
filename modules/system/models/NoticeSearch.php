<?php

namespace app\modules\system\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NoticeSearch represents the model behind the search form about `app\modules\system\models\Notice`.
 */
class NoticeSearch extends Notice
{
    public $search_type;

    public $search_keywords;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'recipient_uid', 'sender_uid'], 'integer'],
            [['title', 'content', 'receive_time', 'send_time', 'search_type', 'search_keywords'], 'safe'],
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
        $query = Notice::find();

        if(Yii::$app->requestedAction->id!='index'){
            $uid = Yii::$app->user->id;
            $query->where('find_in_set('.$uid.',recipient_uid)');
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'send_time' => SORT_DESC,
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
            'status' => $this->status,
            'recipient_uid' => $this->recipient_uid,
            'sender_uid' => $this->sender_uid,
            'receive_time' => $this->receive_time,
            'send_time' => $this->send_time,
        ]);

        $this->search_type == 1 && $query->andFilterWhere(['like', 'content', $this->search_keywords]);

        return $dataProvider;
    }
}
