-- The default database_table_prefix "thumbsup_" is assumed.

CREATE TABLE `thumbsup_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `closed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date` int(11) unsigned NOT NULL,
  `votes_up` int(11) NOT NULL DEFAULT '0',
  `votes_down` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_NAME` (`name`)
) DEFAULT CHARSET=utf8;

CREATE TABLE `thumbsup_votes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(11) unsigned NOT NULL,
  `value` tinyint(1) unsigned NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `date` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;
