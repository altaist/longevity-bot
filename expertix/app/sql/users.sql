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


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `expertix_2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `app_user`
--
DROP TABLE IF EXISTS `app_user`;
CREATE TABLE IF NOT EXISTS `app_user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userKey` varchar(32) COLLATE utf8_bin NOT NULL,
  `personId` varchar(128) COLLATE utf8_bin NOT NULL,
  `name` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `img` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `login` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `salt` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `authLink` varchar(128) COLLATE utf8_bin NOT NULL,
  `oauthId` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `confirmCode` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `confirmExpired` datetime DEFAULT NULL,
  `confirmResendExpired` datetime DEFAULT NULL,
  `role` tinyint(2) NOT NULL DEFAULT 0,
  `level` tinyint(2) NOT NULL DEFAULT 0,
  `state` tinyint(2) NOT NULL DEFAULT 0,
  `rating` smallint(6) NOT NULL DEFAULT 0,
  `groupId` int(11) DEFAULT NULL,
  `affKey` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `companyId` int(11) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `confirmedDate` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `lastRequestDate` datetime DEFAULT NULL,
  PRIMARY KEY (`userId`) USING BTREE,
  UNIQUE KEY `authLink` (`authLink`),
  UNIQUE KEY `userKey` (`userKey`) USING BTREE,
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `affKey` (`affKey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



/* Default DATA */
-- admin
INSERT INTO `app_user` (`userId`, `userKey`, `personId`, `name`, `email`, `img`, `authLink`, `login`, `password`, `salt`, `oauthId`, `confirmCode`, `confirmExpired`, `confirmResendExpired`, `role`, `level`, `state`, `rating`, `groupId`, `affKey`, `companyId`, `created`, `updated`, `confirmedDate`, `lastRequestDate`) VALUES ('1', 'nimda', 'nimbda', 'Admin', 'admin@email', NULL, 'nimbda', 'nimbda', "test", NULL, NULL, NULL, NULL, NULL, 1, 10, 1, 0, NULL, 'nimbda', NULL, current_timestamp(), NULL, NULL, NULL);
-- test user
INSERT INTO `app_user` (`userKey`, `personId`, `name`, `email`, `authLink`, `login`, `state`, `level`, `role`, `affKey`) VALUES('user1', 'user1', 'user1', '@user1', 'user1', 'user1', 10, 10, 1, 'user1');
INSERT INTO `app_user` (`userKey`, `personId`, `name`, `email`, `authLink`, `login`, `state`, `level`, `role`, `affKey`) VALUES('user2', 'user2', 'user2', '@user2', 'user2', 'user2', 10, 10, 1, 'user2');

-- managers
INSERT INTO `app_user` (`userKey`, `personId`, `name`, `email`, `authLink`, `login`, `state`, `level`, `role`, `affKey`) VALUES('manager1', 'manager1', 'manager1', '@manager1', 'manager1', 'manager1', 10, 10, 1, 'manager1');
INSERT INTO `app_user` (`userKey`, `personId`, `name`, `email`, `authLink`, `login`, `state`, `level`, `role`, `affKey`) VALUES('manager2', 'manager2', 'manager2', '@manager2', 'manager2', 'manager2', 10, 10, 1, 'manager2');
-- students
INSERT INTO `app_user` (`userKey`, `personId`, `name`, `email`, `authLink`, `login`, `state`, `level`, `role`, `affKey`) VALUES('student1', 'student1', 'student1', '@student1', 'student1', 'student1', 1, 1, 1, 'student1');
INSERT INTO `app_user` (`userKey`, `personId`, `name`, `email`, `authLink`, `login`, `state`, `level`, `role`, `affKey`) VALUES('student2', 'student2', 'student2', '@student2', 'student2', 'student2', 1, 1, 1, 'student2');
-- teachers
INSERT INTO `app_user` (`userKey`, `personId`, `name`, `email`, `authLink`, `login`, `state`, `level`, `role`, `affKey`) VALUES('teacher1', 'teacher1', 'teacher1', '@teacher1', 'teacher1', 'teacher1', 5, 5, 1, 'teacher1');
INSERT INTO `app_user` (`userKey`, `personId`, `name`, `email`, `authLink`, `login`, `state`, `level`, `role`, `affKey`) VALUES('teacher2', 'teacher2', 'teacher2', '@teacher2', 'teacher2', 'teacher2', 5, 5, 1, 'teacher2');



-- 

-- --------------------------------------------------------

--
-- Структура таблицы `app_person`
--

DROP TABLE IF EXISTS `app_person`;
CREATE TABLE IF NOT EXISTS `app_person` (
  `aiId` int(11) NOT NULL AUTO_INCREMENT,
  `personId` varchar(128) COLLATE utf8_bin NOT NULL,
  `lastName` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `firstName` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `middleName` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `img` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `age` tinyint(4) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` tinyint(6) NOT NULL,
  `region` varchar(128) COLLATE utf8_bin NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `tel` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `social` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `telegram` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `insta` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `fb` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `vk` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `org` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `department` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `parentsLastName` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `parentsFirstName` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `parentsMiddleName` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `parentsTel` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `parentsEmail` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `comments` text COLLATE utf8_bin DEFAULT NULL,
  `jsonData` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `energy` DECIMAL(6,2) NOT NULL DEFAULT '0',
  `rating1` smallint(6) NOT NULL DEFAULT 0,
  `rating2` smallint(6) NOT NULL DEFAULT 0,
  `rating3` smallint(6) NOT NULL DEFAULT 0,
  `src` tinyint(4) DEFAULT NULL,
  `state` tinyint(4) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  KEY (`aiId`) USING BTREE,
  PRIMARY KEY (`personId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- INSERT DATA
--

INSERT INTO `app_person` (`personId`, `lastName`, `firstName`, `middleName`, `img`, `age`, `birthday`, `gender`, `region`, `address`, `tel`, `social`, `telegram`, `insta`, `fb`, `vk`, `org`, `department`, `parentsLastName`, `parentsFirstName`, `parentsMiddleName`, `parentsTel`, `parentsEmail`, `comments`, `jsonData`, `src`, `state`, `created`, `updated`) VALUES ('nimbda', 'Админ', 'Иван', 'Иванович', NULL, '12', NULL, '1', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, current_timestamp(), current_timestamp());

INSERT INTO `app_person` (`personId`, `lastName`, `firstName`, `middleName`) VALUES ("user1", "Иванов", "Сергей", "Иванович");
INSERT INTO `app_person` (`personId`, `lastName`, `firstName`, `middleName`) VALUES ("user2", "Петрова", "Ольга", "Дмитриевна");


INSERT INTO `app_person` (`personId`, `lastName`, `firstName`, `middleName`) VALUES ("student1", "Студент", "Сергей", "Иванович");
INSERT INTO `app_person` (`personId`, `lastName`, `firstName`, `middleName`) VALUES ("student2", "Студент", "Игорь", "Александрович");
INSERT INTO `app_person` (`personId`, `lastName`, `firstName`, `middleName`) VALUES ("manager1", "Методист", "Михайил", "Иванович");
INSERT INTO `app_person` (`personId`, `lastName`, `firstName`, `middleName`) VALUES ("manager2", "Методист", "Сергей", "Алексеевич");
INSERT INTO `app_person` (`personId`, `lastName`, `firstName`, `middleName`) VALUES ("teacher1", "Преподаватель", "Михайил", "Иванович");
INSERT INTO `app_person` (`personId`, `lastName`, `firstName`, `middleName`) VALUES ("teacher2", "Преподаватель", "Сергей", "Алексеевич");


COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
