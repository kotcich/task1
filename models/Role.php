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

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['id' => 'menu_id'])
            ->viaTable('menu_role', ['role_id' => 'id'], function ($query) {
                $query->andWhere('status=1');
            });
    }

    public function getMenu_role()
    {
        return $this->hasMany(Menu_role::className(), ['role_id' => 'id'])->where('status=1');
    }
}