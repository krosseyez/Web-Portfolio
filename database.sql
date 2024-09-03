-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2024 at 02:02 PM
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
-- Database: `portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_section`
--

CREATE TABLE `about_section` (
  `id` int(11) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `project_count` int(11) NOT NULL,
  `client_count` int(11) NOT NULL,
  `review_count` int(11) NOT NULL,
  `cv_link` varchar(255) NOT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `skills` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_section`
--

INSERT INTO `about_section` (`id`, `heading`, `description`, `project_count`, `client_count`, `review_count`, `cv_link`, `facebook_link`, `linkedin_link`, `instagram_link`, `twitter_link`, `skills`) VALUES
(1, 'About Me', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore a harum, molestiae praesentium rem mollitia neque quibusdam consectetur dolores! Pariatur recusandae commodi et cumque.', 60, 30, 30, 'https://www.linkedin.com/in/william-francis-mwaijande/', 'https://www.linkedin.com/in/william-francis-mwaijande/', 'https://www.linkedin.com/in/william-francis-mwaijande/', 'https://www.linkedin.com/in/william-francis-mwaijande/', 'https://www.linkedin.com/in/william-francis-mwaijande/', 'PhpMyAdmin ,PHP,  Responsive Web Design, Front-end Coding, C, Java  MySQL,  Accounting , Web Development\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `contact_form`
--

CREATE TABLE `contact_form` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('unread','read') NOT NULL DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_form`
--

INSERT INTO `contact_form` (`id`, `first_name`, `last_name`, `email`, `comment`, `created_at`, `status`) VALUES
(16, 'William', 'Mwaijande', 'mwaijandeaw@gmail.com', 'i want to create a section in the adminDash.php where user can edit the about s section of the index.html (links and all others)', '2024-09-02 17:08:09', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `home_section`
--

CREATE TABLE `home_section` (
  `id` int(11) NOT NULL,
  `dev_name` varchar(255) NOT NULL,
  `dev_title` varchar(255) NOT NULL,
  `dev_intro` text NOT NULL,
  `dev_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_section`
--

INSERT INTO `home_section` (`id`, `dev_name`, `dev_title`, `dev_intro`, `dev_image`) VALUES
(1, 'William Mwaijande', 'Web Developer', 'As a web developer, I specialize in crafting dynamic and responsive websites using a range of languages and technologies such as JavaScript, PHP, MySQL, HTML, CSS, and Bootstrap. My proficiency in these tools allows me to build robust front-end and back-end solutions that enhance user experience and functionality. Additionally, my knowledge of C and Java provides a strong foundation in programming principles and algorithms, enabling me to approach problem-solving with a versatile and comprehensive skill set. This blend of web development expertise and traditional programming knowledge equips me to tackle a wide array of projects with efficiency and creativity.\r\n', '../images/KILLUA.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `adminID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `email` varchar(100) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`adminID`, `firstName`, `lastName`, `pwd`, `gender`, `email`, `createdAt`) VALUES
(10010, 'William', 'Mwaijande', '1234', 'male', 'wm@gmail.com', '2024-09-02 10:16:48');

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `projectID` int(11) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `project_image` varchar(255) NOT NULL,
  `project_link` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolio`
--

INSERT INTO `portfolio` (`projectID`, `project_name`, `project_image`, `project_link`, `created_at`) VALUES
(1, 'QR code', '../images/portfolio/2.jpg', 'https://github.com/krosseyez', '2024-09-02 17:17:02'),
(2, 'KrossEyez', '../images/portfolio/1.jpg', 'https://github.com/krosseyez', '2024-09-02 17:17:36'),
(3, 'KrossEyez', '../images/portfolio/4.jpg', 'https://github.com/krosseyez', '2024-09-02 17:17:54'),
(4, 'KrossEyez', '../images/portfolio/6.jpg', 'https://github.com/krosseyez', '2024-09-02 17:18:25'),
(5, 'KrossEyez', '../images/portfolio/3.jpg', 'https://github.com/krosseyez', '2024-09-02 17:18:59');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `serviceID` int(11) NOT NULL,
  `service_icon` varchar(255) NOT NULL,
  `service_title` varchar(100) NOT NULL,
  `service_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`serviceID`, `service_icon`, `service_title`, `service_description`) VALUES
(2, 'lightbulb-fill.svg', 'Creative Design', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.'),
(3, 'image.svg', 'Photoshop', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.'),
(5, 'image.svg', 'Photoshop', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `testimonialID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `testimonial_text` text NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`testimonialID`, `name`, `position`, `testimonial_text`, `rating`, `created_at`) VALUES
(4, 'Jimmy Mapunda', 'CEO', 'A software engineer is a creative problem-solver at the heart of modern technology. They turn complex ideas into innovative solutions, crafting the software that powers our daily lives, from the apps we use to the systems that drive businesses forward. With a blend of analytical thinking, coding skills, and an eye for detail, software engineers build robust, efficient, and scalable applications that shape the future. They are lifelong learners, constantly adapting to new technologies and challenges, making them the unsung heroes of our digital world. Their work not only solves problems but also creates opportunities, making the impossible possible.', 4, '2024-09-03 11:58:38'),
(6, 'Metro Mapunda', 'CEO', 'A software engineer is a creative problem-solver at the heart of modern technology. They turn complex ideas into innovative solutions, crafting the software that powers our daily lives, from the apps we use to the systems that drive businesses forward. With a blend of analytical thinking, coding skills, and an eye for detail, software engineers build robust, efficient, and scalable applications that shape the future. They are lifelong learners, constantly adapting to new technologies and challenges, making them the unsung heroes of our digital world. Their work not only solves problems but also creates opportunities, making the impossible possible.', 5, '2024-09-03 12:00:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_section`
--
ALTER TABLE `about_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_form`
--
ALTER TABLE `contact_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_section`
--
ALTER TABLE `home_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`adminID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`projectID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`serviceID`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`testimonialID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_section`
--
ALTER TABLE `about_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_form`
--
ALTER TABLE `contact_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `home_section`
--
ALTER TABLE `home_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10011;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `projectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `serviceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `testimonialID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
