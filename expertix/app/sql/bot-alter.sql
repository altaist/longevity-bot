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

ALTER TABLE `bot_chat`
  add `firstName` varchar(128) COLLATE utf8_bin DEFAULT NULL after `username`,
  add `lastName` varchar(128) COLLATE utf8_bin DEFAULT NULL after `firstName`,
  add `lang` varchar(32) COLLATE utf8_bin DEFAULT NULL after `role`,
  add `location` varchar(256) COLLATE utf8_bin DEFAULT NULL after `lang`,
  add `address` varchar(1024) COLLATE utf8_bin DEFAULT NULL after `location`,
  add `city` varchar(512) COLLATE utf8_bin DEFAULT NULL after `address`,
  add `timezone` tinyint(2) DEFAULT 0 after `city`;
COMMIT;
