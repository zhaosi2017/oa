<?php

namespace app\modules\task\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//use app\modules\task\models\TaskRemark;

/**
 * TaskRemarkSearch represents the model behind the search form about `app\modules\task\models\TaskRemark`.
 */
class TaskRemarkSearch extends TaskRemark
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'task_id', 'create_author_uid', 'type', 'status'], 'integer'],
            [['content', 'create_time'], 'safe'],
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
        $query = TaskRemark::find();

        $actionId = Yii::$app->requestedAction->id;
        switch ($actionId){
            case 'index':
                $query->where(['task_remark.status'=>0]);
                break;
            case 'remark':
                $query->where(['task_remark.status'=>0]);
                break;
            case 'trash':
                $query->where(['task_remark.status'=>1]);
                break;
            case 'remark-trash':
                $query->where(['task_remark.status'=>1]);
                break;
        }

//        $query->joinWith('creator')->joinWith('updater');
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
            'task_id' => $this->task_id,
            'create_author_uid' => $this->create_author_uid,
            'create_time' => $this->create_time,
            'type' => $this->type,
            'status' => $this->status,
        ]);

        strlen($this->content)>0 && $query->andFilterWhere(['in', 'id', $this->searchIds($this->content)]);

        return $dataProvider;
    }

    public function searchIds($searchWords)
    {
        $ids = [0];
        $query = $this::find()->select(['content','id'])->all();
        foreach ($query as $row)
        {
            $pos = strpos($row['content'],$searchWords);
            if(is_int($pos)){
                $ids[] = $row['id'];
            }
        }
        return $ids;
    }
}
