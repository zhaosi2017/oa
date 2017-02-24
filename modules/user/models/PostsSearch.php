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

    public $search_type;

    public $search_keywords;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'department_id', 'status', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['name', 'company_name', 'company_id', 'department_id', 'department_name','create_time', 'update_time', 'search_type', 'search_keywords'], 'safe'],
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
            'posts.company_id' => $this->company_id,
            'posts.department_id' => $this->department_id,
        ]);

        $this->search_type ==1 && $query->andFilterWhere(['like', 'posts.name', $this->search_keywords]);

        return $dataProvider;
    }

}
