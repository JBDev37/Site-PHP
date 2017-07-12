SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `friendships` (
`id` int(8) NOT NULL,
  `id_user_1` int(8) NOT NULL,
  `id_user_2` int(8) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `friendships` (`id`, `id_user_1`, `id_user_2`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 1, 4),
(4, 1, 5),
(5, 1, 6),
(6, 2, 3),
(7, 2, 4),
(8, 2, 5),
(9, 2, 6),
(10, 3, 4),
(11, 3, 5),
(12, 3, 6),
(13, 4, 5),
(14, 4, 6),
(15, 5, 6);

CREATE TABLE IF NOT EXISTS `messages` (
`id` int(11) NOT NULL,
  `from_user_id` int(8) NOT NULL,
  `to_user_id` int(8) NOT NULL,
  `message` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_timestamp` int(32) DEFAULT NULL,
  `read` int(1) DEFAULT NULL,
  `read_timestamp` int(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `users` (
`id` int(8) NOT NULL,
  `identifier` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastupdate` int(32) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `identifier`, `name`, `picture`, `lastupdate`) VALUES
(1, 'JohnC', 'John C.', 'https://s3.amazonaws.com/uifaces/faces/twitter/sauro/128.jpg', 1457526789),
(2, 'JasonDarc', 'Jason Darc', 'https://s3.amazonaws.com/uifaces/faces/twitter/azielsilas/128.jpg', 1457958401),
(3, 'JoanaPereira', 'Joana Pereira', 'https://s3.amazonaws.com/uifaces/faces/twitter/ladylexy/128.jpg', 1457668266),
(4, 'LucasA', 'Lucas A.', 'https://s3.amazonaws.com/uifaces/faces/twitter/spiltmilkstudio/128.jpg', 1458102271),
(5, 'PabloVaras', 'Pablo Varas', 'https://s3.amazonaws.com/uifaces/faces/twitter/dannpetty/128.jpg', 1458100212),
(6, 'LucasOliver', 'Lucas Oliver', 'https://s3.amazonaws.com/uifaces/faces/twitter/ok/128.jpg', 1458100215);

ALTER TABLE `friendships`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `messages`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `friendships`
MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;

ALTER TABLE `messages`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
