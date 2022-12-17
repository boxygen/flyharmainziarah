-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2022 at 08:05 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `v8`
--

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) NOT NULL,
  `parent_id` enum('hotels','flights','tours','cars','visa','reviews','extra','rental','cruise') NOT NULL,
  `name` varchar(150) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `settings` text NOT NULL,
  `order` varchar(300) NOT NULL,
  `c1` varchar(225) NOT NULL,
  `c2` varchar(225) NOT NULL,
  `c3` varchar(225) NOT NULL,
  `c4` varchar(225) NOT NULL,
  `c5` varchar(225) NOT NULL,
  `c6` varchar(225) NOT NULL,
  `c7` varchar(225) NOT NULL,
  `c8` varchar(225) NOT NULL,
  `c9` varchar(225) NOT NULL,
  `c10` varchar(225) NOT NULL,
  `b2c_markup` int(11) NOT NULL DEFAULT 0,
  `b2b_markup` int(11) NOT NULL DEFAULT 0,
  `b2e_markup` int(11) NOT NULL DEFAULT 0,
  `developer_mode` varchar(225) NOT NULL,
  `desposit` int(11) NOT NULL DEFAULT 0,
  `tax` int(11) NOT NULL DEFAULT 0,
  `servicefee` int(11) NOT NULL DEFAULT 0,
  `deposit_type` varchar(225) NOT NULL DEFAULT '0',
  `tax_type` varchar(225) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `module_currency` varchar(225) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `parent_id`, `name`, `is_active`, `settings`, `order`, `c1`, `c2`, `c3`, `c4`, `c5`, `c6`, `c7`, `c8`, `c9`, `c10`, `b2c_markup`, `b2b_markup`, `b2e_markup`, `developer_mode`, `desposit`, `tax`, `servicefee`, `deposit_type`, `tax_type`, `color`, `module_currency`, `payment_mode`) VALUES
