<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `app\modules\user\models\User`.
 */
class UserSearch extends User
{
    public $department_name;

    public $posts_name;

    public $create_author;

    public $update_author;

    public $search_type;

    public $search_keywords;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'department_id', 'posts_id', 'status', 'login_permission', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['search_type','search_keywords','account', 'department_name', 'posts_name', 'nickname', 'email', 'password', 'create_author', 'update_author', 'create_time', 'update_time'], 'safe'],
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
        $query = $this::find()->where(['user.status' => Yii::$app->requestedAction->id == 'index' ? 0 : 1]);

        $query->joinWith('company')->joinWith('department')->joinWith('posts')->joinWith('creator')->joinWith('updater');
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
            'user.id' => $this->id,
            'user.company_id' => $this->company_id,
            'user.department_id' => $this->department_id,
            'user.posts_id' => $this->posts_id,
            'user.status' => $this->status,
            'user.login_permission' => $this->login_permission,
            'user.create_author_uid' => $this->create_author_uid,
            'user.update_author_uid' => $this->update_author_uid,
            'user.create_time' => $this->create_time,
            'user.update_time' => $this->update_time,
        ]);

        $this->search_type ==1 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'user.id', $this->searchIds($this->search_keywords)]);
        $this->search_type ==2 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'creator.id', $this->searchIds($this->search_keywords)]);
        $this->search_type ==3 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'updater.id', $this->searchIds($this->search_keywords)]);
        return $dataProvider;
    }

    public function searchIds($searchWords)
    {
        $ids = [0];
        $query = $this::find()->select(['account','id'])->all();
        foreach ($query as $row)
        {
            $pos = strpos($row['account'],$searchWords);
            if(is_int($pos)){
                $ids[] = $row['id'];
            }
        }
        return $ids;
    }

    public function filterCompany()
    {
        return Company::find()->select(['name','id'])->where(['status'=>0])->indexBy('id')->column();
    }

}
