-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 06 2022 г., 13:19
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
-- Структура таблицы `store_product`
--

DROP TABLE IF EXISTS `store_product`;
CREATE TABLE IF NOT EXISTS `store_product` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `productKey` varchar(128) COLLATE utf8_bin NOT NULL,
  `appId` smallint(6) NOT NULL,
  `categoryId` smallint(6) NOT NULL,
  `productType` tinyint(6) NOT NULL DEFAULT 0,
  `title` varchar(512) COLLATE utf8_bin NOT NULL,
  `subTitle` text COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `img` text COLLATE utf8_bin DEFAULT NULL,
  `video` text COLLATE utf8_bin NOT NULL,
  `viewKey` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT 0,
  `vendorId` int(11) DEFAULT NULL,
  `creatorId` int(11) NOT NULL,
  `companyId` int(11) NOT NULL,
  `likes` smallint(6) NOT NULL,
  `dislikes` smallint(6) NOT NULL,
  `jsonData` text COLLATE utf8_bin DEFAULT NULL,
  `hasPrice` tinyint(4) NOT NULL,
  `priceRecommended1` decimal(6,2) NOT NULL,
  `priceRecommended2` decimal(6,2) NOT NULL,
  `priceRecommended3` decimal(6,2) NOT NULL,
  `priceNetto1` decimal(6,2) NOT NULL,
  `priceNetto2` decimal(6,2) NOT NULL,
  `priceNetto3` decimal(6,2) NOT NULL,
  `priceAgency1` decimal(6,2) NOT NULL,
  `priceAgency2` decimal(6,2) NOT NULL,
  `priceAgency3` decimal(6,2) NOT NULL,
  `isActive` tinyint(4) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------


--
-- Структура таблицы `store_site`
--

DROP TABLE IF EXISTS `store_site`;
CREATE TABLE IF NOT EXISTS `store_site` (
  `siteId` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(128) COLLATE utf8_bin NOT NULL,
  `companyId` int(11) DEFAULT NULL,
  `lang` tinyint(4) DEFAULT NULL,
  `title` varchar(128) COLLATE utf8_bin NOT NULL,
  `subTitle` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `description` varchar(2048) COLLATE utf8_bin DEFAULT NULL,
  `img` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `htmlTitle` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `htmlH1` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `htmlDescription` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `footer` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `contacts` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `contentJson` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`siteId`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
COMMIT;



-- --------------------------------------------------------

--
-- Структура таблицы `store_request`
--

DROP TABLE IF EXISTS `store_request`;
CREATE TABLE `store_request` (
  `requestId` int(11) NOT NULL AUTO_INCREMENT,
  `appKey` varchar(128) COLLATE utf8_bin DEFAULT NULL,
	`formId` varchar(128) COLLATE utf8_bin NOT NULL,
  `productId` int(11) NOT NULL,
  `serviceId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productTitle` text COLLATE utf8_bin DEFAULT NULL,
  `firstName` varchar(255) COLLATE utf8_bin NOT NULL,
  `lastName` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `age` tinyint(4) NOT NULL,
  `address` varchar(256) COLLATE utf8_bin NOT NULL,
  `comments` text COLLATE utf8_bin DEFAULT NULL,
  `tel` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `socials` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `placeId` int(11) NOT NULL,
  `state` tinyint(4) DEFAULT NULL,
  `jsonData` text COLLATE utf8_bin DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`requestId`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

