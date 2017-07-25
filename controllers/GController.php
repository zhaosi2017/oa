<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class GController extends Controller
{
    public $layout = '@app/views/layouts/global';

    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['logout','index','rate','sent-index','wait-index','received-index','root-set','summary','ip-lock','record'],
                'rules' => [
                    [
                        'actions' => ['delete'],
                        'allow' => false,
                    ],
                    [
                        'allow' => true,
                        'actions' => ['entry','captcha','code','get-push-data'],
                        'roles' => ['?'],
                    ],
                    [
//                        'actions' => ['logout',],
                        'actions' => [
                            'logout','password','deny','sent-detail','wait-detail','received-detail','trash','sent-trash',
                            'execute','execute-received','index-received','switch','create','update','price',
                            'view','create-child','received-feedback','received-handle','receive','customer',
                            'grade','second-category','product-search','product-tree','release','download',
                            'get-second-category','remark','get-second-subject','get-company-task','read','user-read',
                            'received','set','feedback','feedback-trash','pay-receipt-info','remark-trash','superior',
                            'department','auth','posts','permission','user-index'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    //作RBAC权限控制的操作
                    [
                        'actions' => [
                            'index','rate','sent-index','trashed-index','handle-index','finished-index','wait-index','received-index','root-set','summary','ip-lock','record',
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            if(Yii::$app->user->isGuest){
                                return false;
                            }
                            $identity = (Object) Yii::$app->user->identity;
                            if($identity->username=='oaAdmin'){
                                if(Yii::$app->controller->module->id=='user'){
                                    return true;
                                }
                                return false;
                            }
//                            var_dump(Yii::$app->user->can(Yii::$app->requestedRoute)) ; exit;
                            return Yii::$app->user->can(Yii::$app->requestedRoute);
                        }
                    ],
                ],
                'denyCallback' => function () { //have two params $rule , $action
                    if(Yii::$app->user->isGuest){
                        return $this->redirect(Url::to(['/login/default/entry']));
                    }
                    return $this->redirect(Url::to(['/home/main/deny']));
                },
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->layout = '@app/views/layouts/right';
        /*$actionId = Yii::$app->requestedAction->id;
        switch ($actionId){
            case 'add':
                $this->layout = '@app/views/layouts/form';
                break;
            case 'edit':
                $this->layout = '@app/views/layouts/form';
                break;
            case 'create':
                $this->layout = '@app/views/layouts/form';
                break;
            case 'update':
                $this->layout = '@app/views/layouts/form';
                break;
            case 'view':
                $this->layout = '@app/views/layouts/form';
                break;
            case 'index':
                $this->layout = '@app/views/layouts/list';
                break;
            case 'trash':
                $this->layout = '@app/views/layouts/list';
                break;
            default:
                $this->layout = '@app/views/layouts/global';
        }*/
        return parent::beforeAction($action);

    }

    /**
     * @param array $response
     */
    public function ajaxResponse($response = ['code'=>0, 'msg'=>'操作成功', 'data'=>[]])
    {
        header('Content-Type: application/json');
        exit(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

}
