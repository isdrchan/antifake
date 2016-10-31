-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2016-10-31 09:33:39
-- 服务器版本： 5.5.49
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maotai`
--

-- --------------------------------------------------------

--
-- 表的结构 `info`
--

CREATE TABLE `info` (
  `id` int(11) NOT NULL COMMENT '主键',
  `wine_id` varchar(64) DEFAULT '0' COMMENT '酒品序列号',
  `product_timestamp` int(10) DEFAULT NULL COMMENT '生产时间戳',
  `express` mediumtext COMMENT '快递信息',
  `query_random` varchar(128) DEFAULT NULL COMMENT '查询生成的随机数',
  `query_timestamp` int(10) DEFAULT NULL COMMENT '查询的时间',
  `query_times` int(11) DEFAULT '0' COMMENT '查询次数'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `info`
--

INSERT INTO `info` (`id`, `wine_id`, `product_timestamp`, `express`, `query_random`, `query_timestamp`, `query_times`) VALUES
(1, 'CYN123', 1476945992, '13:18:12包裹正在等待揽收<br>\n20:47:44[金华市]圆通速递 浙江省金华市义乌市北苑三分部收件员 已揽件<br>\n21:52:29浙江省金华市义乌市北苑三分部公司 已打包<br>\n18:48:28广东省珠海市唐家金鼎 已收入<br>', 'TvFVyxK9', 1477467433, 51),
(2, 'DRCHAN9405', 1477467547, '', 'Hv4bGtPl', 1477665697, 18),
(3, 'ABC123ABC', 1477618724, '', 'D9oELzqr', 1477619715, 1),
(4, 'OKOK12312', 1477618751, '', 'wcj6UTVr', 1477665733, 1),
(5, 'mytest', 1477619330, '', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL COMMENT '主键',
  `info_id` int(11) DEFAULT NULL COMMENT 'info表的主键',
  `ip` varchar(16) DEFAULT NULL COMMENT '查询者的ip',
  `gps` varchar(128) DEFAULT NULL COMMENT '查询者的gps',
  `location` varchar(2048) DEFAULT NULL COMMENT '查询者的位置信息',
  `query_random` varchar(128) DEFAULT NULL,
  `timestamp` int(10) DEFAULT NULL COMMENT '查询时间戳'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `log`
--

INSERT INTO `log` (`id`, `info_id`, `ip`, `gps`, `location`, `query_random`, `timestamp`) VALUES
(12, 1, '113.74.76.136', NULL, '广东省珠海市', 'JdCadPF6pN', 1477380838),
(13, 1, '127.0.0.1', '113.543785,22.265811', '广东省珠海市香洲区梅华街道珠海市香洲区人民政府', '31xvgUdbgl', 1477382243),
(14, 1, '113.76.73.108', '113.55965485375393,22.37449479146867', '广东省珠海市香洲区唐家湾镇创新一路', 'bM6H4YdffG', 1477451734),
(15, 1, '113.76.73.108', '113.5623796278829,22.37606370424027', '广东省珠海市香洲区唐家湾镇科技一路16号', 'Q4nMBuZ3', 1477465660),
(16, 1, '113.76.73.108', '113.5623796278829,22.37606370424027', '广东省珠海市香洲区唐家湾镇科技一路16号', 'bkU8sBlL', 1477465707),
(17, 1, '113.76.73.108', '113.55943432972845,22.374787048633692', '广东省珠海市香洲区唐家湾镇创新一路1号3栋', 'TvFVyxK9', 1477467491),
(18, 2, '113.76.73.108', '113.5596080364811,22.37448311478501', '广东省珠海市香洲区唐家湾镇创新一路', 'ep43KJan', 1477467633),
(19, 2, '112.96.97.191', '113.55959911118885,22.37444974475594', '广东省珠海市香洲区唐家湾镇创新一路', 'Z75invrF', 1477484045),
(20, 2, '113.76.73.108', NULL, '广东省珠海市', 'C5zGUwFe', 1477536279),
(21, 2, '113.76.73.108', '113.55954721660594,22.374596173087458', '广东省珠海市香洲区唐家湾镇创新一路', 'FUKl5tFl', 1477537149),
(22, 2, '113.74.76.29', '113.55946848111218,22.37473722292161', '广东省珠海市香洲区唐家湾镇创新一路', 'EX2wBBO3', 1477550373),
(23, 2, '14.17.37.145', '113.559954,22.373842', '广东省珠海市香洲区唐家湾镇港湾大道', 'z82kzEMW', 1477550624),
(24, 2, '14.17.37.145', '113.560064,22.373815', '广东省珠海市香洲区唐家湾镇港湾大道', 'x3a1kF1o', 1477560809),
(25, 2, '221.4.214.59', '113.53844752113262,22.361653421562725', '广东省珠海市香洲区唐家湾镇赤花山路北京理工大学珠海学院', 'S2i7e6ip', 1477577595),
(26, 2, '221.4.214.59', '113.53853331551473,22.361602277174352', '广东省珠海市香洲区唐家湾镇赤花山路北京理工大学珠海学院', 'cH9MOcNm', 1477583356),
(27, 2, '112.96.188.60', '113.53850004241174,22.36158396964604', '广东省珠海市香洲区唐家湾镇赤花山路北京理工大学珠海学院', '5lEwidjJ', 1477585032),
(28, 2, '219.133.40.15', '113.560129,22.373736', '广东省珠海市香洲区唐家湾镇港湾大道', '3cSKVsWB', 1477617121),
(29, 2, '14.17.37.145', '113.560424,22.373743', '广东省珠海市香洲区唐家湾镇港湾大道', 'tS8CnRbA', 1477618572),
(30, 2, '113.74.76.29', '113.55942278812938,22.374819764042588', '广东省珠海市香洲区唐家湾镇创新一路1号3栋', '4ZHelJyt', 1477619130),
(31, 2, '113.74.76.29', '113.55982991079142,22.37441794019775', '广东省珠海市香洲区唐家湾镇宝莱特科技园', 'Yy7dNyvW', 1477619700),
(32, 3, '14.17.37.145', '113.560016,22.373761', '广东省珠海市香洲区唐家湾镇港湾大道', 'D9oELzqr', 1477619832),
(33, 2, '113.74.76.29', '113.5596007435954,22.37446070658586', '广东省珠海市香洲区唐家湾镇创新一路', '8pSdJDtz', 1477620016),
(34, 2, '113.108.11.52', '113.483225,22.29764', '广东省中山市坦洲镇菜子街', 'fO9IOQFw', 1477625642),
(35, 2, '113.108.11.52', '113.483193,22.297384', '广东省中山市坦洲镇菜子街', 'E2ZQfoAf', 1477627994),
(36, 2, '113.74.76.29', '113.55954029092482,22.37439175358701', '广东省珠海市香洲区唐家湾镇广东珠海民营科技园', 'ZS9MmAVl', 1477642018),
(37, 4, '221.4.214.59', '113.53844206919158,22.361561067197087', '广东省珠海市香洲区唐家湾镇赤花山路北京理工大学珠海学院', 'wcj6UTVr', 1477665749);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键', AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键', AUTO_INCREMENT=38;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
