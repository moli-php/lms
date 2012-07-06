/*
SQLyog Community v9.51 
MySQL - 5.5.17-log : Database - bldph107
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bldph107` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `bldph107`;

/*Table structure for table `faqbarry_category` */

DROP TABLE IF EXISTS `faqbarry_category`;

CREATE TABLE `faqbarry_category` (
  `pg_idx` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `dscription` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`pg_idx`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `faqbarry_category` */

insert  into `faqbarry_category`(`pg_idx`,`name`,`dscription`,`status`) values (1,'Our Services','Queries regarding what services we offer and how we maintain them.','published'),(2,'Our Products','Questions regarding our products and information about warranty policies and order placements.','published'),(3,'Account Management','Concerns about managing a user\'s account.','published'),(4,'Recruit','Information about company benefits and job opportunities.','published');

/*Table structure for table `faqbarry_question` */

DROP TABLE IF EXISTS `faqbarry_question`;

CREATE TABLE `faqbarry_question` (
  `pg_idx` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` int(10) unsigned NOT NULL,
  `question` varchar(100) NOT NULL,
  `answer` text NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `date` int(10) unsigned NOT NULL,
  `last_updated` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`pg_idx`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `faqbarry_question` */

insert  into `faqbarry_question`(`pg_idx`,`category`,`question`,`answer`,`status`,`date`,`last_updated`) values (19,2,'Can I change or cancel an order I\'ve already placed?','Yes. For any cancellation or change in orders, please call 408.123.4567 for immediate requests to be done over the phone. Alternatively, you can send an email to info@globalbizinc.com. ','unpublished',1328165953,1328168386),(20,2,'Can I change or cancel an order I\'ve already placed?','Yes. For any cancellation or change in orders, please call 408.123.4567 for immediate requests to be done over the phone. Alternatively, you can send an email to info@globalbizinc.com. ','Published',1328166006,1328171675),(21,2,'Can I change or cancel an order I\'ve already placed?','Yes. For any cancellation or change in orders, please call 408.123.4567 for immediate requests to be done over the phone. Alternatively, you can send an email to info@globalbizinc.com. ','unpublished',1328166040,1328175616),(22,1,'Really','Yes. For any cancellation or change in orders, please call 408.123.4567 for immediate requests to be done over the phone. Alternatively, you can send an email to info@globalbizinc.com. ','Unpublished',1328166067,1328254577),(23,3,'How do I update my account information?','Log in using your username and password to globalbizinc.com and go to the right side of the screen.\r\n\r\nClick on My Profile and edit all the necessary information.\r\n\r\n','published',1328175657,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
