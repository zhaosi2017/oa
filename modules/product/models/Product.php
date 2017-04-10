<?php

namespace app\modules\product\models;

use Yii;
use app\models\CActiveRecord;
use app\modules\system\models\Money;
use app\modules\user\models\Company;
use app\modules\user\models\User;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 * @property integer $first_category_id
 * @property integer $second_category_id
 * @property string $number
 * @property string $description
 * @property integer $enable
 * @property integer $status
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class Product extends CActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'second_category_id', 'number'], 'required'],
            [['first_category_id', 'second_category_id', 'enable', 'status', 'create_author_uid', 'update_author_uid', 'company_id'], 'integer'],
            [['description'], 'string', 'max' => 200],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'number'], 'string', 'max' => 10],
            [['name'], 'uniqueName'],
            [['number'], 'unique'],
        ];
    }

    public function uniqueName($attribute)
    {
        $model = $this::find()->select(['name','id']);
        $list = $model->indexBy('id')->column();
        foreach ($list as $id => $name)
        {
            $dec_value = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
            if($this->isNewRecord){
                if($this->name == $dec_value){
                    $this->addError($attribute, '该名称已被占用。');
                }
            }else{
                if($this->name == $dec_value && $this->id != $id){
                    $this->addError($attribute, '该名称已被占用。');
                }
            }
        }
    }

    /*public function uniqueNumber($attribute)
    {
        $model = $this::find()->select(['number','id']);
        $list = $model->indexBy('id')->column();
        foreach ($list as $id => $name)
        {
            $dec_value = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
            if($this->isNewRecord){
                if($this->number == $dec_value){
                    $this->addError($attribute, '编号已存在。');
                }
            }else{
                if($this->number == $dec_value && $this->id != $id){
                    $this->addError($attribute, '编号已存在。');
                }
            }
        }
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '产品名称',
            'first_category_id' => '产品一级分类',
            'second_category_id' => '产品二级分类',
            'number' => '编号',
            'description' => '产品说明',
            'enable' => '可用',
            'status' => '状态',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->name = Yii::$app->security->decryptByKey(base64_decode($this->name), Yii::$app->params['inputKey']);
        $this->description && $this->description = Yii::$app->security->decryptByKey(base64_decode($this->description), Yii::$app->params['inputKey']);
    }

    public function beforeSave($insert)
    {
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->create_author_uid = $uid;
                $this->update_author_uid = $uid;
                $this->create_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
                $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
                $this->name = base64_encode(Yii::$app->security->encryptByKey($this->name,Yii::$app->params['inputKey']));
                $this->description && $this->description = base64_encode(Yii::$app->security->encryptByKey($this->description,Yii::$app->params['inputKey']));
            }else{
                $this->name = base64_encode(Yii::$app->security->encryptByKey($this->name,Yii::$app->params['inputKey']));
                $this->description && $this->description = base64_encode(Yii::$app->security->encryptByKey($this->description,Yii::$app->params['inputKey']));
                $this->update_author_uid = $uid;
                $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            }
            return true;
        }
        return false;
    }

    /**
     * 获取创建人
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'create_author_uid'])->alias('creator');
    }

    /**
     * 获取最后修改人
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'update_author_uid'])->alias('updater');
    }

    /**
     * 获取公司
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->alias('company');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategory::className(),['id' => 'second_category_id'])->alias('category');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRootCategory()
    {
        return $this->hasOne(RootCategory::className(),['company_id'=>'company_id'])->alias('rootCategory');
    }


    public function getFirstCategory()
    {
        $res = ProductCategory::find()->select(['name','id'])->where(['status'=>0,'superior_id'=>0])->indexBy('id')->column();

        foreach ($res as $id=>$name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
        }
        return $res;
    }

    public function getSecondCategory()
    {
        $model = ProductCategory::find()->select(['name','id'])->where(['status'=>0]);
        !$this->isNewRecord && $model->andWhere(['superior_id'=>$this->first_category_id]);
        if(Yii::$app->request->get('ProductSearch')){
            $search = Yii::$app->request->get('ProductSearch');
            $model->andWhere(['superior_id'=>$search['first_category_id']]);
        }
        $res = $model->indexBy('id')->column();

        foreach ($res as $id=>$name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
        }
        return $res;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchasePrice()
    {
        return $this->hasMany(ProductPurchasePrice::className(),['product_id'=>'id'])->alias('purchasePrice');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMoney()
    {
        $res = Money::find()->select(['name', 'id'])->where(['status' => 0])->indexBy('id')->column();
        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
        }
        return $res;
    }

    public function getGrade(){
        return \Yii::$app->request->get('grade');
    }

}
