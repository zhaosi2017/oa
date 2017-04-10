<?php

namespace app\modules\finance\models;

use app\modules\system\models\SerialNumber;
use app\modules\user\models\User;
use Yii;
use app\models\CActiveRecord;
use app\modules\system\models\Money;
use app\modules\task\models\Task;
use app\modules\user\models\Company;

/**
 * This is the model class for table "statement".
 *
 * @property integer $id
 * @property string $statement_no
 * @property integer $company_id
 * @property integer $first_subject_id
 * @property integer $second_subject_id
 * @property integer $type
 * @property integer $associate_id
 * @property integer $status
 * @property integer $direction
 * @property integer $money_id
 * @property string $amount
 * @property string $accounting_date
 * @property string $remark
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class Statement extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_subject_id', 'second_subject_id', 'type', 'associate_id', 'direction', 'money_id', 'amount', 'accounting_date'], 'required'],
            [['company_id', 'first_subject_id', 'second_subject_id', 'type', 'associate_id', 'status', 'direction', 'money_id', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['amount'], 'number'],
            [['accounting_date', 'create_time', 'update_time'], 'safe'],
            [['remark'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'first_subject_id' => '一级科目',
            'second_subject_id' => '二级科目',
            'type' => '流水类型',
            'associate_id' => '关联公司/任务',
            'status' => 'Status',
            'direction' => '记账方向',
            'money_id' => '货币',
            'amount' => '记账金额',
            'accounting_date' => '记账日期',
            'remark' => '备注说明',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return StatementQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatementQuery(get_called_class());
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->remark = Yii::$app->security->decryptByKey(base64_decode($this->remark), Yii::$app->params['inputKey']);
    }

    public function getFirstSubject()
    {
        $query = FinanceSubject::find()
            ->select(['subject_name','id'])
            ->where(['status'=>0,'superior_subject_id'=>0])->indexBy('id')->column();
        foreach ($query as $id => $name){
            $query[$id] = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
        }
        return $query;
    }

    public function getSecondSubject()
    {
        $gets = Yii::$app->request->get('StatementSearch');
        if($this->isNewRecord && !$gets){
            return [];
        }

        !empty($gets) && $this->first_subject_id = $gets['first_subject_id'];

        $query = FinanceSubject::find()
            ->select(['subject_name','id'])
            ->where(['status'=>0, 'superior_subject_id'=>$this->first_subject_id])
            ->indexBy('id')->column();
        foreach ($query as $id => $name){
            $query[$id] = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
        }
        return $query;
    }

    public function getAssociateCompanyTask()
    {
        $res = false;
        if($this->isNewRecord){
            $res = [];
        }
        if($this->type==1){
            $res = Company::find()->select(['name','id'])->where(['status'=>0])->indexBy('id')->column();
        }
        if($this->type==2){
            $identity = (Object) Yii::$app->user->identity;
            $res = Task::find()->select(['name','id'])->where([
                'company_id'=>$identity->company_id
            ])
            ->andWhere(['status'=>6])
            ->orWhere(['status'=>7])
            ->indexBy('id')->column();
        }
        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
        }
        return $res;
    }

    public function getMoney()
    {
        $query = Money::find()->select(['name','id'])->where(['status'=>0])->indexBy('id')->column();
        foreach ($query as $id => $name){
            $query[$id] = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
        }
        return $query;
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

    public function getSecondFinanceSubject()
    {
        return $this->hasOne(FinanceSubject::className(),['id'=>'second_subject_id'])->alias('secondFinanceSubject');
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(),['id'=>'company_id'])->alias('company');
    }

    public function getAssociateCompany()
    {
        return $this->hasOne(Company::className(),['id'=>'associate_id'])->alias('associateCompany');
    }

    public function getTask()
    {
        return $this->hasOne(Task::className(),['id'=>'associate_id'])->alias('task');
    }

    public function beforeSave($insert)
    {
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;
        if (parent::beforeSave($insert)) {
            $time_stamp = $_SERVER['REQUEST_TIME'];
            if ($this->isNewRecord) {
                $model = new SerialNumber();
                $serial = $model->generalSerial('statement');
                $this->create_author_uid = $uid;
                $this->update_author_uid = $uid;
                $this->create_time = date('Y-m-d',$time_stamp);
                $this->update_time = date('Y-m-d',$time_stamp);
                $this->status = 0;
                $this->statement_no= date('ymd', $time_stamp) . $serial; //年月日加随机数加序列号
                $this->remark = base64_encode(Yii::$app->security->encryptByKey($this->remark,Yii::$app->params['inputKey']));
            }else{
                $this->remark = base64_encode(Yii::$app->security->encryptByKey($this->remark,Yii::$app->params['inputKey']));
                $this->update_author_uid = $uid;
                $this->update_time = date('Y-m-d',$time_stamp);
            }
            return true;
        }
        return false;
    }
}
