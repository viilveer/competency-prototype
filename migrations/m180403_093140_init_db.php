<?php

use yii\db\Migration;

/**
 * Class m180403_093140_init_db
 */
class m180403_093140_init_db extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            SET NAMES utf8;
            SET time_zone = '+00:00';
            SET foreign_key_checks = 0;
            SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
        ");

        $this->execute("
            DROP TABLE IF EXISTS `company`;
            CREATE TABLE `company` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");

        $this->execute("
            DROP TABLE IF EXISTS `employee`;
            CREATE TABLE `employee` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `age` int(10) unsigned NOT NULL,
              `gender` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
              `company_id` int(10) unsigned NOT NULL,
              PRIMARY KEY (`id`),
              KEY `company_id` (`company_id`),
              CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");

        $this->execute("
            DROP TABLE IF EXISTS `employee_role`;
            CREATE TABLE `employee_role` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `employee_id` int(10) unsigned NOT NULL,
              `role_id` int(10) unsigned NOT NULL,
              PRIMARY KEY (`id`),
              KEY `employee_id` (`employee_id`),
              KEY `role_id` (`role_id`),
              CONSTRAINT `employee_role_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`),
              CONSTRAINT `employee_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");

        $this->execute("
            DROP TABLE IF EXISTS `employee_skill`;
            CREATE TABLE `employee_skill` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `employee_id` int(10) unsigned NOT NULL,
              `skill_id` int(11) NOT NULL,
              `level` int(10) unsigned NOT NULL,
              PRIMARY KEY (`id`),
              KEY `employee_id` (`employee_id`),
              KEY `skill_id` (`skill_id`),
              CONSTRAINT `employee_skill_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`),
              CONSTRAINT `employee_skill_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");

        $this->execute("
            DROP TABLE IF EXISTS `role`;
            CREATE TABLE `role` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `description` text COLLATE utf8_unicode_ci NOT NULL,
              `company_id` int(10) unsigned NOT NULL,
              PRIMARY KEY (`id`),
              KEY `company_id` (`company_id`),
              CONSTRAINT `role_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");

        $this->execute("
            DROP TABLE IF EXISTS `skill`;
            CREATE TABLE `skill` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `company_id` int(10) unsigned NOT NULL,
              `parent_skill_id` int(11) DEFAULT NULL,
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `description` text COLLATE utf8_unicode_ci NOT NULL,
              PRIMARY KEY (`id`),
              KEY `company_id` (`company_id`),
              KEY `skill_id` (`parent_skill_id`),
              CONSTRAINT `skill_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
              CONSTRAINT `skill_ibfk_2` FOREIGN KEY (`parent_skill_id`) REFERENCES `skill` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180403_093140_init_db cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180403_093140_init_db cannot be reverted.\n";

        return false;
    }
    */
}
