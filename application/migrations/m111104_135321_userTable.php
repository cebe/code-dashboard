<?php

class m111104_135321_userTable extends CDbMigration
{
	public function up()
	{
		$this->createTable('users', array(
			'id' => 'pk',
			'name' => 'varchar(32) NOT NULL',
			'realname' => 'varchar(32) DEFAULT NULL',
			'email' => 'varchar(32) NOT NULL',
		));
		$this->createIndex('users_email', 'users', 'email');
		$this->createTable('users_emails', array(
			'email' => 'varchar(32) PRIMARY KEY NOT NULL',
			'userId' => 'int NOT NULL',
			'CONSTRAINT fk_users_emails_userId FOREIGN KEY (`userId`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE',
		));
		Yii::import('application.models.User');
		$user = new User();
		$user->name = 'cbrandt';
		$user->email = 'cbrandt@meta';
		$user->id = 1;
		$user->save();
	}

	public function down()
	{
		$this->dropTable('users_emails');
		$this->dropTable('users');
	}
}
