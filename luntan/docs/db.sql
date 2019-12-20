CREATE TABLE `board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(100) NOT NULL,
  `author` varchar(20) NOT NULL,
  `idate` datetime NOT NULL,
  `replise` int(11) NOT NULL DEFAULT '0',
  `body` text,
  `ndate` datetime NOT NULL,
  `ip` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;