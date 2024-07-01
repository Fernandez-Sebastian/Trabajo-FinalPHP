/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.4.32-MariaDB : Database - trabajo_final
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`trabajo_final` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `trabajo_final`;

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `items` */

insert  into `items`(`id`,`name`,`description`,`price`,`category_id`,`created`,`modified`) values (6,'Bench Shirts','The best shirt!',29,1,'2024-06-30 05:58:40','2014-05-31 02:42:21'),(7,'Lenovo Laptop','My business partner.',399,2,'2014-06-01 01:13:45','2014-05-31 02:43:39'),(8,'Samsung Galaxy Tab 10.1','Good tablet.',259,2,'2014-06-01 01:14:13','2014-05-31 02:44:08'),(9,'Spalding Watch','My sports watch.',199,1,'2014-06-01 01:18:36','2014-05-31 02:48:31'),(10,'Sony Smart Watch','The coolest smart watch!',300,2,'2014-06-06 17:10:01','2014-06-05 18:39:51'),(11,'Huawei Y300','For testing purposes.',100,2,'2014-06-06 17:11:04','2014-06-05 18:40:54'),(12,'Abercrombie Lake Arnold Shirt','Perfect as gift!',60,1,'2014-06-06 17:12:21','2014-06-05 18:42:11'),(13,'Abercrombie Allen Brook Shirt','Cool red shirt!',70,1,'2014-06-06 17:12:59','2014-06-05 18:42:49'),(26,'Another product','Awesome product!',555,2,'2014-11-22 19:07:34','2014-11-21 21:37:34'),(28,'Wallet','You can absolutely use this one!',799,6,'2014-12-04 21:12:03','2014-12-03 23:42:03'),(31,'Amanda Waller Shirt','New awesome shirt!',333,1,'2014-12-13 00:52:54','2014-12-12 03:22:54'),(42,'Nike Shoes for Men','Nike Shoes',12999,3,'2015-12-12 06:47:08','2015-12-12 07:17:08'),(48,'Bristol Shoes','Awesome shoes.',999,5,'2016-01-08 06:36:37','2016-01-08 07:06:37'),(60,'Rolex Watch','Luxury watch.',25000,1,'2016-01-11 15:46:02','2016-01-11 16:16:02');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT COMMENT 'clave primaria para usuarios',
  `User` varchar(50) NOT NULL DEFAULT '' COMMENT 'nombre de usuario',
  `Password` varchar(100) NOT NULL DEFAULT '' COMMENT 'contraseña del usuario',
  `Email` varchar(100) NOT NULL COMMENT 'email del usuario',
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`idUser`,`User`,`Password`,`Email`) values (1,'Bob','12DEA96FEC20593566AB75692C9949596833ADC9','bob@gmail.com'),(2,'John','12DEA96FEC20593566AB75692C9949596833ADC9','john@gmail.com'),(3,'Mark','12DEA96FEC20593566AB75692C9949596833ADC9','mark@gmail.com'),(5,'seba','12DEA96FEC20593566AB75692C9949596833ADC9','prueba@gmail.com'),(7,'user','12DEA96FEC20593566AB75692C9949596833ADC9','user@user.com');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
