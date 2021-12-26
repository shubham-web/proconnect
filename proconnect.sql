-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2021 at 05:15 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesstokens`
--

CREATE TABLE `accesstokens` (
  `id` int(9) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `targetUser` int(9) NOT NULL,
  `lastUsedAt` datetime DEFAULT current_timestamp(),
  `createdAt` datetime DEFAULT current_timestamp(),
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accesstokens`
--

INSERT INTO `accesstokens` (`id`, `token`, `targetUser`, `lastUsedAt`, `createdAt`, `ip`) VALUES
(74, '4bff2a7a195d9e81eaeb1df9a10f7a1e', 8, '2021-12-26 20:09:54', '2021-12-26 20:09:54', '::1'),
(76, '35bc24b951386568201082dfd8e2a0e9', 3, '2021-12-26 20:14:42', '2021-12-26 20:14:42', '::1'),
(77, '6f450b0207db022ffaf0245ba91ee534', 1, '2021-12-26 20:15:01', '2021-12-26 20:15:01', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(9) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'Afghanistan'),
(2, 'Åland Islands'),
(3, 'Albania'),
(4, 'Algeria'),
(5, 'American Samoa'),
(6, 'AndorrA'),
(7, 'Angola'),
(8, 'Anguilla'),
(9, 'Antarctica'),
(10, 'Antigua and Barbuda'),
(11, 'Argentina'),
(12, 'Armenia'),
(13, 'Aruba'),
(14, 'Australia'),
(15, 'Austria'),
(16, 'Azerbaijan'),
(17, 'Bahamas'),
(18, 'Bahrain'),
(19, 'Bangladesh'),
(20, 'Barbados'),
(21, 'Belarus'),
(22, 'Belgium'),
(23, 'Belize'),
(24, 'Benin'),
(25, 'Bermuda'),
(26, 'Bhutan'),
(27, 'Bolivia'),
(28, 'Bosnia and Herzegovina'),
(29, 'Botswana'),
(30, 'Bouvet Island'),
(31, 'Brazil'),
(32, 'British Indian Ocean Territory'),
(33, 'Brunei Darussalam'),
(34, 'Bulgaria'),
(35, 'Burkina Faso'),
(36, 'Burundi'),
(37, 'Cambodia'),
(38, 'Cameroon'),
(39, 'Canada'),
(40, 'Cape Verde'),
(41, 'Cayman Islands'),
(42, 'Central African Republic'),
(43, 'Chad'),
(44, 'Chile'),
(45, 'China'),
(46, 'Christmas Island'),
(47, 'Cocos (Keeling) Islands'),
(48, 'Colombia'),
(49, 'Comoros'),
(50, 'Congo'),
(51, 'Congo, The Democratic Republic of the'),
(52, 'Cook Islands'),
(53, 'Costa Rica'),
(54, 'Cote D\'Ivoire'),
(55, 'Croatia'),
(56, 'Cuba'),
(57, 'Cyprus'),
(58, 'Czech Republic'),
(59, 'Denmark'),
(60, 'Djibouti'),
(61, 'Dominica'),
(62, 'Dominican Republic'),
(63, 'Ecuador'),
(64, 'Egypt'),
(65, 'El Salvador'),
(66, 'Equatorial Guinea'),
(67, 'Eritrea'),
(68, 'Estonia'),
(69, 'Ethiopia'),
(70, 'Falkland Islands (Malvinas)'),
(71, 'Faroe Islands'),
(72, 'Fiji'),
(73, 'Finland'),
(74, 'France'),
(75, 'French Guiana'),
(76, 'French Polynesia'),
(77, 'French Southern Territories'),
(78, 'Gabon'),
(79, 'Gambia'),
(80, 'Georgia'),
(81, 'Germany'),
(82, 'Ghana'),
(83, 'Gibraltar'),
(84, 'Greece'),
(85, 'Greenland'),
(86, 'Grenada'),
(87, 'Guadeloupe'),
(88, 'Guam'),
(89, 'Guatemala'),
(90, 'Guernsey'),
(91, 'Guinea'),
(92, 'Guinea-Bissau'),
(93, 'Guyana'),
(94, 'Haiti'),
(95, 'Heard Island and Mcdonald Islands'),
(96, 'Holy See (Vatican City State)'),
(97, 'Honduras'),
(98, 'Hong Kong'),
(99, 'Hungary'),
(100, 'Iceland'),
(101, 'India'),
(102, 'Indonesia'),
(103, 'Iran, Islamic Republic Of'),
(104, 'Iraq'),
(105, 'Ireland'),
(106, 'Isle of Man'),
(107, 'Israel'),
(108, 'Italy'),
(109, 'Jamaica'),
(110, 'Japan'),
(111, 'Jersey'),
(112, 'Jordan'),
(113, 'Kazakhstan'),
(114, 'Kenya'),
(115, 'Kiribati'),
(116, 'Korea, Democratic People\'S Republic of'),
(117, 'Korea, Republic of'),
(118, 'Kuwait'),
(119, 'Kyrgyzstan'),
(120, 'Lao People\'S Democratic Republic'),
(121, 'Latvia'),
(122, 'Lebanon'),
(123, 'Lesotho'),
(124, 'Liberia'),
(125, 'Libyan Arab Jamahiriya'),
(126, 'Liechtenstein'),
(127, 'Lithuania'),
(128, 'Luxembourg'),
(129, 'Macao'),
(130, 'Macedonia, The Former Yugoslav Republic of'),
(131, 'Madagascar'),
(132, 'Malawi'),
(133, 'Malaysia'),
(134, 'Maldives'),
(135, 'Mali'),
(136, 'Malta'),
(137, 'Marshall Islands'),
(138, 'Martinique'),
(139, 'Mauritania'),
(140, 'Mauritius'),
(141, 'Mayotte'),
(142, 'Mexico'),
(143, 'Micronesia, Federated States of'),
(144, 'Moldova, Republic of'),
(145, 'Monaco'),
(146, 'Mongolia'),
(147, 'Montserrat'),
(148, 'Morocco'),
(149, 'Mozambique'),
(150, 'Myanmar'),
(151, 'Namibia'),
(152, 'Nauru'),
(153, 'Nepal'),
(154, 'Netherlands'),
(155, 'Netherlands Antilles'),
(156, 'New Caledonia'),
(157, 'New Zealand'),
(158, 'Nicaragua'),
(159, 'Niger'),
(160, 'Nigeria'),
(161, 'Niue'),
(162, 'Norfolk Island'),
(163, 'Northern Mariana Islands'),
(164, 'Norway'),
(165, 'Oman'),
(166, 'Pakistan'),
(167, 'Palau'),
(168, 'Palestinian Territory, Occupied'),
(169, 'Panama'),
(170, 'Papua New Guinea'),
(171, 'Paraguay'),
(172, 'Peru'),
(173, 'Philippines'),
(174, 'Pitcairn'),
(175, 'Poland'),
(176, 'Portugal'),
(177, 'Puerto Rico'),
(178, 'Qatar'),
(179, 'Reunion'),
(180, 'Romania'),
(181, 'Russian Federation'),
(182, 'RWANDA'),
(183, 'Saint Helena'),
(184, 'Saint Kitts and Nevis'),
(185, 'Saint Lucia'),
(186, 'Saint Pierre and Miquelon'),
(187, 'Saint Vincent and the Grenadines'),
(188, 'Samoa'),
(189, 'San Marino'),
(190, 'Sao Tome and Principe'),
(191, 'Saudi Arabia'),
(192, 'Senegal'),
(193, 'Serbia and Montenegro'),
(194, 'Seychelles'),
(195, 'Sierra Leone'),
(196, 'Singapore'),
(197, 'Slovakia'),
(198, 'Slovenia'),
(199, 'Solomon Islands'),
(200, 'Somalia'),
(201, 'South Africa'),
(202, 'South Georgia and the South Sandwich Islands'),
(203, 'Spain'),
(204, 'Sri Lanka'),
(205, 'Sudan'),
(206, 'Suriname'),
(207, 'Svalbard and Jan Mayen'),
(208, 'Swaziland'),
(209, 'Sweden'),
(210, 'Switzerland'),
(211, 'Syrian Arab Republic'),
(212, 'Taiwan, Province of China'),
(213, 'Tajikistan'),
(214, 'Tanzania, United Republic of'),
(215, 'Thailand'),
(216, 'Timor-Leste'),
(217, 'Togo'),
(218, 'Tokelau'),
(219, 'Tonga'),
(220, 'Trinidad and Tobago'),
(221, 'Tunisia'),
(222, 'Turkey'),
(223, 'Turkmenistan'),
(224, 'Turks and Caicos Islands'),
(225, 'Tuvalu'),
(226, 'Uganda'),
(227, 'Ukraine'),
(228, 'United Arab Emirates'),
(229, 'United Kingdom'),
(230, 'United States'),
(231, 'United States Minor Outlying Islands'),
(232, 'Uruguay'),
(233, 'Uzbekistan'),
(234, 'Vanuatu'),
(235, 'Venezuela'),
(236, 'Viet Nam'),
(237, 'Virgin Islands, British'),
(238, 'Virgin Islands, U.S.'),
(239, 'Wallis and Futuna'),
(240, 'Western Sahara'),
(241, 'Yemen'),
(242, 'Zambia'),
(243, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2021-12-21-171056', 'App\\Database\\Migrations\\Users', 'default', 'App', 1640458361, 1),
(2, '2021-12-21-174137', 'App\\Database\\Migrations\\UserMeta', 'default', 'App', 1640458361, 1),
(3, '2021-12-21-180207', 'App\\Database\\Migrations\\Posts', 'default', 'App', 1640458361, 1),
(4, '2021-12-21-181941', 'App\\Database\\Migrations\\CreateAdmins', 'default', 'App', 1640458361, 1),
(5, '2021-12-22-021350', 'App\\Database\\Migrations\\CreateCountry', 'default', 'App', 1640458361, 1),
(6, '2021-12-22-053204', 'App\\Database\\Migrations\\CreateAccessTokensTable', 'default', 'App', 1640458361, 1),
(7, '2021-12-22-060020', 'App\\Database\\Migrations\\AddIpInAccessToken', 'default', 'App', 1640458361, 1),
(8, '2021-12-23-062614', 'App\\Database\\Migrations\\AddRoleInUsers', 'default', 'App', 1640458361, 1),
(9, '2021-12-23-064134', 'App\\Database\\Migrations\\RemoveTypeFromAccesstoken', 'default', 'App', 1640458361, 1),
(10, '2021-12-23-064233', 'App\\Database\\Migrations\\RemoveAdminTable', 'default', 'App', 1640458361, 1),
(11, '2021-12-23-120240', 'App\\Database\\Migrations\\AddStatusColumn', 'default', 'App', 1640458361, 1),
(12, '2021-12-26-040059', 'App\\Database\\Migrations\\AddprofileHeaderInUsers', 'default', 'App', 1640491319, 2),
(13, '2021-12-26-040521', 'App\\Database\\Migrations\\AddTimestampInPosts', 'default', 'App', 1640491564, 3),
(14, '2021-12-26-070536', 'App\\Database\\Migrations\\AddDpInUsersTable', 'default', 'App', 1640502392, 4),
(15, '2021-12-26-085624', 'App\\Database\\Migrations\\ChangeLikesType', 'default', 'App', 1640509091, 5),
(16, '2021-12-26-103421', 'App\\Database\\Migrations\\RemoveDpAndHeaderfromemta', 'default', 'App', 1640514916, 6);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(9) NOT NULL,
  `userId` int(9) NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `media` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `likes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','SUSPENDED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `createdAt` datetime DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `userId`, `text`, `media`, `likes`, `status`, `createdAt`, `updatedAt`) VALUES
(17, 1, 'New-age skills for the youth of the future! 🤩 #Skillstars are ready to show their calibre in these seven skills introduced for the first time in #IndiaSkills2021. Make sure you catch them in action at Pragati Maidan, New Delhi. Wish them luck as they aim for the stars!✨ #IndiaKeSkillStar', '{\"images\":[{\"url\":\"usercontent\\/1\\/posts\\/1640498301_0101717b77e829b201fb.jpg\"}],\"video\":[]}', '', 'ACTIVE', '2021-12-26 11:28:22', '2021-12-26 19:46:14'),
(18, 1, 'Inspired to see the energy & passion of these young participants! 💪', '{\"images\":[],\"video\":[{\"url\":\"usercontent\\/1\\/posts\\/1640498624_95c29f9adad9b97710fd.mp4\"}]}', '', 'ACTIVE', '2021-12-26 11:33:45', '2021-12-26 19:46:11'),
(20, 1, '#DualScreenWallpapers', '{\"images\":[{\"url\":\"usercontent\\/1\\/posts\\/1640498707_ded23b3238add08cfbb3.jpg\"},{\"url\":\"usercontent\\/1\\/posts\\/1640498707_83b73ab01d3e32d50461.jpg\"},{\"url\":\"usercontent\\/1\\/posts\\/1640498707_f5d2c08c028b2f716011.jpg\"}],\"video\":[]}', '1', 'ACTIVE', '2021-12-26 11:35:07', '2021-12-26 14:51:54'),
(22, 8, 'Hi Guys!!', '{\"images\":[],\"video\":[]}', '1', 'ACTIVE', '2021-12-26 13:13:53', '2021-12-26 15:00:40'),
(23, 1, 'Let\'s meet in Delhi Guys!!! ', '{\"images\":[{\"url\":\"usercontent\\/1\\/posts\\/1640505845_675e45d45a5ccfbaf109.jfif\"}],\"video\":[]}', '8,1', 'ACTIVE', '2021-12-26 13:34:05', '2021-12-26 20:02:25'),
(24, 1, 'Test post', '{\"images\":[{\"url\":\"usercontent\\/1\\/posts\\/1640528385_cb599be96473093ebb06.webp\"}],\"video\":[]}', NULL, 'ACTIVE', '2021-12-26 19:49:45', '2021-12-26 19:49:45'),
(25, 1, 'test', '{\"images\":[{\"url\":\"usercontent\\/1\\/posts\\/1640528530_ce69ab2405e8e7f9694b.jpg\"}],\"video\":[]}', NULL, 'ACTIVE', '2021-12-26 19:52:10', '2021-12-26 19:52:10'),
(26, 1, 'Video test', '{\"images\":[],\"video\":[{\"url\":\"usercontent\\/1\\/posts\\/1640528913_5950ccd455eefbe1c3cc.mp4\"}]}', NULL, 'ACTIVE', '2021-12-26 19:58:33', '2021-12-26 19:58:33'),
(30, 1, '', '{\"images\":[{\"url\":\"usercontent\\/1\\/posts\\/1640529107_e733227f4d9b0de1e7c8.jpg\"},{\"url\":\"usercontent\\/1\\/posts\\/1640529108_d0e1773906d6108a7a83.jpg\"}],\"video\":[]}', '1', 'ACTIVE', '2021-12-26 20:01:48', '2021-12-26 20:04:37');

-- --------------------------------------------------------

--
-- Table structure for table `usermeta`
--

CREATE TABLE `usermeta` (
  `id` int(9) NOT NULL,
  `userId` int(9) NOT NULL,
  `experience` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profileViews` int(9) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usermeta`
--

INSERT INTO `usermeta` (`id`, `userId`, `experience`, `education`, `profileViews`) VALUES
(1, 1, '[{\"company\":\"XYZ Inc.\",\"title\":\"JS Developer\",\"startDate\":\"1\\/2\\/2019\",\"endDate\":\"12\\/6\\/2020\",\"id\":1}]', '[{\"institute\":\"SFE\",\"course\":\"HSS\",\"stream\":\"Maths\",\"startDate\":\"1\\/2\\/2014\",\"endDate\":\"12\\/6\\/2018\",\"id\":1}]', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(9) NOT NULL,
  `firstName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` int(4) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` bigint(15) NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('VERIFIED','UNVERIFIED','SUSPENDED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'VERIFIED',
  `dob` date DEFAULT NULL,
  `createdAt` datetime DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('USER','ADMIN','MAINTAINER') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USER',
  `profileHeader` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `country`, `email`, `mobile`, `password`, `status`, `dob`, `createdAt`, `updatedAt`, `role`, `profileHeader`, `dp`) VALUES
(1, 'Shubh', 'Prajapat', 101, 'shubham@indiaskills.com', 8319505750, '$2y$10$XpV21pH8RLulSgGK3e2iLeaxIm3IruqVV4P/zOHgsxiQpx74BoWje', 'VERIFIED', '2004-09-01', '2021-12-26 00:22:50', '2021-12-26 20:02:06', 'USER', 'Web Dev', 'usercontent/1/profile/1640528598_64eeb81a8c727d3f6054.jpg'),
(2, 'Juned', 'Adenwalla', 101, 'juned@indiaskills.com', 5867551564, '$2y$10$ctsT1uLDM/GXAbNVc8t6Eudpdq5bNTicWZajZA6kDRWHTSBpjs9ju', 'VERIFIED', '2001-09-07', '2021-12-26 00:22:50', '2021-12-26 00:22:50', 'USER', NULL, NULL),
(3, 'Nidhanshu', 'Sharma', 101, 'nidhanshu@indiaskills.com', 4492406982, '$2y$10$r0IJY8uNeQ2m8.FnnhJAnOfxCZunAyWsY8UwxNwZrngSJ2rQBL12W', 'VERIFIED', '2002-09-13', '2021-12-26 00:22:50', '2021-12-26 13:24:23', 'ADMIN', NULL, NULL),
(4, 'Shri Hari', 'L', 101, 'shrihari@indiaskills.com', 9849853624, '$2y$10$rhx5W.e6Gu8X0mfFSpmQgeo2RKfG4Fh2mhQbj1MjLaba1zJEdcPpG', 'VERIFIED', '2000-03-24', '2021-12-26 00:22:50', '2021-12-26 00:22:50', 'USER', NULL, NULL),
(5, 'Advaith', 'AJ', 101, 'aj@indiaskills.com', 7812729016, '$2y$10$sezEWtJ3P30PV8JMHHCpl.jG2TIr.CYDyyxyOZfy2JYFaf.wxR91i', 'VERIFIED', '2003-11-06', '2021-12-26 00:22:50', '2021-12-26 00:22:50', 'USER', NULL, NULL),
(6, 'Aliya', 'Parveen', 101, 'aliya@indiaskills.com', 1215100970, '$2y$10$Enn0lnCHWYSM8Dc/gso4YONHpxaBbiWQ/ajFbdfwAaMBtL3Iz0bHy', 'VERIFIED', '2000-02-17', '2021-12-26 00:22:50', '2021-12-26 00:22:50', 'USER', NULL, NULL),
(7, 'Aashish Kumar', 'Verma', 101, 'aashish@indiaskills.com', 8050824638, '$2y$10$oOGmisjYEKAaXUplmuthVOqmoMQTJtxuaKpHx7SCauaEHc11TkkDG', 'SUSPENDED', '1999-05-11', '2021-12-26 00:22:50', '2021-12-26 19:56:44', 'USER', NULL, NULL),
(8, 'Pritam', 'Das', 101, 'pritam@indiaskills.com', 2189043261, '$2y$10$2C2fwTEmoMxZXsfUFAW/KeMTh7/gj4mCluT2YC4PbeExkSIKp5qY6', 'VERIFIED', '2002-01-01', '2021-12-26 00:22:50', '2021-12-26 00:22:50', 'USER', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesstokens`
--
ALTER TABLE `accesstokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usermeta`
--
ALTER TABLE `usermeta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesstokens`
--
ALTER TABLE `accesstokens`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `usermeta`
--
ALTER TABLE `usermeta`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
