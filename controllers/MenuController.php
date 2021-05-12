<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Menu;
use yii\helpers\Json;

class MenuController extends Controller
{

    public function actionGetall()
    {
        $model = new Menu;
        $data = $model->getAll();
        return JSON::encode($data);
    }
    
    public function actionGet($id)
    {
        return ("GET MENUES for Role");
    }

    public function actionAdd()
    {
        return ("ADD MENU");
    }

    public function actionUpdate()
    {
        return ("UPDATE MENU");
    }

    public function actionDelete()
    {
        return ("DELETE MENU");
    }
}
