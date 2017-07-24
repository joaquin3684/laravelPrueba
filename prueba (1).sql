-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 19-05-2017 a las 14:46:09
-- Versión del servidor: 5.7.18-0ubuntu0.16.04.1
-- Versión de PHP: 7.0.15-0ubuntu0.16.04.4

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

--
-- Volcado de datos para la tabla `activations`
--

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'JlqO3VZjnHXC0ivEuoGr00iUYKkHdkak', 1, '2017-05-01 04:34:00', '2017-05-01 04:34:00', '2017-05-01 04:34:00');

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
  `fecha_inicio` date NOT NULL,
  `nro_cuota` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cuotas`
--

INSERT INTO `cuotas` (`id`, `created_at`, `updated_at`, `id_venta`, `importe`, `fecha_vencimiento`, `fecha_inicio`, `nro_cuota`, `deleted_at`) VALUES
(1, '2017-05-01 04:54:43', '2017-05-01 04:54:43', 2, 40, '2017-05-01', '2017-08-08', 1, NULL),
(2, '2017-05-01 04:54:43', '2017-05-01 04:54:43', 3, 40, '2017-05-31', '0000-00-00', 2, NULL),
(3, '2017-05-01 04:54:43', '2017-05-01 04:54:43', 4, 40, '2017-06-30', '0000-00-00', 3, NULL),
(4, '2017-05-01 04:54:43', '2017-05-01 04:54:43', 3, 40, '2017-07-30', '0000-00-00', 4, NULL),
(5, '2017-05-01 04:54:43', '2017-05-01 04:54:43', 2, 40, '2017-08-29', '0000-00-00', 5, NULL),
(6, '2017-05-01 05:24:49', '2017-05-01 05:24:49', 5, 100, '2017-05-01', '0000-00-00', 1, NULL),
(7, '2017-05-01 05:24:49', '2017-05-01 05:24:49', 5, 100, '2017-05-31', '0000-00-00', 2, NULL),
(8, '2017-05-01 05:24:49', '2017-05-01 05:24:49', 5, 100, '2017-06-30', '0000-00-00', 3, NULL),
(9, '2017-05-01 05:24:49', '2017-05-01 05:24:49', 5, 100, '2017-07-30', '0000-00-00', 4, NULL),
(10, '2017-05-01 05:24:49', '2017-05-01 05:24:49', 5, 100, '2017-08-29', '0000-00-00', 5, NULL),
(11, '2017-05-01 05:24:49', '2017-05-01 05:24:49', 5, 100, '2017-09-28', '0000-00-00', 6, NULL),
(12, '2017-05-01 05:24:49', '2017-05-01 05:24:49', 5, 100, '2017-10-28', '0000-00-00', 7, NULL),
(13, '2017-05-01 05:24:49', '2017-05-01 05:24:49', 5, 100, '2017-11-27', '0000-00-00', 8, NULL),
(14, '2017-05-09 04:49:32', '2017-05-09 04:49:32', 6, 50, '2017-05-25', '0000-00-00', 1, NULL),
(15, '2017-05-09 04:49:32', '2017-05-09 04:49:32', 6, 50, '2017-06-24', '0000-00-00', 2, NULL),
(16, '2017-05-17 22:40:46', '2017-05-17 22:40:46', 7, 50, '2017-06-01', '2017-05-17', 1, NULL),
(17, '2017-05-17 22:40:46', '2017-05-17 22:40:46', 7, 50, '2017-07-01', '2017-06-02', 2, NULL),
(18, '2017-05-17 22:40:46', '2017-05-17 22:40:46', 7, 50, '2017-07-31', '2017-07-02', 3, NULL),
(19, '2017-05-17 22:40:46', '2017-05-17 22:40:46', 7, 50, '2017-08-30', '2017-08-01', 4, NULL),
(20, '2017-05-17 22:40:46', '2017-05-17 22:40:46', 7, 50, '2017-09-29', '2017-08-31', 5, NULL),
(21, '2017-05-17 22:40:46', '2017-05-17 22:40:46', 7, 50, '2017-10-29', '2017-09-30', 6, NULL),
(22, '2017-05-17 22:40:46', '2017-05-17 22:40:46', 7, 50, '2017-11-28', '2017-10-30', 7, NULL),
(23, '2017-05-17 22:40:46', '2017-05-17 22:40:46', 7, 50, '2017-12-28', '2017-11-29', 8, NULL),
(24, '2017-05-17 22:40:46', '2017-05-17 22:40:46', 7, 50, '2018-01-27', '2017-12-29', 9, NULL),
(25, '2017-05-17 22:40:46', '2017-05-17 22:40:46', 7, 50, '2018-02-26', '2018-01-28', 10, NULL);

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
  `id_cuota` int(10) UNSIGNED NOT NULL,
  `entrada` double NOT NULL,
  `salida` double NOT NULL,
  `fecha` date NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `gastos_administrativos` double NOT NULL,
  `ganancia` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `created_at`, `updated_at`, `id_cuota`, `entrada`, `salida`, `fecha`, `deleted_at`, `gastos_administrativos`, `ganancia`) VALUES
(1, NULL, '2017-05-18 04:41:31', 2, 20, 16, '2017-05-08', NULL, 2, 2),
(2, NULL, '2017-05-18 04:41:31', 2, 20, 16, '2017-05-24', NULL, 2, 2),
(16, '2017-05-08 21:37:28', '2017-05-18 04:27:46', 1, 20, 0, '2017-05-08', NULL, 0, 0),
(17, '2017-05-08 21:39:51', '2017-05-18 04:27:46', 1, 20, 0, '2017-05-08', NULL, 0, 0),
(18, '2017-05-08 21:40:42', '2017-05-18 04:41:31', 3, 20, 16, '2017-05-08', NULL, 2, 2),
(19, '2017-05-09 00:32:26', '2017-05-18 04:41:31', 3, 10, 8, '2017-05-08', NULL, 1, 1),
(20, '2017-05-09 00:32:47', '2017-05-18 04:41:31', 6, 10, 8, '2017-05-08', NULL, 1, 1),
(21, '2017-05-09 00:34:30', '2017-05-18 04:41:31', 3, 10, 8, '2017-05-08', NULL, 1, 1),
(22, '2017-05-09 00:34:36', '2017-05-18 04:41:31', 6, 9, 7.2, '2017-05-08', NULL, 0.9, 0.9),
(23, '2017-05-10 04:48:02', '2017-05-18 04:41:31', 4, 10, 8, '2017-05-10', NULL, 1, 1),
(24, '2017-05-10 04:48:02', '2017-05-18 04:41:31', 6, 11, 8.8, '2017-05-10', NULL, 1.1, 1.1),
(25, '2017-05-11 03:19:58', '2017-05-18 04:41:31', 4, 12, 9.6, '2017-05-11', NULL, 1.2, 1.2),
(26, '2017-05-13 18:16:25', '2017-05-18 04:27:46', 1, 10, 0, '2017-05-13', NULL, 0, 0),
(27, '2017-05-13 18:16:25', '2017-05-18 04:41:31', 6, 10, 8, '2017-05-13', NULL, 1, 1),
(28, '2017-05-13 20:16:22', '2017-05-18 04:27:46', 1, 6, 0, '2017-05-13', NULL, 0, 0),
(29, '2017-05-13 20:16:22', '2017-05-18 04:41:31', 6, 6, 4.8, '2017-05-13', NULL, 0.6, 0.6),
(30, '2017-05-17 21:26:33', '2017-05-18 04:41:31', 2, 3, 2.4, '2017-05-17', NULL, 0.3, 0.3),
(31, '2017-05-17 21:28:25', '2017-05-18 04:41:31', 2, 1, 0.8, '2017-05-17', NULL, 0.1, 0.1),
(32, '2017-05-17 21:32:16', '2017-05-18 04:41:31', 2, 3, 2.4, '2017-05-17', NULL, 0.3, 0.3),
(33, '2017-05-17 21:32:42', '2017-05-18 04:41:31', 2, 10, 8, '2017-05-17', NULL, 1, 1),
(34, '2017-05-17 21:36:52', '2017-05-18 04:41:31', 2, 3, 2.4, '2017-05-17', NULL, 0.3, 0.3),
(35, '2017-05-17 21:56:09', '2017-05-18 04:41:31', 4, 12, 9.6, '2017-05-17', NULL, 1.2, 1.2),
(36, '2017-05-17 21:57:16', '2017-05-18 04:41:31', 4, 5, 4, '2017-05-17', NULL, 0.5, 0.5);

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
(1, 'Dessie Stehr', '2204449', 347, NULL, NULL, NULL),
(2, 'Cicero Maggio I', '35090164', 588, NULL, NULL, NULL),
(3, 'Raoul Reilly', '71854477', 531, NULL, NULL, NULL),
(4, 'Hortense King', '94055521', 387, NULL, NULL, NULL),
(5, 'Miss Irma Kreiger', '85850764', 566, NULL, NULL, NULL),
(6, 'Mr. Brian Hamill IV', '18923916', 573, NULL, NULL, NULL),
(7, 'Mac Cartwright', '94923819', 219, NULL, NULL, NULL),
(8, 'Elian Cormier', '14016314', 86, NULL, NULL, NULL),
(9, 'Javonte Raynor DVM', '95870425', 199, NULL, NULL, NULL),
(10, 'Dr. Gail Carroll', '88208289', 885, NULL, NULL, NULL),
(11, 'Mariane Haag V', '72899447', 936, NULL, NULL, NULL),
(12, 'Ruben Ferry', '69809629', 153, NULL, NULL, NULL),
(13, 'Landen Kreiger', '33028735', 417, NULL, NULL, NULL),
(14, 'Mr. Thaddeus DuBuque', '88811950', 588, NULL, NULL, NULL),
(15, 'Shania Effertz', '17131379', 655, NULL, NULL, NULL),
(16, 'Mr. Misael Stanton', '44645163', 252, NULL, NULL, NULL),
(17, 'Grayson Schneider', '53772340', 566, NULL, NULL, NULL),
(18, 'Judson Skiles', '17535266', 828, NULL, NULL, NULL),
(19, 'Anna Considine', '47240575', 453, NULL, NULL, NULL),
(20, 'Celestino Romaguera MD', '47632092', 376, NULL, NULL, NULL),
(21, 'Harry Thiel', '89557080', 282, NULL, NULL, NULL),
(22, 'Prof. Nadia Wuckert', '56863889', 469, NULL, NULL, NULL),
(23, 'Dr. Brody Terry II', '25934357', 790, NULL, NULL, NULL),
(24, 'Jennings Brakus IV', '52720712', 13, NULL, NULL, NULL),
(25, 'Roxane Littel', '94475820', 877, NULL, NULL, NULL),
(26, 'Therese Dooley I', '83784900', 870, NULL, NULL, NULL),
(27, 'Violet Strosin', '82186493', 881, NULL, NULL, NULL),
(28, 'Dr. Kaley Bayer MD', '60027483', 444, NULL, NULL, NULL),
(29, 'Mrs. Makayla Simonis PhD', '12567222', 818, NULL, NULL, NULL),
(30, 'Ana Hauck', '57408657', 165, NULL, NULL, NULL),
(31, 'Issac Roob', '44896175', 881, NULL, NULL, NULL),
(32, 'Mr. Bernhard Schultz PhD', '5812485', 574, NULL, NULL, NULL),
(33, 'Garrett Wyman', '49881494', 601, NULL, NULL, NULL),
(34, 'Ashlee Marvin', '50529788', 100, NULL, NULL, NULL),
(35, 'Lisette Paucek', '60230491', 383, NULL, NULL, NULL),
(36, 'Prof. Fred Bogisich', '69163384', 836, NULL, NULL, NULL),
(37, 'Jordyn Harber', '28312608', 151, NULL, NULL, NULL),
(38, 'April Stehr', '53567433', 316, NULL, NULL, NULL),
(39, 'Clotilde Herzog I', '29192617', 939, NULL, NULL, NULL),
(40, 'Logan Eichmann', '10709280', 146, NULL, NULL, NULL),
(41, 'Anthony Zulauf IV', '71173082', 122, NULL, NULL, NULL),
(42, 'Kaleigh Rempel', '95313334', 595, NULL, NULL, NULL),
(43, 'Mertie Oberbrunner Jr.', '22307464', 758, NULL, NULL, NULL),
(44, 'Mr. Elijah McClure', '40182306', 678, NULL, NULL, NULL),
(45, 'Sallie Johns MD', '14237324', 363, NULL, NULL, NULL),
(46, 'Elza O\'Hara', '79554274', 245, NULL, NULL, NULL),
(47, 'Ruth Schmitt I', '10168628', 827, NULL, NULL, NULL),
(48, 'Rachel Grady', '99399419', 374, NULL, NULL, NULL),
(49, 'Cade Rodriguez', '97449576', 673, NULL, NULL, NULL),
(50, 'Jimmy Dicki', '46742730', 405, NULL, NULL, NULL),
(51, 'Elmira Boyle', '44389636', 645, NULL, NULL, NULL),
(52, 'Miss Aaliyah Hand Sr.', '99080990', 336, NULL, NULL, NULL),
(53, 'Ms. Lyda Hilpert DDS', '48938661', 894, NULL, NULL, NULL),
(54, 'Dr. Ted Klein PhD', '5702063', 58, NULL, NULL, NULL),
(55, 'Dr. Lemuel Pouros DDS', '31913672', 845, NULL, NULL, NULL),
(56, 'Dr. Jacinthe McGlynn', '45870150', 114, NULL, NULL, NULL),
(57, 'Jammie McKenzie', '76596045', 540, NULL, NULL, NULL),
(58, 'Madelyn Huels', '44089058', 330, NULL, NULL, NULL),
(59, 'Madaline Schmeler', '55533353', 873, NULL, NULL, NULL),
(60, 'Jaron Raynor', '5619816', 453, NULL, NULL, NULL),
(61, 'Prof. Dax Cummings', '11658760', 362, NULL, NULL, NULL),
(62, 'Fidel Daugherty', '94090424', 256, NULL, NULL, NULL),
(63, 'Ms. Maeve Becker PhD', '14032083', 673, NULL, NULL, NULL),
(64, 'Roma Kozey', '82796971', 605, NULL, NULL, NULL),
(65, 'Elisa Kilback', '84182520', 793, NULL, NULL, NULL),
(66, 'Sally Bradtke', '35328256', 544, NULL, NULL, NULL),
(67, 'Prof. Casper Haley', '36380258', 991, NULL, NULL, NULL),
(68, 'Dr. Albert Eichmann', '92805037', 720, NULL, NULL, NULL),
(69, 'Dr. Justus Kulas MD', '31433578', 415, NULL, NULL, NULL),
(70, 'Nickolas Kemmer', '26562855', 685, NULL, NULL, NULL),
(71, 'Miss Nia Smitham', '73312698', 166, NULL, NULL, NULL),
(72, 'Dr. Antonette Mann', '52637091', 91, NULL, NULL, NULL),
(73, 'Orville Kerluke', '23240868', 763, NULL, NULL, NULL),
(74, 'Berta Kuhn II', '91482080', 7, NULL, NULL, NULL),
(75, 'Elody Moen', '2836784', 364, NULL, NULL, NULL),
(76, 'Dr. Deshaun Crist DVM', '88313142', 342, NULL, NULL, NULL),
(77, 'Jaren Marks', '76207861', 402, NULL, NULL, NULL),
(78, 'Polly Cormier', '90418254', 931, NULL, NULL, NULL),
(79, 'Miss Erika Herzog III', '70566380', 603, NULL, NULL, NULL),
(80, 'Felicia Pacocha', '87716626', 31, NULL, NULL, NULL),
(81, 'Dahlia Considine', '6520642', 684, NULL, NULL, NULL),
(82, 'Mr. Grant Hoppe I', '37496332', 275, NULL, NULL, NULL),
(83, 'Prof. Osbaldo Von', '51578042', 440, NULL, NULL, NULL),
(84, 'Lenny Moen II', '14768804', 815, NULL, NULL, NULL),
(85, 'Buck Fritsch', '16463979', 338, NULL, NULL, NULL),
(86, 'Shemar Bartell I', '91248568', 493, NULL, NULL, NULL),
(87, 'Vaughn Schmidt', '26236069', 109, NULL, NULL, NULL),
(88, 'Prof. Branson Welch', '10085540', 69, NULL, NULL, NULL),
(89, 'Larissa Gleichner', '54686599', 492, NULL, NULL, NULL),
(90, 'Garret Koss', '65570467', 724, NULL, NULL, NULL),
(91, 'Jimmy Baumbach', '85528774', 283, NULL, NULL, NULL),
(92, 'Christian Osinski', '44647332', 849, NULL, NULL, NULL),
(93, 'Prof. Enos Bartell Jr.', '470096', 194, NULL, NULL, NULL),
(94, 'Dr. Lonnie Abshire Jr.', '34929030', 678, NULL, NULL, NULL),
(95, 'Charity Nicolas Jr.', '97051262', 509, NULL, NULL, NULL),
(96, 'Mikayla Bode', '90607885', 258, NULL, NULL, NULL),
(97, 'Abby Kuhn Jr.', '88045875', 662, NULL, NULL, NULL),
(98, 'Prof. Marcella Okuneva DVM', '94725153', 621, NULL, NULL, NULL),
(99, 'Heather Parker', '24879596', 101, NULL, NULL, NULL),
(100, 'Sheridan Padberg', '56729203', 288, NULL, NULL, NULL),
(101, 'Anabel Fadel', '46698718', 974, NULL, NULL, NULL),
(102, 'Eino Langworth', '62185826', 793, NULL, NULL, NULL),
(103, 'Mrs. Lea Abshire DDS', '35153026', 401, NULL, NULL, NULL),
(104, 'Ms. Karen Johnston DVM', '12184082', 745, NULL, NULL, NULL),
(105, 'Coy Daugherty', '5214779', 930, NULL, NULL, NULL),
(106, 'Prof. Alan Hirthe I', '76220437', 801, NULL, NULL, NULL),
(107, 'Keshawn Rogahn', '67821879', 988, NULL, NULL, NULL),
(108, 'Billie Auer', '85022815', 467, NULL, NULL, NULL),
(109, 'Lucienne Shanahan', '10441106', 309, NULL, NULL, NULL),
(110, 'Domenick Waters', '93816001', 526, NULL, NULL, NULL),
(111, 'Dr. Cyrus Runolfsson', '20338395', 199, NULL, NULL, NULL),
(112, 'Fredrick Beahan', '22381797', 112, NULL, NULL, NULL),
(113, 'Hermina Doyle', '61532811', 768, NULL, NULL, NULL),
(114, 'Prof. Misael Graham', '88576167', 879, NULL, NULL, NULL),
(115, 'Alexanne Ward', '62955646', 729, NULL, NULL, NULL),
(116, 'Otis Orn II', '57667113', 547, NULL, NULL, NULL),
(117, 'Ms. Caleigh Lind Sr.', '45473495', 901, NULL, NULL, NULL),
(118, 'Buck Crooks', '72033608', 205, NULL, NULL, NULL),
(119, 'Rafael Waelchi Jr.', '5875157', 803, NULL, NULL, NULL),
(120, 'Mrs. Fabiola Fahey', '97477090', 465, NULL, NULL, NULL),
(121, 'Mr. Craig Mueller MD', '4291997', 12, NULL, NULL, NULL),
(122, 'Mr. Rogelio Stroman', '94668786', 839, NULL, NULL, NULL),
(123, 'Dr. Jordy Gibson DDS', '57214076', 897, NULL, NULL, NULL),
(124, 'Garland Schimmel DDS', '6600286', 933, NULL, NULL, NULL),
(125, 'Eve Heller', '56707729', 939, NULL, NULL, NULL),
(126, 'Anabel Halvorson', '33833545', 941, NULL, NULL, NULL),
(127, 'Charley Hilpert', '29499072', 269, NULL, NULL, NULL),
(128, 'Dr. Liliana Torp PhD', '3772027', 500, NULL, NULL, NULL),
(129, 'Samir Purdy', '19746855', 435, NULL, NULL, NULL),
(130, 'Itzel Auer', '8621705', 434, NULL, NULL, NULL),
(131, 'Tre Johnston', '98309261', 846, NULL, NULL, NULL),
(132, 'Prof. Destany Kub', '20338758', 952, NULL, NULL, NULL),
(133, 'Ms. Romaine Murazik III', '86651428', 702, NULL, NULL, NULL),
(134, 'Darrion Hoeger PhD', '82569251', 120, NULL, NULL, NULL),
(135, 'Jedediah Jacobs', '20173399', 523, NULL, NULL, NULL),
(136, 'Ocie Borer', '43544856', 346, NULL, NULL, NULL),
(137, 'Ford VonRueden', '70400528', 279, NULL, NULL, NULL),
(138, 'Nat Harvey I', '57957492', 171, NULL, NULL, NULL),
(139, 'Juston Feil', '37589535', 548, NULL, NULL, NULL),
(140, 'Ethel Muller', '4949901', 743, NULL, NULL, NULL),
(141, 'Freida Adams', '8084595', 143, NULL, NULL, NULL),
(142, 'Miss Noemi Schaefer DDS', '98428854', 214, NULL, NULL, NULL),
(143, 'Shaun Kunze', '14840977', 175, NULL, NULL, NULL),
(144, 'Toni Kling', '48000631', 371, NULL, NULL, NULL),
(145, 'Adam Friesen Jr.', '23595549', 502, NULL, NULL, NULL),
(146, 'Ines Schuppe PhD', '14546452', 101, NULL, NULL, NULL),
(147, 'Serena Gutkowski', '70845837', 589, NULL, NULL, NULL),
(148, 'Brycen Kuvalis', '80172497', 548, NULL, NULL, NULL),
(149, 'Mr. Giuseppe Koepp DDS', '90697844', 103, NULL, NULL, NULL),
(150, 'Jonas Jacobson', '2909334', 629, NULL, NULL, NULL),
(151, 'Rebeca Harvey', '53769760', 150, NULL, NULL, NULL),
(152, 'Garnett Kuphal III', '13105421', 33, NULL, NULL, NULL),
(153, 'Alexander Bernier', '86205400', 954, NULL, NULL, NULL),
(154, 'Celine Kassulke', '35000603', 549, NULL, NULL, NULL),
(155, 'Ada Bartell', '13081627', 651, NULL, NULL, NULL),
(156, 'Miss Trinity Boyle PhD', '62962608', 561, NULL, NULL, NULL),
(157, 'Prof. Cornell Schuster', '16694585', 665, NULL, NULL, NULL),
(158, 'Cassandra Gislason', '8283906', 987, NULL, NULL, NULL),
(159, 'Bryon Zulauf IV', '14394151', 986, NULL, NULL, NULL),
(160, 'Kale Langworth', '17507005', 959, NULL, NULL, NULL),
(161, 'Lynn Mayert', '32897820', 883, NULL, NULL, NULL),
(162, 'Aniya Schowalter', '15460280', 266, NULL, NULL, NULL),
(163, 'Lexie Okuneva Jr.', '11602631', 328, NULL, NULL, NULL),
(164, 'Nelson Heathcote', '25368180', 415, NULL, NULL, NULL),
(165, 'Elmo Carter', '80996736', 512, NULL, NULL, NULL),
(166, 'Darrion Shields', '16625328', 397, NULL, NULL, NULL),
(167, 'Anya Bergstrom', '25200518', 25, NULL, NULL, NULL),
(168, 'Hazle Raynor', '83630915', 607, NULL, NULL, NULL),
(169, 'Mr. Gennaro Witting', '43911636', 872, NULL, NULL, NULL),
(170, 'Brice Medhurst MD', '41697233', 428, NULL, NULL, NULL),
(171, 'Dan Schulist', '56509515', 994, NULL, NULL, NULL),
(172, 'Dr. Elisabeth Hermiston', '23273844', 368, NULL, NULL, NULL),
(173, 'Lucie O\'Conner', '9084272', 11, NULL, NULL, NULL),
(174, 'Marilie Olson Sr.', '99734552', 400, NULL, NULL, NULL),
(175, 'Eino Cartwright', '21015997', 147, NULL, NULL, NULL),
(176, 'Lexus Pagac', '17332322', 903, NULL, NULL, NULL),
(177, 'Jovany Emard', '94485288', 130, NULL, NULL, NULL),
(178, 'Aletha Franecki', '64459772', 544, NULL, NULL, NULL),
(179, 'Ransom Hammes DVM', '61408963', 799, NULL, NULL, NULL),
(180, 'Prof. Minnie Kessler', '64141539', 781, NULL, NULL, NULL),
(181, 'Trever Hermann', '26391239', 775, NULL, NULL, NULL),
(182, 'Napoleon Turcotte', '27020993', 67, NULL, NULL, NULL),
(183, 'Enoch Farrell', '70391917', 138, NULL, NULL, NULL),
(184, 'Jolie Cassin V', '27657383', 44, NULL, NULL, NULL),
(185, 'Ramon Vandervort', '11358598', 662, NULL, NULL, NULL),
(186, 'Nannie Hudson', '97272723', 433, NULL, NULL, NULL),
(187, 'Linnie Mills', '61191206', 931, NULL, NULL, NULL),
(188, 'Mr. Olin Blick', '23636610', 246, NULL, NULL, NULL),
(189, 'Dr. Jeff Fay', '20561426', 945, NULL, NULL, NULL),
(190, 'Jerrold Gleason', '89780462', 451, NULL, NULL, NULL),
(191, 'Eudora Shields V', '78112183', 401, NULL, NULL, NULL),
(192, 'Newell Nitzsche', '61155104', 853, NULL, NULL, NULL),
(193, 'Edgardo Hilpert', '40589873', 720, NULL, NULL, NULL),
(194, 'Buck Kling', '90947373', 653, NULL, NULL, NULL),
(195, 'Alvena Larkin', '16363218', 799, NULL, NULL, NULL),
(196, 'Mr. Kurtis Goldner DDS', '59419100', 196, NULL, NULL, NULL),
(197, 'Desiree Zemlak', '14494457', 919, NULL, NULL, NULL),
(198, 'Deanna Cruickshank Jr.', '24813133', 996, NULL, NULL, NULL),
(199, 'Krystina Johnston', '97562655', 998, NULL, NULL, NULL),
(200, 'Stephen Tillman', '13561021', 122, NULL, NULL, NULL);

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

--
-- Volcado de datos para la tabla `persistences`
--

INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
(1, 1, 'ExcLZTYCjNr2VWAeW7HzJa7CyuYdv0xj', '2017-05-01 04:34:07', '2017-05-01 04:34:07'),
(2, 1, 'lfobd9pBXyT0FtJs1J6Vl6SBgYHT77ii', '2017-05-05 01:51:18', '2017-05-05 01:51:18'),
(3, 1, '8djfXXVHEQkGLzOWs0zR8BMOuuQuqRtz', '2017-05-08 03:31:21', '2017-05-08 03:31:21'),
(4, 1, 'FM2saaMM991fbT5iTvKChEJPlUsrPOMy', '2017-05-08 21:09:12', '2017-05-08 21:09:12'),
(5, 1, 'sDxL9hzGn7sRu9hTbVKALISbSmzqjFq7', '2017-05-09 01:31:07', '2017-05-09 01:31:07'),
(6, 1, 'mvD1SnBFBWa39zJV8x6zMIM0QHUJdptQ', '2017-05-09 03:18:47', '2017-05-09 03:18:47'),
(7, 1, '5xxXD3SaiAOJ5vZqIJHAadnZmNDh96Tv', '2017-05-09 03:19:27', '2017-05-09 03:19:27'),
(8, 1, 'xngGRknEvWeR8bHbxZze4VWS0ovIogtI', '2017-05-10 04:47:46', '2017-05-10 04:47:46'),
(9, 1, 'mKyRNaGQoV4dFXuiDRYj0oq8b24knOcC', '2017-05-11 03:16:18', '2017-05-11 03:16:18'),
(10, 1, 'ZBmgsLPrUeHBpNFHGad0KhPJOB8DBAAF', '2017-05-13 02:11:41', '2017-05-13 02:11:41'),
(11, 1, 'eWFM5Av8vSliDNNMlqLTpCvfHJAMcTee', '2017-05-13 18:14:04', '2017-05-13 18:14:04'),
(12, 1, 'qKCOjOh4c0bApjRQao0Vuvac1eyhAZap', '2017-05-13 20:16:02', '2017-05-13 20:16:02'),
(13, 1, 'XdA4M0cpTv547jgTZfQZoIdRxBoprB08', '2017-05-14 05:19:14', '2017-05-14 05:19:14'),
(14, 1, 'BQB9aDJftrgTkloLJ21VWERcU4LZcunC', '2017-05-14 18:15:27', '2017-05-14 18:15:27'),
(15, 1, '8eR2yiG3g8ESEpUiMrq3kF3LguqEtdOL', '2017-05-14 18:26:47', '2017-05-14 18:26:47'),
(16, 1, 'hZS518n2UlNSIX7yD4iAJbr0AbIdqECI', '2017-05-17 20:53:48', '2017-05-17 20:53:48'),
(17, 1, 'pZ3Lk8AtYaXebEFMbWZafptUFWMJU3dA', '2017-05-19 19:08:43', '2017-05-19 19:08:43');

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
(1, NULL, 'alta', 1, NULL, NULL),
(2, NULL, 'baja', 2, NULL, NULL);

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
  `gastos_administrativos` int(11) NOT NULL,
  `ganancia` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `created_at`, `updated_at`, `id_proovedor`, `descripcion`, `gastos_administrativos`, `ganancia`, `nombre`, `deleted_at`) VALUES
(25, NULL, NULL, 5, '', 10, 10, 'Mr. Gus Crist DVM', NULL),
(26, NULL, NULL, 6, '', 812, 41, 'Darwin Jacobson', NULL),
(27, NULL, NULL, 4, '', 2886, 92, 'Cristopher Crist', NULL),
(28, NULL, NULL, 4, '', 172, 15, 'Chyna Osinski', NULL),
(29, NULL, NULL, 1, '', 601, 28, 'Dr. Danyka Rolfson DVM', NULL),
(30, NULL, NULL, 10, '', 280, 16, 'Dr. Deonte Graham II', NULL),
(31, NULL, NULL, 10, '', 1118, 9, 'Prof. Zelma Jenkins MD', NULL),
(32, NULL, NULL, 10, '', 876, 30, 'Veronica McLaughlin', NULL),
(33, NULL, NULL, 4, '', 1048, 31, 'Laurie Lindgren', NULL),
(34, NULL, NULL, 9, '', 1909, 43, 'Shad Bergnaum PhD', NULL),
(35, NULL, NULL, 4, '', 2057, 81, 'Prof. Ova Wuckert', NULL),
(36, NULL, NULL, 7, '', 746, 34, 'Claudia Powlowski', NULL),
(37, NULL, NULL, 4, '', 2196, 43, 'Elvis Orn DDS', NULL),
(38, NULL, NULL, 3, '', 2400, 26, 'Queenie Champlin', NULL),
(39, NULL, NULL, 2, '', 2403, 6, 'Prof. Daisy Rohan Jr.', NULL),
(40, NULL, NULL, 7, '', 2178, 80, 'Blair Lang', NULL),
(41, NULL, NULL, 9, '', 2076, 20, 'Rubye Russel', NULL),
(42, NULL, NULL, 7, '', 1926, 51, 'Adela Gislason', NULL),
(43, NULL, NULL, 1, '', 595, 27, 'Raphaelle O\'Reilly', NULL),
(44, NULL, NULL, 4, '', 1784, 21, 'Evan Barton', NULL),
(45, NULL, NULL, 4, '', 2071, 5, 'Leanna Hahn DDS', NULL),
(46, NULL, NULL, 5, '', 1347, 89, 'Mr. Holden Bashirian', NULL),
(47, NULL, NULL, 4, '', 18, 2, 'Prof. Jaquelin Tromp I', NULL),
(48, NULL, NULL, 7, '', 2029, 93, 'Mrs. Kelsi Cormier', NULL),
(49, NULL, NULL, 5, '', 789, 88, 'Rowland Klein', NULL),
(50, NULL, NULL, 4, '', 1812, 58, 'Maurine Effertz PhD', NULL),
(51, NULL, NULL, 8, '', 2727, 19, 'Mr. Hank O\'Kon IV', NULL),
(52, NULL, NULL, 4, '', 10, 10, 'Zane Zieme', NULL),
(53, NULL, NULL, 10, '', 2837, 14, 'Saul Waters DDS', NULL),
(54, NULL, NULL, 1, '', 2832, 41, 'Dr. Lysanne Conn DVM', NULL),
(55, NULL, NULL, 4, '', 1454, 40, 'Grace Leannon', NULL),
(56, NULL, NULL, 1, '', 252, 26, 'Dr. Loren Daugherty Sr.', NULL),
(57, NULL, NULL, 2, '', 10, 10, 'Diego Prosacco', NULL),
(58, NULL, NULL, 8, '', 379, 53, 'Prof. Joaquin Flatley MD', NULL),
(59, NULL, NULL, 4, '', 931, 27, 'Prof. Johann Hintz PhD', NULL),
(60, NULL, NULL, 7, '', 1835, 30, 'Miss Carlee Jakubowski', NULL),
(61, NULL, NULL, 8, '', 1029, 49, 'Wilson Nolan', NULL),
(62, NULL, NULL, 3, '', 2284, 70, 'Dr. Grayson Bartoletti', NULL),
(63, NULL, NULL, 6, '', 990, 35, 'Mr. Lindsey Nienow IV', NULL),
(64, NULL, NULL, 2, '', 2243, 50, 'Tevin Green MD', NULL),
(65, NULL, NULL, 3, '', 2591, 48, 'Anais Kerluke Jr.', NULL),
(66, NULL, NULL, 4, '', 1269, 82, 'Dr. Glennie Kuhlman II', NULL),
(67, NULL, NULL, 3, '', 1864, 24, 'Dessie Medhurst DDS', NULL),
(68, NULL, NULL, 1, '', 1225, 29, 'Ethel Wuckert', NULL),
(69, NULL, NULL, 4, '', 372, 78, 'Deron Nikolaus', NULL),
(70, NULL, NULL, 3, '', 2404, 0, 'Johanna Huels', NULL),
(71, NULL, NULL, 7, '', 451, 50, 'Kameron Kunze', NULL),
(72, NULL, NULL, 7, '', 2066, 92, 'Alf Kling', NULL),
(73, NULL, NULL, 3, '', 928, 96, 'Lavern Hermiston', NULL),
(74, NULL, NULL, 2, '', 127, 9, 'Freddy Fadel', NULL),
(75, NULL, NULL, 7, '', 1413, 14, 'Prof. Vidal Marks DDS', NULL),
(76, NULL, NULL, 9, '', 2584, 57, 'Carleton Hirthe Jr.', NULL),
(77, NULL, NULL, 10, '', 2646, 3, 'Prof. Creola Hyatt III', NULL),
(78, NULL, NULL, 10, '', 1404, 32, 'Francisca Pouros', NULL),
(79, NULL, NULL, 3, '', 1321, 86, 'Dr. Alejandrin Stracke', NULL),
(80, NULL, NULL, 8, '', 2172, 42, 'Haley Zulauf MD', NULL),
(81, NULL, NULL, 4, '', 2757, 55, 'Salma Johnston Jr.', NULL),
(82, NULL, NULL, 7, '', 799, 5, 'Laurence Bailey', NULL),
(83, NULL, NULL, 8, '', 279, 51, 'Dr. Korey Farrell', NULL),
(84, NULL, '2017-05-09 03:54:03', 3, 'fdsfsdf', 2036, 97000, 'fdsfdsf', '2017-05-09 03:54:03'),
(85, NULL, NULL, 5, '', 261, 77, 'Rickie Pfeffer V', NULL),
(86, NULL, NULL, 2, '', 1973, 40, 'Dejah Bernier', NULL),
(87, NULL, NULL, 4, '', 2676, 95, 'Miracle Klein', NULL),
(88, NULL, NULL, 2, '', 2735, 82, 'Rebeca Volkman', NULL),
(89, NULL, NULL, 1, '', 1653, 20, 'Lela Grimes', NULL),
(90, NULL, NULL, 6, '', 2929, 30, 'Jakayla Kassulke Sr.', NULL),
(91, NULL, NULL, 8, '', 674, 38, 'Chelsey Kovacek DVM', NULL),
(92, NULL, NULL, 1, '', 2663, 73, 'Mr. Keaton Lang', NULL),
(93, NULL, NULL, 2, '', 921, 26, 'Dallin Bernier', NULL),
(94, NULL, NULL, 3, '', 345, 72, 'Rod Ferry', NULL),
(95, NULL, NULL, 3, '', 1519, 92, 'Mrs. Emmy Gusikowski', NULL),
(96, NULL, NULL, 4, '', 718, 43, 'Trevion Beahan', NULL),
(97, NULL, NULL, 1, '', 68, 33, 'Miss Deborah Hilpert III', NULL),
(98, NULL, NULL, 4, '', 1692, 42, 'Viviane Bernhard', NULL),
(99, NULL, NULL, 6, '', 1217, 69, 'Ms. Adelia Goyette', NULL),
(100, NULL, NULL, 4, '', 2958, 79, 'Prof. Golda Klein I', NULL),
(101, '2017-05-09 03:54:37', '2017-05-09 03:54:37', 2, '588', 0, 888, '12', NULL);

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
(2, 'Baron O\'Connell V', 'I only wish they COULD! I\'m sure I can\'t be Mabel, for I know all sorts of things--I can\'t remember half of them--and it belongs to a farmer, you know, and he says it\'s so useful, it\'s worth a.', 73, 92, NULL, 1, NULL, NULL),
(3, 'Tracy Goyette', 'Now I growl when I\'m pleased, and wag my tail when I\'m angry. Therefore I\'m mad.\' \'I call it purring, not growling,\' said Alice. \'Call it what you like,\' said the Gryphon. \'It all came different!\'.', 38, 45, NULL, 1, NULL, NULL),
(4, 'Hildegard Carroll', 'Conqueror, whose cause was favoured by the pope, was soon submitted to by the English, who wanted leaders, and had been of late much accustomed to usurpation and conquest. Edwin and Morcar, the.', 36, 79, NULL, 1, NULL, NULL),
(5, 'aaaaa', 'fdfdsdfsdflice asked. \'We called him Tortoise because he taught us,\' said the Mock Turtle. \'Seals, turtles, salmon, and so on; then, when you\'ve cleared all the jelly-fish out of.', 713, 423, NULL, 1, NULL, '2017-05-09 01:49:29'),
(6, 'Dr. Nayeli Blanda', 'Alice. One of the jurors had a pencil that squeaked. This of course, Alice could not think of anything to say, she simply bowed, and took the thimble, looking as solemn as she could. \'The Dormouse.', 16, 42, NULL, 2, NULL, NULL),
(7, 'Myles Murphy PhD', 'Queen had ordered. They very soon came upon a neat little house, on the door of which was a bright brass plate with the name \'W. RABBIT\' engraved upon it. She went in without knocking, and hurried.', 0, 15, NULL, 1, NULL, NULL),
(8, 'Ulises Schmidt', 'Alice, \'when one wasn\'t always growing larger and smaller, and being ordered about by mice and rabbits. I almost wish I hadn\'t gone down that rabbit-hole--and yet--and yet--it\'s rather curious, you.', 92, 59, NULL, 1, NULL, NULL),
(9, 'Cassandre Crooks', 'Alice an excellent opportunity for croqueting one of them with the other: the only difficulty was, that her flamingo was gone across to the other side will make you grow shorter.\' \'One side of WHAT?.', 81, 98, NULL, 1, NULL, NULL),
(10, 'Emelie Friesen', 'The players all played at once without waiting for the end of the ground--and I should have croqueted the Queen\'s hedgehog just now, only it ran away when it saw Alice. It looked good-natured, she.', 99, 33, NULL, 1, NULL, NULL);

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

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'genio', 'genio', '{"organismos.crear":true,"organismos.visualizar":true,"organismos.editar":true,"organismos.borrar":true,"socios.editar":true,"socios.visualizar":true,"socios.crear":true,"socios.borrar":true}', '2017-05-01 04:34:00', '2017-05-01 04:34:00');

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

--
-- Volcado de datos para la tabla `role_users`
--

INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2017-05-01 04:34:00', '2017-05-01 04:34:00');

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
(1, 'Serenity Bauch', '0000-00-00', '', 0, '', '', 0, 0, 5, '0000-00-00', 0, '', NULL, NULL, NULL),
(2, 'Grace Crona MD', '0000-00-00', '', 0, '', '', 0, 0, 8, '0000-00-00', 0, '', NULL, NULL, NULL),
(3, 'Alessandro Gibson', '0000-00-00', '', 0, '', '', 0, 0, 1, '0000-00-00', 0, '', NULL, NULL, NULL),
(4, 'Brown O\'Kon', '0000-00-00', '', 0, '', '', 0, 0, 9, '0000-00-00', 0, '', NULL, NULL, NULL),
(5, 'Henriette Denesik', '0000-00-00', '', 0, '', '', 0, 0, 7, '0000-00-00', 0, '', NULL, NULL, NULL),
(6, 'Prof. Shaina McKenzie', '0000-00-00', '', 0, '', '', 0, 0, 5, '0000-00-00', 0, '', NULL, NULL, NULL),
(7, 'Dr. Deron Rolfson Jr.', '0000-00-00', '', 0, '', '', 0, 0, 5, '0000-00-00', 0, '', NULL, NULL, NULL),
(8, 'Iva Lebsack', '0000-00-00', '', 0, '', '', 0, 0, 7, '0000-00-00', 0, '', NULL, NULL, NULL),
(9, 'Dustin Legros', '0000-00-00', '', 0, '', '', 0, 0, 9, '0000-00-00', 0, '', NULL, NULL, NULL),
(10, 'Simone McCullough DDS', '0000-00-00', '', 0, '', '', 0, 0, 8, '0000-00-00', 0, '', NULL, NULL, NULL),
(11, 'Prof. Cydney Spinka', '0000-00-00', '', 0, '', '', 0, 0, 10, '0000-00-00', 0, '', NULL, NULL, NULL),
(12, 'Jules Wiegand', '0000-00-00', '', 0, '', '', 0, 0, 4, '0000-00-00', 0, '', NULL, NULL, NULL),
(13, 'Ezra Stark DDS', '0000-00-00', '', 0, '', '', 0, 0, 2, '0000-00-00', 0, '', NULL, NULL, NULL),
(14, 'Meta O\'Hara', '0000-00-00', '', 0, '', '', 0, 0, 10, '0000-00-00', 0, '', NULL, NULL, NULL),
(15, 'Muriel Moen', '0000-00-00', '', 0, '', '', 0, 0, 6, '0000-00-00', 0, '', NULL, NULL, NULL),
(16, 'Prof. Emmie Padberg', '0000-00-00', '', 0, '', '', 0, 0, 7, '0000-00-00', 0, '', NULL, NULL, NULL),
(17, 'Leta Yundt', '0000-00-00', '', 0, '', '', 0, 0, 3, '0000-00-00', 0, '', NULL, NULL, NULL),
(18, 'Lorena Shields', '0000-00-00', '', 0, '', '', 0, 0, 3, '0000-00-00', 0, '', NULL, NULL, NULL),
(19, 'Hilda Purdy', '0000-00-00', '', 0, '', '', 0, 0, 9, '0000-00-00', 0, '', NULL, NULL, NULL),
(20, 'Mya Waelchi', '0000-00-00', '', 0, '', '', 0, 0, 6, '0000-00-00', 0, '', NULL, NULL, NULL);

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

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `permissions`, `last_login`, `first_name`, `last_name`, `created_at`, `updated_at`, `usuario`) VALUES
(1, '1', '$2y$10$a7msjZLgQSCu4JXCpODfDO1radvqps7eydW45BXXtwcBisQYbve0K', NULL, '2017-05-19 19:08:43', NULL, NULL, '2017-05-01 04:34:00', '2017-05-19 19:08:43', '1');

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
  `deleted_at` timestamp NULL DEFAULT NULL,
  `tipo` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `nro_credito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `created_at`, `updated_at`, `id_asociado`, `id_producto`, `alta`, `aprobado`, `descripcion`, `nro_cuotas`, `fecha`, `deleted_at`, `tipo`, `nro_credito`) VALUES
