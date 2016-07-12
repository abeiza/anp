/*
SQLyog Community v8.6 RC3
MySQL - 5.1.33-community : Database - utf8db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`utf8db` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `utf8db`;

/*Table structure for table `names` */

DROP TABLE IF EXISTS `names`;

CREATE TABLE `names` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `language` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `names` */

insert  into `names`(`id`,`name`,`language`) values (1,'test','English'),(2,'考验, 试验','Chinese'),(3,'lära sig att nätet','Swedish'),(4,'aprender a la red','Spanish'),(5,'تعلم على الشبكة','Arabic'),(6,'lernen, Gitter','German'),(7,'oppia verkkoon','Finnish'),(8,'apprendre à grille','French'),(9,'ללמוד ברשת','Hebrew'),(10,'lære at nettet','Danish'),(11,'グリッドを学ぶ ','Japanese'),(12,'leren raster','Dutch'),(13,'μάθουν να πλέγμα','Greek'),(14,'ग्रिड के लिए सीखना','Hindi');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
