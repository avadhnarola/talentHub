-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2025 at 02:13 PM
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
-- Database: `talenthub`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `time` time NOT NULL,
  `location` text NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `time`, `location`, `date`, `description`, `image`) VALUES
(1, 'How to speak like a native speaker?', '12:30:00', 'Language Lab, Room 204', '2025-08-09', 'Learn the secrets of sounding natural in English! This session focuses on pronunciation, intonation, rhythm, and everyday expressions used by native speakers. Through interactive speaking exercises and real-life dialogues, you practice fluency and reduce common mistakes. Discover how body language, tone, and cultural context influence communication. Perfect for intermediate learners aiming to sound more confident and natural in conversations.', 'ev1.jpg'),
(2, 'What makes grammar sound natural in conversation?', '20:00:00', 'Grammar Café, Main Hall', '2025-08-30', 'Struggling to understand native speakers? This event will teach you how to sharpen your listening through proven strategies and tools. You learn to catch key words, recognize speech patterns, and train your ear with authentic audio from movies, podcasts, and real conversations. Build confidence by understanding fast, connected speech and improve your response time. Suitable for all levels.', 'ev2.webp'),
(3, 'Can listening habits improve your speaking fluency?', '15:00:00', 'Audio Lounge, Media Center', '2025-09-01', 'Want to remember words for life is not just for a test? This session explores effective vocabulary-building techniques using context, repetition, and memory tricks. You learn how to group words meaningfully, create associations, and apply them in speaking and writing. Say goodbye to boring word lists and start using new words confidently. Ideal for students who want real, lasting progress.', 'ev3.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
