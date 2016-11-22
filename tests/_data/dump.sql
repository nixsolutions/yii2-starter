/*
SQLyog Community v11.52 (32 bit)
MySQL - 5.5.50-0ubuntu0.14.04.1 : Database - yii_starter_tests
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`yii_starter_tests` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `yii_starter_tests`;

/*Table structure for table `mail_template` */

DROP TABLE IF EXISTS `mail_template`;

CREATE TABLE `mail_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) DEFAULT NULL,
  `body` text,
  `name` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mail_template` */

LOCK TABLES `mail_template` WRITE;

insert  into `mail_template`(`id`,`key`,`body`,`name`,`updated_at`,`subject`) values (1,'REGISTER','<p>Hello {{user}}</p>\r\n\r\n\r\n\r\n<p>In {{data}}</p>\r\n\r\n\r\n\r\n<p>Visit link {{link}}</p>\r\n\r\n\r\n\r\n<p>Restore password {{password}}</p>\r\n\r\n\r\n\r\n<p>Second password {{password2}}</p>\r\n\r\n\r\n\r\n<p>{{wrong}}</p>\r\n\r\n\r\n\r\n<p>&nbsp;</p>\r\n\r\n','Register','2016-12-22 17:16:52','Test regisret user');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
