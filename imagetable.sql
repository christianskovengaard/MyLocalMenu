
CREATE TABLE IF NOT EXISTS `images` (
  `iImageId` int(11) NOT NULL AUTO_INCREMENT,
  `iFK_iRestuarentInfoId` int(11) DEFAULT NULL,
  `sImageName` varchar(45) DEFAULT NULL,
  `sImageDate` date DEFAULT NULL,
  PRIMARY KEY (`iImageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=118 ;
