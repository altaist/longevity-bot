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

-- Content
DROP TABLE IF EXISTS `bot_content`;
CREATE TABLE IF NOT EXISTS `bot_content` (
  `contentId` int(11) NOT NULL AUTO_INCREMENT,
  `groupId` tinyint(4),
  `typeId` tinyint(2),
  `contentType` varchar(64),
  `text` text,
  `img` varchar(512),
  `caption` varchar(512),
  `meta` text,
  PRIMARY KEY (`contentId`) USING BTREE
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `bot_content_type`;
CREATE TABLE IF NOT EXISTS `bot_content_type` (
  `typeId` int(11) NOT NULL,
  `contentType` varchar(64),
  `description` varchar(256)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `bot_content_group`;
CREATE TABLE IF NOT EXISTS `bot_content_group` (
  `groupId` int(11) NOT NULL,
  `description` varchar(256)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `bot_content_tag`;
CREATE TABLE IF NOT EXISTS `bot_content_tag` (
  `contentId` int(11) NOT NULL, 
  `tagId` int(11) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `bot_tag`;
CREATE TABLE IF NOT EXISTS `bot_tag` (
  `tagId` int(11) NOT NULL,
  `name` varchar(256),
  `contentId` int(11) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


--
-- Структура таблицы `bot_chat_action`
--
DROP TABLE IF EXISTS `bot_chat_action`;
CREATE TABLE IF NOT EXISTS `bot_chat_action` (
  `actionId` int(11) NOT NULL AUTO_INCREMENT,
  `chatId` varchar(128) NOT NULL,
  `botId` int(11) DEFAULT NULL,
  `messageId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `message` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `state` tinyint(2) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`actionId`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `bot_chat_message`;
CREATE TABLE IF NOT EXISTS `bot_chat_message` (
  `chatMessageId` int(11) NOT NULL AUTO_INCREMENT,
  `chatId` varchar(128) NOT NULL,
  `messageId` int(11) DEFAULT NULL,
  `contentId` int(11) DEFAULT NULL,
  `contentGroup` int(11) DEFAULT NULL,
  `contentIndex` int(11) DEFAULT NULL,
	`category` varchar(256) null,
	`tags` varchar(1024) null,
	`messageText` varchar(1024) null,
	`messageImg` varchar(1024) null,
  `answerText` varchar(2048) null,
  `rating` tinyint(2) DEFAULT 0,
  `dateLastAnswer` datetime DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`chatMessageId`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


COMMIT;
