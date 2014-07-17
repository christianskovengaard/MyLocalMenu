SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `company` (
  `iCompanyId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sCompanyName` varchar(256) DEFAULT NULL,
  `sCompanyPhone` varchar(256) DEFAULT NULL,
  `sCompanyAddress` varchar(256) DEFAULT NULL,
  `sCompanyZipcode` varchar(256) DEFAULT NULL,
  `sCompanyCVR` varchar(256) DEFAULT NULL,
  `iCompanyActive` int(11) DEFAULT '1',
  PRIMARY KEY (`iCompanyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

CREATE TABLE IF NOT EXISTS `day` (
  `iDayId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sDayName` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`iDayId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

CREATE TABLE IF NOT EXISTS `gallery` (
  `iGalleryId` int(11) NOT NULL AUTO_INCREMENT,
  `iFK_iResturentInfoId` int(11) NOT NULL,
  `sGalleryImage` varchar(255) DEFAULT NULL,
  `iGalleryImagePlaceInList` int(11) DEFAULT NULL,
  PRIMARY KEY (`iGalleryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

CREATE TABLE IF NOT EXISTS `images` (
  `iImageId` int(11) NOT NULL AUTO_INCREMENT,
  `iFK_iRestuarentInfoId` int(11) DEFAULT NULL,
  `sImageName` varchar(45) DEFAULT NULL,
  `sImageDate` date DEFAULT NULL,
  PRIMARY KEY (`iImageId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `iFK_iUserId` int(11) NOT NULL,
  `time` varchar(30) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `menucard` (
  `iMenucardId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sMenucardName` varchar(256) DEFAULT NULL,
  `iMenucardIdHashed` text,
  `iMenucardActive` int(11) DEFAULT '1',
  `iMenucardSerialNumber` varchar(256) DEFAULT NULL,
  `iFK_iRestuarentInfoId` int(11) DEFAULT NULL COMMENT 'THis is used to show wich company has wich menucards',
  PRIMARY KEY (`iMenucardId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

CREATE TABLE IF NOT EXISTS `menucardcategory` (
  `iMenucardCategoryId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sMenucardCategoryName` varchar(256) DEFAULT NULL,
  `sMenucardCategoryDescription` varchar(256) DEFAULT NULL,
  `iMenucardCategoryActive` int(11) DEFAULT '1',
  `iMenucardCategoryIdHashed` varchar(100) DEFAULT NULL,
  `iFK_iMenucardId` int(11) DEFAULT NULL,
  PRIMARY KEY (`iMenucardCategoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8077 ;

CREATE TABLE IF NOT EXISTS `menucardinfo` (
  `iMenucardInfoId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sMenucardInfoHeadline` varchar(256) DEFAULT NULL,
  `sMenucardInfoParagraph` text CHARACTER SET utf8 COLLATE utf8_danish_ci,
  `iFK_iMenucardId` int(11) DEFAULT NULL,
  `iMenucardInfoActive` int(11) DEFAULT '1',
  PRIMARY KEY (`iMenucardInfoId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2465 ;

CREATE TABLE IF NOT EXISTS `menucarditem` (
  `iMenucardItemId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sMenucardItemName` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `sMenucardItemNumber` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `sMenucardItemDescription` text COLLATE utf8_danish_ci,
  `iMenucardItemPrice` varchar(256) COLLATE utf8_danish_ci DEFAULT NULL,
  `iMenucardItemActive` int(11) DEFAULT '1',
  `iMenucardItemIdHashed` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `iMenucardItemPlaceInList` int(11) DEFAULT NULL,
  `iFK_iMenucardCategoryId` int(11) DEFAULT NULL,
  PRIMARY KEY (`iMenucardItemId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=48059 ;

CREATE TABLE IF NOT EXISTS `messages` (
  `iMessageId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sMessageHeadline` varchar(256) CHARACTER SET utf8 COLLATE utf8_danish_ci DEFAULT NULL,
  `sMessageBodyText` text CHARACTER SET utf8 COLLATE utf8_danish_ci,
  `dtMessageDate` datetime DEFAULT NULL,
  `dMessageDateStart` date DEFAULT NULL,
  `dMessageDateEnd` date DEFAULT NULL,
  `sMessageImage` varchar(255) NOT NULL,
  `iFK_iRestuarentInfoId` int(11) DEFAULT NULL,
  PRIMARY KEY (`iMessageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

CREATE TABLE IF NOT EXISTS `openinghours` (
  `iOpeningHoursId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iFK_iMenucardId` int(11) DEFAULT NULL,
  `iFK_iDayId` int(11) DEFAULT NULL,
  `iFK_iTimeFromId` int(11) DEFAULT NULL,
  `iFK_iTimeToId` int(11) DEFAULT NULL,
  `iClosed` int(11) DEFAULT '0' COMMENT '1 = closed, 0 = open',
  PRIMARY KEY (`iOpeningHoursId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=421 ;

CREATE TABLE IF NOT EXISTS `restuarentinfo` (
  `iRestuarentInfoId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sRestuarentInfoName` varchar(256) DEFAULT NULL,
  `sRestuarentInfoSlogan` varchar(256) DEFAULT NULL,
  `sRestuarentInfoPhone` varchar(256) DEFAULT NULL,
  `sRestuarentInfoAddress` varchar(256) DEFAULT NULL,
  `iRestuarentInfoZipcode` int(11) DEFAULT NULL,
  `sRestuarentInfoQRcode` varchar(256) DEFAULT NULL,
  `sRestuarentInfoQrcodeData` varchar(256) DEFAULT NULL,
  `iFK_iCompanyInfoId` int(11) DEFAULT NULL,
  `iRestuarentInfoActive` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`iRestuarentInfoId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

CREATE TABLE IF NOT EXISTS `restuarentname_search` (
  `iRestuarentInfoId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sRestuarentInfoName` varchar(256) DEFAULT NULL,
  `sRestuarentInfoSlogan` varchar(256) DEFAULT NULL,
  `sRestuarentInfoPhone` varchar(256) DEFAULT NULL,
  `sRestuarentInfoAddress` varchar(256) DEFAULT NULL,
  `iRestuarentInfoZipcode` int(11) DEFAULT NULL,
  `sRestuarentInfoQRcode` varchar(256) DEFAULT NULL,
  `sRestuarentInfoQrcodeData` varchar(256) DEFAULT NULL,
  `iFK_iCompanyInfoId` int(11) DEFAULT NULL,
  `iRestuarentInfoActive` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`iRestuarentInfoId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=773 ;

CREATE TABLE IF NOT EXISTS `serialnumbers` (
  `iSerialnumberId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sSerialNumber` varchar(256) DEFAULT '',
  `iFK_iRestuarentInfoId` int(11) DEFAULT NULL,
  `iSerialnumberActive` int(11) DEFAULT '1',
  PRIMARY KEY (`iSerialnumberId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10001 ;

CREATE TABLE IF NOT EXISTS `stamp` (
  `iStampId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dtStampDateTime` datetime DEFAULT NULL,
  `sCustomerId` varchar(256) COLLATE utf8_danish_ci DEFAULT NULL COMMENT 'Id(from smartphone) for the user scanning the QRcode',
  `iStampUsed` int(11) DEFAULT '0' COMMENT '1 = stamp is used, 0 = stamp is not used',
  `iFK_iStampcardId` bigint(20) NOT NULL,
  `iFK_iMenucardSerialNumber` varchar(256) COLLATE utf8_danish_ci DEFAULT NULL,
  PRIMARY KEY (`iStampId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=18 ;

CREATE TABLE IF NOT EXISTS `stampcard` (
  `iStampcardId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iStampcardMaxStamps` int(11) unsigned DEFAULT NULL COMMENT 'Number of stamp placeholders on stampcard',
  `iStampcardNumberOfGivenStamps` bigint(20) unsigned DEFAULT '0' COMMENT 'Number of all stamps given',
  `iStampcardRedemeCode` int(11) DEFAULT NULL,
  `sStampcardText` varchar(256) COLLATE utf8_danish_ci DEFAULT NULL,
  `iFK_iRestuarentInfoId` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`iStampcardId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=63 ;

CREATE TABLE IF NOT EXISTS `takeaway` (
  `iTakeAwayId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iFK_iMenucardId` int(11) DEFAULT NULL,
  `iFK_iDayId` int(11) DEFAULT NULL,
  `iFK_iTimeFromId` int(11) DEFAULT NULL,
  `iFK_iTimeToId` int(11) DEFAULT NULL,
  PRIMARY KEY (`iTakeAwayId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `time` (
  `iTimeId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iTime` time DEFAULT NULL,
  PRIMARY KEY (`iTimeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

CREATE TABLE IF NOT EXISTS `users` (
  `iUserId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sUsername` varchar(256) COLLATE utf8_danish_ci NOT NULL DEFAULT '',
  `sUserPassword` varchar(256) COLLATE utf8_danish_ci NOT NULL DEFAULT '',
  `iUserRole` int(11) NOT NULL,
  `iUserIdHashed` varchar(256) COLLATE utf8_danish_ci DEFAULT NULL,
  `iUserActive` int(11) DEFAULT '1',
  `iFK_iCompanyId` int(11) DEFAULT NULL,
  `sUserCreateToken` varchar(256) COLLATE utf8_danish_ci DEFAULT NULL,
  PRIMARY KEY (`iUserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=73 ;

CREATE TABLE IF NOT EXISTS `zipcodecity` (
  `iZipcodecity` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iZipcode` varchar(256) COLLATE utf8_danish_ci DEFAULT NULL,
  `sCityname` varchar(256) COLLATE utf8_danish_ci DEFAULT NULL,
  PRIMARY KEY (`iZipcodecity`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=1447 ;
