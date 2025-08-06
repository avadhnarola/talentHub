-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2025 at 12:25 PM
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
-- Database: `e-learning`
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
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `category` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `category`, `title`, `description`, `image`) VALUES
(1, 'Technology', 'Data Science', 'Analyze data, build models, and visualize results using Python, machine learning, and real datasets.', 'data-sci.webp'),
(2, 'Technology', 'Artificial Intelligence', ' Explore AI concepts, algorithms, and applications such as natural language processing and computer vision.', 'Artificial Intelligence.avif'),
(3, 'Architecture', 'Interior Architecture', 'Study space optimization, lighting, furniture design, and aesthetics in interior environments.', 'Interior.jpg'),
(4, 'Medical', 'Medical Microbiology', 'Study microorganisms causing diseases and their role in infection, immunity, and clinical treatment.', 'Medical Microbiology.jpeg'),
(5, 'Science', 'Astronomy and Space Science', 'Discover stars, planets, and galaxies, and learn the science behind our ever-expanding universe.', 'Astronomy and Space Science.webp'),
(6, 'Architecture', 'Digital Architecture', 'Utilize digital tools like BIM and parametric design to create complex architectural forms and models.', 'Digital Architecture.png'),
(7, 'Technology', 'Cloud Computing Essentials', 'Understand cloud fundamentals, deployment models, and services with practical experience on AWS and Azure platforms.', 'Cloud Computing Essentials.jpg'),
(8, 'Technology', 'Web Development ', 'Build responsive websites using HTML, CSS, JavaScript, and frameworks like React through interactive projects.', 'Web Development Bootcamp.jpg'),
(9, 'Technology', 'Blockchain Technology Explained', 'Understand blockchain principles, smart contracts, cryptocurrencies, and decentralized applications through real-world use cases.', 'Blockchain Technology Explained.png'),
(10, 'Technology', 'Mobile App Development', 'Design and build Android and iOS applications using Flutter and React Native with real-world scenarios.', 'Mobile App Development.jpg'),
(11, 'Architecture', 'Structural Systems in Architecture', 'Understand load-bearing elements, materials, and construction methods essential for safe architectural structures.', 'Structural Systems in Architecture.jpg'),
(12, 'Architecture', 'Architectural Visualization ', 'Create photorealistic images and animations using 3D modeling and rendering software.', 'Architectural Visualization and Rendering.jpg'),
(13, 'Medical', 'Pharmacology', 'Learn drug actions, interactions, and therapeutic uses essential for safe and effective medical treatment.', 'Pharmacology.png'),
(14, 'Medical', 'Surgery Basics Skills', 'Learn surgical principles, sterile techniques, and emergency procedures for operating room preparedness.', 'Surgery Basics Skills.jpg'),
(15, 'Medical', 'Pediatrics', 'Study childhood diseases, development, and pediatric care from infancy through adolescence.', 'Pediatrics.jpg'),
(16, 'Medical', 'Ophthalmology', 'Study eye anatomy, vision disorders, and treatments including surgery and corrective lenses.', 'Ophthalmology.avif'),
(17, 'Science', 'Forensic Science', 'Learn crime scene investigation techniques using biology, chemistry, and physics to analyze evidence.', 'Forensic Science.jpg'),
(18, 'Science', 'Climate Science and Solutions', 'Understand climate systems, global warming, and scientific strategies to mitigate environmental impact.', 'Climate Science and Solutions.jpg'),
(19, 'Science', 'Human Physiology', 'Understand body systems, organs, and functions essential for health sciences and medical-related fields.', 'Human Physiology.jpg'),
(20, 'Science', 'Physics Fundamentals', 'Explore motion, forces, energy, and matter through classical and modern physics concepts and experiments.', 'Physics Fundamentals.jpg'),
(21, 'Science', 'Earth and Environmental Science', 'Investigate Earths structure, natural resources, climate change, and sustainable practices through scientific analysis.', 'Earth and Environmental Science.jpg');

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `slider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
