-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-04-2017 a las 00:09:33
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activations`
--

CREATE TABLE `activations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas`
--

CREATE TABLE `cuotas` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_venta` int(10) UNSIGNED NOT NULL,
  `importe` double NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `nro_cuota` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cuotas`
--

INSERT INTO `cuotas` (`id`, `created_at`, `updated_at`, `id_venta`, `importe`, `fecha_vencimiento`, `nro_cuota`, `deleted_at`) VALUES
(3, '2017-04-08 00:12:19', '2017-04-08 00:12:19', 4, 40, '2017-04-30', 1, NULL),
(4, '2017-04-08 00:12:19', '2017-04-08 00:12:19', 4, 40, '2017-05-30', 2, NULL),
(5, '2017-04-08 00:12:19', '2017-04-08 00:12:19', 4, 40, '2017-06-29', 3, NULL),
(6, '2017-04-08 00:12:19', '2017-04-08 00:12:19', 4, 40, '2017-07-29', 4, NULL),
(7, '2017-04-08 00:12:19', '2017-04-08 00:12:19', 4, 40, '2017-08-28', 5, NULL),
(8, '2017-04-09 20:38:12', '2017-04-09 20:38:12', 5, 25, '2017-04-30', 1, NULL),
(9, '2017-04-09 20:38:12', '2017-04-09 20:38:12', 5, 25, '2017-05-30', 2, NULL),
(10, '2017-04-09 20:38:12', '2017-04-09 20:38:12', 5, 25, '2017-06-29', 3, NULL),
(11, '2017-04-09 20:38:12', '2017-04-09 20:38:12', 5, 25, '2017-07-29', 4, NULL),
(18, '2017-04-10 19:32:08', '2017-04-10 19:32:08', 8, 100, '2017-04-30', 1, NULL),
(19, '2017-04-10 19:32:08', '2017-04-10 19:32:08', 8, 100, '2017-05-30', 2, NULL),
(20, '2017-04-10 19:32:08', '2017-04-10 19:32:08', 8, 100, '2017-06-29', 3, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_07_02_230147_migration_cartalyst_sentinel', 1),
(2, '2017_01_20_190905_create_a_b_m_organismos_table', 1),
(3, '2017_01_20_200525_create_prioridades_table', 1),
(4, '2017_01_20_210151_create_proovedores_table', 1),
(5, '2017_01_25_235406_create_socios_table', 1),
(6, '2017_02_19_225125_create_pantallas_table', 1),
(7, '2017_03_04_030112_create_productos_table', 1),
(8, '2017_03_04_045316_create_ventas_table', 1),
(9, '2017_03_04_046515_create_cuotas_table', 1),
(10, '2017_04_07_174005_movimientos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_venta` int(10) UNSIGNED NOT NULL,
  `nro_cuota` int(11) NOT NULL,
  `entrada` double NOT NULL,
  `salida` double NOT NULL,
  `fecha` date NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `created_at`, `updated_at`, `id_venta`, `nro_cuota`, `entrada`, `salida`, `fecha`, `deleted_at`) VALUES
