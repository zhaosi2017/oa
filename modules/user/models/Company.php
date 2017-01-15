<?php

namespace app\modules\user\models;

use app\models\CActiveRecord;
//use Yii;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sup_id
 * @property integer $status
 * @property integer $level
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class Company extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'sup_id', 'level', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['name'], 'required'],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '公司名称',
            'sup_id' => '上级公司',
            'status' => '状态',
            'level' => '层级',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return CompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyQuery(get_called_class());
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
     * 获取上级
     * @return \yii\db\ActiveQuery
     */
    public function getSuperior()
    {
        return $this->hasOne($this::className(), ['id' => 'sup_id'])->alias('superior');
    }

    public function getChildren($id)
    {
        $self = $this::findOne(['id'=>$id,'status'=>0]);

        $sql = 'select id,sup_id,name from 
                  (select * from '.$this::tableName().' where sup_id>0 order by id desc) realname_sorted, 
                  (select @pv :='.$id.') initialisation 
                  where (find_in_set(sup_id,@pv)>0 and @pv := concat(@pv,",",id))';
        $children = [] + $this::getDb()->createCommand($sql)->queryAll();

        array_unshift($children, $self);

        return $children;
    }
}
