<?php

namespace app\modules\user\models;

//use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//use app\modules\user\models\Posts;

/**
 * PostsSearch represents the model behind the search form about `app\modules\user\models\Posts`.
 */
class PostsSearch extends Posts
{

    public $company_name;

    public $department_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'department_id', 'status', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['name', 'company_name', 'department_name','create_time', 'update_time'], 'safe'],
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
        $query = $this::find()->where([
            'posts.status'=>\Yii::$app->requestedAction->id == 'index' ? 0 : 1,
        ]);

        // add conditions that should always apply here
        $query->joinWith('company')->joinWith('department')->joinWith('creator')->joinWith('updater');

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
            'status' => $this->status,
            'create_author_uid' => $this->create_author_uid,
            'update_author_uid' => $this->update_author_uid,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'posts.name', $this->name])
            ->andFilterWhere(['like', 'company.name', $this->company_name])
            ->andFilterWhere(['like', 'department.name', $this->department_name]);

        return $dataProvider;
    }

}
