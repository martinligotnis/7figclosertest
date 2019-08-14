<?php

use yii\db\Migration;

/**
 * Class m190807_092241_tests
 */
class m190807_092241_tests extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tests}}', [
            'id'                => $this->primaryKey(),
            'user_id'           => $this->integer()->notNull(),
            'crated_at'         => $this->timestamp(),
            'finished_at'       => $this->timestamp(),
            'question_seqience' => $this->text(),
            'result'            => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-tests-user_id',
            'tests',
            'user_id'
        );

        // add foreign key for table `tests`
        $this->addForeignKey(
            'fk-tests-user_id',
            'tests',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `tests`
        $this->dropForeignKey(
            'fk-tests-user_id',
            'tests'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-tests-user_id',
            'tests'
        );

        $this->dropTable('{{%tests}}');
    }
}
