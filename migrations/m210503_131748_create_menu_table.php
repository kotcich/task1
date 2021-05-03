<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu}}`.
 */
class m210503_131748_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu}}', [
            'id'            => $this->primaryKey(),
            'menu_id'       => $this->integer(11)->defaultValue(null),
            'title'         => $this->string(255)->notNull(),
            'status'        => $this->integer(11)->defaultValue(1),
            'created_at'    => $this->integer(11)->notNull(),
            'updated_at'    => $this->integer(11)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%menu}}');
    }
}
