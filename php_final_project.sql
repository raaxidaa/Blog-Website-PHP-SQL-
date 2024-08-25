-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Hazırlanma Vaxtı: 25 Avq, 2024 saat 20:00
-- Server versiyası: 10.4.32-MariaDB
-- PHP Versiyası: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Verilənlər Bazası: `php_final_project`
--

-- --------------------------------------------------------

--
-- Cədvəl üçün cədvəl strukturu `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `blog_img` varchar(255) NOT NULL,
  `is_publish` tinyint(1) DEFAULT 0,
  `view_count` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sxemi çıxarılan cedvel `blogs`
--

INSERT INTO `blogs` (`id`, `user_id`, `category_id`, `title`, `description`, `blog_img`, `is_publish`, `view_count`, `created_at`, `updated_at`) VALUES
(14, 2, 14, 'The Rise of Artificial Intelligence', 'Artificial Intelligence (AI) is transforming various industries by automating tasks, enhancing decision-making, and providing personalized experiences. From virtual assistants to advanced analytics, AI is driving innovation and efficiency.', '66c4cf92ed8e0.jpg', 1, NULL, '2024-08-20 17:17:06', '2024-08-20 17:26:16'),
(15, 2, 14, 'The Evolution of the Internet of Things (IoT)', 'Artificial Intelligence (AI) is transforming various industries by automating tasks, enhancing decision-making, and providing personalized experiences. From virtual assistants to advanced analytics, AI is driving innovation and efficiency.', '66c4cfc894525.jpg', 1, NULL, '2024-08-20 17:18:00', '2024-08-20 17:26:17'),
(16, 2, 14, 'How 5G Technology is Changing Connectivity', '5G technology offers significantly faster data speeds, lower latency, and greater connectivity compared to previous generations. It enables advancements in areas such as autonomous vehicles, smart cities, and augmented reality by supporting high-bandwidth applications.', '66c4cffb9c947.jpg', 1, NULL, '2024-08-20 17:18:51', '2024-08-20 17:26:19'),
(17, 2, 14, 'The Impact of Blockchain Beyond Cryptocurrencies', 'Blockchain technology, initially known for its role in cryptocurrencies, is now being applied to various sectors including supply chain management, healthcare, and voting systems. Its decentralized nature and immutability offer enhanced security and transparency.', '66c4d03b0bf0f.jpg', 1, NULL, '2024-08-20 17:19:55', '2024-08-20 17:26:27'),
(18, 5, 16, 'Top Destinations for 2024', 'Discover the top travel destinations for 2024, including emerging cities, natural wonders, and cultural hotspots. Whether you\'re looking for adventure, relaxation, or cultural experiences, these destinations offer something for every traveler.', '66c4dd5daac3a.jpg', 1, NULL, '2024-08-20 18:15:57', '2024-08-20 18:20:49'),
(19, 5, 16, 'How to Plan a Road Trip', 'Planning a road trip involves choosing your route, preparing your vehicle, and packing essentials. Tips include creating a flexible itinerary, finding interesting stops along the way, and ensuring you have everything needed for a smooth journey.', '66c4dd7dd6df4.jpg', 1, NULL, '2024-08-20 18:16:29', '2024-08-20 18:20:50'),
(20, 5, 16, 'The Ultimate Guide to Traveling on a Budget', 'Traveling on a budget requires careful planning and smart choices. Consider staying in hostels, using public transportation, and eating at local markets. Additionally, look for deals and discounts on flights and accommodations.', '66c4ddab0fda7.jpg', 1, NULL, '2024-08-20 18:17:15', '2024-08-20 18:20:51'),
(21, 5, 16, 'Exploring Hidden Gems in Europe', 'Traveling on a budget requires careful planning and smart choices. Consider staying in hostels, using public transportation, and eating at local markets. Additionally, look for deals and discounts on flights and accommodations.', '66c4ddd39f091.jpg', 1, NULL, '2024-08-20 18:17:55', '2024-08-20 18:21:05'),
(22, 5, 16, 'Essential Tips for Solo Travelers', 'Solo travel can be both exciting and challenging. Safety tips include researching destinations, staying connected, and trusting your instincts. Embrace the freedom of traveling alone and make the most of your experiences.', '66c4de0337ea9.webp', 1, NULL, '2024-08-20 18:18:43', '2024-08-20 18:21:02'),
(23, 5, 16, 'Family-Friendly Travel Destinations', 'Finding family-friendly travel destinations involves considering activities and accommodations suitable for all ages. Look for places with kid-friendly attractions, interactive museums, and family-oriented resorts.', '66c4de2bde873.webp', 1, NULL, '2024-08-20 18:19:23', '2024-08-20 18:20:58'),
(24, 5, 16, 'The Best Beach Getaways', 'For those seeking sun and sand, consider top beach destinations around the world. From the crystal-clear waters of the Caribbean to the stunning coastlines of Southeast Asia, there\'s a perfect beach getaway for every preference.', '66c4de4c59b81.jpg', 1, NULL, '2024-08-20 18:19:56', '2024-08-20 18:21:08'),
(25, 5, 16, 'Traveling During the Off-Season', 'Traveling during the off-season can offer significant benefits such as lower prices, fewer crowds, and a more relaxed experience. Research destinations with mild weather and explore popular sites without the usual hustle and bustle.', '66c4de71d4d68.jpg', 1, NULL, '2024-08-20 18:20:33', '2024-08-20 18:20:55');

-- --------------------------------------------------------

--
-- Cədvəl üçün cədvəl strukturu `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sxemi çıxarılan cedvel `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(14, 'Technology', '2024-08-20 17:14:25', '2024-08-20 18:10:09'),
(16, 'Travel', '2024-08-20 18:10:25', '2024-08-20 18:10:25'),
(17, 'Global', '2024-08-21 11:13:47', '2024-08-21 11:13:47'),
(18, 'Sport', '2024-08-21 11:13:56', '2024-08-21 11:13:56'),
(19, 'Education', '2024-08-21 11:14:32', '2024-08-21 11:14:32'),
(20, 'Criminal', '2024-08-21 11:15:04', '2024-08-21 11:15:04'),
(21, 'Childreen', '2024-08-21 11:15:19', '2024-08-21 11:15:19');

-- --------------------------------------------------------

--
-- Cədvəl üçün cədvəl strukturu `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` int(11) DEFAULT 1,
  `dob` date NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `otp` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sxemi çıxarılan cedvel `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `gender`, `email`, `active`, `dob`, `profile`, `role`, `created_at`, `updated_at`, `otp`, `password`) VALUES
