<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Role;
use yii\helpers\Json;

class RoleController extends Controller
{

    public function actionGet($id)
    {
        if ($id)
        {
            $model = new Role;
            $data = $model->getRole($id);
            return JSON::encode($data);
        }
        return (null);
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
