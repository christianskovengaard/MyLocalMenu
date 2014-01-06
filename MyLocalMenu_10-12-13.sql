# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.33)
# Database: MyLocalMenu
# Generation Time: 2014-01-06 14:39:44 +0000
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
	(3,'Onsdag'),
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
	(1,'Menukort navn HARDCODED','$2y$12$922309682952a9d8e141du/2fyG6gWe76eh5.Yj9vnQEl0en0uWMO',1,'AA0001',1);

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
  `iMenucardCategoryIdHashed` varchar(100) DEFAULT NULL,
  `iFK_iMenucardId` int(11) DEFAULT NULL,
  PRIMARY KEY (`iMenucardCategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `menucardcategory` WRITE;
/*!40000 ALTER TABLE `menucardcategory` DISABLE KEYS */;

INSERT INTO `menucardcategory` (`iMenucardCategoryId`, `sMenucardCategoryName`, `sMenucardCategoryDescription`, `iMenucardCategoryActive`, `iMenucardCategoryIdHashed`, `iFK_iMenucardId`)
VALUES
	(1,'Liste 1','Beskrivelse',1,'52a9d8e2b275a1',1),
	(2,'liste 2h','jhkjhkjh',1,'52a9d8e2b387e2',1),
	(4,'Ny list','beskrivelse',1,'52a9d8e2b59684',1),
	(5,'liste 4','dfg',1,'52aef7e445b2d5',1),
	(6,'hjk','hjkhk',1,'52af04532354f6',1);

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
	(41,'Vi LAVER firmaaftaler og mad til receptioner','Spydstegte franske kyllinger i ægte rotisserie-over, salatbar, sandwich, bagte kartofter, bigger fries, flødekartofler, biggerfries, flødekartofler, ovnbagte kartofler i kyllingefond, aioli, coleslaw, tzatziki, hjemmelavede saucer, marinader, dressinge\" HE',1,1),
	(42,'Take-away røtisserie, her er mere','Vi får leveret friske franske kyllinger. Disse bliver marineret i hjemmelavet lage og langtidsstegte i røstisserie-ovne, hvor hovedparten af fedtet steges væk. Der er altså tale om et produkt, som er lækkert og med saftig smag. Vi er leveringdygtige ti\"\"DE',1,1);

/*!40000 ALTER TABLE `menucardinfo` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table menucarditem
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menucarditem`;

CREATE TABLE `menucarditem` (
  `iMenucardItemId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sMenucardItemName` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `sMenucardItemNumber` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `sMenucardItemDescription` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `iMenucardItemPrice` int(11) DEFAULT NULL,
  `iMenucardItemActive` int(11) DEFAULT '1',
  `iMenucardItemIdHashed` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `iMenucardItemPlaceInList` int(11) DEFAULT NULL,
  `iFK_iMenucardCategoryId` int(11) DEFAULT NULL,
  PRIMARY KEY (`iMenucardItemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

LOCK TABLES `menucarditem` WRITE;
/*!40000 ALTER TABLE `menucarditem` DISABLE KEYS */;

INSERT INTO `menucarditem` (`iMenucardItemId`, `sMenucardItemName`, `sMenucardItemNumber`, `sMenucardItemDescription`, `iMenucardItemPrice`, `iMenucardItemActive`, `iMenucardItemIdHashed`, `iMenucardItemPlaceInList`, `iFK_iMenucardCategoryId`)
VALUES
	(2,'Pizza Meatlover','2','yy',105,1,'52a9d8e2b404b2',1,2),
	(4,'Pizza Hawaii','1','Tomat, ost, ananas, skinke',65,1,'52a9d8e2b61844',1,4),
	(29,'Pizza speciale','3','safsdfsdfsdfnew',123,1,'52aef67439ebb29',1,5),
	(35,'sdfsdf','1','sd',12,1,'52aef7e4467bb35',2,5),
	(38,'w','4','ewe',23,1,'52aeffcb5ab4038',3,1),
	(46,'burger','12','asd',23,1,'52af01bb8d2d446',1,1),
	(47,'we','12','sdfsdfsdfsdf',12,1,'52af0453214a847',2,2),
	(48,'sa','12','sd',12,1,'52af04532d3f648',1,6),
	(49,'ytuy','5','gh',23,1,'52b02f88b67f049',2,1);

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
	(4,1,5,5,10),
	(5,1,3,10,46);

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


# Dump of table test
# ------------------------------------------------------------

DROP TABLE IF EXISTS `test`;

CREATE TABLE `test` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;

INSERT INTO `test` (`id`, `data`)
VALUES
	(1,':data'),
	(2,''),
	(3,''),
	(4,''),
	(5,''),
	(6,''),
	(7,''),
	(8,NULL),
	(9,NULL),
	(10,'123456'),
	(11,NULL),
	(12,'123456'),
	(13,'123123');

/*!40000 ALTER TABLE `test` ENABLE KEYS */;
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
  `sUserCreateToken` varchar(256) COLLATE utf8_danish_ci DEFAULT NULL,
  PRIMARY KEY (`iUserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`iUserId`, `sUsername`, `sUserPassword`, `iUserRole`, `iUserIdHashed`, `iUserActive`, `iFK_iCompanyId`, `sUserCreateToken`)
VALUES
	(1,'admin','$2y$12$539624240529cf1f00395OsHrpz/in8hbqiMVBMYZR4zLFoQD2Q6y',1,'$2y$12$8016158251529cf1f1721uMhHVwzZBEnDpbni1hAu.lC3.5IT665i',1,1,NULL),
	(2,'christianskovengaard@gmail.com','',1,'$2y$12$861349610952b05e12836uJ4oDMWH/KCSJ.D2SQJIDLOrRPHWBdv.',1,NULL,'$2y$12$31436992752b05e11106bO.K0mOgYjmHDfhDnoeZkLPAqBUAbXwfa');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
