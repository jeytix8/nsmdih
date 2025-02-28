-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2025 at 07:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nsmdih_it`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id_no` int(250) NOT NULL,
  `id` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `section` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id_no`, `id`, `password`, `section`) VALUES
(1, 'superadmin', '$2a$12$Rka9To.yzsyIPyFriYpcQ.im4KBUzmad0K3HFhdh5Lnxm0AYvsCoa', 'IT & Communication'),
(2, 'administrator', '$2a$12$Rka9To.yzsyIPyFriYpcQ.im4KBUzmad0K3HFhdh5Lnxm0AYvsCoa', 'IT & Communication'),
(3, 'accounting', '$2y$10$1nEro52BmaNSHrD58YBvGOsXeQPc8knz46lgE45HtnqF3iAA.cwzy', 'Accounting'),
(4, 'administration', '$2a$12$LCYxIFI85VEsztcJOd0PCeS2h8z1JAwzsBHOUSoAsQuiEOZSinDnC', 'Administration'),
(5, 'billing', '$2a$12$G1Zv.stZjg43X4WKuHpDTuDV8ILjkoUnwN1hClsHwyxGhRweSEEZC', 'Billing'),
(6, 'biomedical', '$2a$12$RDy0V4T.KGknYXaKAEBip.sTFJzpkyO4u6W6Uzmc4Xr23NLKOI4lu', 'Biomedical '),
(7, 'boffice', '$2y$10$.mAZ4JmmUHFGHfQ96JTbm.zuIe9nQKimSo6VBtX.lfyrj7zYYhreC', 'Business Office'),
(8, 'cashier', '$2a$12$JKxah8/diFTLVCd6dgghKeuoL2g0w8W5icdaqycA/5yAsxo0b5IRe', 'Cashier'),
(9, 'cnc', '$2y$10$FDu4Gh83siXV0mlWQXsgJ.EddZP17p34MaJ7rsnnR4RPvMTaLo/sy', 'Credit & Collection'),
(10, 'dietary', '$2y$10$097o0CGTeEkxqNSaCLpFuuW6Y12KO2XY1Cb2Vqheg9vmes.99Thaq', 'Dietary'),
(11, 'enm', '$2y$10$IXIXMEnY4PigwhFcwsHRceFta7mDp7YW5bwUNd8Zv9HaCpkQMvzcS', 'Engineering & Maintenance'),
(12, 'gservices', '$2y$10$dcpnypb8xKiPLckhXeQQKuIyLaEADWZ1p21tnSWakdHtLAyXcwBie', 'General Services'),
(13, 'hmo', '$2a$12$XvO1gyS0a6GPAPvM8bZCGuYR67AFeFX3pNGNxWJ3m01enQ4k9ESNG', 'HMO/Industrial'),
(14, 'hr', '$2a$12$9v0BbU.fwZ7djY5G5HsHU.szhgRJ475Xcv6j9jA6gttclrpphufJG', 'Human Resources'),
(15, 'ina', '$2y$10$T4vKGX6/vZvcfn22q0XSe.BoAHVVUUcGIGLCZQsIhLz53Xh03Bzs2', 'Info & Admitting'),
(16, 'laboratory', '$2y$10$JFDUtbWrRPHduu/DtRNM5uHqT1XE1FeJAebBe6LT0BIJfnibGEsYK', 'Laboratory'),
(17, 'mrecord', '$2y$10$D.DryeQXsa6k48CMN.TDdeXYRumhCxTDRx87mQ4wvYyhLTdEBNxr2', 'Medical Record'),
(18, 'mservices', '$2y$10$MrN2KsmB2yc.ZcU65x1mBOcb0Q9mlUOhj09/0gJkkJX4h9Jv2nvxq', 'Medical Services'),
(19, 'nservice', '$2y$10$w/khitj6sgN2JnLeyDvYNu9FYx.Tudgzi06fS4fG93DAH0OHdAnY6', 'Nursing Service'),
(20, 'pharmacy', '$2y$10$RZVUrN0MR7LH3V6w9QePnenGsMmSel8GpEWfzqiJUBLxspcK9QHOK', 'Pharmacy'),
(21, 'purchasing', '$2y$10$w.rKLdE2mjnIfhmBCHwnH.1VWCrV6Hx7N3HvOO/3rLIgGZiKnTWk2', 'Purchasing'),
(22, 'qms', '$2a$12$3bJv1hL9mXyXwjzR7WJyMOUFkAkzBISbNiMgFBYycaaiGMgZCzU2S', 'Quality Management System'),
(23, 'radiology', '$2y$10$jQg8qft1WGfrCt0WQtnLhO7IidnnZX6/8aymAh/HBVKqNUSGaFBeG', 'Radiology'),
(24, 'rmedicine', '$2y$10$fuNv8fVBVH6MQRQSk4xQPO4UizCk7eMAh03JngHkNKShJ24C6Z0pS', 'Rehabilitation Medicine'),
(25, 'ss', '$2y$10$1vOa7P6eeS.hCEPjYaZgKOk95QJ3I7ZwnYFvVjQgM/qOQRzB4M8E6', 'Social Service'),
(26, 'sdiagnostic', '$2y$10$KEgpmoEuTRSeWfh.jd.4IOJq60YR7hYEhLo3Uyxhh1JthREQK4vEy', 'Special Diagnostic'),
(29, 'csr', '$2y$10$wHCOyOT/txKlCoHwthUEvuEwIYPAHDf.Eb5U24f6tvkaM4EGiRqPW', 'Warehouse/CSR');

-- --------------------------------------------------------

--
-- Table structure for table `category_job_order`
--

CREATE TABLE `category_job_order` (
  `id` int(11) NOT NULL,
  `category` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_job_order`
