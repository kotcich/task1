<?php

use yii\db\Migration;


class m210503_132613_create_role_table extends Migration
{
    public function safeUp()
    {
        $utf8 = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('role', [
            'id' => $this->primaryKey()->notNull(),
            'title' => $this->string(255)->notNull(),
            'status' => $this->integer(11)->notNull()->defaultValue(1),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $utf8);
    }

    public function safeDown()
    {
        $this->dropTable('role');
    }
}
