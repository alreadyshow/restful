-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 �?04 �?27 �?09:56
-- 服务器版本: 5.5.53
-- PHP 版本: 5.6.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `mydb`
--

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL,
  `content` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`article_id`, `title`, `content`, `createdAt`, `user_id`) VALUES
(2, 'biaiti', 'neirong', '2018-04-27 08:23:17', 5),
(3, 'biaiti', 'neirong', '2018-04-27 08:24:46', 5),
(4, 'ninini', 'dasjhdkjahsdkjsa', '2018-04-27 08:27:31', 5),
(5, 'biaiti', 'neirong', '2018-04-27 08:28:18', 5),
(6, '标题', '内容', '2018-04-27 09:17:58', 5),
(7, '标题aa', '内容', '2018-04-27 09:18:53', 5),
(8, '标题aa', '内容', '2018-04-27 09:19:16', 5),
(9, '标题aa', '内容', '2018-04-27 09:20:26', 5),
(10, '标题aa', '内容', '2018-04-27 17:20:54', 5);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `createdAt` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `username` (`username`),
  KEY `createdAt` (`createdAt`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `createdAt`) VALUES
(1, 'admin', 'admin', '0000-00-00 00:00:00'),
(2, 'admina', '5650b95ca7fd12a542d0139dc8a8b076', '0000-00-00 00:00:00'),
(3, 'aaa', 'bd44e102d0bfb9947c815778131971e9', '0000-00-00 00:00:00'),
(4, 'bbb', '61712b081f5dff190d325cdcbf2900e8', '2018-04-27 07:32:35'),
(5, 'ccc', '74259c09de0e71d236959a215c53e5a7', '2018-04-27 07:40:20');

--
-- 限制导出的表
--

--
-- 限制表 `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
