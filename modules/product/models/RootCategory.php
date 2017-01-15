<?php

namespace app\modules\product\models;

//use Yii;
use app\models\CActiveRecord;

/**
 * This is the model class for table "root_category".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $visible
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class RootCategory extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'root_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['create_author_uid', 'update_author_uid', 'visible', 'company_id'], 'integer'],
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
            'company_id' => '所属公司',
            'name' => '根分类名称设置',
            'visible' => '可见',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return RootCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RootCategoryQuery(get_called_class());
    }
}
