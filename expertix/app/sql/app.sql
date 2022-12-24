-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 06 2022 г., 12:53
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
-- Структура таблицы `app_aff`
--

DROP TABLE IF EXISTS `app_aff`;
CREATE TABLE IF NOT EXISTS `app_aff` (
  `affId` int(11) NOT NULL AUTO_INCREMENT,
  `affType` tinyint(4) NOT NULL DEFAULT 0,
  `userId` int(11) NOT NULL,
  `parentUserId` int(11) NOT NULL,
  `action` tinyint(4) NOT NULL DEFAULT 0,
  `state` tinyint(4) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`affId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `app_company`
--

DROP TABLE IF EXISTS `app_company`;
CREATE TABLE IF NOT EXISTS `app_company` (
  `companyId` int(11) NOT NULL AUTO_INCREMENT,
  `companyKey` varchar(64) COLLATE utf8_bin NOT NULL,
  `name` varchar(256) COLLATE utf8_bin NOT NULL,
  `fullName` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `companyType` tinyint(4) NOT NULL,
  `tel` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `social` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `web` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `address` text COLLATE utf8_bin DEFAULT NULL,
  `gps` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `placeId` smallint(6) NOT NULL,
  `parentCompanyId` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `affKey` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `jsonData` text COLLATE utf8_bin DEFAULT NULL,
  `contactName` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`companyId`),
  UNIQUE KEY `companyKey` (`companyKey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `app_file`
--

DROP TABLE IF EXISTS `app_file`;
CREATE TABLE IF NOT EXISTS `app_file` (
  `fileId` int(11) NOT NULL AUTO_INCREMENT,
  `fileKey` varchar(16) COLLATE utf8_bin NOT NULL,
  `userId` int(11) NOT NULL,
  `appId` int(11) NOT NULL,
  `title` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `description` varchar(2048) COLLATE utf8_bin DEFAULT NULL,
  `type` tinyint(2) NOT NULL DEFAULT 0,
  `mime` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `size` smallint(6) DEFAULT NULL,
  `fileName` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `ext` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `remoteUrl` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `fileNameSrc` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`fileId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `app_log`
--

DROP TABLE IF EXISTS `app_log`;
CREATE TABLE IF NOT EXISTS `app_log` (
  `logId` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(64) COLLATE utf8_bin NOT NULL,
  `url` text COLLATE utf8_bin DEFAULT NULL,
  `request` text COLLATE utf8_bin NOT NULL,
  `response` text COLLATE utf8_bin DEFAULT NULL,
  `headers` text COLLATE utf8_bin DEFAULT NULL,
  `action` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `timeFrom` timestamp NULL DEFAULT NULL,
  `timeTo` timestamp NULL DEFAULT NULL,
  `comments` text COLLATE utf8_bin DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`logId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `app_role`
--

DROP TABLE IF EXISTS `app_role`;
CREATE TABLE IF NOT EXISTS `app_role` (
  `roleId` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8_bin NOT NULL,
  `subTitle` varchar(512) COLLATE utf8_bin NOT NULL,
  `level` tinyint(4) NOT NULL,
  `pathLogin` varchar(128) COLLATE utf8_bin NOT NULL,
  `pathLogout` varchar(128) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`roleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `app_user_agency`
--

DROP TABLE IF EXISTS `app_user_company`;
CREATE TABLE IF NOT EXISTS `app_user_company` (
  `userId` int(11) NOT NULL,
  `companyId` int(11) NOT NULL,
  
  `role` tinyint(4) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `app_user_role`
--

DROP TABLE IF EXISTS `app_user_role`;
CREATE TABLE IF NOT EXISTS `app_user_role` (
  `userId` int(11) NOT NULL,
  `roleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
COMMIT;
