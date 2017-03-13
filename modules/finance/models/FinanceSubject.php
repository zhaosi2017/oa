<?php

namespace app\modules\finance\models;

//use Yii;
use app\models\CActiveRecord;
use app\modules\user\models\User;

/**
 * This is the model class for table "finance_subject".
 *
 * @property integer $id
 * @property string $subject_name
 * @property integer $superior_subject_id
 * @property integer $enable
 * @property integer $status
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class FinanceSubject extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finance_subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['subject_name', 'superior_subject_id', 'create_author_uid', 'update_author_uid'], 'required'],
            [['subject_name','enable'], 'required'],
            [['enable', 'status', 'create_author_uid', 'update_author_uid','superior_subject_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['subject_name'], 'string', 'max' => 20],
            [['subject_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject_name' => '科目名称',
            'superior_subject_id' => '上级科目',
            'enable' => '可用',
            'status' => 'Status',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return FinanceSubjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FinanceSubjectQuery(get_called_class());
    }

    public function getSuperiorSubject()
    {
        $query = FinanceSubject::find()
            ->select(['subject_name','id'])
            ->where(['status'=>0,'superior_subject_id'=>0]);
        if(!$this->isNewRecord){
            $query->andWhere(['!=','id',$this->id]);
        }
        return [0=>'无']+$query->indexBy('id')->column();
    }

    public function getSuperior()
    {
        return $this->hasOne($this::className(),['id'=>'superior_subject_id'])->alias('superior');
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
