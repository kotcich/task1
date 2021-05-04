<?php


namespace app\models;


use yii\db\ActiveRecord;
use app\models\Menu;
use yii\behaviors\TimestampBehavior;

class Role extends ActiveRecord
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

    public function rules()
    {
        return [
            ['title', 'required', 'message' => 'Обязательно к заполнению'],
            ['title', 'trim'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['id' => 'menu_id'])
            ->viaTable('menu_role', ['role_id' => 'id']);
    }
}