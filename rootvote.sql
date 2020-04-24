-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2020 年 01 月 15 日 14:24
-- 伺服器版本： 10.4.10-MariaDB
-- PHP 版本： 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `rootvote`
--
CREATE DATABASE IF NOT EXISTS `rootvote` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rootvote`;

-- --------------------------------------------------------

--
-- 資料表結構 `final`
--

CREATE TABLE `final` (
  `id` int(11) NOT NULL,
  `personcate` varchar(5) NOT NULL,
  `partycate` varchar(5) NOT NULL,
  `name` varchar(10) NOT NULL,
  `ratio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `final`
--

INSERT INTO `final` (`id`, `personcate`, `partycate`, `name`, `ratio`) VALUES
(1, '1', 'a', 'KMT_old', 0.33),
(2, '1', 'b', 'DPP_old', 0.47),
(3, '1', 'c', 'OTH_old', 0.2),
(4, '2', 'a', 'KMT_mid', 0.44),
(5, '2', 'b', 'DPP_mid', 0.36),
(6, '2', 'c', 'OTH_mid', 0.2),
(7, '3', 'a', 'KMT_you', 0.41),
(8, '3', 'b', 'DPP_you', 0.32),
(9, '3', 'c', 'OTH_you', 0.27);

-- --------------------------------------------------------

--
-- 資料表結構 `party`
--

CREATE TABLE `party` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `party`
--

INSERT INTO `party` (`id`, `name`) VALUES
(1, 'KMT'),
(2, 'DPP'),
(3, 'OTH');

-- --------------------------------------------------------

--
-- 資料表結構 `population`
--

