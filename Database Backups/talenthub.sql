-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2025 at 06:08 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `gender` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`, `gender`) VALUES
(1, 'Saniya Markana', 'admin@gmail.com', 'admin123', ''),
(2, 'avadh', 'avadh@gmail.com', 'avadh1525', 'Male'),
(3, 'Tirth Narola', 'tirth@gmail.com', 'tirth123', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `admission`
--

CREATE TABLE `admission` (
  `id` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `phoneNo` bigint(12) NOT NULL,
  `email` text NOT NULL,
  `application` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admission`
--

INSERT INTO `admission` (`id`, `fname`, `lname`, `phoneNo`, `email`, `application`) VALUES
(1, 'Saniya', 'Markana', 9601833510, 'sanu25@g.co', 'i want to apply for the FYBCA 2025-26'),
(2, 'Avadh', 'Narola', 9601833510, 'avadh@g.co', 'i want to apply for the FYBCA 2025-26'),
(7, 'Tirth', 'Narola', 9605563540, 'tirth@gmail.com', 'This is a best'),
(8, 'Kayra', 'Narola', 6351036225, 'kayra8811@gmail.com', 'hdsdgshd'),
(9, 'Saniya', 'Markana', 8140047020, 'sanu@gmail.com', 'This is application for the admission in FY Bsc DataScience'),
(16, 'Kayra', 'Narola', 9601933510, 'kavu@gmail.com', 'This is a application for admission in this course');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `category` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `duration` text NOT NULL,
  `price` int(11) NOT NULL,
  `material_url` text NOT NULL,
  `start_date` text NOT NULL,
  `end_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `category`, `title`, `description`, `image`, `duration`, `price`, `material_url`, `start_date`, `end_date`) VALUES
(1, 'Technology', 'Data Science', 'Analyze data, build models, and visualize results using Python, machine learning, and real datasets.', 'data-sci.webp', '14', 199, '1756567476_Principles-of-Data-Science-WEB.pdf', '2026-01-14', '2026-04-22'),
(2, 'Technology', 'Artificial Intelligence', ' Explore AI concepts, algorithms, and applications such as natural language processing and computer vision.', 'Artificial Intelligence.avif', '25', 399, '1756567504_Artificial Intellignece.pdf', '2025-12-15', '2026-06-08'),
(3, 'Architecture', 'Interior Architecture', 'Study space optimization, lighting, furniture design, and aesthetics in interior environments.', 'Interior.jpg', '4', 49, '1756568022_Interior Architecture.pdf', '2025-10-19', '2025-11-16'),
(4, 'Medical', 'Medical Microbiology', 'Study microorganisms causing diseases and their role in infection, immunity, and clinical treatment.', 'Medical Microbiology.jpeg', '16', 249, '1756568356_Medical Microbiology.pdf', '2025-11-12', '2026-03-04'),
(5, 'Science', 'Astronomy and Space Science', 'Discover stars, planets, and galaxies, and learn the science behind our ever-expanding universe.', 'Astronomy and Space Science.webp', '7', 99, '1756568967_Astronomy and Space Science.pdf', '2025-08-20', '2025-10-08'),
(6, 'Architecture', 'Digital Architecture', 'Utilize digital tools like BIM and parametric design to create complex architectural forms and models.', 'Digital Architecture.png', '18', 139, '1756568195_Digital Architecture.pdf', '2025-08-21', '2025-12-25'),
(7, 'Technology', 'Cloud Computing Essentials', 'Understand cloud fundamentals, deployment models, and services with practical experience on AWS and Azure platforms.', 'Cloud Computing Essentials.jpg', '12', 159, '1756567576_Cloud Computing Essentials.pdf', '2025-12-31', '2026-03-25'),
(8, 'Technology', 'Web Development ', 'Build responsive websites using HTML, CSS, JavaScript, and frameworks like React through interactive projects.', 'Web Development Bootcamp.jpg', '20', 699, '1756567652_9_Web-Development-Essentials.pdf', '2025-10-15', '2026-03-04'),
(9, 'Technology', 'Blockchain Technology Explained', 'Understand blockchain principles, smart contracts, cryptocurrencies, and decentralized applications through real-world use cases.', 'Blockchain Technology Explained.png', '9', 150, '1756567724_Blockchain Technology Explained.pdf', '2025-08-31', '2025-11-02'),
(10, 'Technology', 'Mobile App Development', 'Design and build Android and iOS applications using Flutter and React Native with real-world scenarios.', 'Mobile App Development.jpg', '10', 200, '1756567820_Mobile App Development.pdf', '2025-12-31', '2026-03-11'),
(11, 'Architecture', 'Structural Systems in Architecture', 'Understand load-bearing elements, materials, and construction methods essential for safe architectural structures.', 'Structural Systems in Architecture.jpg', '20', 666, '1756568247_Structural design for architecture.pdf', '2025-12-12', '2026-05-01'),
(12, 'Architecture', 'Architectural Visualization ', 'Create photorealistic images and animations using 3D modeling and rendering software.', 'Architectural Visualization and Rendering.jpg', '15', 599, '1756568298_Architectural Visualization.pdf', '2026-05-25', '2026-09-07'),
(13, 'Medical', 'Pharmacology', 'Learn drug actions, interactions, and therapeutic uses essential for safe and effective medical treatment.', 'Pharmacology.png', '9', 129, '1756568510_Pharmacology.pdf', '2025-12-31', '2026-03-04'),
(14, 'Medical', 'Surgery Basics Skills', 'Learn surgical principles, sterile techniques, and emergency procedures for operating room preparedness.', 'Surgery Basics Skills.jpg', '8', 259, '1756568547_Surgery Basics Skills.pdf', '2025-10-15', '2025-12-10'),
(15, 'Medical', 'Pediatrics', 'Study childhood diseases, development, and pediatric care from infancy through adolescence.', 'Pediatrics.jpg', '6', 149, '1756568617_Pediatrics.pdf', '2025-11-23', '2026-01-04'),
(16, 'Medical', 'Ophthalmology', 'Study eye anatomy, vision disorders, and treatments including surgery and corrective lenses.', 'Ophthalmology.avif', '4', 99, '1756568746_Ophthalmology.pdf', '2025-08-30', '2025-09-27'),
(17, 'Science', 'Forensic Science', 'Learn crime scene investigation techniques using biology, chemistry, and physics to analyze evidence.', 'Forensic Science.jpg', '9', 299, '1756569137_Forensic Science.pdf', '2025-09-28', '2025-11-30'),
(18, 'Science', 'Climate Science and Solutions', 'Understand climate systems, global warming, and scientific strategies to mitigate environmental impact.', 'Climate Science and Solutions.jpg', '6', 159, '1756569388_Climate Science and Solutions.pdf', '2025-08-24', '2025-10-05'),
(19, 'Science', 'Human Physiology', 'Understand body systems, organs, and functions essential for health sciences and medical-related fields.', 'Human Physiology.jpg', '5', 135, '1756569547_Human Physiology.pdf', '2025-09-14', '2025-10-19'),
(20, 'Science', 'Physics Fundamentals', 'Explore motion, forces, energy, and matter through classical and modern physics concepts and experiments.', 'Physics Fundamentals.jpg', '10', 399, '1756569708_Physics Fundamentals.pdf', '2025-08-31', '2025-11-09'),
(21, 'Science', 'Earth and Environmental Science', 'Investigate Earths structure, natural resources, climate change, and sustainable practices through scientific analysis.', 'Earth and Environmental Science.jpg', '8', 159, '1756569890_Earth and Environmental Science.pdf', '2025-08-14', '2025-10-09');

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

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `slider_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`slider_id`, `title`, `image`) VALUES
(6, 'Learning never exhausts the mind.', 'slider3.jpeg'),
(7, 'Education is the passport to the future.', 'slider2.jpg'),
(8, 'Knowledge is power.', 'slider1.avif');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `profile_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_img`) VALUES
(3, 'Saniya Markana', 'sanu@gmail.com', 'saniya', 'admin/image/1754995734_user-profile.jpg'),
(4, 'Tirthbhai', 'abc@gmail.com', '123', 'admin/image/default.png'),
(5, 'Avadh Narola', 'avadh@gmail.com', 'avadh123', 'admin/image/1754997373_kavu.JPG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `admission`
--
ALTER TABLE `admission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admission`
--
ALTER TABLE `admission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `slider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
