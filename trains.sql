-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 01 2014 г., 21:41
-- Версия сервера: 5.5.35-log
-- Версия PHP: 5.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `trains`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT 'имя типа вагона',
  `places` int(11) NOT NULL COMMENT 'кол-во мест в вагоне',
  `price` int(11) NOT NULL COMMENT 'цена за 1 км',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `name`, `places`, `price`) VALUES
(1, 'плацкарт', 50, 50),
(2, 'купе', 20, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'ФИО заказчика',
  `price` int(10) unsigned NOT NULL,
  `id_route` int(10) unsigned NOT NULL,
  `id_stationFrom` int(11) NOT NULL,
  `id_stationTo` int(11) NOT NULL,
  `car` int(10) unsigned NOT NULL,
  `place` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `parts`
--

CREATE TABLE IF NOT EXISTS `parts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station1` int(11) NOT NULL,
  `station2` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Дамп данных таблицы `parts`
--

INSERT INTO `parts` (`id`, `station1`, `station2`, `length`) VALUES
(3, 19, 20, 5),
(4, 19, 21, 8),
(5, 19, 22, 14),
(7, 19, 23, 8),
(8, 19, 24, 4),
(9, 20, 19, 8),
(10, 20, 21, 4),
(11, 20, 22, 14),
(12, 20, 23, 5),
(13, 21, 19, 14),
(14, 21, 20, 5),
(15, 21, 22, 4),
(16, 21, 25, 4),
(17, 24, 19, 5),
(18, 24, 20, 5),
(19, 24, 22, 14),
(20, 24, 27, 4),
(21, 24, 28, 14),
(22, 25, 28, 14),
(23, 25, 30, 8),
(24, 28, 31, 14),
(25, 31, 32, 4),
(26, 22, 25, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stFrom` int(11) NOT NULL COMMENT 'исходная станция "город - станция"',
  `stTo` int(11) NOT NULL COMMENT 'конечная станция "город - станция"',
  `message` text NOT NULL COMMENT 'примечание',
  `cars` text NOT NULL,
  `timeFrom` time NOT NULL COMMENT 'время отбытия из начальной станции',
  `timeTo` time NOT NULL COMMENT 'время прибытия в конечную станцию',
  `date` date NOT NULL COMMENT 'дата поездки/билета',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `routes`
--

INSERT INTO `routes` (`id`, `stFrom`, `stTo`, `message`, `cars`, `timeFrom`, `timeTo`, `date`) VALUES
(1, 19, 25, 'ежедневно без выходных', '1,1,1,1,2,2,2,2', '16:00:00', '02:00:00', '2014-09-04'),
(3, 19, 25, 'ежедневно без выходных', '1,1,2', '07:00:00', '16:00:00', '2014-09-07');

-- --------------------------------------------------------

--
-- Структура таблицы `routes_parts`
--

CREATE TABLE IF NOT EXISTS `routes_parts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_route` int(10) unsigned NOT NULL,
  `id_part` int(10) unsigned NOT NULL,
  `timeFrom` time NOT NULL,
  `timeTo` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `routes_parts`
--

INSERT INTO `routes_parts` (`id`, `id_route`, `id_part`, `timeFrom`, `timeTo`) VALUES
(6, 15, 1, '00:00:00', '01:00:00'),
(7, 15, 2, '01:02:00', '03:00:00'),
(8, 15, 1, '00:00:00', '01:00:00'),
(9, 15, 2, '01:02:00', '03:00:00'),
(10, 15, 1, '03:03:00', '05:00:00'),
(11, 15, 1, '00:00:00', '00:00:00'),
(17, 2, 4, '16:00:00', '18:00:00'),
(18, 2, 16, '18:05:00', '21:00:00'),
(19, 2, 22, '21:05:00', '02:00:00'),
(20, 2, 24, '02:10:00', '04:00:00'),
(21, 2, 25, '04:03:00', '06:00:00'),
(22, 3, 3, '07:00:00', '08:30:00'),
(23, 3, 11, '08:40:00', '10:00:00'),
(24, 3, 26, '10:05:00', '13:00:00'),
(25, 3, 22, '13:10:00', '16:00:00'),
(26, 1, 4, '16:00:00', '18:00:00'),
(27, 1, 16, '18:05:00', '21:00:00'),
(28, 1, 22, '21:05:00', '02:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `Stations`
--

CREATE TABLE IF NOT EXISTS `Stations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Дамп данных таблицы `Stations`
--

INSERT INTO `Stations` (`id`, `city`, `name`) VALUES
(19, 'г1', 'с1'),
(20, 'г1', 'с2'),
(21, 'г2', 'с1'),
(22, 'г2', 'с2'),
(23, 'г2', 'с3'),
(24, 'г3', 'с1'),
(25, 'г3', 'с2'),
(26, 'г3', 'с3'),
(27, 'г3', 'с4'),
(28, 'г4', 'с1'),
(29, 'г4', 'с2'),
(30, 'г4', 'с3'),
(31, 'г5', 'с1'),
(32, 'г5', 'с2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
