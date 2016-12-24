<?php

namespace app\modules\user\models;

//use Yii;
use app\models\CActiveRecord;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $name
 * @property integer $department_id
 * @property string $company_name
 * @property integer $status
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class Posts extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'department_id', 'company_name'], 'required'],
            [['id', 'department_id', 'status', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'company_name'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '岗位名称',
            'department_id' => '所属部门',
            'company_name' => '所属公司',
            'status' => '状态',
            'create_author_uid' => '创建人',
            'update_author_uid' => '最后修改人',
            'create_time' => '创建时间',
            'update_time' => '最后修改时间',
        ];
    }

    /**
     * @inheritdoc
     * @return PostsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostsQuery(get_called_class());
    }
}