--

INSERT INTO `category_job_order` (`id`, `category`) VALUES
(4, 'Network'),
(7, 'PC'),
(13, 'Internet'),
(14, 'Others'),
(15, 'Printer');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(250) NOT NULL,
  `name` varchar(500) NOT NULL,
  `section` varchar(500) NOT NULL,
  `image_data` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `section`, `image_data`) VALUES
(1, 'PACO, OMARITO BAUAN', 'IT & Communication', ''),
(2, 'LAUREÑO, BRIAN ANGELO FAJANIILAN', 'IT & Communication', ''),
(3, 'HERNANDEZ, CAMILLE PABLEO', 'IT & Communication', ''),
(4, 'JABAT, JEDRICK RANSLEY ', 'IT & Communication', ''),
(5, 'BUSTILLO, KRISTINA JOYCE DELDA', 'IT & Communication', ''),
(6, 'BARGO, JOHN PAUL  MARQUEZ', 'IT & Communication', ''),
(7, 'ASINAS, MICHAEL ALFONS EVASCO', 'Accounting', ''),
(8, 'ALCABASA, NORA MATUTE', 'Accounting', ''),
(9, 'VALLENTE, GIZELLE JOY CENTENO', 'Accounting', ''),
(10, 'ALCAZAR, RACHEILLE JACINTO', 'Accounting', ''),
(11, 'SOMIDO, ANNABELLE ESPINAS', 'Accounting', ''),
(12, 'DIVINAFLOR, MARY JOY SAN AGUSTIN', 'Accounting', ''),
(13, 'RESPECIO, BERNARD CARLO BELANDO', 'Accounting', ''),
(14, 'VILLALUNA, WALLY EZEKIEL CHUAQUICO', 'Accounting', ''),
(15, 'MARTINEZ, SHIELA DATILES', 'Administration', ''),
(16, 'ADONIS, IRALYN LAINE GREGANDA', 'Administration', ''),
(17, 'ESCOTA, AIRIEL PADUA', 'Administration', ''),
(18, 'TAN, SHIRLEY ESPINOSA', 'Billing', ''),
(19, 'KREUZMAN, VERNA ANN CASTANAR', 'Billing', ''),
(20, 'RODRIGUEZ, ALFIE JAY BALATAN', 'Billing', ''),
(21, 'SISON, ARIANNE CANICOSA', 'Billing', ''),
(22, 'BARRAQUIO, MARY GRACE RECTO', 'Billing', ''),
(23, 'ISORENA, MAITE BERMEJO', 'Billing', ''),
(24, 'MALIT, KATE MENDOZA', 'Billing', ''),
(25, 'CHAVEZ, MARY JANE ALEVOSO', 'Billing', ''),
(26, 'CABUGDA, JHONMER ACAYLAR', 'Biomedical ', ''),
(27, 'BIAZON, RHOILEN DE GUZMAN', 'Biomedical ', ''),
(28, 'ABLAZO, ROAN BATOY', 'Business Office', ''),
(29, 'APOSTOL, JEANNIE PUNZALAN', 'Business Office', ''),
(30, 'DE LEON, MA. KATHRINA', 'Business Office', ''),
(31, 'MORACA, ELLAMAE DELIMAN', 'Business Office', ''),
(32, 'BARCENAS, MELINDA BALLARBARE', 'Business Office', ''),
(33, 'OLEDAN, DESIREE CAJETA', 'Cashier', ''),
(34, 'ISAAC, JOYCE ROSARIO', 'Cashier', ''),
(35, 'LABRADOR, FLORDELIZA BONAGUA', 'Cashier', ''),
(36, 'MARTE, MARY JANE RETEZ', 'Cashier ', ''),
(37, 'KARIKITAN, KATHERINE MANCE', 'Credit & Collection', ''),
(38, 'GARVIDA, ERWIN REY LOZANO', 'Credit & Collection', ''),
(39, 'TRIBIANA, JULIANNE AUBREY SIAL', 'Credit & Collection', ''),
(40, 'BAUTISTA, YLLOR DON REYES', 'Credit & Collection', ''),
(41, 'DAYEGO, DANSTEL RHODES GUBI', 'Dietary', ''),
(42, 'DURANTE, ALDWIN FLORES', 'Engineering & Maintenance', ''),
(43, 'AGUILLON, EDWIN NODADO', 'Engineering & Maintenance', ''),
(44, 'GARCIA, REY DOROMPILI', 'Engineering & Maintenance', ''),
(45, 'LOCSIN, REYNALDO DELMO', 'Engineering & Maintenance', ''),
(46, 'JAMELARIN, ELMAR DEMONTEVERDE', 'Engineering & Maintenance', ''),
(47, 'SILVANO, ARNEL OLPENDA', 'Engineering & Maintenance', ''),
(48, 'ROMASANTA, HELBERT AVILA', 'Engineering & Maintenance', ''),
(49, 'TAWAT, OLIVER PEREZ', 'Engineering & Maintenance', ''),
(50, 'PANINGBATAN, DANILO VINOYA', 'Engineering & Maintenance', ''),
(51, 'MASUJER, JEROME RAGUDO', 'Engineering & Maintenance', ''),
(52, 'BINALUYO, KRISTIAN BENITEZ', 'Engineering & Maintenance', ''),
(53, 'BRIONES, WENCESLAO JR. DELOS SANTOS', 'General Services', ''),
(54, 'BATO, ROMEL ROXAS', 'General Services', ''),
(55, 'LAYUGAN, DENNIS ALILURAN', 'General Services', ''),
(56, 'LANDICHO, LESTER SUPERABLE', 'General Services', ''),
(57, 'REALON, ROSEFEL JOYCE TERCERO', 'HMO/Industrial', ''),
(58, 'ABUDA, APRIL ROSE TABARES', 'HMO/Industrial', ''),
(59, 'SALAZAR, FATIMA SAN JUAN', 'HMO/Industrial', ''),
(60, 'PERMEJO, MARIA ROWENA DINULOS', 'HMO/Industrial', ''),
(61, 'INTIA, LOUISE LYNE BARCELLANO', 'HMO/Industrial', ''),
(62, 'DIMALALUAN, JOANNA MARIE AGDAN', 'HMO/Industrial', ''),
(63, 'VERGARA, JOHN BERNARD ', 'HMO/Industrial', ''),
(64, 'ROXAS, AMICA SOPHIA SANTIAGO', 'HMO/Industrial', ''),
(65, 'PAGSUYUIN, ANNALINE CORPUZ', 'Human Resources', ''),
(66, 'SUNGA, CHELL JOYCE QUERO', 'Human Resources', ''),
(67, 'MERCADO, MOISES NOE PAELMO', 'Human Resources', ''),
(68, 'DELA CRUZ, TRICIA ABLETIA', 'Human Resources', ''),
(69, 'CUSTODIO, MILAGROSA DELFINO', 'Info & Admitting', ''),
(70, 'CRISTOBAL, MARJORIE SHAINE GLORIA', 'Info & Admitting', ''),
(71, 'CLIMACO, JERONIMO CARASCO', 'Info & Admitting', ''),
(72, 'BUCOY, MARIA GIMA GAMIER', 'Laboratory', ''),
(73, 'PILI, MARIELLA LORENZO', 'Laboratory', ''),
(74, 'CARPIO, CHILLY GRACE RAMOS', 'Laboratory', ''),
(75, 'CAYABYAB, CIELO MAKIL', 'Laboratory', ''),
(76, 'SILVANO, DYNA ROSE GUTIEREZ', 'Laboratory', ''),
(77, 'DE LA CRUZ, HEDDA ROSE VIDA LAMIGAS', 'Laboratory', ''),
(78, 'LAZARO, DOIS JORI BAÑADOS', 'Laboratory', ''),
(79, 'LANDICHO, MA. JEAN RACHEL EDOSMA', 'Laboratory', ''),
(80, 'AMULAR, MICHELLE ALVAREZ', 'Laboratory', ''),
(81, 'GOJIT, HAZEL BLANCHE ALIPALA', 'Laboratory', ''),
(82, 'RAMOS, ANN MAZELLE FLORES', 'Laboratory', ''),
(83, 'MENDOZA, FRANCISCA OCFEMIA', 'Laboratory', ''),
(84, 'PANGHULAN, ROUSELLE FRANCE ABELA', 'Laboratory', ''),
(85, 'GALLO, GEORGIA MARIZ REMO', 'Laboratory', ''),
(86, 'IBASCO, SANDRA CABANELA', 'Laboratory', ''),
(87, 'ROSARITO, FRANCHESCA ESPEJO', 'Laboratory', ''),
(88, 'SUSON, SHARMAINE CAMONAYAN', 'Laboratory', ''),
(89, 'COLLANTES, GELYN', 'Laboratory', ''),
(90, 'ESTEBAN, JOYCE SAMSON', 'Laboratory', ''),
(91, 'PUGA, KAREN GRACE SAMULDE', 'Laboratory', ''),
(92, 'VIRGENES, RIANE DARLENE SO', 'Laboratory', ''),
(93, 'TAYAO, DEUTSCH CAMILLE OCAMPO', 'Laboratory', ''),
(94, 'MOLERO, JULIANNE LEIGHNE DEFEO', 'Laboratory', ''),
(95, 'CUYOS, FORTUNATO CEJANE JR.', 'Laboratory', ''),
(96, 'FARIÑAS, CLARK DANIEL BACARRO', 'Laboratory', ''),
(97, 'LOCSIN, RALF JOSHUA ARCIAGA', 'Laboratory', ''),
(98, 'MANALILI, CHARLOT-ANN ESCUETA', 'Medical Record', ''),
(99, 'LAYTO, CRISTINE ALEGRO', 'Medical Record', ''),
(100, 'JOP, FLORA TAWAT', 'Medical Services', ''),
(101, 'CELIS, ANNA THERESA CALASANZ', 'Medical Services', ''),
(102, 'MAGCAMIT, LEALEE TENORIO', 'Medical Services', ''),
(103, 'REYES, ROSEMARIE AMORANTO', 'Medical Services', ''),
(104, 'TULAYLAY, JENYLYN BRIONES', 'Medical Services', ''),
(105, 'TABUNO, GRACE MONDRAGON', 'Medical Services', ''),
(106, 'DIAGO, MARY JANE ALORA', 'Medical Services', ''),
(107, 'CASTRILLO, MARY CLARE TING', 'Medical Services', ''),
(108, 'MANDIGMA, ANGELAH AGARAO', 'Medical Services', ''),
(109, 'CANTILLAN, MARJORIE ANNE', 'Medical Services', ''),
(110, 'MAGBANUA, ANDREA MARIE', 'Medical Services', ''),
(111, 'HAMBALA, ERIKA MAE LAVAPIE', 'Medical Services', ''),
(112, 'GENESE, NORJIEL ALDOUS ESPARRAGO', 'Medical Services', ''),
(113, 'LUSTRE, ENJELENE NAZEL EVARDONE', 'Medical Services', ''),
(114, 'GATON, ROSARIO DE CHAVEZ', 'Medical Services', ''),
(115, 'STA. ROSA, JANELLE ARCA', 'Medical Services', ''),
(116, 'GATELA, ROSE ANN', 'Medical Services', ''),
(117, 'ANIVES, MARY JANE ESPIRITU', 'Medical Services', ''),
(118, 'TORRES, CORRINA CARASCO', 'Medical Services', ''),
(119, 'BATALLA, JACQUETA ROSS DIMAPILIS', 'Medical Services', ''),
(120, 'DEL MUNDO, PAUL WISDOM MEDRANO', 'Nursing Service', ''),
(121, 'BAYLON, JOVITH GELLA', 'Nursing Service', ''),
(122, 'YONSON, ARMANDO VARON', 'Nursing Service', ''),
(123, 'DELOTAVO, CHARLIE DE PAULA', 'Nursing Service', ''),
(124, 'LOPEZ, WILLIARD CRUZ', 'Nursing Service', ''),
(125, 'VILLEZA, GEROME HERNANDEZ', 'Nursing Service', ''),
(126, 'MADRID, EMILCOR CAPRE', 'Nursing Service', ''),
(127, 'BASCO, ALDRIN YORK ALMODOVAR', 'Nursing Service', ''),
(128, 'ZAMORA, LANZ ANGLELES DECENA', 'Nursing Service', ''),
(129, 'ROA, RAMIL RECANIA', 'Nursing Service', ''),
(130, 'PAGA, ALEXANDER TANCHICO', 'Nursing Service', ''),
(131, 'CARMONA, MARK JASPER GANTONG', 'Nursing Service', ''),
(132, 'OLORAZA, CONRADO PAMATIAN', 'Nursing Service', ''),
(133, 'VALMORIA, ALJECARL AVENTURADO', 'Nursing Service', ''),
(134, 'BRIONES, JULIUS ROBLES', 'Nursing Service', ''),
(135, 'OYALES, MARICAR IGNACIO', 'Nursing Service', ''),
(136, 'MAGLAQUI, MA. DOREEN REBONG', 'Nursing Service', ''),
(137, 'OCAMPO, MERYL CHAVEZ', 'Nursing Service', ''),
(138, 'BAUTISTA, OLIVE LUCERO', 'Nursing Service', ''),
(139, 'ALONTE, SHAILINI VIRTUCIO', 'Nursing Service', ''),
(140, 'AGUILA, ROFAULA MANCE', 'Nursing Service', ''),
(141, 'ILAGAN, HAROLD KARLO DINGLASAN', 'Nursing Service', ''),
(142, 'PEÑA, NORIANNE MANAS', 'Nursing Service', ''),
(143, 'CATINDIG, HYNA DANICA CABANCE', 'Nursing Service', ''),
(144, 'DULCE, LATIFA EISSA MAGBANUA', 'Nursing Service', ''),
(145, 'ALCASABAS, CHRISTINE RAMOS', 'Nursing Service', ''),
(146, 'NONIFARA, RODALYN ESTORES', 'Nursing Service', ''),
(147, 'MELENDREZ, MAYA ROSE TALAGA', 'Nursing Service', ''),
(148, 'MANGOSO, JOY ANN ALVERO', 'Nursing Service', ''),
(149, 'VILLASANTA, JANE MARGARET GULAPA', 'Nursing Service', ''),
(150, 'PADUA, INNA MICHAELA VILLEGAS', 'Nursing Service', ''),
(151, 'BERMAS, DWIGHT MALIK FAJURA', 'Nursing Service', ''),
(152, 'YAMBAO, ROSE ANN ROMASANTA', 'Nursing Service', ''),
(153, 'REYES, LAARNI BAUTISTA', 'Nursing Service', ''),
(154, 'BARROGA, REMMON MARIA RAVELO', 'Nursing Service', ''),
(155, 'CASTRILLO, MA. MARJORIE YATCO', 'Nursing Service', ''),
(156, 'LACHICA, MARBEN BOADO', 'Nursing Service', ''),
(157, 'PASCUA, MARIA KRISANTHA LIM', 'Nursing Service', ''),
(158, 'ELLAZAR, CHRIS GEROME AÑONUEVO', 'Nursing Service', ''),
(159, 'BAWALAN, MARY JOY GARTE', 'Nursing Service', ''),
(160, 'MAHIA, SHEENA CARMEL DOMINGUEZ', 'Nursing Service', ''),
(161, 'CRUZAT,JORATHY LIANNE ABARQUEZ', 'Nursing Service', ''),
(162, 'RIVERA, AILEEN RAMOS', 'Nursing Service', ''),
(163, 'MORATO, KRIZZIA MAE NABO', 'Nursing Service', ''),
(164, 'MERZA, CHRIS ALBERT BUENAVENTURA', 'Nursing Service', ''),
(165, 'ISAYAS, JONALYN HEMEDEZ', 'Nursing Service', ''),
(166, 'IPIL, MICHELLE BAGONOC', 'Nursing Service', ''),
(167, 'CUBERO, RACHELLE ANN SIGUE', 'Nursing Service', ''),
(168, 'TAROG, JAZCEL LOLO', 'Nursing Service', ''),
(169, 'DELOS SANTOS, MARIA ABIE DIMATULAC', 'Nursing Service', ''),
(170, 'DUATIN, ROCHELLE MAAÑO', 'Nursing Service', ''),
(171, 'MORALES, LAIZA SHARMAINE NOGA', 'Nursing Service', ''),
(172, 'DAMARILLO, GENELI PASCO', 'Nursing Service', ''),
(173, 'UNTALAN, CRISTINA TUMAMBING', 'Nursing Service', ''),
(174, 'NIEVA, RAMONLINO', 'Nursing Service', ''),
(175, 'LUMBES, SHELLA MELITANTE', 'Nursing Service', ''),
(176, 'ASTOVEZA, DAWNY DAN ', 'Nursing Service', ''),
(177, 'CHUA, MARTIN WEILAND DIMAANO', 'Nursing Service', ''),
(178, 'GAVARRA, JESSICA EILEEN RIVERO', 'Nursing Service', ''),
(179, 'JAVIER, RECHELLE GATCHALAN', 'Nursing Service', ''),
(180, 'VILLEGAS, MA. MONICA CARINGAL', 'Nursing Service', ''),
(181, 'DAWAT, MARVIN ODIVER', 'Nursing Service', ''),
(182, 'HAO, JENELYN RICAFORT', 'Nursing Service', ''),
(183, 'PARAO, CHERRY MAE BARTOLOME', 'Nursing Service', ''),
(184, 'DEL BARRIO, RENATO JR. LOPEZ', 'Nursing Service', ''),
(185, 'DIAGAN, RANDY PAUL SUMINTAC', 'Nursing Service', ''),
(186, 'GARAY, ALMA MARTICION', 'Nursing Service', ''),
(187, 'MAGALLANES, JOSEPH PHEEBON LANDICHO', 'Nursing Service', ''),
(188, 'ELAMPARO, MELODY URBIZTONDO', 'Nursing Service', ''),
(189, 'HERNANDEZ, FERDINAND JR. GOTGOTAO', 'Nursing Service', ''),
(190, 'GERODIAS, CHANTAL APHRODITE TATLONGMARIA', 'Nursing Service', ''),
(191, 'CAGUIOA, RAMIRO SERQUIÑA JR.', 'Nursing Service', ''),
(192, 'RIVERA, JOSEPH LASERNA', 'Nursing Service', ''),
(193, 'HERRERA, NICHOL MAGNO', 'Nursing Service', ''),
(194, 'NOGOT, JOAN BARLONGO', 'Nursing Service', ''),
(195, 'MELENDREZ, MICHAEL SILVESTRE', 'Nursing Service', ''),
(196, 'ZANTUA, SELWYN LOIS HADI', 'Nursing Service', ''),
(197, 'PELOTA, JAN MARK ALAN BELTRAN', 'Nursing Service', ''),
(198, 'ZAMORO, ARNOLD BULFA', 'Nursing Service', ''),
(199, 'MIRUL, MHIERSALYN ABDULLA', 'Nursing Service', ''),
(200, 'CARILLO, ZENMAE ABONITA', 'Nursing Service', ''),
(201, 'MARAVILLA, DAVID GABRIEL AMARO', 'Nursing Service', ''),
(202, 'CARIDO, NALLA LEONOR', 'Nursing Service', ''),
(203, 'MARTIN, JOHN ELREEN MILANA', 'Nursing Service', ''),
(204, 'MARTIN, CHRISTINE JOYCE CARTEL', 'Nursing Service', ''),
(205, 'FURIGAY, GEMMALYN NAVAL', 'Nursing Service', ''),
(206, 'HERNANDEZ, JACQUILINE HANNAH HILVANO', 'Nursing Service', ''),
(207, 'CAMPOS, MARIA ELENA VERAS', 'Nursing Service', ''),
(208, 'RICAFORT, RHIELLA AYRHA CORTEZ', 'Nursing Service', ''),
(209, 'ABAÑO, RAZZEL AGULTO', 'Nursing Service', ''),
(210, 'CADAY, FERNANDO CAPILI', 'Nursing Service', ''),
(211, 'ALMIRA, ABBEY JANE ROMERO', 'Nursing Service', ''),
(212, 'SUAREZ, RICHARD EVANGELISTA', 'Nursing Service', ''),
(213, 'CEZAR, MARY ADELAINE SUZANNE INAMAC', 'Nursing Service', ''),
(214, 'RAMOS, CINDY BRAZAS', 'Nursing Service', ''),
(215, 'KHAN, JOHN PATRICK CRUZ', 'Nursing Service', ''),
(216, 'ELECCION, BRYAN ESCOBAR', 'Nursing Service', ''),
(217, 'ONA, ROLAND IVAN TAN', 'Nursing Service', ''),
(218, 'PAJARES, KARISSA DEL ROSARIO', 'Nursing Service', ''),
(219, 'MATEL, DULSE CORPUZ', 'Nursing Service', ''),
(220, 'MARQUEZ, JOY CARATIQUIT', 'Nursing Service', ''),
(221, 'ROQUE, KARLYN LAPARA', 'Nursing Service', ''),
(222, 'AMATORIO, ARIANNE JOY FERRER', 'Nursing Service', ''),
(223, 'MANAY, ANGELA JOY CANASA', 'Nursing Service', ''),
(224, 'REMPIS, MARY BERNADETTE BORABO', 'Nursing Service', ''),
(225, 'UDARBE, IHRENE TOMANDAO', 'Nursing Service', ''),
(226, 'CUADRILLERO, GISELA BAURE', 'Nursing Service', ''),
(227, 'HIPOL, MAY CARIO', 'Nursing Service', ''),
(228, 'BUSTINERA, ERIKA JOY RAMOS', 'Nursing Service', ''),
(229, 'CARLOS, PATRICIA ALAINE ', 'Nursing Service', ''),
(230, 'PUZON, ROSARIO MERCEDEZ PANER', 'Nursing Service', ''),
(231, 'PADILLA, DYNEIL JOY ABALOS', 'Nursing Service', ''),
(232, 'CARANDANG, CARISSA NICOLETTE VILLALUZ', 'Nursing Service', ''),
(233, 'JACA, ALYANNA MARIE FERRER', 'Nursing Service', ''),
(234, 'MENDOZA, ALYSSA PAMELA LAROYA', 'Nursing Service', ''),
(235, 'RAMIREZ, EARLY JANE LIMPIOSO', 'Nursing Service', ''),
(236, 'DE VERO, CATHERINE BORLAGDA', 'Nursing Service', ''),
(237, 'ELNAR, KENT NEIL TEÑIDO', 'Nursing Service', ''),
(238, 'CAPUL, ELLYZA SIGUE', 'Nursing Service', ''),
(239, 'GERONIMO, NINA KRISTA SAJOR', 'Nursing Service', ''),
(240, 'GARRINO, LENI BALQUIN', 'Nursing Service', ''),
(241, 'BATALLONES, JAN KOLO DELFINO', 'Nursing Service', ''),
(242, 'LUCIANO, JOHN SAUL GARCIA', 'Nursing Service', ''),
(243, 'PADUA, MICHELLE MAE RAFOLS', 'Nursing Service', ''),
(244, 'ANTAS, AVE MARJOE LAYAG', 'Nursing Service', ''),
(245, 'CASUNURAN, LORRAINE ANNE SOCHACO', 'Nursing Service', ''),
(246, 'DALAS, ANALIZA MARCELO', 'Pharmacy', ''),
(247, 'LABIAN, MICHELLE PAHAYAHAY', 'Pharmacy', ''),
(248, 'PEPUGAL, VIENA LINSEN ALMEDA', 'Pharmacy', ''),
(249, 'SORIA, CRISTINE JOYCE MURILLO', 'Pharmacy', ''),
(250, 'PILI, EMYRR ANN GUARTE', 'Pharmacy', ''),
(251, 'BELESINA, KATHLYN MARIBETH CAPARAS', 'Pharmacy', ''),
(252, 'RAGUB, MAEVHELLE SELUDO', 'Pharmacy', ''),
(253, 'PASCUBILLO, JOESA MAY GRIFAL', 'Pharmacy', ''),
(254, 'CASTAÑAS, ELTON JOHN LABRAGUE', 'Pharmacy', ''),
(255, 'DELOS SANTOS, TIMOTHY JED MERCADO', 'Purchasing', ''),
(256, 'CASULUCAN, NEL KRIS AMOROSO', 'Purchasing', ''),
(257, 'PARAKIKAY, ALYZZA ANNE ALINSOD', 'Quality Management System', ''),
(258, 'ROBLES, ROCHELLE RAMOS', 'Quality Management System', ''),
(259, 'TORRES, R-JAY RIVERA', 'Quality Management System', ''),
(260, 'MAÑABO, ABIGAIL MARIE SOLLEZA', 'Radiology', ''),
(261, 'ALQUEZA, JEANNETTE MIGANO', 'Radiology', ''),
(262, 'DAYEGO, DANNELLE JOHN GUBI', 'Radiology', ''),
(263, 'IBIAS, CHRISTIAN CARLO TUZON', 'Radiology', ''),
(264, 'DOLIGOL, GINA DUNASCO', 'Radiology', ''),
(265, 'MAGSINO, CHRISTIAN KLEIN SERRANO', 'Radiology', ''),
(266, 'DE VERA, GABRIELLE', 'Radiology', ''),
(267, 'RAPADA, ANTONINA RAYGON', 'Radiology', ''),
(268, 'CUBANGBANG, CHRISTELLE JOY CABAUATAN', 'Radiology', ''),
(269, 'GABALES, LUZ MIKAELLA ALCALA', 'Radiology', ''),
(270, 'FABRE, EZHRA LAVIÑA', 'Radiology', ''),
(271, 'TATLONGMARIA, HANNAH MICHIKO ALFONSO', 'Radiology', ''),
(272, 'NAVALTA, PAOLO MIGUEL RIVERA', 'Radiology', ''),
(273, 'LACSON, KLAIREE KWIN ELEGADO', 'Radiology', ''),
(274, 'CANOY, DAY ANN ABELLAR', 'Rehabilitation Medicine', ''),
(275, 'BASLAN, YANNI CHIARA CALAUSTRO', 'Rehabilitation Medicine', ''),
(276, 'CREDO, CLEVIN TOM BAILADO', 'Rehabilitation Medicine', ''),
(277, 'BAWALAN, MARIEDENE ESCUETA', 'Rehabilitation Medicine', ''),
(278, 'SAYO, RHEAM RONZIEL RAMOS', 'Rehabilitation Medicine', ''),
(279, 'SUPETRAN, ELLAINE MAE RECAIDO', 'Rehabilitation Medicine', ''),
(280, 'BERCERO, BERNARDINO SALINAS', 'Rehabilitation Medicine', ''),
(281, 'BUTUYAN, CHEYENNE PARAS', 'Rehabilitation Medicine', ''),
(282, 'RIVERA, RADZEL JOSEPH DELA PAZ', 'Rehabilitation Medicine', ''),
(283, 'DE VILLA, FRANCO MATHEW BLASA', 'Rehabilitation Medicine', ''),
(284, 'DELA VEGA, HAYDEE PATRICIA JONSON', 'Rehabilitation Medicine', ''),
(285, 'HERNANDEZ, JUAN PAOLO SANTIAGO', 'Rehabilitation Medicine', ''),
(286, 'ESPELETA, RICHELLE RIA ARAMBULO', 'Rehabilitation Medicine', ''),
(287, 'FACTO, MAE-ANNE NAPILOT', 'Rehabilitation Medicine', ''),
(288, 'FACUN, KENNETH BRYAN AGPAOA', 'Rehabilitation Medicine', ''),
(289, 'SAMSON, LEAN THERESE HAY', 'Rehabilitation Medicine', ''),
(290, 'TALIÑO, ROSHELLE ANN BAYBAYAN', 'Rehabilitation Medicine', ''),
(291, 'UNIFORME, MARIA KLARIZA FAYE SANTIAGO', 'Rehabilitation Medicine', ''),
(292, 'ASUNIO, ALYSSA PADIOS', 'Social Service', ''),
(293, 'GARCIA, MA. ALYZA DAPUSIN', 'Social Service', ''),
(294, 'VILLANUEVA, MARIZOL PENTECOSTE', 'Special Diagnostic', ''),
(295, 'ABELLANA, MERRY DAWN CAMPECIÑO', 'Special Diagnostic', ''),
(296, 'AGBING,MA. JOBEL CARTA', 'Special Diagnostic', ''),
(297, 'BARAQUIEL, ERICKA GALLEGOS', 'Special Diagnostic', ''),
(298, 'LAYUG, ABIGAIL', 'Special Diagnostic', ''),
(299, 'CANLAS, ALLYANA MARIE CLASARA', 'Special Diagnostic', ''),
(300, 'NG, PATRICIA RIANZARES', 'Special Diagnostic', ''),
(301, 'BEBIC, CAROL ANN ALARCON', 'Special Diagnostic', ''),
(302, 'TRESVALLES, EDENEL PARAO', 'Special Diagnostic', ''),
(303, 'ABELLANA, RODLIEN MORALDE', 'Warehouse/CSR', ''),
(304, 'ENCINA, EDSEL BESTUDIO', 'Warehouse/CSR', ''),
(305, 'NAS, JEFFRY OPERIANO', 'Warehouse/CSR', '');

-- --------------------------------------------------------

--
-- Table structure for table `records_job_order`
--

CREATE TABLE `records_job_order` (
  `id` int(250) NOT NULL,
  `name` varchar(500) NOT NULL,
  `section` varchar(500) NOT NULL,
  `job_order_nature` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `issue_year` int(250) NOT NULL,
  `issue_month` varchar(500) NOT NULL,
  `issue_day` int(250) NOT NULL,
  `issue_time` varchar(500) NOT NULL,
  `assign_to` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `timestamp_received` varchar(500) NOT NULL,
  `computer_name` varchar(500) NOT NULL,
  `model` varchar(500) NOT NULL,
  `ip_address` varchar(500) NOT NULL,
  `operating_system` varchar(500) NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `timestamp_remarks` varchar(500) NOT NULL,
  `satisfied` varchar(500) NOT NULL,
  `unsatisfied` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id_no`);

--
-- Indexes for table `category_job_order`
--
ALTER TABLE `category_job_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `records_job_order`
--
ALTER TABLE `records_job_order`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id_no` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `category_job_order`
--
ALTER TABLE `category_job_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318;

--
-- AUTO_INCREMENT for table `records_job_order`
--
ALTER TABLE `records_job_order`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
