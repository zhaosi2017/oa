<?php

namespace app\modules\user\models;

use app\models\CActiveRecord;
use Yii;
use app\modules\finance\models\Statement;
use app\modules\task\models\TaskCollectionInfo;
use app\modules\task\models\TaskDealPrice;
use app\modules\task\models\TaskExecuteInfo;
use app\modules\task\models\TaskPayInfo;

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

    public function beforeSave($insert)
    {
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;

        if ($this->isNewRecord) {
            $this->create_author_uid = $uid;
            $this->update_author_uid = $uid;
            $this->create_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        }else{
            $this->update_author_uid = $uid;
            $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        }

        $query = $this::findOne(['id'=>$this->sup_id]);
        $this->level = $query ? $query->getAttribute('level') + 1 : 1;
        return true;
    }

    public function getUserIds()
    {
        return $this->hasMany(User::className(),['company_id'=>'id'])->select(['id'])->alias('userIds');
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

    public function getStatistic()
    {
        $statistic = [];

        $collection_query = TaskCollectionInfo::find()->select(['group_concat(task_id) as task_ids','company_id']);

        $pay_query = TaskPayInfo::find()->select(['group_concat(task_id) as task_ids','pay_company_id']);

        $deal_query = TaskDealPrice::find();

        $execute_query = TaskExecuteInfo::find();

        //收
        $company_tasks = $collection_query
            ->where(['status'=>2,'company_id'=>$this->id])
            ->groupBy('company_id')->indexBy('company_id')->column();
        $statistic['collection'] = $deal_query->select(['sum(price) as sum_collection','money_id'])
            ->where(['in','task_id',$company_tasks])->groupBy('money_id')->indexBy('money_id')->column();

        //支
        $company_tasks = $collection_query
            ->where(['status'=>2,'customer_category'=>2,'company_customer_id'=>$this->id])
            ->groupBy('company_id')->indexBy('company_id')->column();
        $statistic['un_collection'] = $deal_query->select(['sum(price) as sum_collection','money_id'])
            ->where(['in','task_id',$company_tasks])->groupBy('money_id')->indexBy('money_id')->column();

        //收
        $company_tasks = $pay_query
            ->where(['status'=>2,'execute_company_id'=>$this->id])
            ->groupBy('pay_company_id')->indexBy('pay_company_id')->column();
        $statistic['un_pay'] = $execute_query->select(['sum(price) as sum_collection','money_id'])
            ->where(['in','task_id',$company_tasks])->groupBy('money_id')->indexBy('money_id')->column();

        //支
        $company_tasks = $pay_query
            ->where(['status'=>2,'pay_company_id'=>$this->id])
            ->groupBy('pay_company_id')->indexBy('pay_company_id')->column();
        $statistic['pay'] = $execute_query->select(['sum(price) as sum_collection','money_id'])
            ->where(['in','task_id',$company_tasks])->groupBy('money_id')->indexBy('money_id')->column();


        $statement_query = Statement::find();
        $statistic['statement'] = $statement_query->select([
            'sum(case when direction=2 then amount end) as gross',
            'sum(case when direction=1 then amount end) as spending','money_id'
        ])->where(['company_id'=>$this->id])->groupBy('money_id')->indexBy('money_id')->asArray()->all();

        return $statistic;
    }
}
