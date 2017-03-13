<?php

namespace app\modules\user\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LoginLogsSearch represents the model behind the search form about `app\modules\user\models\LoginLogs`.
 */
class LoginLogsSearch extends LoginLogs
{

    public $search_type;

    public $search_keywords;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'status'], 'integer'],
            [['login_time', 'login_ip', 'search_type', 'search_keywords'], 'safe'],
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
        $query = LoginLogs::find();

        if(\Yii::$app->requestedAction->id=='ip-lock'){
            $query->where(['login_logs.status'=>1])->orWhere(['login_logs.status'=>4]);
        }
        $query->joinWith('user');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'login_time' => SORT_DESC,
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
            'uid' => $this->uid,
            'login_logs.status' => $this->status,
            'login_time' => $this->login_time,
        ]);

        $this->search_type==1 && $query->andFilterWhere(['like', 'user.account', $this->search_keywords]);
        $this->search_type==2 && $query->andFilterWhere(['like', 'login_logs.login_ip', $this->search_keywords]);

        return $dataProvider;
    }
}
