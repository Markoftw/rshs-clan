CREATE TABLE IF NOT EXISTS `memberlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `realName` varchar(100) NOT NULL,
  `rsn` varchar(12) NOT NULL,
  `color` varchar(100) NOT NULL,
  `combat` double(5,2) NOT NULL,
  `overall` int(4) NOT NULL,
  `attack` int(2) NOT NULL,
  `strength` int(2) NOT NULL,
  `defence` int(2) NOT NULL,
  `ranged` int(2) NOT NULL,
  `hp` int(2) NOT NULL,
  `magic` int(2) NOT NULL,
  `prayer` int(2) NOT NULL,
  `wc` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;