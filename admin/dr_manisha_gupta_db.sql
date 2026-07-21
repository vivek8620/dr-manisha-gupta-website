-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2026 at 06:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dr_manisha_gupta_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'admin',
  `status` enum('active','inactive') DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `locked_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `full_name`, `role`, `status`, `last_login`, `failed_attempts`, `locked_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'drmanisha@gmail.com', '$2a$12$kJjJCgbRWPc1Yu4Zg6VXd.fAe8uQpAiM3mNZ2dHtLPrltdMph06XO', 'Admin User', 'admin', 'active', '2026-07-08 04:37:31', 0, NULL, '2026-06-01 04:59:21', '2026-07-08 04:37:31');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(300) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `content` longtext NOT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `status` enum('published','draft','archived') DEFAULT 'draft',
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `category`, `content`, `short_description`, `featured_image`, `author_id`, `views`, `status`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'Thyroid Disorders in India: Why They Are Becoming So Common, Especially Among Women', 'thyroid-disorders-india-women', 'Thyroid Management', '<p>Thyroid disorders, particularly hypothyroidism, have become increasingly prevalent in India. A significant number of patients, especially women, are being diagnosed with thyroid dysfunction each year.</p><h2>Why Thyroid Problems Are Rising</h2><ul><li><strong>Higher susceptibility in women:</strong> Women are 5-8 times more likely to develop thyroid disorders than men.</li><li><strong>Autoimmune causes:</strong> Hashimoto\'s thyroiditis is the most common reason for hypothyroidism in India.</li><li><strong>Nutritional transition:</strong> Universal salt iodisation has improved iodine status, but this shift can trigger autoimmune responses in susceptible individuals.</li><li><strong>Lifestyle and environmental influences:</strong> Vitamin D deficiency, chronic stress, obesity, sedentary lifestyles, processed food, pollution, and endocrine disruptors contribute to risk.</li><li><strong>Better awareness and screening:</strong> Routine tests during pregnancy, infertility work-ups, and health check-ups have increased detection.</li></ul><p>Estimates suggest that hypothyroidism affects approximately 10-11% of Indian adults, with prevalence notably higher in women.</p><h2>What Should Be Done?</h2><p>Early detection and timely intervention are essential. Women above 35 years, those planning pregnancy, or those experiencing fatigue, weight gain, cold intolerance, hair loss, constipation, dry skin, or menstrual irregularities should undergo thyroid function testing.</p><h2>Proper Management</h2><p>The standard and most effective treatment for hypothyroidism remains levothyroxine, a synthetic thyroid hormone replacement. Diagnosis, dose adjustment, empty-stomach administration, and periodic monitoring are important for good results.</p><blockquote>In pregnancy, dose requirements often increase, and more frequent monitoring is necessary to protect maternal and fetal health.</blockquote><p>Thyroid disorders are common in India but highly manageable with proper medical care. Patients should consult a qualified physician rather than relying on self-medication or unproven supplements.</p>', 'Women are 5-8 times more likely to develop thyroid disorders than men. Understand the rising causes, key symptoms, and proper treatment.', 'images/Blogs/Thyroid Management/Thyroid.jpg', 1, 0, 'published', '2026-05-10 09:00:00', '2026-06-01 04:59:21', '2026-06-01 04:59:21'),
(2, 'Diabetes in India: Recognising Early Symptoms', 'diabetes-india-early-symptoms', 'Diabetology', '<p>Diabetes, particularly Type 2 diabetes, has emerged as one of the most significant public health challenges in India. Many cases are detected late, leading to avoidable complications.</p><h2>Why Early Detection Matters</h2><p>Type 2 diabetes develops gradually, and symptoms can be subtle or absent in the initial phase. Prediabetes offers a critical window for intervention through lifestyle changes.</p><h2>Common Early Symptoms</h2><ul><li>Increased thirst and frequent urination.</li><li>Excessive hunger despite eating.</li><li>Unexplained fatigue.</li><li>Blurred vision.</li><li>Slow-healing wounds or frequent infections.</li><li>Tingling, numbness, or pain in hands and feet.</li><li>Unexplained weight loss.</li><li>Darkened skin patches around the neck, armpits, or groin.</li></ul><blockquote>These symptoms often develop slowly, which is why regular screening is more reliable than waiting for noticeable signs.</blockquote><h2>When to Consult a Doctor</h2><ul><li>Any symptom listed above, even if mild.</li><li>Family history of diabetes.</li><li>Overweight, abdominal obesity, age above 30-35, or sedentary lifestyle.</li><li>History of gestational diabetes, hypertension, abnormal lipids, or PCOS.</li></ul><h2>Prevention and Management</h2><p>Effective management involves balanced diet, regular physical activity, weight control, stress management, and appropriate medical therapy when needed.</p><p>Do not ignore symptoms or rely on self-assessment. Early evaluation and treatment can prevent complications.</p>', 'India has over 100 million people living with diabetes, yet many cases are detected late. Learn the warning signs most people ignore.', 'images/Blogs/Diabetology/Diabetology2.jpg', 1, 0, 'published', '2026-05-08 09:00:00', '2026-06-01 04:59:21', '2026-06-01 04:59:21'),
(3, 'Why You Should Lose Those Extra Kilos', 'why-you-should-lose-extra-kilos', 'Diabetology', '<p>Excess body weight is not merely a cosmetic issue. It significantly affects long-term health and increases the risk of several chronic conditions.</p><h2>Why Healthy Weight Loss Matters</h2><p>Being overweight or obese contributes to Type 2 diabetes, hypertension, heart disease, thyroid disorders, joint problems, fatty liver disease, sleep apnoea, fertility issues, and certain cancers.</p><h2>Benefits of Healthy Weight</h2><ul><li>Better blood sugar control.</li><li>Improved blood pressure and cholesterol levels.</li><li>Reduced joint pain and better mobility.</li><li>Better energy, sleep, and mental well-being.</li><li>Lower risk of heart disease and stroke.</li></ul><p>Losing even 5-10% of body weight can lead to substantial improvements.</p><h2>How to Approach Weight Loss</h2><ul><li><strong>Balanced nutrition:</strong> Prefer home-cooked meals with vegetables, whole grains, pulses, lean protein, and healthy fats.</li><li><strong>Regular physical activity:</strong> Aim for at least 150 minutes of moderate exercise per week plus strength training.</li><li><strong>Portion control:</strong> Eat slowly and avoid distractions during meals.</li><li><strong>Sleep and stress:</strong> Poor sleep and chronic stress affect hunger hormones and weight loss.</li><li><strong>Consistency:</strong> Small, maintainable changes work better than extreme short-term efforts.</li></ul><h2>When to Consult a Doctor</h2><p>Seek medical guidance if BMI is 23 or above, weight loss is difficult despite effort, or weight gain is accompanied by fatigue, hair loss, irregular periods, increased thirst, or family history of diabetes, hypertension, or thyroid disorders.</p><p>Maintaining a healthy weight is one of the most effective ways to protect overall health and improve quality of life.</p>', 'Excess weight is not just cosmetic. Learn why losing even 5-10% of body weight can transform long-term health.', 'images/Blogs/Diabetology/Diabetology4.jpeg', 1, 0, 'published', '2026-05-05 09:00:00', '2026-06-01 04:59:21', '2026-06-01 04:59:21');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `color`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Cardiology Care', 'cardiology-care', 'Heart and Cardiovascular Health', NULL, '#E74C3C', 'active', '2026-06-01 04:59:21', '2026-06-01 04:59:21'),
(2, 'Diabetology', 'diabetology', 'Diabetes Management and Treatment', NULL, '#3498DB', 'active', '2026-06-01 04:59:21', '2026-06-01 04:59:21'),
(3, 'Gastrointestinal (Gastric) Care', 'gastric-care', 'Digestive System Health', NULL, '#F39C12', 'active', '2026-06-01 04:59:21', '2026-06-01 04:59:21'),
(4, 'Thyroid Management', 'thyroid-management', 'Thyroid Disorders and Treatment', NULL, '#9B59B6', 'active', '2026-06-01 04:59:21', '2026-06-01 04:59:21');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` longtext NOT NULL,
  `status` enum('new','read','replied','archived') DEFAULT 'new',
  `replied_by` int(11) DEFAULT NULL,
  `reply_message` longtext DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `replied_by`, `reply_message`, `replied_at`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 'Vivek Tiwari', 'tvivek2021@gmail.com', '9848965785', 'Appointment Request', 'Hello', 'read', NULL, NULL, NULL, NULL, '2026-06-01 05:09:10', '2026-06-01 05:19:31'),
(2, 'Ravina Sharma', 'ravina123@gmail.com', '9352487594', 'Consultation - Cardiology', 'Hii', 'read', NULL, NULL, NULL, NULL, '2026-06-01 05:10:11', '2026-06-01 05:18:48'),
(4, 'Manisha Gupta', 'drmanisha@gmail.com', '9756485248', 'Consultation - Thyroid', 'Hello', 'read', NULL, NULL, NULL, NULL, '2026-06-01 05:30:20', '2026-06-01 05:30:25'),
(5, 'Shivam Pandey', 'pandey@gmail.com', '9745256875', 'Consultation - Diabetes', 'Hii', 'read', NULL, NULL, NULL, NULL, '2026-06-01 05:55:27', '2026-06-01 05:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Dr Manisha Gupta', '2026-06-01 04:59:21', '2026-06-01 04:59:21'),
(2, 'site_email', 'manisha_guptaus@yahoo.com', '2026-06-01 04:59:21', '2026-06-01 05:05:25'),
(3, 'site_phone', '+91 9417555092', '2026-06-01 04:59:21', '2026-06-01 05:05:25'),
(4, 'site_address', 'Consultant Internal Medicine Sohana Hospital Sector 77, Sahibzada Ajit Singh Nagar, Punjab 140308, india', '2026-06-01 04:59:21', '2026-06-01 05:05:26'),
(5, 'site_description', 'Expert Medical Consultation by Dr Manisha Gupta', '2026-06-01 04:59:21', '2026-06-01 04:59:21'),
(6, 'social_instagram', 'https://www.instagram.com/consultantmedicinemanisha/', '2026-06-01 04:59:21', '2026-06-01 04:59:21'),
(7, 'social_facebook', 'https://www.facebook.com/manisha.gupta.3956', '2026-06-01 04:59:21', '2026-06-01 04:59:21'),
(8, 'social_youtube', '', '2026-06-01 04:59:21', '2026-06-01 04:59:21'),
(9, 'social_linkedin', '', '2026-06-01 04:59:21', '2026-06-01 04:59:21');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `token` varchar(500) NOT NULL,
  `token_type` varchar(20) DEFAULT 'Bearer',
  `expires_at` datetime NOT NULL,
  `revoked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_published` (`published_at`),
  ADD KEY `idx_blogs_author` (`author_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_categories_slug` (`slug`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_contacts_replied` (`replied_by`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `idx_admin_id` (`admin_id`),
  ADD KEY `idx_token` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`replied_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
