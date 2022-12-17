-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 20, 2020 at 09:25 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel_hotels`
--

-- --------------------------------------------------------

--
-- Table structure for table `travelpayouthotel_amenities`
--

CREATE TABLE `travelpayouthotel_amenities` (
  `id` int(11) NOT NULL,
  `a_id` bigint(20) NOT NULL,
  `a_name` varchar(225) NOT NULL,
  `a_groupName` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `travelpayouthotel_amenities`
--

INSERT INTO `travelpayouthotel_amenities` (`id`, `a_id`, `a_name`, `a_groupName`) VALUES
(1, 148, 'Adults only', 'General'),
(2, 4, 'TV', 'Room'),
(3, 9, 'Restaurant', 'General'),
(4, 11, 'Air conditioning', 'Room'),
(5, 16, 'Mini bar', 'Room'),
(6, 23, '24hr room service', 'Services'),
(7, 28, 'Pets allowed', 'General'),
(8, 30, 'Wake up service', 'Services'),
(9, 35, 'Ironing board', 'Room'),
(10, 47, 'Faxing Facilities', 'Services'),
(11, 54, 'Free parking', 'Parking'),
(12, 59, 'Wheelchair accessible', 'General'),
(13, 61, 'Bathrobes', 'Room'),
(14, 66, 'Refrigerator', 'Room'),
(15, 73, 'Tennis courts', 'Activities'),
(16, 78, 'Doctor on call', 'Services'),
(17, 80, 'Playground', 'Activities'),
(18, 85, 'Sunbathing Terrace', 'General'),
(19, 92, 'Table tennis', 'Activities'),
(20, 97, 'Barbecue Area', 'General'),
(21, 100, 'Animation', 'Activities'),
(22, 105, 'Nightclub', 'Activities'),
(23, 112, 'Horse Riding', 'Activities'),
(24, 117, 'Ski room', 'General'),
(25, 124, 'Free local telephone calls', 'Services'),
(26, 129, 'Water Sports', 'Activities'),
(27, 131, 'Wi-Fi in public areas', 'General'),
(28, 136, 'English', 'Staff languages'),
(29, 143, 'Russian', 'Staff languages'),
(30, 5, 'Telephone', 'Room'),
(31, 12, 'Shops', 'General'),
(32, 24, 'Internet Access', 'Internet'),
(33, 29, 'Disabled facilities', 'General'),
(34, 31, 'Daily newspaper', 'Room'),
(35, 36, 'Garden', 'General'),
(36, 43, 'Reception', 'General'),
(37, 48, 'Massage', 'Activities'),
(38, 50, '24h. Reception', 'General'),
(39, 62, 'Inhouse movies', 'Room'),
(40, 67, 'Crib available', 'Room'),
(41, 74, 'Medical Service', 'Services'),
(42, 79, 'Water sports (non-motorized)', 'Activities'),
(43, 81, 'Library', 'General'),
(44, 86, 'Heated pool', 'Activities'),
(45, 93, 'Casino', 'Activities'),
(46, 98, 'Games Room', 'Activities'),
(47, 101, 'Billiards', 'Activities'),
(48, 106, 'Welcome drink', 'General'),
(49, 113, 'Diving', 'Activities'),
(50, 118, 'Gift Shop', 'General'),
(51, 120, 'Wheel chair access', 'General'),
(52, 125, 'Handicapped Room', 'Room'),
(53, 132, 'Smoking room', 'Hotel'),
(54, 137, 'French', 'Staff languages'),
(55, 144, 'Cleaning', 'Room'),
(56, 6, 'Business center', 'Services'),
(57, 13, 'Laundry service', 'Services'),
(58, 18, 'Radio', 'Room'),
(59, 20, 'Meeting facilities', 'General'),
(60, 25, 'Room Service', 'Services'),
(61, 32, 'In-room safe', 'Room'),
(62, 37, 'Outdoor pool', 'Activities'),
(63, 44, 'Concierge', 'Services'),
(64, 49, 'Hotel/airport transfer', 'Services'),
(65, 51, 'Voice mail', 'Room'),
(66, 56, 'Car parking', 'Parking'),
(67, 63, 'Babysitting', 'Services'),
(68, 68, 'Indoor pool', 'Activities'),
(69, 70, 'Golf course (on site)', 'Activities'),
(70, 75, 'Multilingual staff', 'General'),
(71, 82, 'Wellness', 'Activities'),
(72, 87, 'Kids pool', 'Activities'),
(73, 94, 'Beauty Salon', 'Services'),
(74, 99, 'Video/DVD Player', 'Room'),
(75, 102, 'Private beach', 'General'),
(76, 107, 'LGBT friendly', 'General'),
(77, 114, 'Mini-Supermarket', 'General'),
(78, 119, 'Eco Friendly', 'General'),
(79, 121, 'Security Guard', 'General'),
(80, 126, 'Luggage Service', 'Services'),
(81, 133, 'Wi-Fi in room', 'Room'),
(82, 138, 'Deutsch', 'Staff languages'),
(83, 140, 'Arabic', 'Staff languages'),
(84, 145, 'Deposit', 'Hotel'),
(85, 2, 'Hairdryer', 'Room'),
(86, 7, 'Shower', 'Room'),
(87, 14, 'Bar', 'General'),
(88, 19, 'Desk', 'Room'),
(89, 21, 'Elevator', 'General'),
(90, 26, 'Bathtub', 'Room'),
(91, 33, 'Balcony/terrace', 'Room'),
(92, 38, 'Swimming Pool', 'Activities'),
(93, 40, 'Gym / Fitness Centre', 'Activities'),
(94, 45, 'Tours', 'Activities'),
(95, 52, 'Lobby', 'General'),
(96, 57, 'Jacuzzi', 'Activities'),
(97, 64, 'Banquet Facilities', 'General'),
(98, 69, 'Currency Exchange', 'Services'),
(99, 71, 'Electronic room keys', 'Room'),
(100, 76, 'Parasols', 'General'),
(101, 83, 'Wi-Fi Available', 'Internet'),
(102, 88, 'Breakfast to go', 'Services'),
(103, 95, 'Steam Room', 'General'),
(104, 103, 'Squash courts', 'Activities'),
(105, 108, 'Water sports (motorized)', 'Activities'),
(106, 110, 'Slippers', 'Room'),
(107, 115, 'Mini Golf', 'Activities'),
(108, 122, 'Children care/activities', 'Activities'),
(109, 127, 'Copying Services', 'Services'),
(110, 134, 'Daily Housekeeping', 'Room'),
(111, 139, 'Spanish', 'Staff languages'),
(112, 141, 'Italian', 'Staff languages'),
(113, 146, 'Private Bathroom', 'Room'),
(114, 3, 'Safe', 'Room'),
(115, 8, 'Non-smoking rooms', 'Room'),
(116, 10, 'Separate shower and tub', 'Room'),
(117, 15, 'Sauna', 'Activities'),
(118, 22, 'Bathroom', 'Room'),
(119, 27, 'Coffee/tea maker', 'Room'),
(120, 41, 'Cafe', 'General'),
(121, 46, 'Conference Facilities', 'General'),
(122, 53, 'Kitchenette', 'Room'),
(123, 58, 'Bicycle rental', 'Activities'),
(124, 60, 'Microwave', 'Room'),
(125, 65, 'Spa', 'Activities'),
(126, 72, 'Solarium', 'Activities'),
(127, 77, 'Luggage room', 'General'),
(128, 84, 'Cloakroom', 'General'),
(129, 89, 'Launderette', 'General'),
(130, 91, 'Washing machine', 'General'),
(131, 96, 'Rent a car in the hotel', 'Parking'),
(132, 104, 'Secretary Service', 'Services'),
(133, 109, 'Garage', 'Parking'),
(134, 111, 'Valet service', 'Parking'),
(135, 116, 'Bowling', 'Activities'),
(136, 123, 'In-house movie', 'General'),
(137, 128, 'Porters', 'Services'),
(138, 130, 'Tour Desk', 'General'),
(139, 135, 'Connecting rooms', 'Room'),
(140, 142, 'Chinese', 'Staff languages'),
(141, 147, 'Shared Bathroom', 'Room');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `travelpayouthotel_amenities`
--
ALTER TABLE `travelpayouthotel_amenities`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `travelpayouthotel_amenities`
--
ALTER TABLE `travelpayouthotel_amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