(2, '2017-05-01 04:54:43', '2017-05-01 04:54:43', 1, 57, NULL, NULL, '', 5, '0000-00-00', NULL, '', 0),
(3, '2017-05-01 04:58:21', '2017-05-01 04:58:21', 1, 25, NULL, NULL, '', 5, '0000-00-00', NULL, '', 0),
(4, '2017-05-01 04:58:37', '2017-05-01 04:58:37', 14, 25, NULL, NULL, '', 5, '0000-00-00', NULL, '', 0),
(5, '2017-05-01 05:24:49', '2017-05-01 05:24:49', 1, 25, NULL, NULL, '', 8, '0000-00-00', NULL, '', 0),
(6, '2017-05-09 04:49:32', '2017-05-09 04:49:32', 1, 39, NULL, NULL, '', 2, '0000-00-00', NULL, '', 0),
(7, '2017-05-17 22:40:46', '2017-05-17 22:40:46', 6, 26, NULL, NULL, '', 10, '0000-00-00', NULL, 'producto', 0);

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
  ADD KEY `movimientos_id_cuota_foreign` (`id_cuota`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `prioridades`
--
ALTER TABLE `prioridades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT de la tabla `proovedores`
--
ALTER TABLE `proovedores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `socios`
--
ALTER TABLE `socios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `throttle`
--
ALTER TABLE `throttle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
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
  ADD CONSTRAINT `movimientos_id_cuota_foreign` FOREIGN KEY (`id_cuota`) REFERENCES `cuotas` (`id`);

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
