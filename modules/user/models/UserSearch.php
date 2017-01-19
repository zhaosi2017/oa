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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'department_id', 'posts_id', 'status', 'login_permission', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['account', 'department_name', 'posts_name', 'nickname', 'email', 'password', 'create_author', 'update_author', 'create_time', 'update_time'], 'safe'],
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

        $query->andFilterWhere(['like', 'user.account', $this->account])
            ->andFilterWhere(['like', 'department.name', $this->department_name])
            ->andFilterWhere(['like', 'posts.name', $this->posts_name])
            ->andFilterWhere(['like', 'creator.account', $this->create_author])
            ->andFilterWhere(['like', 'updater.account', $this->update_author]);

        return $dataProvider;
    }

    public function filterCompany()
    {
        return Company::find()->select(['name','id'])->where(['status'=>0])->indexBy('id')->column();
    }

}