(1, 'hkjbkjnkjnkjnkjnknkj', 'nkkbkbkbkbkbkbkbk', 2, 'asdasd@gmail.com', 0, '2024-08-16', NULL, 0, '2024-08-13 12:07:10', '2024-08-16 17:09:50', NULL, '$2y$10$auyZ0AVeVUeygyjtA0bfoeVQG6iKuNdehK/AwepR3wtDe.QP5Hi3O'),
(2, 'Ramal', 'Isgenderli', 1, 'ramal34@gmail.com', 1, '2024-07-30', '66c4cf5d73bb7.jpg', 0, '2024-08-13 12:08:25', '2024-08-24 10:43:02', NULL, '$2y$10$..r3PLIJ5ozl93VhiRGPyuntXidLZ1x7OfJ.Fue6TbQFGN.eBwEe2'),
(3, 'Rahide67', 'Isgenderli', 2, 'rahideisgenderova67@gmail.com', 1, '2003-08-03', '66bdf0656c5c8.webp', 1, '2024-08-13 17:23:57', '2024-08-15 12:11:17', NULL, '$2y$10$5Iv5iIdQT73apEK5Y5Dunu/9X2I12PHSJYMv/TK/WeZaMGXUU/fMO'),
(4, 'nuray', 'elizade', 2, 'nuray12@gmail.com', 1, '2024-08-02', '66bf5156b932e.png', 0, '2024-08-16 13:17:10', '2024-08-16 13:17:39', NULL, '$2y$10$7luY62NujC86CsnyZpRqP.JAUlERVj0IUDLTR.PF96Xs2gDz.HnVW'),
(5, 'Malik Barry', 'Valencia', 2, 'teqehu@mailinator.com', 1, '1981-12-11', NULL, 0, '2024-08-20 18:07:48', '2024-08-20 18:08:09', NULL, '$2y$10$jnftdQxclKFdnAg9vaGba.rZ3kN2yezmHx8QBPzzJ6Z0/hXE5OJT.'),
(6, 'Pearl Burnett', 'Nelson', 1, 'zozira@mailinator.com', 1, '1978-07-08', NULL, 0, '2024-08-20 18:08:26', '2024-08-20 18:08:45', NULL, '$2y$10$sczkJs5YYQ06alTaOkIoZOZVfoLZV8.F2NxK/pKrhD9nooLx/IqVm'),
(7, 'Bryar Walter', 'Riley', 1, 'wuderefybe@mailinator.com', 1, '2019-12-22', NULL, 0, '2024-08-20 18:09:00', '2024-08-20 18:09:10', NULL, '$2y$10$5PH9Qhr/.4eeAWbgnLYKNOumX8lC44lq8IDcp6h1sebVk80wXzPDq'),
(8, 'Daphne Barron', 'Clark', 2, 'fuzicam@mailinator.com', 1, '1991-09-23', NULL, 0, '2024-08-21 11:16:05', '2024-08-21 11:17:02', NULL, '$2y$10$pYv5REjfuFcROShKCWAITuO8lrIIF5RRdi7HssWxytCC6QNKZbH.a'),
(9, 'Chaney Preston', 'Wilkins', 1, 'vobamysag@mailinator.com', 1, '1999-01-01', NULL, 0, '2024-08-21 11:17:21', '2024-08-21 11:17:35', NULL, '$2y$10$UhQDZ3wzRMhlOIJaQdH4xudy5pLg4lQf1ubjHI0g1J2m6BjtaXA02'),
(10, 'Leman', 'Ehedova', 1, 'leman15@gmail.com', 1, '2024-08-09', '66c9c6f0962b8.jpg', 0, '2024-08-24 11:41:36', '2024-08-24 11:42:26', NULL, '$2y$10$w.bIaeBGPU52OV4ojXbCMuJqiyytvaZYnJYPqbB22XR8duKlDLeZa');

--
-- Indexes for dumped tables
--

--
-- Cədvəl üçün indekslər `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Cədvəl üçün indekslər `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Cədvəl üçün indekslər `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- Cədvəl üçün AUTO_INCREMENT `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Cədvəl üçün AUTO_INCREMENT `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Cədvəl üçün AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `blogs_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
