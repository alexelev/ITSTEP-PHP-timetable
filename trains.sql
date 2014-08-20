-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 15 2014 г., 21:41
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
CREATE DATABASE IF NOT EXISTS `trains` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `trains`;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `name`, `places`, `price`) VALUES
(1, 'плацкарт', 50, 50),
(2, 'купе', 20, 100);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `parts`
--

INSERT INTO `parts` (`id`, `station1`, `station2`, `length`) VALUES
(1, 13, 15, 11),
(2, 14, 15, 5);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `routes_parts`
--

CREATE TABLE IF NOT EXISTS `routes_parts` (
  `id_route` int(10) unsigned NOT NULL,
  `id_part` int(10) unsigned NOT NULL,
  `timeFrom` time NOT NULL,
  `timeTo` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Stations`
--

CREATE TABLE IF NOT EXISTS `Stations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `Stations`
--

INSERT INTO `Stations` (`id`, `city`, `name`) VALUES
(11, 'Mariupol', '1'),
(12, 'Mariupol', '2sdlkfjghsklj'),
(13, 'город 1', 'станция 1'),
(14, 'город 1', 'станция 2'),
(15, 'город 2', 'станция 1'),
(16, 'город 3', 'станция 1'),
(17, 'город 3', 'станция 2'),
(18, 'город 3', 'станция 3');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
