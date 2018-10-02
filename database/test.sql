-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 02 2018 г., 10:36
-- Версия сервера: 5.7.23
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `files`
--

INSERT INTO `files` (`id`, `name`, `created_at`, `status`) VALUES
(34, 'file.xml', '2018-10-02 10:28:24', 1),
(33, 'file.xml', '2018-10-02 10:27:25', 1),
(32, 'cd.xml', '2018-10-02 10:22:12', 1),
(31, 'file.xml', '2018-10-02 10:22:08', 1),
(30, 'food.xml', '2018-10-02 10:22:05', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `files_descriptions`
--

DROP TABLE IF EXISTS `files_descriptions`;
CREATE TABLE IF NOT EXISTS `files_descriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `unique_tags` int(11) NOT NULL,
  `tags` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` smallint(6) NOT NULL,
  PRIMARY KEY (`id`,`file_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `files_descriptions`
--

INSERT INTO `files_descriptions` (`id`, `file_id`, `unique_tags`, `tags`, `created_at`, `status`) VALUES
(12, 32, 7, '[\n    \'ARTIST\' => 27,\n    \'CD\' => 2,\n    \'COMPANY\' => 27,\n    \'COUNTRY\' => 27,\n    \'PRICE\' => 27,\n    \'TITLE\' => 27,\n    \'YEAR\' => 27,\n]', '2018-10-02 10:22:12', 1),
(13, 33, 8, '[\n    \'@attributes\' => 7,\n    \'CommandLine\' => 7,\n    \'Input\' => 7,\n    \'Name\' => 7,\n    \'Output\' => 7,\n    \'Test\' => 2,\n    \'TestId\' => 7,\n    \'TestType\' => 7,\n]', '2018-10-02 10:27:25', 1),
(11, 31, 8, '[\n    \'@attributes\' => 7,\n    \'CommandLine\' => 7,\n    \'Input\' => 7,\n    \'Name\' => 7,\n    \'Output\' => 7,\n    \'Test\' => 2,\n    \'TestId\' => 7,\n    \'TestType\' => 7,\n]', '2018-10-02 10:22:08', 1),
(10, 30, 5, '[\n    \'calories\' => 6,\n    \'description\' => 6,\n    \'food\' => 2,\n    \'name\' => 6,\n    \'price\' => 6,\n]', '2018-10-02 10:22:05', 1),
(14, 34, 8, '[\n    \'@attributes\' => 7,\n    \'CommandLine\' => 7,\n    \'Input\' => 7,\n    \'Name\' => 7,\n    \'Output\' => 7,\n    \'Test\' => 2,\n    \'TestId\' => 7,\n    \'TestType\' => 7,\n]', '2018-10-02 10:28:24', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
