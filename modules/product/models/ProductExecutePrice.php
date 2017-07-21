<?php

namespace app\modules\product\models;

use app\modules\user\models\Company;
use app\models\CActiveRecord;
use app\modules\user\models\User;

/**
 * This is the model class for table "product_execute_price".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $company_id
 * @property integer $money_id
 * @property string $price
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class ProductExecutePrice extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_execute_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id', 'company_id', 'money_id', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['price'], 'number'],
            [['create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'company_id' => 'Company ID',
            'money_id' => 'Money ID',
            'price' => 'Price',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return ProductExecutePriceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductExecutePriceQuery(get_called_class());
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(),['id' => 'company_id'])->alias('company');
    }

    public function getUser()
    {
        return $this->hasMany(User::className(),['company_id' => 'company_id'])->select(['id','account','company_id'])->alias('user');
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

}
