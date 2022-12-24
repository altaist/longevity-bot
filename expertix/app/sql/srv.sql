-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 06 2022 г., 13:31
-- Версия сервера: 10.3.15-MariaDB
-- Версия PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- База данных: `expertix_2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `srv_action`
--

DROP TABLE IF EXISTS `srv_action`;
CREATE TABLE IF NOT EXISTS `srv_action` (
  `actionId` int(11) NOT NULL AUTO_INCREMENT,
  `activityId` int(11) NOT NULL,
  `actionIndex` smallint(6) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `memberId` int(11) NOT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `result` tinyint(4) NOT NULL,
  `answerInt` mediumint(6) DEFAULT NULL,
  `answerJson` text COLLATE utf8_bin DEFAULT NULL,
  `answerText` text COLLATE utf8_bin DEFAULT NULL,
  `metaJson` text COLLATE utf8_bin DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL,
  `name` text COLLATE utf8_bin NOT NULL,
  `org` text COLLATE utf8_bin NOT NULL,
  `presentationTitle` text COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`actionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `srv_activity`
--

DROP TABLE IF EXISTS `srv_activity`;
CREATE TABLE IF NOT EXISTS `srv_activity` (
  `activityId` int(11) NOT NULL AUTO_INCREMENT,
  `parentId` int(11) NOT NULL,
  `activityKey` varchar(64) COLLATE utf8_bin NOT NULL,
  `serviceId` int(11) DEFAULT NULL,
  `appId` int(11) DEFAULT NULL,
  `authorId` int(11) DEFAULT NULL,
  `title` varchar(512) COLLATE utf8_bin NOT NULL,
  `subTitle` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin DEFAULT NULL,
  `img` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `video` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `currentAction` tinyint(4) NOT NULL,
  `actionsNum` tinyint(4) NOT NULL,
  `quiz` text COLLATE utf8_bin DEFAULT NULL,
  `homeworkText` text COLLATE utf8_bin DEFAULT NULL,
  `homeworkDateTo` date DEFAULT NULL,
  `required` tinyint(4) NOT NULL DEFAULT 0,
  `jsonData` text COLLATE utf8_bin DEFAULT NULL,
  `appConfig` text COLLATE utf8_bin DEFAULT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `state` tinyint(4) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`activityId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `srv_activity_meeting`
--

DROP TABLE IF EXISTS `srv_activity_meeting`;
CREATE TABLE IF NOT EXISTS `srv_activity_meeting` (
  `activityId` int(11) NOT NULL,
  `meetingId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `srv_activity_member`
--

DROP TABLE IF EXISTS `srv_activity_member`;
CREATE TABLE IF NOT EXISTS `srv_activity_member` (
  `memberId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `firstName` varchar(64) COLLATE utf8_bin NOT NULL,
  `lastName` varchar(64) COLLATE utf8_bin NOT NULL,
  `nickName` varchar(64) COLLATE utf8_bin NOT NULL,
  `currentAction` tinyint(4) NOT NULL,
  `currentStep` tinyint(4) NOT NULL,
  `currentResult` smallint(6) NOT NULL,
  `jsonData` text COLLATE utf8_bin NOT NULL,
  `activityId` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`memberId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `srv_meeting`
--

DROP TABLE IF EXISTS `srv_meeting`;
CREATE TABLE IF NOT EXISTS `srv_meeting` (
  `meetingId` int(11) NOT NULL AUTO_INCREMENT,
  `parentId` int(11) NOT NULL,
  `meetingKey` varchar(128) COLLATE utf8_bin NOT NULL,
  `serviceId` int(11) DEFAULT NULL,
  `productId` int(11) NOT NULL,
  `appId` int(11) DEFAULT NULL,
  `authorId` int(11) DEFAULT NULL,
  `title` varchar(512) COLLATE utf8_bin NOT NULL,
  `subTitle` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin DEFAULT NULL,
  `img` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `video` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `quiz` text COLLATE utf8_bin DEFAULT NULL,
  `homeworkText` text COLLATE utf8_bin DEFAULT NULL,
  `homeworkDateTo` date DEFAULT NULL,
  `required` tinyint(4) NOT NULL DEFAULT 0,
  `jsonData` text COLLATE utf8_bin DEFAULT NULL,
  `appConfig` text COLLATE utf8_bin DEFAULT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `state` tinyint(4) NOT NULL,
  `pos` tinyint(4) NOT NULL,
  `isRequired` tinyint(4) NOT NULL,
  `isExam` tinyint(4) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`meetingId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `srv_service`
--

DROP TABLE IF EXISTS `srv_service`;
CREATE TABLE IF NOT EXISTS `srv_service` (
  `serviceId` int(11) NOT NULL AUTO_INCREMENT,
  `serviceType` tinyint(6) DEFAULT 0,
  `serviceKey` varchar(64) COLLATE utf8_bin NOT NULL,
  `productId` int(11) DEFAULT NULL,
  `title` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `subTitle` text COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin DEFAULT NULL,
  `contentId` int(11) NOT NULL,
  `dateFrom` datetime DEFAULT NULL,
  `dateTo` datetime DEFAULT NULL,
  `placeId` int(11) DEFAULT 0,
  `address` text COLLATE utf8_bin NOT NULL,
  `currentStep` int(11) DEFAULT 0,
  `state` tinyint(4) DEFAULT 0,
  `minAccesLevel` tinyint(4) NOT NULL,
  `maxUsersNum` smallint(6) DEFAULT 0,
  `minUsersNum` smallint(6) DEFAULT 0,
  `maxMiniGroupsNum` tinyint(4) DEFAULT 0,
  `maxMiniGroupSize` smallint(6) DEFAULT 0,
  `minMiniGroupSize` smallint(6) DEFAULT 0,
  `speakerId` int(11),
  `creatorId` int(11),
  `companyId` int(11) DEFAULT NULL,
  `jsonData` text COLLATE utf8_bin DEFAULT NULL,
  `isDeleted` tinyint(4) DEFAULT 0,
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`serviceId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `srv_subscription`
--

DROP TABLE IF EXISTS `srv_subscription`;
CREATE TABLE IF NOT EXISTS `srv_subscription` (
  `subscriptionId` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) DEFAULT NULL,
  `serviceId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT 0,
  `state` tinyint(6) DEFAULT 0,
  `accessLevel` tinyint(6) DEFAULT 0,
  `role` tinyint(6) DEFAULT 0,
  `resultLevel` tinyint(6) DEFAULT 0,
  `dateFrom` datetime DEFAULT NULL,
  `dateTo` datetime DEFAULT NULL,
  `jsonData` text COLLATE utf8_bin DEFAULT NULL,
  `isDeleted` tinyint(4) DEFAULT 0,
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`subscriptionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
COMMIT;
