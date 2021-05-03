<?php

use yii\db\Migration;


class m210503_131541_create_menu_table extends Migration
{
    public function safeUp()
    {
//        $utf8 = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('menu', [
            'id' => $this->primaryKey()->notNull(),
            'menu_id' => $this->integer(11)->defaultValue(null),
            'title' => $this->string(255)->notNull(),
            'status' => $this->integer(11)->notNull()->defaultValue(1),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ]);
    }


    public function safeDown()
    {
        $this->dropTable('menu');
    }
}
