<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clients}}`.
 */
class m210317_131404_create_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clients}}', [
            'id' => $this->primaryKey(),
            'last_name' => $this->string(64)->notNull(),
            'first_name' => $this->string(64)->notNull(),
            'patronymic' => $this->string(64),
            'email' => $this->string()->notNull(),
            'phone' => $this->string(20)->notNull(),
            'agreement' => $this->boolean()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clients}}');
    }
}
