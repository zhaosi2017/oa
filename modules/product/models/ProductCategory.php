<?php

namespace app\modules\product\models;

//use Yii;
use app\modules\user\models\Company;
use app\modules\user\models\User;
use app\models\CActiveRecord;

/**
 * This is the model class for table "product_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $superior_id
 * @property integer $company_id
 * @property integer $avisible
 * @property integer $status
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class ProductCategory extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['superior_id', 'name'], 'required'],
            [['superior_id', 'company_id', 'avisible', 'status', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名称',
            'superior_id' => '上级分类',
            'company_id' => 'Company ID',
            'avisible' => '可见',
            'status' => '状态',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return ProductCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductCategoryQuery(get_called_class());
    }

    /**
     * 获取创建人
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'create_author_uid']);
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
     * 获取上级
     * @return \yii\db\ActiveQuery
     */
    public function getSuperior()
    {
        return $this->hasOne($this::className(), ['id' => 'superior_id'])->alias('superior');
    }

}
