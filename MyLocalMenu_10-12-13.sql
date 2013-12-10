# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.33)
# Database: MyLocalMenu
# Generation Time: 2013-12-10 11:43:05 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table company
# ------------------------------------------------------------

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `iCompanyId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sCompanyName` varchar(256) DEFAULT NULL,
  `sCompanyPhone` varchar(256) DEFAULT NULL,
  `sCompanyAddress` varchar(256) DEFAULT NULL,
  `sCompanyCVR` varchar(256) DEFAULT NULL,
  `iCompanyActive` int(11) DEFAULT NULL,
  PRIMARY KEY (`iCompanyId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;

INSERT INTO `company` (`iCompanyId`, `sCompanyName`, `sCompanyPhone`, `sCompanyAddress`, `sCompanyCVR`, `iCompanyActive`)
VALUES
	(1,'Pizza ApS','12345678','Testvej 123','56473648',1);

/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table day
# ------------------------------------------------------------

DROP TABLE IF EXISTS `day`;

CREATE TABLE `day` (
  `iDayId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sDayName` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`iDayId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `day` WRITE;
/*!40000 ALTER TABLE `day` DISABLE KEYS */;

INSERT INTO `day` (`iDayId`, `sDayName`)
VALUES
	(1,'Mandag'),
	(2,'Tirsdag'),
	(3,'Onsday'),
	(4,'Torsdag'),
	(5,'Fredag'),
	(6,'Lørdag'),
	(7,'Søndag');

/*!40000 ALTER TABLE `day` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table login_attempts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `iFK_iUserId` int(11) NOT NULL,
  `time` varchar(30) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;

INSERT INTO `login_attempts` (`iFK_iUserId`, `time`)
VALUES
	(1,'1386246383'),
	(1,'1386246400'),
	(1,'1386246406'),
	(1,'1386246412'),
	(1,'1386246419'),
	(1,'1386246428');

/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table menucard
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menucard`;

CREATE TABLE `menucard` (
  `iMenucardId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sMenucardName` varchar(256) DEFAULT NULL,
  `iMenucardIdHashed` text,
  `iMenucardActive` int(11) DEFAULT '1',
  `iMenucardSerialNumber` varchar(256) DEFAULT NULL,
  `iFK_iRestuarentInfoId` int(11) DEFAULT NULL COMMENT 'THis is used to show wich company has wich menucards',
  PRIMARY KEY (`iMenucardId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `menucard` WRITE;
/*!40000 ALTER TABLE `menucard` DISABLE KEYS */;

INSERT INTO `menucard` (`iMenucardId`, `sMenucardName`, `iMenucardIdHashed`, `iMenucardActive`, `iMenucardSerialNumber`, `iFK_iRestuarentInfoId`)
VALUES
	(1,'Menukort navn HARDCODED','$2y$12$9310397815528e17234eeuCpTkBF3tSkwm9cSm83Td0uSsCiDsVPy',1,'AA0001',1);

/*!40000 ALTER TABLE `menucard` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table menucardcategory
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menucardcategory`;

CREATE TABLE `menucardcategory` (
  `iMenucardCategoryId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sMenucardCategoryName` varchar(256) DEFAULT NULL,
  `sMenucardCategoryDescription` varchar(256) DEFAULT NULL,
  `iMenucardCategoryActive` int(11) DEFAULT '1',
  `iFK_iMenucardId` int(11) DEFAULT NULL,
  PRIMARY KEY (`iMenucardCategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `menucardcategory` WRITE;
/*!40000 ALTER TABLE `menucardcategory` DISABLE KEYS */;

INSERT INTO `menucardcategory` (`iMenucardCategoryId`, `sMenucardCategoryName`, `sMenucardCategoryDescription`, `iMenucardCategoryActive`, `iFK_iMenucardId`)
VALUES
	(1,'Liste 1','Beskrivelse',1,1),
	(2,'liste 2h','jhkjhkjh',1,1),
	(3,'er','sdsdsdsd',1,1);

/*!40000 ALTER TABLE `menucardcategory` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table menucardinfo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menucardinfo`;

CREATE TABLE `menucardinfo` (
  `iMenucardInfoId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sMenucardInfoHeadline` varchar(256) DEFAULT NULL,
  `sMenucardInfoParagraph` varchar(256) DEFAULT NULL,
  `iFK_iMenucardId` int(11) DEFAULT NULL,
  `iMenucardInfoActive` int(11) DEFAULT '1',
  PRIMARY KEY (`iMenucardInfoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `menucardinfo` WRITE;
/*!40000 ALTER TABLE `menucardinfo` DISABLE KEYS */;

INSERT INTO `menucardinfo` (`iMenucardInfoId`, `sMenucardInfoHeadline`, `sMenucardInfoParagraph`, `iFK_iMenucardId`, `iMenucardInfoActive`)
VALUES
	(1,'Vi laver firmaaftaler og mad til receptioner','Spydstegte franske kyllinger i ægte rotisserie-over, salatbar, sandwich, bagte kartofter, bigger fries, flødekartofler, biggerfries, flødekartofler, ovnbagte kartofler i kyllingefond, aioli, coleslaw, tzatziki, hjemmelavede saucer, marinader, dressinger',1,1),
	(2,'Take-away røtisserie','Vi får leveret friske franske kyllinger. Disse bliver marineret i hjemmelavet lage og langtidsstegte i røstisserie-ovne, hvor hovedparten af fedtet steges væk. Der er altså tale om et produkt, som er lækkert og med saftig smag. Vi er leveringdygtige til en',1,1);

/*!40000 ALTER TABLE `menucardinfo` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table menucarditem
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menucarditem`;

CREATE TABLE `menucarditem` (
  `iMenucardItemId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sMenucardItemName` varchar(256) DEFAULT NULL,
  `sMenucardItemNumber` varchar(256) DEFAULT NULL,
  `sMenucardItemDescription` varchar(256) DEFAULT NULL,
  `iMenucardItemPrice` int(11) DEFAULT NULL,
  `iMenucardItemActive` int(11) DEFAULT '1',
  `iFK_iMenucardCategoryId` int(11) DEFAULT NULL,
  PRIMARY KEY (`iMenucardItemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `menucarditem` WRITE;
/*!40000 ALTER TABLE `menucarditem` DISABLE KEYS */;

INSERT INTO `menucarditem` (`iMenucardItemId`, `sMenucardItemName`, `sMenucardItemNumber`, `sMenucardItemDescription`, `iMenucardItemPrice`, `iMenucardItemActive`, `iFK_iMenucardCategoryId`)
VALUES
	(1,'Pizza Hawaii','1','Tomat, ost, ananas &amp; skinke',65,1,1),
	(2,'Pizza Meatlover','2','Tomat, ost, peproni, bacon, pølse, ris, tun, gryderet, smør &amp; skinke',105,1,1),
	(3,'sdasd','12','sdsd',12,1,2),
	(4,'dfsfsdf','232','dsfsfd',4,1,3);

/*!40000 ALTER TABLE `menucarditem` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table openinghours
# ------------------------------------------------------------

DROP TABLE IF EXISTS `openinghours`;

CREATE TABLE `openinghours` (
  `iOpeningHoursId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iFK_iMenucardId` int(11) DEFAULT NULL,
  `iFK_iDayId` int(11) DEFAULT NULL,
  `iFK_iTimeFromId` int(11) DEFAULT NULL,
  `iFK_iTimeToId` int(11) DEFAULT NULL,
  PRIMARY KEY (`iOpeningHoursId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `openinghours` WRITE;
/*!40000 ALTER TABLE `openinghours` DISABLE KEYS */;

INSERT INTO `openinghours` (`iOpeningHoursId`, `iFK_iMenucardId`, `iFK_iDayId`, `iFK_iTimeFromId`, `iFK_iTimeToId`)
VALUES
	(1,1,1,25,46),
	(2,1,2,20,48),
	(3,1,4,10,14),
	(4,1,5,5,10);

/*!40000 ALTER TABLE `openinghours` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table restuarentinfo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `restuarentinfo`;

CREATE TABLE `restuarentinfo` (
  `iRestuarentInfoId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sRestuarentInfoName` varchar(256) DEFAULT NULL,
  `sRestuarentInfoPhone` varchar(256) DEFAULT NULL,
  `sRestuarentInfoAddress` varchar(256) DEFAULT NULL,
  `iFK_iCompanyInfoId` int(11) DEFAULT NULL,
  `iRestuarentInfoActive` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`iRestuarentInfoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `restuarentinfo` WRITE;
/*!40000 ALTER TABLE `restuarentinfo` DISABLE KEYS */;

INSERT INTO `restuarentinfo` (`iRestuarentInfoId`, `sRestuarentInfoName`, `sRestuarentInfoPhone`, `sRestuarentInfoAddress`, `iFK_iCompanyInfoId`, `iRestuarentInfoActive`)
VALUES
	(1,'Ali Pizza','12345678','Testvej 123',1,1),
	(2,'A Burger joint','87654321','Nyvej 321',2,1),
	(3,'Alle veje pizza','12121212','Gheudfo 23',3,1),
	(4,'A est','6736253','Gdsudf 4',4,1);

/*!40000 ALTER TABLE `restuarentinfo` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table takeaway
# ------------------------------------------------------------

DROP TABLE IF EXISTS `takeaway`;

CREATE TABLE `takeaway` (
  `iTakeAwayId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iFK_iMenucardId` int(11) DEFAULT NULL,
  `iFK_iDayId` int(11) DEFAULT NULL,
  `iFK_iTimeFromId` int(11) DEFAULT NULL,
  `iFK_iTimeToId` int(11) DEFAULT NULL,
  PRIMARY KEY (`iTakeAwayId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `takeaway` WRITE;
/*!40000 ALTER TABLE `takeaway` DISABLE KEYS */;

INSERT INTO `takeaway` (`iTakeAwayId`, `iFK_iMenucardId`, `iFK_iDayId`, `iFK_iTimeFromId`, `iFK_iTimeToId`)
VALUES
	(1,1,1,25,46),
	(2,1,2,30,48),
	(3,1,4,10,14),
	(4,1,5,10,16),
	(5,1,3,10,16);

/*!40000 ALTER TABLE `takeaway` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table time
# ------------------------------------------------------------

DROP TABLE IF EXISTS `time`;

CREATE TABLE `time` (
  `iTimeId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iTime` time DEFAULT NULL,
  PRIMARY KEY (`iTimeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `time` WRITE;
/*!40000 ALTER TABLE `time` DISABLE KEYS */;

INSERT INTO `time` (`iTimeId`, `iTime`)
VALUES
	(1,'00:00:00'),
	(2,'00:30:00'),
	(3,'01:00:00'),
	(4,'01:30:00'),
	(5,'02:00:00'),
	(6,'02:30:00'),
	(7,'03:00:00'),
	(8,'03:30:00'),
	(9,'04:00:00'),
	(10,'04:30:00'),
	(11,'05:00:00'),
	(12,'05:30:00'),
	(13,'06:00:00'),
	(14,'06:30:00'),
	(15,'07:00:00'),
	(16,'07:30:00'),
	(17,'08:00:00'),
	(18,'08:30:00'),
	(19,'09:00:00'),
	(20,'09:30:00'),
	(21,'10:00:00'),
	(22,'10:30:00'),
	(23,'11:00:00'),
	(24,'11:30:00'),
	(25,'12:00:00'),
	(26,'12:30:00'),
	(27,'13:00:00'),
	(28,'13:30:00'),
	(29,'14:00:00'),
	(30,'14:30:00'),
	(31,'15:00:00'),
	(32,'15:30:00'),
	(33,'16:00:00'),
	(34,'16:30:00'),
	(35,'17:00:00'),
	(36,'17:30:00'),
	(37,'18:00:00'),
	(38,'18:30:00'),
	(39,'19:00:00'),
	(40,'19:30:00'),
	(41,'20:00:00'),
	(42,'20:30:00'),
	(43,'21:00:00'),
	(44,'21:30:00'),
	(45,'22:00:00'),
	(46,'22:30:00'),
	(47,'23:00:00'),
	(48,'23:30:00'),
	(49,'24:00:00');

/*!40000 ALTER TABLE `time` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `iUserId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sUsername` varchar(256) COLLATE utf8_danish_ci NOT NULL DEFAULT '',
  `sUserPassword` varchar(256) COLLATE utf8_danish_ci NOT NULL DEFAULT '',
  `iUserRole` int(11) NOT NULL,
  `iUserIdHashed` varchar(256) COLLATE utf8_danish_ci DEFAULT NULL,
  `iUserActive` int(11) DEFAULT '1',
  `iFK_iCompanyId` int(11) DEFAULT NULL,
  PRIMARY KEY (`iUserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`iUserId`, `sUsername`, `sUserPassword`, `iUserRole`, `iUserIdHashed`, `iUserActive`, `iFK_iCompanyId`)
VALUES
	(1,'admin','$2y$12$539624240529cf1f00395OsHrpz/in8hbqiMVBMYZR4zLFoQD2Q6y',1,'$2y$12$8016158251529cf1f1721uMhHVwzZBEnDpbni1hAu.lC3.5IT665i',1,NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
