<?php

namespace app\models;

use Yii;
use yii\base\Model;

class TestForm extends Model
{
    public $title;

    public function rules()
    {
        return [
            [['title'],'required'],
        ];
    }

}

?>