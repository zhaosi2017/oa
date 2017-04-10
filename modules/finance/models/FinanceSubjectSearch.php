<?php

namespace app\modules\finance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FinanceSubjectSearch represents the model behind the search form about `app\modules\finance\models\FinanceSubject`.
 */
class FinanceSubjectSearch extends FinanceSubject
{
    public $search_type;

    public $search_keywords;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'superior_subject_id', 'enable', 'status', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['subject_name', 'create_time', 'update_time', 'search_type', 'search_keywords'], 'safe'],
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
        $query = FinanceSubject::find();

        $query->where(['finance_subject.status' => Yii::$app->requestedAction->id == 'index' ? 0 : 1]);
        // add conditions that should always apply here
        $query->joinWith('creator')->joinWith('updater')->joinWith('superior');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'superior_subject_id' => $this->superior_subject_id,
            'finance_subject.enable' => $this->enable,
            'status' => $this->status,
            'create_author_uid' => $this->create_author_uid,
            'update_author_uid' => $this->update_author_uid,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $this->search_type ==1 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'finance_subject.id', $this->searchIds($this->search_keywords)]);
        $this->search_type ==2 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'superior.id', $this->searchIds($this->search_keywords)]);
        return $dataProvider;
    }

    public function searchIds($searchWords)
    {
        $ids = [0];
        $query = $this::find()->select(['subject_name','id'])->all();
        foreach ($query as $row)
        {
            $pos = strpos($row['subject_name'],$searchWords);
            if(is_int($pos)){
                $ids[] = $row['id'];
            }
        }
        return $ids;
    }
}
