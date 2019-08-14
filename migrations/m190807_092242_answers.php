<?php

use yii\db\Migration;

/**
 * Class m190807_092255_answers
 */
class m190807_092242_answers extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%answers}}', [
            'id' => $this->primaryKey(),
            'test_id' => $this->integer()->notNull(),
            'qestion_no' => $this->integer()->notNull(),
            'question_type' => $this->text(),
            'question_id' => $this->text(),
            'next_closing_section_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `test_id`
        $this->createIndex(
            'idx-answers-test_id',
            'answers',
            'test_id'
        );
        // creates index for column `next_closing_section_id`
        $this->createIndex(
            'idx-answers-next_closing_section_id',
            'answers',
            'next_closing_section_id'
        );

        // add foreign key for table `tests`
        $this->addForeignKey(
            'fk-answers-test_id',
            'answers',
            'test_id',
            'tests',
            'id',
            'CASCADE'
        );

        // add foreign key for table `closing_sections`
        $this->addForeignKey(
            'fk-answers-next_closing_section_id',
            'answers',
            'next_closing_section_id',
            'closing_sections',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // drops foreign key for table `tests`
        $this->dropForeignKey(
            'fk-answers-test_id',
            'answers'
        );

        // drops foreign key for table `closing_sections`
        $this->dropForeignKey(
            'fk-answers-next_closing_section_id',
            'answers'
        );

        // drops index for column `test_id`
        $this->dropIndex(
            'idx-answers-test_id',
            'answers'
        );

        // drops index for column `next_closing_section_id`
        $this->dropIndex(
            'idx-answers-next_closing_section_id',
            'answers'
        );

        $this->dropTable('{{%answers}}');
    }
}
