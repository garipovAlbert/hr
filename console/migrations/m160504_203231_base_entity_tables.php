<?php

use yii\db\Migration;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class m160504_203231_base_entity_tables extends Migration
{

    public function up()
    {
        /* Entity tables */
        $this->execute("
            CREATE TABLE IF NOT EXISTS {{%account}} (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `role` char(31) NOT NULL,
                `status` enum('ACTIVE','BLOCKED') NOT NULL DEFAULT 'ACTIVE',
                `authKey` char(32) NOT NULL,
                `login` varchar(255) NOT NULL,
                `passwordHash` varchar(255) NOT NULL,
                `email` varchar(255) DEFAULT NULL,
                `firstName` varchar(32) NOT NULL,
                `lastName` varchar(32) NOT NULL,
                `position` varchar(255) DEFAULT NULL,
                `createdBy` int(10) unsigned DEFAULT NULL,
                `updatedBy` int(10) unsigned DEFAULT NULL,
                `createdAt` int(10) unsigned NOT NULL,
                `updatedAt` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->execute("
            CREATE TABLE IF NOT EXISTS {{%city}} (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `isActive` tinyint(1) NOT NULL,
                `createdBy` int(10) unsigned DEFAULT NULL,
                `updatedBy` int(10) unsigned DEFAULT NULL,
                `createdAt` int(10) unsigned NOT NULL,
                `updatedAt` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->execute("
            CREATE TABLE IF NOT EXISTS {{%metro}} (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `cityId` int(10) unsigned DEFAULT NULL,
                `name` varchar(255) NOT NULL,
                `createdBy` int(10) unsigned DEFAULT NULL,
                `updatedBy` int(10) unsigned DEFAULT NULL,
                `createdAt` int(10) unsigned NOT NULL,
                `updatedAt` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`),
                KEY `metro_fk1` (`cityId`),
                CONSTRAINT `metro_fk1` FOREIGN KEY (`cityId`) 
                    REFERENCES {{%city}} (`id`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->execute("
            CREATE TABLE IF NOT EXISTS {{%cinema}} (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `cityId` int(10) unsigned DEFAULT NULL,
                `name` varchar(255) NOT NULL,
                `createdBy` int(10) unsigned DEFAULT NULL,
                `updatedBy` int(10) unsigned DEFAULT NULL,
                `createdAt` int(10) unsigned NOT NULL,
                `updatedAt` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`),
                KEY `cinema_fk1` (`cityId`),
                CONSTRAINT `cinema_fk1` FOREIGN KEY (`cityId`) 
                    REFERENCES {{%city}} (`id`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->execute("
            CREATE TABLE IF NOT EXISTS {{%citizenship}} (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `createdBy` int(10) unsigned DEFAULT NULL,
                `updatedBy` int(10) unsigned DEFAULT NULL,
                `createdAt` int(10) unsigned NOT NULL,
                `updatedAt` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->execute("
            CREATE TABLE IF NOT EXISTS {{%vacancy}} (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `description` text,
                `createdBy` int(10) unsigned DEFAULT NULL,
                `updatedBy` int(10) unsigned DEFAULT NULL,
                `createdAt` int(10) unsigned NOT NULL,
                `updatedAt` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->execute("
            CREATE TABLE IF NOT EXISTS {{%applicant}} (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `citizenshipId` int(10) unsigned DEFAULT NULL,
                `vacancyId` int(10) unsigned NOT NULL,
                `cinemaId` int(10) unsigned NOT NULL,
                `status` enum('NEW','HIRED','INVITED','DECLINED','UNCONFIRMED','CALL') NOT NULL DEFAULT 'NEW',
                `firstName` varchar(255) NOT NULL,
                `lastName` varchar(255) NOT NULL,
                `age` int(10) unsigned NOT NULL,
                `phone` int(10) unsigned NOT NULL,
                `email` varchar(255) NOT NULL,
                `info` text,
                `updatedBy` int(10) unsigned DEFAULT NULL,
                `createdAt` int(10) unsigned NOT NULL,
                `updatedAt` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`),
                KEY `applicant_fk1` (`citizenshipId`),
                KEY `applicant_fk2` (`vacancyId`),
                KEY `applicant_fk3` (`cinemaId`),
                CONSTRAINT `applicant_fk1` FOREIGN KEY (`citizenshipId`) 
                    REFERENCES {{%citizenship}} (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                CONSTRAINT `applicant_fk2` FOREIGN KEY (`vacancyId`) 
                    REFERENCES {{%vacancy}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `applicant_fk3` FOREIGN KEY (`cinemaId`) 
                    REFERENCES {{%cinema}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        /* /Entity tables */


        /* Link tables */
        $this->execute("
            CREATE TABLE IF NOT EXISTS {{%cinema_metro_link}} (
                `cinemaId` int(10) unsigned NOT NULL,
                `metroId` int(10) unsigned NOT NULL,
                PRIMARY KEY (`cinemaId`,`metroId`),
                KEY `cinema_metro_link_fk2` (`metroId`),
                CONSTRAINT `cinema_metro_link_fk2` FOREIGN KEY (`metroId`) 
                    REFERENCES {{%metro}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `cinema_metro_link_fk1` FOREIGN KEY (`cinemaId`) 
                    REFERENCES {{%cinema}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->execute("
            CREATE TABLE IF NOT EXISTS {{%vacancy_cinema_link}} (
                `vacancyId` int(10) unsigned NOT NULL,
                `cinemaId` int(10) unsigned NOT NULL,
                PRIMARY KEY (`vacancyId`,`cinemaId`),
                KEY `vacancy_cinema_link_fk2` (`cinemaId`),
                CONSTRAINT `vacancy_cinema_link_fk2` FOREIGN KEY (`cinemaId`) 
                    REFERENCES {{%cinema}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `vacancy_cinema_link_fk1` FOREIGN KEY (`vacancyId`) 
                    REFERENCES {{%vacancy}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->execute("
            CREATE TABLE IF NOT EXISTS {{%account_cinema_link}} (
                `accountId` int(10) unsigned NOT NULL,
                `cinemaId` int(10) unsigned NOT NULL,
                PRIMARY KEY (`accountId`,`cinemaId`),
                KEY `account_cinema_link_fk2` (`cinemaId`),
                CONSTRAINT `account_cinema_link_fk2` FOREIGN KEY (`cinemaId`) 
                    REFERENCES {{%cinema}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `account_cinema_link_fk1` FOREIGN KEY (`accountId`) 
                    REFERENCES {{%account}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        /* /Link tables */
    }

    public function down()
    {
        $this->execute('DROP TABLE IF EXISTS {{%account_cinema_link}}');
        $this->execute('DROP TABLE IF EXISTS {{%vacancy_cinema_link}}');
        $this->execute('DROP TABLE IF EXISTS {{%cinema_metro_link}}');
        $this->execute('DROP TABLE IF EXISTS {{%applicant}}');
        $this->execute('DROP TABLE IF EXISTS {{%vacancy}}');
        $this->execute('DROP TABLE IF EXISTS {{%citizenship}}');
        $this->execute('DROP TABLE IF EXISTS {{%cinema}}');
        $this->execute('DROP TABLE IF EXISTS {{%metro}}');
        $this->execute('DROP TABLE IF EXISTS {{%city}}');
        $this->execute('DROP TABLE IF EXISTS {{%account}}');
    }

}