<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->execute("
        CREATE TABLE `posts` (
        `id` int(10) NOT NULL  AUTO_INCREMENT,
        `title` varchar(200) NOT NULL,
        `text` TEXT NOT NULL,
        `cat_id` int(10) NOT NULL,
        PRIMARY KEY (`id`)
        );
        
        CREATE TABLE `categories` (
            `id` int(10) NOT NULL  AUTO_INCREMENT,
            `name` varchar(200) NOT NULL,
            PRIMARY KEY (`id`)
        );
        
        CREATE TABLE `tags` (
            `id` int NOT NULL  AUTO_INCREMENT,
            `name` varchar(200) NOT NULL,
            PRIMARY KEY (`id`)
        );
        
        CREATE TABLE `post_tag` (
            `post_id` int NOT NULL,
            `tag_id` int NOT NULL
        );
        
        ALTER TABLE `posts` ADD CONSTRAINT `posts_fk0` FOREIGN KEY (`cat_id`) REFERENCES `categories`(`id`);
        
        ALTER TABLE `post_tag` ADD CONSTRAINT `post_tag_fk0` FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`);
        
        ALTER TABLE `post_tag` ADD CONSTRAINT `post_tag_fk1` FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`);
        ");
    }




    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%posts}}');
        $this->dropTable('{{%tags}}');
        $this->dropTable('{{%post_tag}}');
        $this->dropTable('{{%categories}}');
    }
}
