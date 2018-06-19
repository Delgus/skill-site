<?php

use yii\db\Migration;

class m180531_073929_create_table_test extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%test}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название'),
            'description' => $this->text()->notNull()->comment('Краткое описание'),
            'created_at' => $this->integer()->notNull()->comment('Время создания'),
            'created_by' => $this->integer()->notNull()->comment('Создано'),
            'updated_at' => $this->integer()->notNull()->comment('Последнее изменение'),
            'updated_by' => $this->integer()->notNull()->comment('Изменено'),
            'status' => $this->integer()->notNull()->comment('Статус'),
            'category_id' => $this->integer()->notNull()->comment('Категория'),
        ], $tableOptions);

        $this->createTable('{{%test_answer}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Ответ'),
            'test_question_id' => $this->integer()->notNull()->comment('Тест'),
            'result' => $this->integer()->notNull()->comment('Результат'),
        ], $tableOptions);

        $this->createTable('{{%test_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название'),
            'description' => $this->text()->notNull()->comment('Краткое описание'),
            'created_at' => $this->integer()->notNull()->comment('Время создания'),
            'created_by' => $this->integer()->notNull()->comment('Создано'),
            'updated_at' => $this->integer()->notNull()->comment('Последнее изменение'),
            'updated_by' => $this->integer()->notNull()->comment('Изменено'),
            'status' => $this->integer()->notNull()->comment('Статус'),
        ], $tableOptions);

        $this->createTable('{{%test_question}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название'),
            'description' => $this->text()->notNull()->comment('Тело вопроса'),
            'created_at' => $this->integer()->notNull()->comment('Время создания'),
            'created_by' => $this->integer()->notNull()->comment('Создано'),
            'updated_at' => $this->integer()->notNull()->comment('Последнее изменение'),
            'updated_by' => $this->integer()->notNull()->comment('Изменено'),
            'test_id' => $this->integer()->notNull()->comment('Тест'),
            'type' => $this->integer()->notNull(),
            'points' => $this->integer()->notNull()->comment('баллы'),
        ], $tableOptions);

        $this->createTable('{{%test_result}}', [
            'id' => $this->primaryKey(),
            'test_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'test_result' => $this->integer()->notNull(),
            'answers' => $this->text(),
        ], $tableOptions);

        $this->createIndex('test_id', '{{%test_question}}', 'test_id');
        $this->addForeignKey('test_question_ibfk_1', '{{%test_question}}', 'test_id', '{{%test}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('test_question_id', '{{%test_answer}}', 'test_question_id');
        $this->addForeignKey('test_answer_ibfk_1', '{{%test_answer}}', 'test_question_id', '{{%test_question}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('category_id', '{{%test}}', 'category_id');
        $this->addForeignKey('test_ibfk_1', '{{%test}}', 'category_id', '{{%test_category}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%test_result}}');
        $this->dropTable('{{%test_answer}}');
        $this->dropTable('{{%test_question}}');
        $this->dropTable('{{%test}}');
        $this->dropTable('{{%test_category}}');
    }
}
