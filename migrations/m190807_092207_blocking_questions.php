<?php

use yii\db\Migration;

/**
 * Class m190807_092207_blocking_questions
 */
class m190807_092207_blocking_questions extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%blocking_questions}}', [
            'id' => $this->primaryKey(),
            'closing_section_id' => $this->integer()->notNull(),
            'question_1' => $this->text(),
            'answer_1' => $this->text(),
            'question_2' => $this->text(),
            'answer_2' => $this->text(),
        ], $tableOptions);

        // creates index for column `closing_section_id`
        $this->createIndex(
            'idx-blocking_questions-closing_section_id',
            'blocking_questions',
            'closing_section_id'
        );

        // add foreign key for table `closing_sections`
        $this->addForeignKey(
            'fk-blocking_questions-closing_section_id',
            'blocking_questions',
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
            'fk-blocking_questions-closing_section_id',
            'blocking_questions'
        );

        // drops index for column `closing_section_id`
        $this->dropIndex(
            'idx-blocking_questions-closing_section_id',
            'blocking_questions'
        );

        $this->dropTable('{{%blocking_questions}}');
    }
}