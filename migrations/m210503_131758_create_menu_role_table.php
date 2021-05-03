<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu_role}}`.
 */
class m210503_131758_create_menu_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu_role}}', [
            'id'            => $this->primaryKey(),
            'menu_id'       => $this->integer(11)->notNull(),
            'role_id'       => $this->integer(11)->notNull(),
            'status'        => $this->integer(11)->notNull(),
            'created_at'    => $this->integer(11)->notNull(),
            'updated_at'    => $this->integer(11)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%menu_role}}');
    }
}
