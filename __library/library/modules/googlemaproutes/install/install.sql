CREATE TABLE `Googlemaproutes_settings` (
  `center` varchar(100) NOT NULL,
  `coordinates` varchar(100) DEFAULT NULL,
  `size` varchar(15) NOT NULL,
  `zoom` int(2) NOT NULL,
  `map_type` int(1) NOT NULL,
  `caption` varchar(100) DEFAULT NULL,
  `zoomcontrol_size` int(1) DEFAULT NULL,
  `zoomcontrol_position` int(1) DEFAULT NULL,
  `maptypecontrol_type` int(1) DEFAULT NULL,
  `maptypecontrol_position` int(1) DEFAULT NULL,
  `scale_position` int(1) DEFAULT NULL,
  `streetview_position` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `Googlemaproutes_routes` (
  `route` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8
