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

INSERT INTO `bot_content_group` (`description`) VALUES ('Group1');
INSERT INTO `bot_content_group` (`description`) VALUES ('Group1');
INSERT INTO `bot_content_group` (`description`) VALUES ('Group3');

INSERT INTO `bot_content_type` (`description`) VALUES ('Type1');
INSERT INTO `bot_content_type` (`description`) VALUES ('Type2');
INSERT INTO `bot_content_type` (`description`) VALUES ('Type3');

INSERT INTO `bot_tag` (`name`) VALUES ('Tag1');
INSERT INTO `bot_tag` (`name`) VALUES ('Tag2');
INSERT INTO `bot_tag` (`name`) VALUES ('Tag3');

INSERT INTO `bot_content_type` (`description`) VALUES ('Type1');

INSERT INTO `bot_content` (`text`) VALUES ('Text1');
INSERT INTO `bot_content` (`text`) VALUES ('Text2');

INSERT INTO `bot_content_tag` (`tagId`, `contentId`) VALUES (0, 0);
INSERT INTO `bot_content_tag` (`tagId`, `contentId`) VALUES (0, 1);
INSERT INTO `bot_content_tag` (`tagId`, `contentId`) VALUES (0, 3);
INSERT INTO `bot_content_tag` (`tagId`, `contentId`) VALUES (1, 1);
INSERT INTO `bot_content_tag` (`tagId`, `contentId`) VALUES (2, 1);
INSERT INTO `bot_content_tag` (`tagId`, `contentId`) VALUES (3, 0);

COMMIT;
