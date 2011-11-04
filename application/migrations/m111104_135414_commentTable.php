<?php

class m111104_135414_commentTable extends CDbMigration
{
	public function up()
	{
		$this->createTable('comments', array(
			'id' => 'pk',
			'message' => 'text',
			'userId' => 'int DEFAULT NULL',
			'CONSTRAINT fk_comments_userId FOREIGN KEY (`userId`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE',
		));
		$this->createTable('comments_commits_map', array(
			'commentId' => 'pk',
			'commitSha' => 'varchar(40) NOT NULL',
			'CONSTRAINT fk_comments_commits_map_commentId FOREIGN KEY (`commentId`) REFERENCES `comments`(`id`) ON DELETE CASCADE ON UPDATE CASCADE',
		));
	}

	public function down()
	{
		$this->dropTable('comments');
		$this->dropTable('comments_commit_map');
	}
}
