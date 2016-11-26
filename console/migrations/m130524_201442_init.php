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
        
        INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
        (1, 'admin', 'V00NvFEiJKLRBIK6bjYcBW6C5_YyOfMn', '$2y$13\$SVfRN6CT48y4MyV0asF9fe4WRey.XONIf37br/r0pDTqwWxLsE2xW', NULL, 'admin@admin.ru', 10, 1480074237, 1480074237),
        (2, 'editor', '2LKqSKhyVoJXKOlebfLMzgp5lfXw2GVQ', '$2y$13$1yBCt1NoKB8mlvYD.17SQ.WxVFtaCDxwKkCdALWQDXym3uUofXHv2', NULL, 'editor@editor.com', 10, 1480077113, 1480077113),
        (3, 'user', 'wppSYZpjDQQ4plVmbsgEPUl9ahEx8QYv', '$2y$13\$Oe1iU3tx8MGbITkiIiW0Ker9eSQJfGu/sjG38HRuk93k.Ez52OAT6', NULL, 'user@ggg.ru', 10, 1480075034, 1480075034);
        
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
