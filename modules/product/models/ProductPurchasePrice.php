<?php

namespace app\modules\product\models;

use app\models\CActiveRecord;
use app\modules\system\models\Money;
use app\modules\user\models\User;

/**
 * This is the model class for table "product_purchase_price".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $money_id
 * @property string $a_grade_price
 * @property string $b_grade_price
 * @property string $c_grade_price
 * @property string $d_grade_price
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class ProductPurchasePrice extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_purchase_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id', 'money_id', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['a_grade_price', 'b_grade_price', 'c_grade_price', 'd_grade_price'], 'number'],
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
            'a_grade_price' => 'A Grade Price',
            'b_grade_price' => 'B Grade Price',
            'c_grade_price' => 'C Grade Price',
            'd_grade_price' => 'D Grade Price',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return ProductPurchasePriceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductPurchasePriceQuery(get_called_class());
    }

    public function getMoney()
    {
        return $this->hasOne(Money::className(),['id'=>'money_id'])->alias('money');
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
