<?php

use yii\db\Migration;

/**
 * Class m190807_092130_opening_statements
 */
class m190807_092130_opening_statements extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%opening_statements}}', [
            'id' => $this->primaryKey(),
            'statement' => $this->text(),
            'interest_level' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%opening_statements}}');
    }
}
