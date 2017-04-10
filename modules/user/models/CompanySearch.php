<?php

namespace app\modules\user\models;

//use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//use app\modules\user\models\Company;

/**
 * CompanySearch represents the model behind the search form about `app\modules\user\models\Company`.
 */
class CompanySearch extends Company
{
    public $superior_name;

    public $search_type;

    public $search_keywords;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sup_id', 'status', 'level', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['name', 'create_time', 'update_time', 'superior_name', 'search_type', 'search_keywords'], 'safe'],
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
        $query = Company::find()->select([
            'company.id',
            'company.sup_id',
            'company.status',
            'company.level',
            'company.create_author_uid',
            'company.update_author_uid',
            'company.create_time',
            'company.update_time',
            'company.name',
            // 'superior.id', 若出现覆盖主键
            'superior.name as superior_name',
            'creator.account',
            'updater.account',
        ])->where([
            'company.status'=>\Yii::$app->requestedAction->id == 'index' ? 0 : 1,
        ]);

        $query->joinWith('superior')->joinWith('creator')->joinWith('updater');
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

        $dataProvider->setSort([
            'attributes' => [
                /* 其它字段不要动 */
                /*  下面这段是加入的 */
                /*=============*/
                'superior_name' => [
                    'asc' => ['superior.sup_id' => SORT_ASC],
                    'desc' => ['superior.sup_id' => SORT_DESC],
                    'label' => 'sup_id'
                ],
                /*=============*/
            ]
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
            'sup_id' => $this->sup_id,
            'status' => $this->status,
            'level' => $this->level,
            'create_author_uid' => $this->create_author_uid,
            'update_author_uid' => $this->update_author_uid,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $this->search_type ==1 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'company.id', $this->searchIds($this->search_keywords)]);
        $this->search_type ==2 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'superior.id', $this->searchIds($this->search_keywords)]);
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
