<?php

namespace app\modules\task\models;

use Yii;
use app\modules\product\models\ProductCategory;
use app\modules\product\models\RootCategory;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\product\models\Product;

/**
 * ProductSearch represents the model behind the search form about `app\modules\product\models\Product`.
 */
class ProductSearch extends Product
{
    public $root_category_id;

    public $grade;

    public $search_keywords;

    public $search_type;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'root_category_id', 'first_category_id', 'second_category_id', 'enable', 'status', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['name', 'number', 'description', 'create_time', 'update_time', 'creator_account', 'updater_account'], 'safe'],
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
        $query = Product::find()->select([])->where([
            'product.status'=>0,
        ]);

        if(Yii::$app->controller->module->id=='task'){
            //todo
            $identity = (Object) Yii::$app->user->identity;
            $query->andWhere(['in','rootCategory.visible',[1,3,5,7,9,11,13,15]]);
            $query->andWhere(['in','category.avisible',[1,3,5,7,9,11,13,15]]);
            $query->orWhere(['category.company_id'=>$identity->company_id]);
        }
        $query
            ->joinWith('company')
            ->joinWith('rootCategory')
            ->joinWith('category')
            ->with('purchasePrice');
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
            'product.id' => $this->id,
            'product.first_category_id' => $this->first_category_id,
            'product.second_category_id' => $this->second_category_id,
            'rootCategory.id' => $this->root_category_id,
            'product.enable' => $this->enable,
        ]);

        $this->search_type == 1 && strlen($this->search_keywords)>0 && $query->andFilterWhere(['in', 'product.id', $this->searchIds($this->search_keywords)])
            ->orFilterWhere(['like', 'product.number', $this->number]);

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

    public function filterCategory()
    {
       $res = ProductCategory::find()->select(['name','id'])->where(['status'=>0,'superior_id'=>0])->indexBy('id')->column();
        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
        }
        return $res;
    }

    public function filterRootCategory()
    {
        $res = RootCategory::find()->select(['name','id'])->where([])->indexBy('id')->column();
        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
        }
        return $res;
    }
}
