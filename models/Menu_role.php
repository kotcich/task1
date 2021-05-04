<?php


namespace app\models;


use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Menu_role extends ActiveRecord
{
    public function formName()
    {
        return '';
    }

    public function attributeLabels()
    {
        return [
            'title' => '',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}