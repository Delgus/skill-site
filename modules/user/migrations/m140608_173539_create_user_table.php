<?php

use yii\db\Migration;

class m140608_173539_create_user_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $tablename = \Yii::$app->getModule('user')->user_table;

        // Create user table
        $this->createTable($tablename, array(
            'id' => 'pk',
            'username' => 'string not null',
            'auth_key' => 'varchar(32) not null',
            'password_hash' => 'string not null',
            'confirmation_token' => 'string',
            'status' => 'int not null default 1',
            'superadmin' => 'smallint default 0',
            'created_at' => 'int not null',
            'updated_at' => 'int not null',
        ), $tableOptions);


        $this->createTable('auth', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);

        $this->addForeignKey('fk-auth-user_id-user-id', 'auth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }


    public function safeDown()
    {
        $this->dropTable('auth');
        $this->dropTable(Yii::$app->getModule('user')->user_table);
    }
}
