<?php

use yii\db\Migration;

/**
 * Class m190807_092152_forwarding_questions
 */
class m190807_092152_forwarding_questions extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%forwarding_questions}}', [
            'id' => $this->primaryKey(),
            'closing_section_id' => $this->integer()->notNull(),
            'question_1' => $this->text(),
            'answer_1' => $this->text(),
            'question_2' => $this->text(),
            'answer_2' => $this->text(),
            'question_3' => $this->text(),
            'answer_3' => $this->text(),
        ], $tableOptions);

        // creates index for column `closing_section_id`
        $this->createIndex(
            'idx-forwarding_questions-closing_section_id',
            'forwarding_questions',
            'closing_section_id'
        );

        // add foreign key for table `closing_sections`
        $this->addForeignKey(
            'fk-forwarding_questions-closing_section_id',
            'forwarding_questions',
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
            'fk-forwarding_questions-closing_section_id',
            'forwarding_questions'
        );

        // drops index for column `closing_section_id`
        $this->dropIndex(
            'idx-forwarding_questions-closing_section_id',
            'forwarding_questions'
        );

        $this->dropTable('{{%forwarding_questions}}');
    }
}
