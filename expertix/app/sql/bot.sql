-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 29 2022 г., 07:12
-- Версия сервера: 10.3.15-MariaDB
-- Версия PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


-- --------------------------------------------------------

--
-- Структура таблицы `bot_chat`
--
DROP TABLE IF EXISTS `bot_chat`;
CREATE TABLE IF NOT EXISTS `bot_chat` (
  `chatId` varchar(128) NOT NULL,
  `botId` int(11) DEFAULT NULL,
  `userName` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT -1,
  `mode` tinyint(4) NOT NULL DEFAULT 0,
  `role` tinyint(4) NOT NULL DEFAULT 0,
  `lastCommand` varchar(128) DEFAULT NULL,
  `lastCommandArgIndex` tinyint(2) DEFAULT 0,
  
  `contentConfig` text DEFAULT null,
  `lastContentIndex` int(11) DEFAULT 0,
  `lastContentType` tinyint(2) DEFAULT 0,

  `isNeedUpdate` tinyint(2) NOT NULL DEFAULT 0,
	`isWaitingForAnswer` tinyint(2) NOT NULL DEFAULT 0, 
  `alarmLevel` tinyint(2) NOT NULL DEFAULT 0,
  `affKey` varchar(128) COLLATE utf8_bin DEFAULT NULL,

  `dateLastAnswer` datetime DEFAULT current_timestamp(),
  `dateLastRecieved` datetime DEFAULT current_timestamp(),
  `dateLinkCreated` datetime DEFAULT NULL,
  `dateLastAlarmNotify` datetime DEFAULT current_timestamp(),
  
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `confirmedDate` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  
  
  PRIMARY KEY (`chatId`) USING BTREE,
  UNIQUE KEY `affKey` (`affKey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Структура таблицы `bot_chat_action`
--
DROP TABLE IF EXISTS `bot_chat_action`;
CREATE TABLE IF NOT EXISTS `bot_chat_action` (
  `actionId` int(11) NOT NULL AUTO_INCREMENT,
  `chatId` int(11) DEFAULT NULL,
  `botId` int(11) DEFAULT NULL,
  `messageId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `message` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `state` tinyint(2) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`actionId`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `bot_chat_link`;
CREATE TABLE IF NOT EXISTS `bot_chat_link` (
  `chatId1` varchar(128) NOT NULL,
  `chatId2` varchar(128) NOT NULL,
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

COMMIT;

DROP TABLE IF EXISTS `bot_log`;
CREATE TABLE IF NOT EXISTS `bot_log` (
  `chatId` varchar(128) NOT NULL,
  `type` tinyint(2) DEFAULT NULL,
  `request` text DEFAULT NULL,
  `response` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

COMMIT;
