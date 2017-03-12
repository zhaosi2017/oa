<?php

namespace app\modules\system\models;

use app\modules\task\models\TaskExecuteInfo;
use Yii;
use app\models\CActiveRecord;
use app\modules\finance\models\Statement;
use app\modules\task\models\TaskCollectionInfo;
use app\modules\task\models\TaskDealPrice;
use app\modules\task\models\TaskPayInfo;
use app\modules\user\models\User;

/**
 * This is the model class for table "money".
 *
 * @property integer $id
 * @property string $name
 * @property integer $enable
 * @property integer $status
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class Money extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'money';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['id', 'enable', 'status', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '货币名称',
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
     * @return MoneyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MoneyQuery(get_called_class());
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

    //总收入
    public function getGross()
    {
        $identity = (Object) Yii::$app->user->identity;
        $gross = [];
        //收款单
        $query = TaskCollectionInfo::find()->select(['task_id','id'])->where(['status'=>2]);
        $query->andWhere(['company_id'=>$identity->company_id]);

        //付款单
        $query_pay = TaskPayInfo::find()->select(['task_id','id'])->where(['status'=>2]);
        $query_pay->andWhere(['execute_company_id'=>$identity->company_id]);

        //流水的收入
        $query_state = Statement::find()->where(['status'=>0,'direction'=>2])->andWhere(['money_id'=>$this->id]);
        $query_state->andWhere(['company_id'=>$identity->company_id]);

        $gets = Yii::$app->request->get('MoneySearch');
        if(!empty($gets) && $gets['start_date']){
            $query->andWhere(['between','update_time',$gets['start_date'],$gets['end_date']]);
            $query_state->andWhere(['between','update_time',$gets['start_date'],$gets['end_date']]);
            $query_pay->andWhere(['between','update_time',$gets['start_date'],$gets['end_date']]);
        }

        $task_ids = $query->indexBy('id')->column();
        $gross[] = TaskDealPrice::find()
            ->select(['price'])
            ->where(['in','task_id',$task_ids])
            ->andWhere(['money_id'=>$this->id])->sum('price');

        $pay_task_ids = $query_pay->indexBy('id')->column();
        $gross[] = TaskExecuteInfo::find()
            ->select(['price'])
            ->where(['in','task_id',$pay_task_ids])
            ->andWhere(['money_id'=>$this->id])->sum('price');

        $gross[] = $query_state->sum('amount');

        $res = array_sum($gross)>0 ? array_sum($gross) : '0.00';
        return $res;
    }

    //总支出
    public function getSpending()
    {
        $identity = (Object) Yii::$app->user->identity;
        $spending = [];
        //收款单
        $query = TaskCollectionInfo::find()->select(['task_id','id'])->where(['status'=>2]);
        $query->andWhere(['customer_category'=>2,'company_customer_id'=>$identity->company_id]);

        //付款单
        $query_pay = TaskPayInfo::find()->select(['task_id','id'])->where(['status'=>2]);
        $query_pay->andWhere(['pay_company_id'=>$identity->company_id]);

        //流水
        $query_state = Statement::find()->where(['status'=>0,'direction'=>1])->andWhere(['money_id'=>$this->id]);
        $query_state->andWhere(['company_id'=>$identity->company_id]);

        $gets = Yii::$app->request->get('MoneySearch');
        if(!empty($gets) && $gets['start_date']){
            $query->andWhere(['between','update_time',$gets['start_date'],$gets['end_date']]);
            $query_state->andWhere(['between','update_time',$gets['start_date'],$gets['end_date']]);
            $query_pay->andWhere(['between','update_time',$gets['start_date'],$gets['end_date']]);
        }

        //收款成交价格
        $task_ids = $query->indexBy('id')->column();
        $spending[] = TaskDealPrice::find()
            ->select(['price'])
            ->where(['in','task_id',$task_ids])
            ->andWhere(['money_id'=>$this->id])->sum('price');

        //付款执行价格
        $pay_task_ids = $query_pay->indexBy('id')->column();
        $spending[] = TaskExecuteInfo::find()
            ->select(['price'])
            ->where(['in','task_id',$pay_task_ids])
            ->andWhere(['money_id'=>$this->id])->sum('price');

        //流水的支出
        $spending[] = $query_state->sum('amount');

        $res = array_sum($spending) ? array_sum($spending) : '0.00';
        return $res;
    }

}
