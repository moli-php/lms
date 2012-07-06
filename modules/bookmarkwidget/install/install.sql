CREATE TABLE `Bookmarkwidget_webpages` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `user_ip` varchar(50) DEFAULT NULL,
  `url` longtext,
  `name` longtext,
  `title` longtext,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

CREATE TABLE `Bookmarkwidget_title` (
  `title` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;