(1, 'extra', 'Blog', 1, '{\"name\":\"Blog\",\"label\":\"Blog\",\"slug\":\"blog\",\"frontend\":{\"label\":\"Blog\",\"slug\":\"blog\",\"icon\":\"blog.png\"},\"description\":\"\",\"active\":1,\"order\":\"26\",\"menus\":{\"icon\":\"<span class=\'material-icons\'>auto_stories<\\/span>\",\"admin\":[{\"label\":\"Posts\",\"link\":\"admin\\/blog\"},{\"label\":\"Blog Categories\",\"link\":\"admin\\/blog\\/category\"},{\"label\":\"Blog Settings\",\"link\":\"admin\\/blog\\/settings\"}],\"supplier\":[]}}', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 0, 0, 0, '', NULL, NULL, 'USD', NULL),
(2, 'cars', 'Cars', 0, '{\"name\":\"Cars\",\"label\":\"Cars\",\"slug\":\"cars\",\"frontend\":{\"label\":\"Cars\",\"slug\":\"cars\",\"icon\":\"la la-car\"},\"description\":\"\",\"active\":0,\"order\":\"1\",\"menus\":{\"icon\":\"fa fa-car\",\"admin\":[{\"label\":\"Cars\",\"link\":\"admin\\/cars\"},{\"label\":\"Extras\",\"link\":\"admin\\/cars\\/extras\"},{\"label\":\"Cars Settings\",\"link\":\"admin\\/cars\\/settings\"}],\"supplier\":[{\"label\":\"Cars\",\"link\":\"supplier\\/cars\"},{\"label\":\"Extras\",\"link\":\"supplier\\/cars\\/extras\"}]}}', '5', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 0, 0, 0, '', NULL, NULL, 'USD', NULL),
(4, 'extra', 'Coupons', 0, '{\"name\":\"Coupons\",\"label\":\"Coupons\",\"slug\":\"\",\"frontend\":[],\"description\":\"\",\"active\":0,\"order\":\"29\",\"menus\":{\"icon\":\"\",\"admin\":[],\"supplier\":[]}}', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 0, 0, 0, '', NULL, NULL, 'USD', NULL),
(6, 'flights', 'Flights', 1, '{\"name\":\"Flights\",\"label\":\"Flights\",\"slug\":\"flights\",\"test\":\"false\",\"frontend\":{\"label\":\"Flights\",\"slug\":\"flights\",\"icon\":\"la la-plane\"},\"description\":\"\",\"active\":1,\"order\":\"1\",\"menus\":{\"icon\":\"fa fa-plane\",\"admin\":[{\"label\":\"Routes\",\"link\":\"admin\\/flights\\/routes\"},{\"label\":\"Airports\",\"link\":\"admin\\/flights\\/airports\"},{\"label\":\"Airlines\",\"link\":\"admin\\/flights\\/airlines\"},{\"label\":\"Countries\",\"link\":\"admin\\/flights\\/countries\"},{\"label\":\"Featured Flights\",\"link\":\"admin\\/flights\"},{\"label\":\"Settings\",\"link\":\"admin\\/settings\\/modules\\/module_setting\\/flights\"}],\"supplier\":[]},\"\":null}', '2', '', '', '', '', '', '', '', '', '', '', 10, 5, 2, '0', 100, 10, 5, '', NULL, '#000000', 'USD', NULL),
(8, 'hotels', 'Hotels', 1, '{\"name\":\"Hotels\",\"label\":\"Hotels\",\"slug\":\"hotels\",\"frontend\":{\"label\":\"Hotels\",\"slug\":\"hotels\",\"icon\":\"la la-building-o\"},\"description\":\"\",\"active\":1,\"order\":\"1\",\"menus\":{\"icon\":\"fa fa-building-o\",\"admin\":[{\"label\":\"Hotels\",\"link\":\"admin\\/hotels\"},{\"label\":\"Rooms\",\"link\":\"admin\\/hotels\\/rooms\"},{\"label\":\"Extras\",\"link\":\"admin\\/hotels\\/extras\"},{\"label\":\"Reviews\",\"link\":\"admin\\/hotels\\/reviews\"},{\"label\":\"Settings\",\"link\":\"admin\\/hotels\\/settings\"}],\"supplier\":[{\"label\":\"Manage Hotels\",\"link\":\"supplier\\/hotels\"},{\"label\":\"Manage Rooms\",\"link\":\"supplier\\/hotels\\/rooms\"},{\"label\":\"Add Room\",\"link\":\"supplier\\/hotels\\/rooms\\/add\"},{\"label\":\"Extras\",\"link\":\"supplier\\/hotels\\/extras\"}]},\"ordering\":\"645\"}', '1', '', '', '', '', '', '', '', '', '', '', 10, 5, 2, '', 100, 2, 10, 'percentage', 'percentage', NULL, 'USD', NULL),
(12, 'extra', 'Locations', 1, '{\"name\":\"Locations\",\"label\":\"Locations\",\"slug\":\"\",\"frontend\":[],\"description\":\"\",\"active\":1,\"order\":\"28\",\"menus\":{\"icon\":\"<span class=\'material-icons\'>map<\\/span>\",\"admin\":[{\"label\":\"Locations \",\"link\":\"admin\\/locations\"}],\"supplier\":[{\"label\":\"Locations\",\"link\":\"supplier\\/locations\"}]}}', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 0, 0, 0, '', NULL, NULL, 'USD', NULL),
(13, 'extra', 'Newsletter', 1, '{\"name\":\"Newsletter\",\"label\":\"Newsletter\",\"slug\":\"\",\"frontend\":[],\"description\":\"\",\"active\":1,\"order\":\"31\",\"menus\":{\"icon\":\"\",\"admin\":[],\"supplier\":[]}}', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 0, 0, 0, '', NULL, NULL, 'USD', NULL),
(14, 'extra', 'Offers', 1, '{\"name\":\"Offers\",\"label\":\"Offers\",\"slug\":\"offers\",\"frontend\":{\"label\":\"Offers\",\"slug\":\"offers\",\"icon\":\"offers.png\"},\"description\":\"\",\"active\":1,\"order\":\"25\",\"menus\":{\"icon\":\"\",\"admin\":[],\"supplier\":[]}}', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 0, 0, 0, '', NULL, NULL, 'USD', NULL),
(15, 'extra', 'Reviews', 0, '{\"name\":\"Reviews\",\"label\":\"Reviews\",\"slug\":\"\",\"frontend\":[],\"description\":\"\",\"active\":0,\"order\":\"29\",\"menus\":{\"icon\":\"\",\"admin\":[],\"supplier\":[]}}', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 0, 0, 0, '', NULL, NULL, 'USD', NULL),
(16, 'tours', 'Tours', 1, '{\"name\":\"Tours\",\"label\":\"Tours\",\"slug\":\"tours\",\"frontend\":{\"label\":\"Tours\",\"slug\":\"tours\",\"icon\":\"la la-suitcase\"},\"description\":\"\",\"active\":1,\"order\":\"3\",\"menus\":{\"icon\":\"fa fa-suitcase\",\"admin\":[{\"label\":\"Tours\",\"link\":\"admin\\/tours\"},{\"label\":\"Extras\",\"link\":\"admin\\/tours\\/extras\"},{\"label\":\"Reviews\",\"link\":\"admin\\/tours\\/reviews\"},{\"label\":\"Settings\",\"link\":\"admin\\/tours\\/settings\"}],\"supplier\":[{\"label\":\"Manage Tours\",\"link\":\"supplier\\/tours\"},{\"label\":\"Extras\",\"link\":\"supplier\\/tours\\/extras\"}]}}', '3', '', '', '', '', '', '', '', '', '', '', 10, 5, 3, '', 100, 10, 10, 'percentage', 'fixed', NULL, 'USD', NULL),
(26, 'tours', 'Viator', 1, '{\"name\":\"Viator\",\"label\":\"Viator\",\"slug\":\"viator\",\"frontend\":{\"label\":\"Viator\",\"slug\":\"viator\",\"icon\":\"flight.png\"},\"description\":\"\",\"active\":1,\"order\":\"21\",\"menus\":{\"icon\":\"fa fa-tag\",\"admin\":[{\"label\":\"viator Settings\",\"link\":\"admin\\/viator\\/settings\"}],\"supplier\":[]},\"settings\":{\"api_environment\":\"production\",\"api_endpoint\":\"https:\\/\\/viatorapi.viator.com\\/service\\/\",\"apiKey\":\"380374363657375804\"}}', '3', '28fdcf77-82bf-4389-9295-6afdd1828002', '', '', '', '', '', '', '', '', '', 10, 5, 3, '0', 100, 0, 0, '', NULL, '#176a6e', 'USD', '1'),
(39, 'rental', 'Rentals', 0, '{\"name\":\"Rentals\",\"label\":\"Rentals\",\"slug\":\"rentals\",\"frontend\":{\"label\":\"Rentals\",\"slug\":\"rentals\",\"icon\":\"tour.png\"},\"description\":\"\",\"active\":0,\"order\":\"20\",\"menus\":{\"icon\":\"fa fa-suitcase\",\"admin\":[{\"label\":\"Rentals\",\"link\":\"admin\\/rentals\"},{\"label\":\"Extras\",\"link\":\"admin\\/rentals\\/extras\"},{\"label\":\"Reviews\",\"link\":\"admin\\/rentals\\/reviews\"},{\"label\":\"Settings\",\"link\":\"admin\\/rentals\\/settings\"}],\"supplier\":[{\"label\":\"Manage Tours\",\"link\":\"supplier\\/tours\"},{\"label\":\"Extras\",\"link\":\"supplier\\/tours\\/extras\"}]}}', '1', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 0, 0, 0, '', NULL, NULL, 'USD', NULL),
(40, 'cruise', 'Boats', 0, '{\"name\":\"Boats\",\"label\":\"Boats\",\"slug\":\"boats\",\"frontend\":{\"label\":\"Boats\",\"slug\":\"boats\",\"icon\":\"la la-suitcase\"},\"description\":\"\",\"active\":0,\"order\":\"19\",\"menus\":{\"icon\":\"fa fa-suitcase\",\"admin\":[{\"label\":\"Boats\",\"link\":\"admin\\/boats\"},{\"label\":\"Add New\",\"link\":\"admin\\/boats\\/add\"},{\"label\":\"Extras\",\"link\":\"admin\\/boats\\/extras\"},{\"label\":\"Reviews\",\"link\":\"admin\\/boats\\/reviews\"},{\"label\":\"Settings\",\"link\":\"admin\\/boats\\/settings\"}],\"supplier\":[{\"label\":\"Manage Rentals\",\"link\":\"supplier\\/rentals\"},{\"label\":\"Extras\",\"link\":\"supplier\\/rentals\\/extras\"}]}}', '2', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 0, 0, 0, '', NULL, NULL, 'USD', NULL),
(47, 'hotels', 'Rezlives', 0, '{\"name\":\"Rezlives\",\"label\":\"Rezlives\",\"slug\":\"rezlives\",\"frontend\":{\"label\":\"Hotels\",\"slug\":\"properties\",\"icon\":\"hotel.png\"},\"description\":\"\",\"active\":0,\"order\":\"2\",\"menus\":{\"icon\":\"fa fa-building\",\"admin\":[{\"label\":\"Bookings\",\"link\":\"admin\\/rezlives\\/bookings\"},{\"label\":\"Settings\",\"link\":\"admin\\/settings\\/modules\\/module_setting\\/rezlives\"}],\"supplier\":[]}}', '1', 'CD32251', 'reims.qviclub', 'Selangor@2021', '', '', '', '', '', '', '', 10, 5, 2, '0', 5, 3, 4, '', NULL, '#f9af4c', 'USD', '1'),
(49, 'visa', 'Ivisa', 0, '{\"name\":\"ivisa\",\"label\":\"Visa\",\"slug\":\"ivisa\",\"frontend\":{\"label\":\"Visa\",\"slug\":\"ivisa\",\"icon\":\"la la-tag\"},\"description\":\"\",\"active\":0,\"order\":\"1\",\"menus\":{\"icon\":\"fa fa-tag\",\"admin\":[{\"label\":\"Settings\",\"link\":\"admin\\/ivisa\\/settings\"},{\"label\":\"Bookings\",\"link\":\"admin\\/ivisa\\/booking\"}],\"supplier\":[]}}', '6', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 0, 0, 0, '', NULL, NULL, 'USD', NULL),
(54, 'flights', 'Kiwi', 0, '{\"name\":\"Kiwi\",\"label\":\"Kiwi\",\"slug\":\"kiwi\",\"test\":\"false\",\"frontend\":{\"label\":\"Flights\",\"slug\":\"flights\",\"icon\":\"la la-plane\"},\"description\":\"\",\"active\":0,\"order\":\"3\",\"menus\":{\"icon\":\"fa fa-plane\",\"admin\":[{\"label\":\"Settings\",\"link\":\"admin\\/settings\\/modules\\/module_setting\\/kiwi\\/\"},{\"label\":\"Bookings\",\"link\":\"admin\\/kiwi\\/bookings\"}],\"supplier\":[]},\"\":null}', '2', 'booknowphptravels', 'hM_ulx_KEwojzGyTCrKeSJuWMUVJWIA9', '', '', '', '', '', '', '', '', 10, 10, 10, '1', 10, 10, 10, '', NULL, '#00a991', 'USD', '1'),
(57, 'flights', 'Amadeus', 1, '{\"name\":\"Amadeus\",\"label\":\"Amadeus\",\"slug\":\"amadeus\",\"test\":\"false\",\"frontend\":{\"label\":\"Flights\",\"slug\":\"flights\",\"icon\":\"la la-plane\"},\"description\":\"\",\"active\":1,\"order\":\"2\",\"menus\":{\"icon\":\"fa fa-plane\",\"admin\":[{\"label\":\"Settings\",\"link\":\"admin\\/settings\\/modules\\/module_setting\\/amadeus\\/\"},{\"label\":\"Bookings\",\"link\":\"admin\\/amadeus\\/bookings\"}],\"supplier\":[]},\"\":null}', '2', 'client_credentials', '96SUxWJF6Jum216jiJjWWxbCfkFIB3wG', 'KN1B1ces6kppK5ET', '', '', '', '', '', '', '', 10, 5, 3, '1', 100, 5, 0, '', NULL, '#005eb8', 'USD', '1'),
(58, 'flights', 'Aerticket', 0, '{\"name\":\"Aerticket\",\"label\":\"Aerticket\",\"slug\":\"aerticket\",\"test\":\"false\",\"frontend\":{\"label\":\"Flights\",\"slug\":\"flights\",\"icon\":\"la la-plane\"},\"description\":\"\",\"active\":0,\"order\":\"4\",\"menus\":{\"icon\":\"fa fa-plane\",\"admin\":[{\"label\":\"Settings\",\"link\":\"admin\\/settings\\/modules\\/module_setting\\/aerticket\\/\"},{\"label\":\"Bookings\",\"link\":\"admin\\/aerticket\\/bookings\"}],\"supplier\":[]},\"\":null}', '2', '930661', '^RslASmVBXvSV#tr', '', '', '', '', '', '', '', '', 10, 5, 3, '1', 100, 0, 0, '0', NULL, '#2258a6', 'USD', '1'),
(59, 'hotels', 'Hotelston', 0, '{\"name\":\"Hotelston\",\"label\":\"Hotelston\",\"slug\":\"hotelston\",\"frontend\":{\"label\":\"Hotels\",\"slug\":\"properties\",\"icon\":\"hotel.png\"},\"description\":\"\",\"active\":0,\"order\":\"7\",\"menus\":{\"icon\":\"fa fa-building\",\"admin\":[{\"label\":\"Bookings\",\"link\":\"admin\\/hotelston\\/bookings\"},{\"label\":\"Settings\",\"link\":\"admin\\/hotelston\\/settings\"}],\"supplier\":[]}}', '2', 'info@phptravels.com', 'Allah4ever44', '', '', '', '', '', '', '', '', 0, 0, 0, '0', 0, 0, 0, '0', NULL, '#a7d701', 'EUR', '1'),
(60, 'hotels', 'Agoda', 0, '{\"name\":\"Agoda\",\"label\":\"Agoda\",\"slug\":\"agoda\",\"frontend\":{\"label\":\"Hotels\",\"slug\":\"properties\",\"icon\":\"hotel.png\"},\"description\":\"\",\"active\":0,\"order\":\"7\",\"menus\":{\"icon\":\"fa fa-building\",\"admin\":[{\"label\":\"Bookings\",\"link\":\"admin\\/agoda\\/bookings\"},{\"label\":\"Settings\",\"link\":\"admin\\/agoda\\/settings\"}],\"supplier\":[]}}', '2', 'http://affiliateapi7643.agoda.com/affiliateservice/lt_v1', '1743607', 'A34C14A7-4BC3-4D0D-BD43-36CA7A4BB2B9', '', '', '', '', '', '', '', 0, 0, 0, '1', 0, 0, 0, '0', NULL, '#ff0000', 'USD', '1'),
(61, 'flights', 'Duffel', 0, '{\"name\":\"Duffel\",\"label\":\"Duffel\",\"slug\":\"duffel\",\"test\":\"false\",\"frontend\":{\"label\":\"Flights\",\"slug\":\"flights\",\"icon\":\"la la-plane\"},\"description\":\"\",\"active\":0,\"order\":\"2\",\"menus\":{\"icon\":\"fa fa-plane\",\"admin\":[{\"label\":\"Settings\",\"link\":\"admin\\/settings\\/modules\\/module_setting\\/duffel\\/\"},{\"label\":\"Bookings\",\"link\":\"admin\\/duffel\\/bookings\"}],\"supplier\":[]},\"\":null}', '2', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '0', 0, 0, 0, '0', NULL, '#e14747', 'USD', '1'),
(62, 'flights', 'Hiholiday', 0, '{\"name\":\"Hiholiday\",\"label\":\"Hiholiday\",\"slug\":\"hiholiday\",\"test\":\"false\",\"frontend\":{\"label\":\"Flights\",\"slug\":\"flights\",\"icon\":\"la la-plane\"},\"description\":\"\",\"active\":0,\"order\":\"2\",\"menus\":{\"icon\":\"fa fa-plane\",\"admin\":[{\"label\":\"Settings\",\"link\":\"admin\\/settings\\/modules\\/module_setting\\/hiholiday\\/\"},{\"label\":\"Bookings\",\"link\":\"admin\\/hiholiday\\/bookings\"}],\"supplier\":[]},\"\":null}', '2', '2495722d-8796-43ad-8f0e-90fd088c20c7', '09120335360', '5126', '', '', '', '', '', '', '', 0, 0, 0, '0', 0, 0, 0, '0', NULL, '#000000', 'IRR', '1'),
(63, 'flights', 'Iata', 0, '{\"name\":\"iata\",\"label\":\"iata\",\"slug\":\"iata\",\"test\":\"false\",\"frontend\":{\"label\":\"Flights\",\"slug\":\"flights\",\"icon\":\"la la-plane\"},\"description\":\"\",\"active\":0,\"order\":\"2\",\"menus\":{\"icon\":\"fa fa-plane\",\"admin\":[{\"label\":\"Settings\",\"link\":\"admin/settings/modules/module_setting\\/iata\\/\"},{\"label\":\"Bookings\",\"link\":\"admin\\/iata\\/bookings\"}],\"supplier\":[]},\"\":null}', '2', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 0, 0, 0, '0', NULL, NULL, NULL, NULL),
(64, 'tours', 'Tiqets', 1, '{\"name\":\"Tiqets\",\"label\":\"Tiqets\",\"slug\":\"Tiqets\",\"test\":\"false\",\"frontend\":{\"label\":\"Tiqets\",\"slug\":\"Tiqets\",\"icon\":\"la la-briefcase\"},\"description\":\"\",\"active\":1,\"order\":\"2\",\"menus\":{\"icon\":\"fa fa-briefcase\",\"admin\":[{\"label\":\"Settings\",\"link\":\"admin\\/settings\\/modules\\/module_setting\\/Tiqets\\/\"}],\"supplier\":[]},\"\":null}', '3', 'fZdFl0JKlfgz5j5vNXaMxAHlLJ2ZzJVA', '', '', '', '', '', '', '', '', '', 0, 0, 0, '1', 0, 0, 0, '0', NULL, '#48c2c5', 'USD', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
