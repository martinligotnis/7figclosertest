<?php

use yii\db\Migration;

/**
 * Class m190807_092225_objections
 */
class m190807_092225_objections extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%objections}}', [
            'id' => $this->primaryKey(),
            'closing_section_id' => $this->integer()->notNull(),
            'is_objection' => $this->boolean()->notNull(),
            'objection' => $this->text(),
            'handle' => $this->text(),
            'next_closing_section_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `closing_section_id`
        $this->createIndex(
            'idx-objections-closing_section_id',
            'objections',
            'closing_section_id'
        );

        // add foreign key for table `closing_sections`
        $this->addForeignKey(
            'fk-objections-closing_section_id',
            'objections',
            'closing_section_id',
            'closing_sections',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // drops foreign key for table `closing_sections`
        $this->dropForeignKey(
            'fk-objections-closing_section_id',
            'objections'
        );

        // drops index for column `closing_section_id`
        $this->dropIndex(
            'idx-objections-closing_section_id',
            'objections'
        );

        $this->dropTable('{{%objections}}');
    }
}
