<?php

namespace app\modules\task\models;

use app\modules\customer\models\Customer;
use app\modules\product\models\Product;
use app\modules\product\models\ProductExecutePrice;
use app\modules\product\models\ProductPurchasePrice;
use app\modules\system\models\Money;
use app\modules\system\models\SerialNumber;
use app\modules\user\models\Company;
use app\modules\user\models\User;
use Yii;
use app\models\CActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property string $number
 * @property string $name
 * @property integer $company_id
 * @property integer $execute_company_id
 * @property integer $company_customer_id
 * @property integer $execute_type
 * @property integer $fee_settlement
 * @property integer $customer_category
 * @property integer $customer_grate
 * @property integer $product_id
 * @property string $requirement
 * @property string $attachment
 * @property integer $status
 * @property integer $superior_task_id
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property integer $create_time
 * @property integer $update_time
 */
class Task extends CActiveRecord
{

    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'product_id','customer_category', 'company_customer_id', 'customer_grate', 'requirement'], 'required'],
            [['company_id','execute_company_id', 'company_customer_id','execute_type', 'fee_settlement', 'customer_category', 'customer_grate', 'product_id', 'status', 'superior_task_id', 'create_author_uid', 'update_author_uid', 'create_time', 'update_time'], 'integer'],
            [['requirement'], 'string', 'max' => 500],
            [['name'], 'string', 'max' => 20],
            [['execute_type', 'fee_settlement'], 'default', 'value' => 0],
            [['attachment','number'], 'string', 'max' => 64],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'zip, rar, 7z', 'maxSize'=>1024*1024*10, 'tooBig'=>'文件上传过大！大小不能超过10M',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '任务名称',
            'number' => '项目编号',
            'company_id' => '所属公司',
            'execute_company_id' => '执行公司',
            'execute_type' => '执行方式',
            'fee_settlement' => '费用结算',
            'customer_category' => '客户类别',
            'customer_grate' => '客户级别',
            'company_customer_id' => '集团公司/外部客户名称',
            'product_id' => '产品',
            'requirement' => '任务要求',
            'attachment' => '附件',
            'status' => '状态',
            'superior_task_id' => 'Superior Task ID',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'file' => '附件',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->name = Yii::$app->security->decryptByKey(base64_decode($this->name), Yii::$app->params['inputKey']);
        $this->requirement = Yii::$app->security->decryptByKey(base64_decode($this->requirement), Yii::$app->params['inputKey']);
    }

    public function getStatuses()
    {
        return [
            0 => '正常',
            1 => '已作废',
            2 => '待发布',
            3 => '待接收',
            4 => '处理中',
            5 => '待验收',
            6 => '结算中',
            7 => '已完成',
            8 => '任务撤销',
            9 => '无法执行',
            10 => '待处理',
        ];
    }

    public function beforeSave($insert)
    {
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $time_stamp = $_SERVER['REQUEST_TIME'];
                $model = new SerialNumber();
                $serial = $model->generalSerial('task');
                $this->create_author_uid = $uid;
                $this->update_author_uid = $uid;
                $this->create_time = $time_stamp;
                $this->update_time = $time_stamp;
                $this->status = 2;
                $this->number = date('ymd', $time_stamp) . $serial; //年月日加随机数加序列号
                $this->name = base64_encode(Yii::$app->security->encryptByKey($this->name,Yii::$app->params['inputKey']));
                $this->requirement = base64_encode(Yii::$app->security->encryptByKey($this->requirement,Yii::$app->params['inputKey']));
            }else{
                $this->name = base64_encode(Yii::$app->security->encryptByKey($this->name,Yii::$app->params['inputKey']));
                $this->requirement = base64_encode(Yii::$app->security->encryptByKey($this->requirement,Yii::$app->params['inputKey']));
                $this->update_author_uid = $uid;
                $this->update_time = $_SERVER['REQUEST_TIME'];
            }
            return true;
        }
        return false;
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
     * 获取所在公司
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->alias('company');
    }

    public function getExecuteCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'execute_company_id'])->alias('executeCompany');
    }

    /**
     * 获取集团客户
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_customer_id'])->alias('group');
    }

    /**
     * 获取外部客户
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'company_customer_id'])->alias('customer');
    }

    /**
     * 获取上级
     * @return \yii\db\ActiveQuery
     */
    public function getSuperior()
    {
        return $this->hasOne($this::className(), ['id' => 'superior_task_id'])->alias('superior');
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id'])->alias('product');
    }

    public function getDeal()
    {
        return $this->hasMany(TaskDealPrice::className(), ['task_id' => 'id'])->alias('deal');
    }

    public function getPurchase()
    {
        return $this->hasMany(ProductPurchasePrice::className(), ['product_id' => 'product_id'])->alias('purchase');
    }

    public function getExecute()
    {
        $identity = (Object) Yii::$app->user->identity;
        return $this->hasOne(ProductExecutePrice::className(), ['product_id' => 'product_id'])
            ->where(['company_id'=>$identity->company_id])->alias('execute');
    }

    public function getProductExecuteUser()
    {
        $productExecuteCompany = ProductExecutePrice::find()
            ->select(['company_id'])
            ->where(['product_id'=>$this->product_id])
            ->column();
        $user = User::find()->select(['id'])->where(['status'=>0])
            ->andWhere(['in','company_id',$productExecuteCompany])->asArray()->all();
        return $user;
    }

    public function whereExecuteProductIds($company_id)
    {
        $executeProductIds = ProductExecutePrice::find()->distinct('product_id')->select('product_id')
            ->where(['company_id'=>$company_id])->column();
        return $executeProductIds;
    }

    public function getMoney()
    {
        $res = Money::find()->select(['name', 'id'])->where(['status' => 0])->indexBy('id')->column();
        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
        }
        return $res;
    }

    public function getExecuteInfo()
    {
        return $this->hasOne(TaskExecuteInfo::className(),['task_id'=>'id']);
    }

    public function getChildren()
    {
        //        $self = $this::findOne(['id'=>$id,'status'=>0]);

        $id = $this->id;
        /*$sql = 'select id,superior_task_id,name,number,requirement,company_id,status,update_author_uid,update_time from
                  (select * from '.$this::tableName().' where superior_task_id>0 order by id desc) real_name_sorted, 
                  (select @pv :='.$id.') initialisation 
                  where (find_in_set(superior_task_id,@pv)>0 and @pv := concat(@pv,",",id))';

        $sql = 'select 
                s.number as sup_number,u.account as u_account,
                company.name as company_name,c.id,c.superior_task_id,c.name,c.number,c.requirement,c.company_id,c.status,c.update_time 
                from ('. $sql . ') c 
                left join task s on c.superior_task_id=s.id 
                left join user u on c.update_author_uid=u.id 
                left join company on c.company_id=company.id';
        $children = $this::getDb()->createCommand($sql)->queryAll();*/

        $real_name_sorted = $this::find()->where(['>','superior_task_id',0])->orderBy(['id'=>SORT_DESC]);

        $subQuery = $this::find()->select(['id','superior_task_id','name','number','requirement','company_id','status','update_author_uid','update_time'])
                ->from(['real_name_sorted'=>$real_name_sorted,'initialisation'=>'(select @pv :='.$id.')'])
                ->where(['>','find_in_set(superior_task_id,@pv)',0])
                ->andWhere('@pv :=concat(@pv,",",id)');
        $children = (new Query())->from(['c'=>$subQuery])->select([
            's.number as sup_number','u.account as u_account','company.name as company_name',
            'c.id','c.superior_task_id','c.name','c.number','c.requirement','c.company_id','c.status','c.update_time'])
        ->leftJoin(['s'=>$this::tableName()],'c.superior_task_id=s.id')
        ->leftJoin(['u'=>User::tableName()],'c.update_author_uid=u.id')
        ->leftJoin(Company::tableName(),'c.company_id=company.id')->all();



        //        array_unshift($children, $self);

        foreach ($children as $i => $data){
            $children[$i]['name'] = Yii::$app->security->decryptByKey(base64_decode($data['name']),Yii::$app->params['inputKey']);
            $children[$i]['requirement'] = Yii::$app->security->decryptByKey(base64_decode($data['requirement']),Yii::$app->params['inputKey']);
            $children[$i]['u_account'] = Yii::$app->security->decryptByKey(base64_decode($data['u_account']),Yii::$app->params['inputKey']);
            $children[$i]['company_name'] = Yii::$app->security->decryptByKey(base64_decode($data['company_name']),Yii::$app->params['inputKey']);
        }
        return $children;
    }

}
