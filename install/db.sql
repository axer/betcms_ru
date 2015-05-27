SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
#####################################
SET time_zone = "+00:00";
#####################################
CREATE TABLE IF NOT EXISTS `betting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idsob` int(11) NOT NULL,
  `onwhom` int(11) NOT NULL,
  `who` int(11) NOT NULL,
  `how` float NOT NULL,
  `howwin` float NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;
#####################################
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` int(11) NOT NULL,
  `team1` varchar(120) NOT NULL,
  `team2` varchar(120) NOT NULL,
  `timestart` int(11) NOT NULL,
  `factor1` float NOT NULL,
  `factor0` float NOT NULL,
  `factor2` float NOT NULL,
  `result` int(11) NOT NULL,
  `old` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;
#####################################
CREATE TABLE IF NOT EXISTS `input_means` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `who` int(11) NOT NULL,
  `how` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `time` int(11) NOT NULL,
  `confirm` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;
#####################################
CREATE TABLE IF NOT EXISTS `mini_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `who` int(11) NOT NULL,
  `msg` text NOT NULL,
  `times` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
#####################################
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `link` varchar(128) NOT NULL,
  `icon` text NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;
#####################################
CREATE TABLE IF NOT EXISTS `output_means` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `who` int(11) NOT NULL,
  `how` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `time` int(11) NOT NULL,
  `confirm` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;
#####################################
CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;
#####################################
CREATE TABLE IF NOT EXISTS `settings` (
  `chat_close` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_msg_chat` int(11) NOT NULL,
  `min_out` float NOT NULL,
  `max_out` float NOT NULL,
  `min_in` float NOT NULL,
  `max_in` float NOT NULL,
  `admin_qiwi` varchar(128) NOT NULL,
  `admin_webmoney` varchar(128) NOT NULL,
  `admin_visa` varchar(128) NOT NULL,
  `icon_size` int(11) NOT NULL,
  `icon_width` int(11) NOT NULL,
  `icon_height` int(11) NOT NULL,
  `max_rate` int(11) NOT NULL,
  `min_rate` int(11) NOT NULL,
  `bonus_reg` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
#####################################
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(120) NOT NULL,
  `email` varchar(100) NOT NULL,
  `admin` int(1) NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `webmoney` varchar(13) NOT NULL,
  `qiwi` varchar(11) NOT NULL,
  `balance` float NOT NULL,
  `visa` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;
#####################################
INSERT INTO `modules` (`id`, `name`, `link`, `icon`, `active`) VALUES
(1, 'Анкета', '/bukmeker/questionnaire', 'user1.png', 1),
(2, 'Ввод средств', '/bukmeker/input.means', 'plus.png', 1),
(3, 'Вывод средств', '/bukmeker/output.means', 'minus.png', 1),
(4, 'Мои ставки', '/bukmeker/bets', 'bet.png', 1),
(5, 'Чат', '/bukmeker/chat', 'chat.png', 1),
(6, 'Live-результаты', '/bukmeker/live', 'live.png', 1),
(7, 'Помощь', '/faq', 'help.png', 1),
(8, 'Выход', '/bukmeker/exit', 'exit.png', 1);