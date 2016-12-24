<?php

namespace app\modules\user\models;

use Yii;
use yii\db\Query;
use app\models\CActiveRecord;
/**
 * This is the model class for table "company".
 *
 * @property string $name
 * @property string $superior_company_name
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
            [['name', 'superior_company_name'], 'required'],
            [['status', 'level', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'superior_company_name'], 'string', 'max' => 40],
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
     * @获取状态为正常公司列表
     *
     */
    public function getCompanyList()
    {
        return (new Query())->from($this::tableName())->where(['status'=>0])->all();
    }

    public function nameExists($name)
    {
        $sql = 'SELECT `name`,level FROM'.' ' . $this::tableName() .' WHERE `name`= :name';
        $res = $this::getDb()->createCommand($sql)->bindValue(':name',$name)->queryOne();
        return $res;
    }

    public function oneCompany($condition)
    {
        return (new Query())->from($this::tableName())->where($condition)->one();
    }

    public function listHandle()
    {
        $posts = Yii::$app->request->post();
        if($posts){
            $query = new Query();
            $where = [
                'and',
                ['status' => $posts['type']==1 ? 0 : 1],
                ['like',$posts['name'],isset($posts['search']) ? $posts['search'] : ''],
            ];


            /*$where = ['like',$posts['name'],isset($posts['search']) ? $posts['search'] : ''];
            if($posts['type']==1){
                $where['status'] = 0;
            }else{
                $where['status'] = 1;
            }*/
            $total = $query->select('name')->from($this::tableName())->where($where)->count();

            $data = $query->select([])
                ->from($this::tableName())
                ->where($where)
                ->limit($posts['limit'])
                ->offset($posts['offset'])
                ->orderBy(['create_time'=>$posts['order']])
                ->all();
            $this->ajaxResponse([
                'code'  => 0,
                'msg'   => 'list',
                'data'  => $data,
                'total' => $total
            ]);
        }
        return;
    }

    /**
     * @param  int $level prent-level
     * @return array
     */
    public function filterCompanyList($level){
        return (new Query())->from($this::tableName())->where(['status'=>0,'level'=>$level])->all();
    }

    public function editHandle()
    {
        $posts = Yii::$app->request->post();
        if($posts['primary_key']!=$posts['name']){
            //判断公司名是否存在
            $isExists = $this->nameExists($posts['name']);

            if($isExists){
                $this->ajaxResponse([
                    'code'    => 1,
                    'msg'     => '公司名称已存在，请勿重复添加！',
                    'data'    => $isExists
                ]);
            }
        }

        $params = [
            'name'     => $posts['name'],
            'superior_company_name' => $posts['superior_company_name'],
            'level'    => ++$posts['level']
            //            ':cuid'     => $posts['create_author_uid'],TODO 超级管理员先添加公司，UID为默认值
            //            ':uuid'     => $posts['update_author_uid'],
        ];
        if($this::getDb()->createCommand('')->update($this::tableName(),$params,['name'=>$posts['primary_key']])->execute()){
            $this->ajaxResponse([
                'code'    => 0,
                'msg'     => '公司编辑成功',
                'data'    => $this->filterCompanyList($posts['level'])
            ]);
        }else{
            $this->ajaxResponse([
                'code'    => 1,
                'msg'     => '操作失败',
                'data'    => []
            ]);
        }
        return;
    }

    public function addHandle()
    {
        $posts = Yii::$app->request->post();
        //判断公司名是否存在
        $isExists = $this->nameExists($posts['name']);

        if($isExists){
            $this->ajaxResponse([
                'code'    => 1,
                'msg'     => '公司名称已存在，请勿重复添加！',
                'data'    => $isExists
            ]);
        }

        $params = [
            'name'     => $posts['name'],
            'superior_company_name' => $posts['superior_company_name'],
            'level'    => ++$posts['level']
        //            ':cuid'     => $posts['create_author_uid'],TODO 超级管理员先添加公司，UID为默认值
        //            ':uuid'     => $posts['update_author_uid'],
        ];
        if($this::getDb()->createCommand('')->insert($this::tableName(),$params)->execute()){
            $this->ajaxResponse([
                'code'    => 0,
                'msg'     => '公司添加成功',
                'data'    => $this->getCompanyList()
            ]);
        }
        return;
    }
}
