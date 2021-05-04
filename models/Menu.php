<?php


namespace app\models;


use yii\db\ActiveRecord;
use app\models\Role;
use yii\behaviors\TimestampBehavior;

class Menu extends ActiveRecord
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
//          [['created_at', 'updated_at', 'status', 'id', 'menu_id'], 'safe'],
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

    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['id' => 'role_id'])
            ->viaTable('menu_role', ['menu_id' => 'id']);
    }
}