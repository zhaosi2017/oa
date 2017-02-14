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
//                'only' => ['logout','index','create','update','switch','trash','rate'],
                'only' => ['logout'],
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => ['delete'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['entry'],
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function () {
                            return Yii::$app->user->can(Yii::$app->requestedRoute);
                        }
                    ],
                ],
                'denyCallback' => function () { //have two params $rule , $action
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