CREATE TABLE `population` (
  `id` int(2) NOT NULL,
  `county` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
  `population_y` int(6) DEFAULT NULL,
  `population_m` int(7) DEFAULT NULL,
  `population_o` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `population`
--

INSERT INTO `population` (`id`, `county`, `population_y`, `population_m`, `population_o`) VALUES
(1, '連江縣', 3032, 6342, 1378),
(2, '宜蘭縣', 94030, 207159, 60339),
(3, '彰化縣', 268846, 564818, 165883),
(4, '南投縣', 100602, 225391, 71931),
(5, '雲林縣', 131180, 308868, 101322),
(6, '屏東縣', 166379, 382731, 114924),
(7, '臺東縣', 42609, 101077, 29665),
(8, '花蓮縣', 65262, 150698, 44552),
(9, '澎湖縣', 23699, 47372, 14480),
(10, '基隆市', 74173, 177111, 50325),
(11, '新竹市', 84267, 205331, 46480),
(12, '臺北市', 462306, 1233035, 397132),
(13, '新北市', 805116, 1944200, 484192),
(14, '臺中市', 599753, 1292732, 301050),
(15, '臺南市', 372139, 891755, 244132),
(16, '桃園市', 479132, 1031529, 227751),
(17, '苗栗縣', 111123, 246662, 73366),
(18, '新竹縣', 111478, 255978, 57459),
(19, '嘉義市', 53511, 120516, 34048),
(20, '嘉義縣', 98373, 232171, 80093),
(21, '高雄市', 545096, 1320052, 362645),
(22, '金門縣', 33150, 68421, 16026);

-- --------------------------------------------------------

--
-- 資料表結構 `population_backup`
--

CREATE TABLE `population_backup` (
  `id` int(2) NOT NULL,
  `county` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
  `population_y` int(6) DEFAULT NULL,
  `population_m` int(7) DEFAULT NULL,
  `population_o` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `population_backup`
--

INSERT INTO `population_backup` (`id`, `county`, `population_y`, `population_m`, `population_o`) VALUES
(1, '基隆市', 74173, 177111, 50325),
(2, '臺北市', 462306, 1233035, 397132),
(3, '新北市', 805116, 1944200, 484192),
(4, '桃園市', 479132, 1031529, 227751),
(5, '新竹市', 84267, 205331, 46480),
(6, '新竹縣', 111478, 255978, 57459),
(7, '苗栗縣', 111123, 246662, 73366),
(8, '台中市', 599753, 1292732, 301050),
(9, '彰化縣', 268846, 564818, 165883),
(10, '南投縣', 100602, 225391, 71931),
(11, '雲林縣', 131180, 308868, 101322),
(12, '嘉義市', 53511, 120516, 34048),
(13, '嘉義縣', 98373, 232171, 80093),
(14, '台南市', 372139, 891755, 244132),
(15, '高雄市', 545096, 1320052, 362645),
(16, '屏東縣', 166379, 382731, 114924),
(17, '台東縣', 42609, 101077, 29665),
(18, '花蓮縣', 65262, 150698, 44552),
(19, '宜蘭縣', 94030, 207159, 60339),
(20, '澎湖縣', 23699, 47372, 14480),
(21, '金門縣', 33150, 68421, 16026),
(22, '連江縣', 3032, 6342, 1378);

-- --------------------------------------------------------

--
-- 資料表結構 `questionnaireparty`
--

CREATE TABLE `questionnaireparty` (
  `id` int(11) NOT NULL,
  `Countyname` varchar(25) NOT NULL,
  `KMT` float NOT NULL,
  `DPP` float NOT NULL,
  `OTH` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `questionnaireparty`
--

INSERT INTO `questionnaireparty` (`id`, `Countyname`, `KMT`, `DPP`, `OTH`) VALUES
(1, 'Lienchiang County', 0.195846, 0.581602, 0.222552),
(2, 'Yilan County', 0, 1, 0),
(3, 'Changhua County', 0.1, 0.7, 0.2),
(4, 'Nantou County', 0, 1, 0),
(5, 'Yunlin County', 0, 1, 0),
(6, 'Pingtung County', 0, 0.75, 0.25),
(7, 'Taitung County', 0, 1, 0),
(8, 'Hualien County', 0.421053, 0.368421, 0.210526),
(9, 'Penghu County', 0.195846, 0.581602, 0.222552),
(10, 'Keelung City', 0, 1, 0),
(11, 'Hsinchu City', 0.285714, 0.428571, 0.285714),
(12, 'Taipei City', 0.0344828, 0.793103, 0.172414),
(13, 'New Taipei City', 0, 0.942857, 0.0571429),
(14, 'Taichung City', 0.115385, 0.730769, 0.153846),
(15, 'Tainan City', 0.231707, 0.487805, 0.280488),
(16, 'Taoyuan City', 0.285714, 0.285714, 0.428571),
(17, 'Miaoli County', 0.166667, 0.833333, 0),
(18, 'Hsinchu County', 0, 0.75, 0.25),
(19, 'Chiayi City', 0.625, 0.208333, 0.166667),
(20, 'Chiayi County', 0.25, 0.25, 0.5),
(21, 'Kaohsiung City', 0.0689655, 0.758621, 0.172414),
(22, 'Kinmen County', 0, 1, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `table2php`
--

CREATE TABLE `table2php` (
  `id` int(11) NOT NULL,
  `county` varchar(5) NOT NULL,
  `kmt_y` float NOT NULL,
  `kmt_m` float NOT NULL,
  `kmt_o` float NOT NULL,
  `dpp_y` float NOT NULL,
  `dpp_m` float NOT NULL,
  `dpp_o` float NOT NULL,
  `oth_y` float NOT NULL,
  `oth_m` float NOT NULL,
  `oth_o` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `table2php`
--

INSERT INTO `table2php` (`id`, `county`, `kmt_y`, `kmt_m`, `kmt_o`, `dpp_y`, `dpp_m`, `dpp_o`, `oth_y`, `oth_m`, `oth_o`) VALUES
(1, '連江縣', 0.632778, 0.632778, 0.632778, 0, 0, 0, 0.367222, 0.367222, 0.367222),
(2, '宜蘭縣', 0.479628, 0.479628, 0.479628, 0.370509, 0.370509, 0.370509, 0.149864, 0.149864, 0.149864),
(3, '彰化縣', 0.33, 0.592918, 0.768588, 0.6, 0.337082, 0.161412, 0.07, 0.07, 0.07),
(4, '南投縣', 0.649966, 0.649966, 0.649966, 0.32421, 0.32421, 0.32421, 0.0258243, 0.0258243, 0.0258243),
(5, '雲林縣', 0.05, 0.570363, 0.761574, 0.666, 0.410205, 0.218994, 0.284, 0.0194321, 0.0194321),
(6, '屏東縣', 0.1, 0.48, 0.46135, 0.8, 0.459495, 0.458083, 0.1, 0.0605054, 0.0805665),
(7, '臺東縣', 0.574797, 0.574797, 0.574797, 0.360497, 0.360497, 0.360497, 0.0647061, 0.0647061, 0.0647061),
(8, '花蓮縣', 0.5, 0.4, 0.550875, 0.25, 0.2, 0.448567, 0.25, 0.4, 0.000557401),
(9, '澎湖縣', 0.377736, 0.377736, 0.377736, 0.318551, 0.318551, 0.318551, 0.303713, 0.303713, 0.303713),
(10, '基隆市', 0.1, 0.566045, 0.566045, 0.885, 0.395919, 0.395919, 0.015, 0.0380355, 0.0380355),
(11, '新竹市', 0.25, 0.3, 0.242697, 0.25, 0.6, 0.445349, 0.5, 0.1, 0.311954),
(12, '臺北市', 0.1, 0.66, 0.161572, 0.115385, 0, 0.718272, 0.784615, 0.34, 0.120157),
(13, '新北市', 0.352647, 0.616701, 0.616701, 0.646765, 0.354595, 0.354595, 0.000588235, 0.0287042, 0.0287042),
(14, '臺中市', 0.2, 0.571429, 0.571429, 0.684211, 0.142857, 0.142857, 0.115789, 0.285714, 0.285714),
(15, '臺南市', 0.1, 0.425926, 0.260406, 0.292308, 0.296296, 0.64643, 0.607692, 0.277778, 0.0931643),
(16, '桃園市', 0.485714, 0.392857, 0.0654199, 0.485714, 0.485714, 0.55037, 0.0285714, 0.121429, 0.38421),
(17, '苗栗縣', 0.2, 0.816123, 0.816123, 0, 0, 0, 0.8, 0.183877, 0.183877),
(18, '新竹縣', 0.15, 0.514975, 0.514975, 0.12, 0.373162, 0.373162, 0.73, 0.111862, 0.111862),
(19, '嘉義市', 0.43, 0.533333, 0.143467, 0.43, 0.2, 0.833868, 0.14, 0.266667, 0.0226646),
(20, '嘉義縣', 0.32, 0.55, 0.774353, 0.5, 0.27, 0.0456466, 0.18, 0.18, 0.18),
(21, '高雄市', 0.242857, 0.553408, 0.513076, 0.714286, 0.420442, 0.440442, 0.0428571, 0.0261501, 0.0464828),
(22, '金門縣', 0.5, 0.249097, 0.249097, 0, 0, 0, 0.5, 0.750903, 0.750903);

-- --------------------------------------------------------

--
-- 資料表結構 `table2php_faketest`
--

CREATE TABLE `table2php_faketest` (
  `id` int(11) NOT NULL,
  `county` varchar(5) NOT NULL,
  `kmt_y` float NOT NULL,
  `kmt_m` float NOT NULL,
  `kmt_o` float NOT NULL,
  `dpp_y` float NOT NULL,
  `dpp_m` float NOT NULL,
  `dpp_o` float NOT NULL,
  `oth_y` float NOT NULL,
  `oth_m` float NOT NULL,
  `oth_o` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `table2php_faketest`
--

INSERT INTO `table2php_faketest` (`id`, `county`, `kmt_y`, `kmt_m`, `kmt_o`, `dpp_y`, `dpp_m`, `dpp_o`, `oth_y`, `oth_m`, `oth_o`) VALUES
(1, '基隆市', 0.447754, 0.528675, 0.447754, 0.528675, 0.447754, 0.528675, 0.0235704, 0.0235704, 0.0235704),
(2, '臺北市', 0.171201, 0.404348, 0.404348, 0.404348, 0.171201, 0.171201, 0.424451, 0.424451, 0.424451),
(3, '新北市', 0.557711, 0.557711, 0.557711, 0.0240794, 0.418209, 0.418209, 0.418209, 0.0240794, 0.0240794),
(4, '桃園市', 0.387647, 0.387647, 0.387647, 0.525765, 0.525765, 0.525765, 0.086588, 0.086588, 0.086588),
(5, '新竹市', 0.273295, 0.273295, 0.273295, 0.486048, 0.486048, 0.486048, 0.240657, 0.240657, 0.240657),
(6, '新竹縣', 0.371222, 0.371222, 0.371222, 0.268995, 0.268995, 0.268995, 0.359783, 0.359783, 0.359783),
(7, '苗栗縣', 0.55647, 0.55647, 0.55647, 0, 0, 0, 0.44353, 0.44353, 0.44353),
(8, '台中市', 0.55445, 0.55445, 0.55445, 0.415073, 0.415073, 0.415073, 0.0304775, 0.0304775, 0.0304775),
(9, '彰化縣', 0.516723, 0.516723, 0.516723, 0.387437, 0.387437, 0.387437, 0.0958399, 0.0958399, 0.0958399),
(10, '南投縣', 0.649966, 0.649966, 0.649966, 0.32421, 0.32421, 0.32421, 0.0258243, 0.0258243, 0.0258243),
(11, '雲林縣', 0.521131, 0.521131, 0.521131, 0.403823, 0.403823, 0.403823, 0.0750457, 0.0750457, 0.0750457),
(12, '嘉義市', 0.40515, 0.40515, 0.40515, 0.389223, 0.389223, 0.389223, 0.205626, 0.205626, 0.205626),
(13, '嘉義縣', 0.277783, 0.277783, 0.277783, 0.479073, 0.479073, 0.479073, 0.243144, 0.243144, 0.243144),
(14, '台南市', 0.315937, 0.315937, 0.315937, 0.371116, 0.371116, 0.371116, 0.312946, 0.312946, 0.312946),
(15, '高雄市', 0.532021, 0.532021, 0.532021, 0.442428, 0.442428, 0.442428, 0.0255512, 0.0255512, 0.0255512),
(16, '屏東縣', 0.403034, 0.403034, 0.403034, 0.53626, 0.53626, 0.53626, 0.0607067, 0.0607067, 0.0607067),
(17, '台東縣', 0.574797, 0.574797, 0.574797, 0.360497, 0.360497, 0.360497, 0.0647061, 0.0647061, 0.0647061),
(18, '花蓮縣', 0.695606, 0.695606, 0.695606, 0.251634, 0.251634, 0.251634, 0.0527596, 0.0527596, 0.0527596),
(19, '宜蘭縣', 0.479628, 0.479628, 0.479628, 0.370509, 0.370509, 0.370509, 0.149864, 0.149864, 0.149864),
(20, '澎湖縣', 0.377736, 0.377736, 0.377736, 0.318551, 0.318551, 0.318551, 0.303713, 0.303713, 0.303713),
(21, '金門縣', 0.466491, 0.466491, 0.466491, 0, 0, 0, 0.533509, 0.533509, 0.533509),
(22, '連江縣', 0.632778, 0.632778, 0.632778, 0, 0, 0, 0.367222, 0.367222, 0.367222);

-- --------------------------------------------------------

--
-- 資料表結構 `table2php_transform1`
--

CREATE TABLE `table2php_transform1` (
  `id` int(11) NOT NULL,
  `county` varchar(25) NOT NULL,
  `kmt_y` float NOT NULL,
  `kmt_m` float NOT NULL,
  `kmt_o` float NOT NULL,
  `dpp_y` float NOT NULL,
  `dpp_m` float NOT NULL,
  `dpp_o` float NOT NULL,
  `oth_y` float NOT NULL,
  `oth_m` float NOT NULL,
  `oth_o` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `table2php_transform1`
--

INSERT INTO `table2php_transform1` (`id`, `county`, `kmt_y`, `kmt_m`, `kmt_o`, `dpp_y`, `dpp_m`, `dpp_o`, `oth_y`, `oth_m`, `oth_o`) VALUES
(1, 'Lienchiang County', 0.146692, 0.503677, 0.816389, 0.599579, 0.145758, 0.183611, 0.253729, 0.350565, 0),
(2, 'Yilan County', 0.106474, 0.384586, 0.55456, 0.714453, 0.39984, 0.44544, 0.179074, 0.215574, 0),
(3, 'Changhua County', 0.112301, 0.398037, 0.564643, 0.704585, 0.400053, 0.435357, 0.183114, 0.201911, 0),
(4, 'Nantou County', 0.137783, 0.464251, 0.662878, 0.648262, 0.329011, 0.337122, 0.213955, 0.206738, 0),
(5, 'Yunlin County', 0.112466, 0.397561, 0.558654, 0.705832, 0.4084, 0.441346, 0.181702, 0.19404, 0),
(6, 'Pingtung County', 0.087077, 0.327847, 0.433387, 0.768613, 0.515595, 0.566613, 0.14431, 0.156558, 0),
(7, 'Taitung County', 0.123384, 0.426807, 0.60715, 0.680141, 0.369447, 0.39285, 0.196475, 0.203746, 0),
(8, 'Hualien County', 0.14838, 0.51232, 0.721986, 0.620398, 0.156813, 0.278014, 0.231222, 0.330866, 0),
(9, 'Penghu County', 0.0906688, 0.348428, 0.529593, 0.740638, 0.396094, 0.470407, 0.168693, 0.255478, 0),
(10, 'Keelung City', 0.0951291, 0.348103, 0.45954, 0.752005, 0.499645, 0.54046, 0.152866, 0.152252, 0),
(11, 'Hsinchu City', 0.0663672, 0.279506, 0.393623, 0.804639, 0.520057, 0.606377, 0.128994, 0.200437, 0),
(12, 'Taipei City', 0.101451, 0.381097, 0.616574, 0.719291, 0.30391, 0.383426, 0.179258, 0.314993, 0),
(13, 'New Taipei City', 0.117413, 0.411157, 0.569751, 0.675091, 0.407274, 0.430249, 0.207496, 0.181568, 0),
(14, 'Taichung City', 0.116726, 0.410213, 0.569689, 0.696816, 0.406301, 0.430311, 0.186458, 0.183486, 0),
(15, 'Tainan City', 0.0665131, 0.226909, 0.472411, 0.783388, 0.394057, 0.527589, 0.150099, 0.379033, 0),
(16, 'Taoyuan City', 0.305167, 0.205066, 0.430941, 0.545935, 0.232402, 0.569059, 0.148898, 0.562532, 0),
(17, 'Miaoli County', 0.133428, 0.470983, 0.778235, 0.625739, 0.16548, 0.221765, 0.240833, 0.363537, 0),
(18, 'Hsinchu County', 0.091355, 0.352789, 0.551113, 0.734529, 0.369088, 0.448887, 0.174116, 0.278122, 0),
(19, 'Chiayi City', 0.0928407, 0.551772, 0.507964, 0.743136, 0.150342, 0.492036, 0.164023, 0.297886, 0),
(20, 'Chiayi County', 0.0674034, 0.282436, 0.399355, 0.801926, 0.514859, 0.600645, 0.130671, 0.202705, 0),
(21, 'Kaohsiung City', 0, 0.396655, 0.544797, 0.669825, 0.427935, 0.455203, 0.330175, 0.17541, 0),
(22, 'Kinmen County', 0.117787, 0.43243, 0.733245, 0.656587, 0.188735, 0.266755, 0.225626, 0.378834, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `table2php_transform2`
--

CREATE TABLE `table2php_transform2` (
  `id` int(11) NOT NULL,
  `county` varchar(5) NOT NULL,
  `kmt_y` float NOT NULL,
  `kmt_m` float NOT NULL,
  `kmt_o` float NOT NULL,
  `dpp_y` float NOT NULL,
  `dpp_m` float NOT NULL,
  `dpp_o` float NOT NULL,
  `oth_y` float NOT NULL,
  `oth_m` float NOT NULL,
  `oth_o` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `table2php_transform2`
--

INSERT INTO `table2php_transform2` (`id`, `county`, `kmt_y`, `kmt_m`, `kmt_o`, `dpp_y`, `dpp_m`, `dpp_o`, `oth_y`, `oth_m`, `oth_o`) VALUES
(1, '連江縣', 0.146692, 0.503677, 0.816389, 0.599579, 0.18248, 0.183611, 0.253729, 0.313843, 0),
(2, '宜蘭縣', 0.106474, 0.384586, 0.55456, 0.714453, 0.414826, 0.44544, 0.179074, 0.200588, 0),
(3, '彰化縣', 0.112301, 0.398037, 0.564643, 0.704585, 0.409637, 0.435357, 0.183114, 0.192327, 0),
(4, '南投縣', 0.137783, 0.464251, 0.662878, 0.648262, 0.331593, 0.337122, 0.213955, 0.204156, 0),
(5, '雲林縣', 0.112466, 0.397561, 0.558654, 0.705832, 0.415904, 0.441346, 0.181702, 0.186535, 0),
(6, '屏東縣', 0.087077, 0.327847, 0.433387, 0.768613, 0.521665, 0.566613, 0.14431, 0.150488, 0),
(7, '臺東縣', 0.123384, 0.426807, 0.60715, 0.680141, 0.375918, 0.39285, 0.196475, 0.197276, 0),
(8, '花蓮縣', 0.14838, 0.51232, 0.721986, 0.620398, 0.156813, 0.278014, 0.231222, 0.330866, 0),
(9, '澎湖縣', 0.0906688, 0.348428, 0.529593, 0.740638, 0.426465, 0.470407, 0.168693, 0.225106, 0),
(10, '基隆市', 0.0951291, 0.348103, 0.45954, 0.752005, 0.502003, 0.54046, 0.152866, 0.149895, 0),
(11, '新竹市', 0.0663672, 0.279506, 0.393623, 0.804639, 0.544123, 0.606377, 0.128994, 0.176371, 0),
(12, '臺北市', 0.101451, 0.381097, 0.616574, 0.719291, 0.346355, 0.383426, 0.179258, 0.272548, 0),
(13, '新北市', 0.117413, 0.411157, 0.569751, 0.675091, 0.409682, 0.430249, 0.207496, 0.179161, 0),
(14, '臺中市', 0.116726, 0.410213, 0.569689, 0.696816, 0.409349, 0.430311, 0.186458, 0.180438, 0),
(15, '臺南市', 0.0665131, 0.226909, 0.472411, 0.783388, 0.394057, 0.527589, 0.150099, 0.379033, 0),
(16, '桃園市', 0.305167, 0.205066, 0.430941, 0.545935, 0.232402, 0.569059, 0.148898, 0.562532, 0),
(17, '苗栗縣', 0.133428, 0.470983, 0.778235, 0.625739, 0.209833, 0.221765, 0.240833, 0.319184, 0),
(18, '新竹縣', 0.091355, 0.352789, 0.551113, 0.734529, 0.405067, 0.448887, 0.174116, 0.242144, 0),
(19, '嘉義市', 0.0928407, 0.551772, 0.507964, 0.743136, 0.150342, 0.492036, 0.164023, 0.297886, 0),
(20, '嘉義縣', 0.0674034, 0.282436, 0.399355, 0.801926, 0.539173, 0.600645, 0.130671, 0.178391, 0),
(21, '高雄市', 0, 0.396655, 0.544797, 0.669825, 0.43049, 0.455203, 0.330175, 0.172855, 0),
(22, '金門縣', 0.117787, 0.43243, 0.733245, 0.656587, 0.242086, 0.266755, 0.225626, 0.325483, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `table 7`
--

CREATE TABLE `table 7` (
  `COL 1` int(2) DEFAULT NULL,
  `COL 2` varchar(3) DEFAULT NULL,
  `COL 3` int(2) DEFAULT NULL,
  `COL 4` int(2) DEFAULT NULL,
  `COL 5` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `table 7`
--

INSERT INTO `table 7` (`COL 1`, `COL 2`, `COL 3`, `COL 4`, `COL 5`) VALUES
(1, '基隆市', 0, 3, 0),
(2, '臺北市', 1, 23, 5),
(3, '新北市', 0, 33, 2),
(4, '桃園市', 12, 12, 18),
(5, '新竹市', 2, 3, 2),
(6, '新竹縣', 0, 3, 1),
(7, '苗栗縣', 1, 5, 0),
(8, '台中市', 3, 19, 4),
(9, '彰化縣', 1, 7, 2),
(10, '南投縣', 0, 1, 0),
(11, '雲林縣', 0, 3, 0),
(12, '嘉義市', 15, 5, 4),
(13, '嘉義縣', 2, 2, 4),
(14, '台南市', 19, 40, 23),
(15, '高雄市', 2, 22, 5),
(16, '屏東縣', 0, 3, 1),
(17, '台東縣', 0, 1, 0),
(18, '花蓮縣', 8, 7, 4),
(19, '宜蘭縣', 0, 1, 0),
(20, '澎湖縣', 0, 0, 0),
(21, '金門縣', 0, 3, 0),
(22, '連江縣', 0, 0, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `table 8`
--

CREATE TABLE `table 8` (
  `COL 1` varchar(2) DEFAULT NULL,
  `COL 2` varchar(13) DEFAULT NULL,
  `COL 3` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `table 8`
--

INSERT INTO `table 8` (`COL 1`, `COL 2`, `COL 3`) VALUES
('Id', 'WillingToVote', 'NUM'),
('1', '4.33', '3'),
('2', '4.72', '25'),
('3', '4.848', '33'),
('4', '5', '8'),
('5', '4.25', '4'),
('6', '4', '4'),
('7', '5', '5'),
('8', '4.9', '20'),
('9', '4.86', '7'),
('10', '5', '1'),
('11', '4.33', '3'),
('12', '4.67', '6'),
('13', '5', '3'),
('14', '4.6875', '16'),
('15', '4.54', '24'),
('16', '4.25', '4'),
('17', '5', '1'),
('18', '5', '2'),
('19', '5', '1'),
('20', '0', '0'),
('21', '5', '2'),
('22', '0', '0');

-- --------------------------------------------------------

--
-- 資料表結構 `testdata`
--

CREATE TABLE `testdata` (
  `id` int(11) NOT NULL,
  `KMT_o` float NOT NULL,
  `DPP_o` float NOT NULL,
  `OTH_o` float NOT NULL,
  `KMT_m` float NOT NULL,
  `DPP_m` float NOT NULL,
  `OTH_m` float NOT NULL,
  `KMT_y` float NOT NULL,
  `DPP_y` float NOT NULL,
  `OTH_y` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `testdata`
--

INSERT INTO `testdata` (`id`, `KMT_o`, `DPP_o`, `OTH_o`, `KMT_m`, `DPP_m`, `OTH_m`, `KMT_y`, `DPP_y`, `OTH_y`) VALUES
(1, 0.33, 0.47, 0.2, 0.44, 0.36, 0.2, 0.41, 0.32, 0.27);

-- --------------------------------------------------------

--
-- 資料表結構 `will2vote`
--

CREATE TABLE `will2vote` (
  `id` int(11) NOT NULL,
  `county` varchar(25) NOT NULL,
  `WillingToVote` float NOT NULL,
  `NUM` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `will2vote`
--

INSERT INTO `will2vote` (`id`, `county`, `WillingToVote`, `NUM`) VALUES
(1, 'Lienchiang County', 0, 0),
(2, 'Yilan County', 5, 1),
(3, 'Changhua County', 4.86, 7),
(4, 'Nantou County', 5, 1),
(5, 'Yunlin County', 4.33, 3),
(6, 'Pingtung County', 4.25, 4),
(7, 'Taitung County', 5, 1),
(8, 'Hualien County', 5, 2),
(9, 'Penghu County', 0, 0),
(10, 'Keelung City', 4.33, 3),
(11, 'Hsinchu City', 4.25, 4),
(12, 'Taipei City', 4.72, 25),
(13, 'New Taipei City', 4.848, 33),
(14, 'Taichung City', 4.9, 20),
(15, 'Tainan City', 4.6875, 16),
(16, 'Taoyuan City', 5, 8),
(17, 'Miaoli County', 5, 5),
(18, 'Hsinchu County', 4, 4),
(19, 'Chiayi City', 4.67, 6),
(20, 'Chiayi County', 5, 3),
(21, 'Kaohsiung City', 4.54, 24),
(22, 'Kinmen County', 5, 2);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `final`
--
ALTER TABLE `final`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `party`
--
ALTER TABLE `party`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `population`
--
ALTER TABLE `population`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `population_backup`
--
ALTER TABLE `population_backup`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `questionnaireparty`
--
ALTER TABLE `questionnaireparty`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `table2php`
--
ALTER TABLE `table2php`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `table2php_faketest`
--
ALTER TABLE `table2php_faketest`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `table2php_transform1`
--
ALTER TABLE `table2php_transform1`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `table2php_transform2`
--
ALTER TABLE `table2php_transform2`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `testdata`
--
ALTER TABLE `testdata`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `will2vote`
--
ALTER TABLE `will2vote`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `final`
--
ALTER TABLE `final`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `party`
--
ALTER TABLE `party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `population`
--
ALTER TABLE `population`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `population_backup`
--
ALTER TABLE `population_backup`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `questionnaireparty`
--
ALTER TABLE `questionnaireparty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `table2php`
--
ALTER TABLE `table2php`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `table2php_faketest`
--
ALTER TABLE `table2php_faketest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `table2php_transform1`
--
ALTER TABLE `table2php_transform1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `table2php_transform2`
--
ALTER TABLE `table2php_transform2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `testdata`
--
ALTER TABLE `testdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `will2vote`
--
ALTER TABLE `will2vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
