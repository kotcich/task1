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
            ->viaTable('menu_role', ['menu_id' => 'id'], function ($query) {
                $query->andWhere('status=1');
            });
    }

    public function getMenu_role()
    {
        return $this->hasMany(Menu_role::className(), ['menu_id' => 'id'])->where('status=1');
    }
}