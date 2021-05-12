<?php

namespace app\models;

use DateTime;
use yii\db\ActiveRecord;

class Menu extends ActiveRecord
{
    public function attributeLabels(){
        return [
            'id'            => 'Ключ',
            'title'         => "Меню",
            'menu_id'       => "Родитель",
            'status'        => "Статус",
            'created_at'    => "Создан",
            'updated_at'    => "Изменен"
        ];
    }

    public function rules(){
        return [
            [['title'], 'required'],
            ['title',  'string']
        ];
    }

    public function add($title, $menu_id = null){

        $time = new DateTime();
        $this->menu_id = $menu_id;
        $this->created_at = $time->getTimestamp();
        $this->updated_at = $time->getTimestamp();
        $this->title = $title;
        $this->status = 1;
        if ($this->validate())
           $this->save();
    }

    public function getAll(){
        return($this->find()->all());
    }

    public function getRole($id)
    {
        return($this->find()->where(["id" => $id])->all());
    }

    public function update($runValidation = true, $attributeNames = NULL){

    }

    public function delete(int $id  = null){

    }
    

}