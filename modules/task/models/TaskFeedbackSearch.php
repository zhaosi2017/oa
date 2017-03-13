<?php

namespace app\modules\task\models;

//use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//use app\modules\task\models\TaskFeedback;

/**
 * TaskFeedbackSearch represents the model behind the search form about `app\modules\task\models\TaskFeedback`.
 */
class TaskFeedbackSearch extends TaskFeedback
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'task_id', 'create_author_uid', 'create_time', 'type', 'status'], 'integer'],
            [['content', 'attachment'], 'safe'],
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
        $query = TaskFeedback::find();

        $actionId = \Yii::$app->requestedAction->id;

        switch ($actionId){
            case 'index':
                $query->where(['status'=>0]);
                break;
            case 'index-received':
                $query->where(['status'=>0]);
                break;
            case 'feedback':
                $query->where(['status'=>0]);
                break;
            case 'trash':
                $query->where(['status'=>1]);
                break;
            case 'trash-received':
                $query->where(['status'=>1]);
                break;
            case 'feedback-trash':
                $query->where(['status'=>1]);
                break;
        }

        $getTaskId = \Yii::$app->request->get('id');
        if($getTaskId){
            $query->andWhere(['task_id'=>$getTaskId]);
        }
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

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'attachment', $this->attachment]);

        return $dataProvider;
    }
}