(1, NULL, NULL, 4, 1, 200, 0, '0000-00-00', NULL),
(2, NULL, NULL, 4, 2, 200, 0, '0000-00-00', NULL),
(3, NULL, NULL, 5, 1, 300, 0, '0000-00-00', NULL),
(4, NULL, NULL, 5, 1, 300, 0, '0000-00-00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organismos`
--

CREATE TABLE `organismos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cuit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cuota_social` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `organismos`
--

INSERT INTO `organismos` (`id`, `nombre`, `cuit`, `cuota_social`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Miss Talia Schmitt II', '56488434', 564, NULL, NULL, NULL),
(2, 'Blanca Weimann III', '81227339', 567, NULL, NULL, NULL),
(3, 'Mr. Dusty Sanford', '97864440', 541, NULL, NULL, NULL),
(4, 'Woodrow Rolfson Sr.', '36666923', 836, NULL, NULL, NULL),
(5, 'Prof. Anne Kuvalis', '38923159', 375, NULL, NULL, NULL),
(6, 'Lia Auer DVM', '53020132', 834, NULL, NULL, NULL),
(7, 'Modesto Keebler', '48027731', 651, NULL, NULL, NULL),
(8, 'Tomas Streich', '99633884', 362, NULL, NULL, NULL),
(9, 'Ms. Ashleigh Gleason', '75712109', 917, NULL, NULL, NULL),
(10, 'Timmy Feest', '21530051', 753, NULL, NULL, NULL),
(11, 'Isom Torp', '65177125', 278, NULL, NULL, NULL),
(12, 'Dylan Glover', '11750616', 311, NULL, NULL, NULL),
(13, 'Eliza Lowe', '98989583', 712, NULL, NULL, NULL),
(14, 'Therese Leuschke', '94730606', 503, NULL, NULL, NULL),
(15, 'Mrs. Tiana Lueilwitz Jr.', '84733851', 115, NULL, NULL, NULL),
(16, 'Mr. Talon Monahan', '9355323', 957, NULL, NULL, NULL),
(17, 'Easton Morar', '31272818', 42, NULL, NULL, NULL),
(18, 'Dalton Wisozk', '72241995', 328, NULL, NULL, NULL),
(19, 'Mr. Eliezer Kautzer DDS', '83817469', 818, NULL, NULL, NULL),
(20, 'Dylan Bernhard', '45202173', 539, NULL, NULL, NULL),
(21, 'Gonzalo Reichert', '38114413', 767, NULL, NULL, NULL),
(22, 'Josianne Witting', '33005402', 422, NULL, NULL, NULL),
(23, 'Miss Emmie Volkman MD', '65090810', 191, NULL, NULL, NULL),
(24, 'Hanna Purdy', '49940695', 326, NULL, NULL, NULL),
(25, 'Dr. Letha Lowe', '41187190', 785, NULL, NULL, NULL),
(26, 'Kaci Cole', '72921994', 524, NULL, NULL, NULL),
(27, 'Dr. Margaretta Kutch MD', '87790598', 217, NULL, NULL, NULL),
(28, 'Damon Marquardt', '32599037', 162, NULL, NULL, NULL),
(29, 'Hellen Dach', '50926935', 239, NULL, NULL, NULL),
(30, 'Alisha Raynor', '24272208', 546, NULL, NULL, NULL),
(31, 'Alyce Rosenbaum', '51832562', 561, NULL, NULL, NULL),
(32, 'Eldora Wintheiser', '96795335', 406, NULL, NULL, NULL),
(33, 'Keon Prohaska', '45194603', 619, NULL, NULL, NULL),
(34, 'Dr. Marjorie Bayer', '45887082', 276, NULL, NULL, NULL),
(35, 'Amina Hettinger', '74951367', 395, NULL, NULL, NULL),
(36, 'Ms. Makenzie Roberts', '361573', 624, NULL, NULL, NULL),
(37, 'Cheyenne Harber', '26619681', 861, NULL, NULL, NULL),
(38, 'Korbin Dare', '19781335', 560, NULL, NULL, NULL),
(39, 'Oswald Kunde', '96849069', 372, NULL, NULL, NULL),
(40, 'Coy Rice V', '47002696', 941, NULL, NULL, NULL),
(41, 'Juvenal Boehm', '17697509', 220, NULL, NULL, NULL),
(42, 'Etha Conroy', '95860422', 863, NULL, NULL, NULL),
(43, 'Dr. Shawn Breitenberg', '15629012', 373, NULL, NULL, NULL),
(44, 'Prof. Julian Kuhlman I', '17084081', 763, NULL, NULL, NULL),
(45, 'Gianni Koepp V', '79982055', 890, NULL, NULL, NULL),
(46, 'Ferne Goodwin', '69983817', 155, NULL, NULL, NULL),
(47, 'Dr. Archibald Sauer', '65101522', 890, NULL, NULL, NULL),
(48, 'Dr. Alford Fadel Sr.', '56655548', 132, NULL, NULL, NULL),
(49, 'Prof. Santino Auer', '34125718', 252, NULL, NULL, NULL),
(50, 'Lorena Nitzsche', '45805928', 155, NULL, NULL, NULL),
(51, 'Prof. Birdie Satterfield', '96147815', 987, NULL, NULL, NULL),
(52, 'Gilda Mayert', '32723937', 334, NULL, NULL, NULL),
(53, 'Myrtle Hirthe', '2555093', 457, NULL, NULL, NULL),
(54, 'Prof. Shannon Schuppe PhD', '1834528', 845, NULL, NULL, NULL),
(55, 'Aiden Rowe', '9088044', 608, NULL, NULL, NULL),
(56, 'Tania Tillman', '97919237', 913, NULL, NULL, NULL),
(57, 'Mr. Ferne Lockman', '34259867', 664, NULL, NULL, NULL),
(58, 'Ward Homenick', '97082947', 241, NULL, NULL, NULL),
(59, 'Mrs. Edna Bergnaum MD', '23779211', 381, NULL, NULL, NULL),
(60, 'Prof. Nash Renner MD', '22993125', 572, NULL, NULL, NULL),
(61, 'Moshe Lueilwitz', '66469094', 89, NULL, NULL, NULL),
(62, 'Clint Blick', '10120170', 564, NULL, NULL, NULL),
(63, 'Andrew Barton Jr.', '59202943', 116, NULL, NULL, NULL),
(64, 'Nash Heller', '50601814', 482, NULL, NULL, NULL),
(65, 'Lindsay Sawayn Sr.', '78151342', 443, NULL, NULL, NULL),
(66, 'Dr. Imani Hoppe II', '24378486', 495, NULL, NULL, NULL),
(67, 'Russel Parisian', '90003456', 755, NULL, NULL, NULL),
(68, 'Alanna D''Amore I', '40827106', 142, NULL, NULL, NULL),
(69, 'Rod Kozey', '30705712', 668, NULL, NULL, NULL),
(70, 'Jacklyn Barton I', '76336217', 410, NULL, NULL, NULL),
(71, 'Mr. Marco Franecki', '38523803', 58, NULL, NULL, NULL),
(72, 'Ruthe Gutkowski', '62368377', 616, NULL, NULL, NULL),
(73, 'Yesenia Goldner', '9166958', 398, NULL, NULL, NULL),
(74, 'Martin McCullough Sr.', '21907715', 813, NULL, NULL, NULL),
(75, 'Lila Stark', '99596584', 797, NULL, NULL, NULL),
(76, 'Aniya Bednar', '18462085', 700, NULL, NULL, NULL),
(77, 'Shanny Schowalter', '54633213', 342, NULL, NULL, NULL),
(78, 'Ms. Dawn Fadel IV', '71140504', 122, NULL, NULL, NULL),
(79, 'Braden Mertz', '52568975', 262, NULL, NULL, NULL),
(80, 'Ms. Isabelle Bashirian', '6439444', 462, NULL, NULL, NULL),
(81, 'Prof. Faustino Schaefer I', '20735234', 13, NULL, NULL, NULL),
(82, 'Orlando Collins', '36507804', 386, NULL, NULL, NULL),
(83, 'Vella Franecki', '50724095', 769, NULL, NULL, NULL),
(84, 'Dortha Hegmann', '68889216', 170, NULL, NULL, NULL),
(85, 'Bertram Langworth PhD', '54016609', 597, NULL, NULL, NULL),
(86, 'Prof. Juvenal Corwin II', '11206642', 914, NULL, NULL, NULL),
(87, 'Mr. Herman Hansen', '17670344', 206, NULL, NULL, NULL),
(88, 'Frida Gerlach', '20666777', 588, NULL, NULL, NULL),
(89, 'Rodolfo Morar', '1951630', 409, NULL, NULL, NULL),
(90, 'Schuyler Koss Sr.', '7390057', 414, NULL, NULL, NULL),
(91, 'Dr. Lesly Murphy', '8198055', 296, NULL, NULL, NULL),
(92, 'Mrs. Sharon Koch DVM', '78549682', 762, NULL, NULL, NULL),
(93, 'Dr. Carmelo Gusikowski DDS', '50430530', 107, NULL, NULL, NULL),
(94, 'Miss Destany Tremblay V', '66911399', 640, NULL, NULL, NULL),
(95, 'Lane Gorczany', '21925042', 628, NULL, NULL, NULL),
(96, 'Ms. Emelia Dooley Sr.', '92464356', 451, NULL, NULL, NULL),
(97, 'Giovanni Veum', '35756722', 992, NULL, NULL, NULL),
(98, 'Markus Tromp', '89917196', 835, NULL, NULL, NULL),
(99, 'Mrs. Sincere Anderson', '29115405', 905, NULL, NULL, NULL),
(100, 'Prof. German Larson', '34278322', 972, NULL, NULL, NULL),
(101, 'Miss Celine Hudson II', '82149315', 542, NULL, NULL, NULL),
(102, 'Jevon Cruickshank MD', '85178052', 646, NULL, NULL, NULL),
(103, 'Mr. Dave Altenwerth I', '76014060', 578, NULL, NULL, NULL),
(104, 'Dorcas Hoppe II', '52904071', 776, NULL, NULL, NULL),
(105, 'Roxane Kessler', '10573241', 202, NULL, NULL, NULL),
(106, 'Anabelle Smith', '13674313', 518, NULL, NULL, NULL),
(107, 'Kelley Crona DDS', '78140666', 505, NULL, NULL, NULL),
(108, 'Prof. Maurine Wintheiser', '33745577', 848, NULL, NULL, NULL),
(109, 'Ms. Elsie Mertz DVM', '37534794', 93, NULL, NULL, NULL),
(110, 'Viola Heidenreich', '90386293', 663, NULL, NULL, NULL),
(111, 'Carlie Roob I', '18185696', 449, NULL, NULL, NULL),
(112, 'Leanne Bernhard', '70625344', 316, NULL, NULL, NULL),
(113, 'Prof. Jeromy Hoeger', '16996639', 395, NULL, NULL, NULL),
(114, 'Esperanza Howe', '77990070', 400, NULL, NULL, NULL),
(115, 'Aida Koss IV', '68994190', 918, NULL, NULL, NULL),
(116, 'Carlo Christiansen', '85738990', 498, NULL, NULL, NULL),
(117, 'Mr. Orin Schneider DVM', '46659668', 444, NULL, NULL, NULL),
(118, 'Ilene Fadel', '61711661', 580, NULL, NULL, NULL),
(119, 'Johan Hamill PhD', '96044975', 696, NULL, NULL, NULL),
(120, 'Rolando Waters', '96695883', 698, NULL, NULL, NULL),
(121, 'Gerald Rippin DDS', '43028156', 929, NULL, NULL, NULL),
(122, 'Shayna Fahey DVM', '4471672', 884, NULL, NULL, NULL),
(123, 'Mrs. Ettie Langosh MD', '68401143', 673, NULL, NULL, NULL),
(124, 'Jaquan Abernathy', '3990864', 148, NULL, NULL, NULL),
(125, 'Susanna Monahan', '31993343', 905, NULL, NULL, NULL),
(126, 'Maureen McCullough', '56579896', 297, NULL, NULL, NULL),
(127, 'Wilma Zieme III', '42512454', 881, NULL, NULL, NULL),
(128, 'Luisa McDermott', '55922186', 477, NULL, NULL, NULL),
(129, 'Ms. Dakota Beier DVM', '84514541', 187, NULL, NULL, NULL),
(130, 'Otilia Lynch', '96626685', 36, NULL, NULL, NULL),
(131, 'Zoie Kunde', '97071450', 92, NULL, NULL, NULL),
(132, 'Bernie Lowe', '18900151', 407, NULL, NULL, NULL),
(133, 'Lucie Homenick', '30791100', 894, NULL, NULL, NULL),
(134, 'Delphine Barton', '24118626', 113, NULL, NULL, NULL),
(135, 'Michael Auer', '88998049', 484, NULL, NULL, NULL),
(136, 'Dorcas Wilkinson', '2955618', 766, NULL, NULL, NULL),
(137, 'Eugenia Bailey', '86009105', 95, NULL, NULL, NULL),
(138, 'Mckayla Beer', '19952976', 391, NULL, NULL, NULL),
(139, 'Ashley Steuber DVM', '87611325', 748, NULL, NULL, NULL),
(140, 'Kaitlin Lubowitz', '82135327', 761, NULL, NULL, NULL),
(141, 'Alivia Kuphal', '96396175', 51, NULL, NULL, NULL),
(142, 'Brayan Abshire', '59351556', 695, NULL, NULL, NULL),
(143, 'Dr. Nickolas Bergstrom', '76774005', 761, NULL, NULL, NULL),
(144, 'Dorthy Hirthe', '53612942', 454, NULL, NULL, NULL),
(145, 'Malachi Kuhn', '25704831', 759, NULL, NULL, NULL),
(146, 'Prof. Vern Kuvalis IV', '90535627', 963, NULL, NULL, NULL),
(147, 'Prof. Stefan Strosin', '51059524', 351, NULL, NULL, NULL),
(148, 'Demario Sawayn Sr.', '29811922', 723, NULL, NULL, NULL),
(149, 'Astrid Runolfsdottir Jr.', '51774235', 70, NULL, NULL, NULL),
(150, 'Anjali Swift', '44377558', 257, NULL, NULL, NULL),
(151, 'Dr. Julio Bechtelar', '59617720', 248, NULL, NULL, NULL),
(152, 'Miss Myrtice Von', '35208315', 451, NULL, NULL, NULL),
(153, 'Prof. Joanie Grimes', '26759007', 172, NULL, NULL, NULL),
(154, 'Melvin O''Reilly', '71392873', 997, NULL, NULL, NULL),
(155, 'Miss Flavie Rippin', '73851178', 717, NULL, NULL, NULL),
(156, 'Derek Hyatt', '79174597', 704, NULL, NULL, NULL),
(157, 'Dr. Dejon Feeney PhD', '72020063', 368, NULL, NULL, NULL),
(158, 'Gertrude Schneider', '15552109', 28, NULL, NULL, NULL),
(159, 'Jaquelin Reinger', '53690739', 109, NULL, NULL, NULL),
(160, 'Loren Heidenreich', '34313178', 220, NULL, NULL, NULL),
(161, 'Lavern Daugherty DVM', '32642832', 241, NULL, NULL, NULL),
(162, 'Dr. Glennie Greenfelder', '92342415', 670, NULL, NULL, NULL),
(163, 'Prof. Melany Runolfsdottir PhD', '50539209', 538, NULL, NULL, NULL),
(164, 'Rachelle Abernathy', '80356946', 282, NULL, NULL, NULL),
(165, 'Dr. Daren Witting II', '12742755', 778, NULL, NULL, NULL),
(166, 'Vita Beahan DDS', '69145279', 741, NULL, NULL, NULL),
(167, 'Prof. Floy Langosh I', '95465554', 228, NULL, NULL, NULL),
(168, 'Jess Sawayn', '65388680', 500, NULL, NULL, NULL),
(169, 'Roselyn Dach', '45008974', 970, NULL, NULL, NULL),
(170, 'Morgan Conn', '36481835', 609, NULL, NULL, NULL),
(171, 'Dr. Andres Zemlak PhD', '6368602', 419, NULL, NULL, NULL),
(172, 'Dr. Crawford Wehner Jr.', '19588391', 250, NULL, NULL, NULL),
(173, 'Prof. Elijah Hettinger', '55405178', 534, NULL, NULL, NULL),
(174, 'Cecil Gleichner', '72231252', 846, NULL, NULL, NULL),
(175, 'Omer Hyatt', '41241087', 812, NULL, NULL, NULL),
(176, 'Prof. Aileen Ritchie PhD', '4090777', 976, NULL, NULL, NULL),
(177, 'Mr. Holden Buckridge PhD', '71937618', 667, NULL, NULL, NULL),
(178, 'Casey Daugherty', '69122883', 138, NULL, NULL, NULL),
(179, 'Michael Jerde', '7465225', 906, NULL, NULL, NULL),
(180, 'Tevin Rempel', '46806980', 694, NULL, NULL, NULL),
(181, 'Prof. Caden Satterfield II', '93139185', 777, NULL, NULL, NULL),
(182, 'Candida Douglas', '26079659', 504, NULL, NULL, NULL),
(183, 'Kari Hand', '1743343', 823, NULL, NULL, NULL),
(184, 'Fiona Hane', '10811789', 682, NULL, NULL, NULL),
(185, 'Dr. Rosella Wolff II', '5091785', 255, NULL, NULL, NULL),
(186, 'Karina Ernser', '86276826', 614, NULL, NULL, NULL),
(187, 'Miss Nyah Ratke', '92221106', 988, NULL, NULL, NULL),
(188, 'Prof. Irma Johns V', '61832802', 584, NULL, NULL, NULL),
(189, 'Autumn Lesch', '70845038', 625, NULL, NULL, NULL),
(190, 'Trycia Leuschke', '23161271', 90, NULL, NULL, NULL),
(191, 'Marjory Morar', '54166430', 411, NULL, NULL, NULL),
(192, 'Mrs. Alayna Wintheiser', '52981343', 981, NULL, NULL, NULL),
(193, 'Miss Anabel Schoen', '66690866', 137, NULL, NULL, NULL),
(194, 'Alvah Mraz', '56904595', 643, NULL, NULL, NULL),
(195, 'Ms. Aditya Buckridge I', '14773843', 633, NULL, NULL, NULL),
(196, 'Prof. Justus Konopelski', '54089279', 466, NULL, NULL, NULL),
(197, 'Jodie Treutel', '81484590', 960, NULL, NULL, NULL),
(198, 'Meggie Kutch', '75505331', 905, NULL, NULL, NULL),
(199, 'Ava Mraz', '502460', 612, NULL, NULL, NULL),
(200, 'Casimir Herman MD', '18107172', 962, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pantallas`
--

CREATE TABLE `pantallas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permiso` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persistences`
--

CREATE TABLE `persistences` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prioridades`
--

CREATE TABLE `prioridades` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `orden` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `prioridades`
--

INSERT INTO `prioridades` (`id`, `deleted_at`, `nombre`, `orden`, `created_at`, `updated_at`) VALUES
(1, NULL, 'alta', 1, '2017-04-07 21:45:05', '2017-04-07 21:45:20'),
(2, NULL, 'media', 2, '2017-04-07 21:45:09', '2017-04-07 21:45:20'),
(3, NULL, 'baja', 3, '2017-04-07 21:45:12', '2017-04-07 21:45:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_proovedor` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `precio` int(11) NOT NULL,
  `retencion` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `created_at`, `updated_at`, `id_proovedor`, `descripcion`, `precio`, `retencion`, `nombre`, `deleted_at`) VALUES
(1, NULL, NULL, 3, '', 0, 50, 'muñeco', NULL),
(2, NULL, NULL, 4, '', 0, 50, 'pum', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proovedores`
--

CREATE TABLE `proovedores` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `porcentaje_retencion` int(11) NOT NULL,
  `porcentaje_gastos_administrativos` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `id_prioridad` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `proovedores`
--

INSERT INTO `proovedores` (`id`, `nombre`, `descripcion`, `porcentaje_retencion`, `porcentaje_gastos_administrativos`, `deleted_at`, `id_prioridad`, `created_at`, `updated_at`) VALUES
(3, 'joaquin', 'almaenero', 0, 0, NULL, 1, '2017-04-07 21:45:46', '2017-04-07 21:45:46'),
(4, 'francisco', '300', 0, 0, NULL, 2, '2017-04-07 21:45:57', '2017-04-07 21:45:57'),
(5, 'pablito', '202', 0, 0, NULL, 3, '2017-04-07 21:46:04', '2017-04-07 21:46:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reminders`
--

CREATE TABLE `reminders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_users`
--

CREATE TABLE `role_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socios`
--

CREATE TABLE `socios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `cuit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dni` int(11) NOT NULL,
  `domicilio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `localidad` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codigo_postal` int(11) NOT NULL,
  `telefono` int(11) NOT NULL,
  `id_organismo` int(10) UNSIGNED NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `legajo` int(11) NOT NULL,
  `grupo_familiar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `socios`
--

INSERT INTO `socios` (`id`, `nombre`, `fecha_nacimiento`, `cuit`, `dni`, `domicilio`, `localidad`, `codigo_postal`, `telefono`, `id_organismo`, `fecha_ingreso`, `legajo`, `grupo_familiar`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Cale Brekke IV', '0000-00-00', '', 0, '', '', 0, 0, 4, '0000-00-00', 0, '', NULL, NULL, NULL),
(2, 'Mathias Windler', '0000-00-00', '', 0, '', '', 0, 0, 2, '0000-00-00', 0, '', NULL, NULL, NULL),
(3, 'Melyna Harris', '0000-00-00', '', 0, '', '', 0, 0, 9, '0000-00-00', 0, '', NULL, NULL, NULL),
(4, 'Ricardo Douglas V', '0000-00-00', '', 0, '', '', 0, 0, 1, '0000-00-00', 0, '', NULL, NULL, NULL),
(5, 'Garrick Hartmann', '0000-00-00', '', 0, '', '', 0, 0, 8, '0000-00-00', 0, '', NULL, NULL, NULL),
(6, 'Nat Reinger', '0000-00-00', '', 0, '', '', 0, 0, 6, '0000-00-00', 0, '', NULL, NULL, NULL),
(7, 'Prof. Elta Ankunding', '0000-00-00', '', 0, '', '', 0, 0, 6, '0000-00-00', 0, '', NULL, NULL, NULL),
(8, 'Estefania D''Amore I', '0000-00-00', '', 0, '', '', 0, 0, 5, '0000-00-00', 0, '', NULL, NULL, NULL),
(9, 'Mrs. Alva Trantow IV', '0000-00-00', '', 0, '', '', 0, 0, 7, '0000-00-00', 0, '', NULL, NULL, NULL),
(10, 'Laurence Stamm', '0000-00-00', '', 0, '', '', 0, 0, 4, '0000-00-00', 0, '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `throttle`
--

CREATE TABLE `throttle` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `usuario` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_asociado` int(10) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL,
  `alta` int(10) UNSIGNED DEFAULT NULL,
  `aprobado` int(10) UNSIGNED DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nro_cuotas` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `created_at`, `updated_at`, `id_asociado`, `id_producto`, `alta`, `aprobado`, `descripcion`, `nro_cuotas`, `fecha`, `deleted_at`) VALUES
(4, '2017-04-08 00:12:19', '2017-04-08 00:12:19', 1, 1, NULL, NULL, '', 5, '0000-00-00', NULL),
(5, '2017-04-09 20:38:12', '2017-04-09 20:38:12', 1, 2, NULL, NULL, '', 4, '0000-00-00', NULL),
(8, '2017-04-10 19:32:08', '2017-04-10 19:32:08', 3, 2, NULL, NULL, '', 3, '0000-00-00', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activations`
--
ALTER TABLE `activations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuotas_id_venta_foreign` (`id_venta`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movimientos_id_venta_foreign` (`id_venta`);

--
-- Indices de la tabla `organismos`
--
ALTER TABLE `organismos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pantallas`
--
ALTER TABLE `pantallas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persistences`
--
ALTER TABLE `persistences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `persistences_code_unique` (`code`);

--
-- Indices de la tabla `prioridades`
--
ALTER TABLE `prioridades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_id_proovedor_foreign` (`id_proovedor`);

--
-- Indices de la tabla `proovedores`
--
ALTER TABLE `proovedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proovedores_id_prioridad_foreign` (`id_prioridad`);

--
-- Indices de la tabla `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indices de la tabla `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- Indices de la tabla `socios`
--
ALTER TABLE `socios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `socios_id_organismo_foreign` (`id_organismo`);

--
-- Indices de la tabla `throttle`
--
ALTER TABLE `throttle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `throttle_user_id_index` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_id_asociado_foreign` (`id_asociado`),
  ADD KEY `ventas_id_producto_foreign` (`id_producto`),
  ADD KEY `ventas_alta_foreign` (`alta`),
  ADD KEY `ventas_aprobado_foreign` (`aprobado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activations`
--
ALTER TABLE `activations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `organismos`
--
ALTER TABLE `organismos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;
--
-- AUTO_INCREMENT de la tabla `pantallas`
--
ALTER TABLE `pantallas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `persistences`
--
ALTER TABLE `persistences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `prioridades`
--
ALTER TABLE `prioridades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `proovedores`
--
ALTER TABLE `proovedores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `socios`
--
ALTER TABLE `socios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `throttle`
--
ALTER TABLE `throttle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD CONSTRAINT `cuotas_id_venta_foreign` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_id_venta_foreign` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_id_proovedor_foreign` FOREIGN KEY (`id_proovedor`) REFERENCES `proovedores` (`id`);

--
-- Filtros para la tabla `proovedores`
--
ALTER TABLE `proovedores`
  ADD CONSTRAINT `proovedores_id_prioridad_foreign` FOREIGN KEY (`id_prioridad`) REFERENCES `prioridades` (`id`);

--
-- Filtros para la tabla `socios`
--
ALTER TABLE `socios`
  ADD CONSTRAINT `socios_id_organismo_foreign` FOREIGN KEY (`id_organismo`) REFERENCES `organismos` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_alta_foreign` FOREIGN KEY (`alta`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ventas_aprobado_foreign` FOREIGN KEY (`aprobado`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ventas_id_asociado_foreign` FOREIGN KEY (`id_asociado`) REFERENCES `socios` (`id`),
  ADD CONSTRAINT `ventas_id_producto_foreign` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
