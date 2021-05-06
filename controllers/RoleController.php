<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Role;
use yii\helpers\Json;

class RoleController extends Controller
{

    public function beforeAction($action)
    {
        
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionGet($id)
    {
        $model = new Role;
        var_dump($id);
        // var_dump($model->get());
        return json_encode([
            [
            "testObject" => "WTF",
            "AnotherObject" => [
                "key1" => "test1",
                "key2"  => "test2"]],
            ["testObject" => "WTF",
            "AnotherObject" => [
                    "key1" => "test1",
                    "key2"  => "test2"]]
        ]);
    }

    public function actionGetall()
    {
        $model = new Role;
        $data = $model->getAll();
        return JSON::encode($data);
    }

    public function actionAdd()
    {
        $model = new Role;
        $request = Yii::$app->request;
        if ($request->post()['TestForm'])
            $model->add($request->post()['TestForm']['title']);
        return ("IT'S ADD ROLE");
    }

    
    public function actionUpdate()
    {
        return ("IT'S UPDATE ROLE");
    }

    
    public function actionDelete()
    {
        return ("IT'S DELETE ROLE");
    }

}
