CREATE TABLE IF NOT EXISTS `Flickrwidget_settings`( idx INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                        pm_idx INT(11) NOT NULL,
                        api_key VARCHAR(100) NOT NULL,
                        userid VARCHAR(50) NOT NULL,
                        display_type INT(1) NOT NULL,
                        display_target INT(1) NOT NULL,
                        display_num INT(2) NULL,
                        template INT(1) NOT NULL,
                        PRIMARY KEY  (idx)
                    ) ENGINE=INNODB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;`bldph105`
