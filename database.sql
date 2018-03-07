-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2018 at 10:20 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bulletin`
--

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_articles`
--

CREATE TABLE `bgdy_articles` (
  `id` int(11) NOT NULL,
  `title` varchar(500) DEFAULT NULL,
  `alias` varchar(500) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `content` text,
  `published` int(11) NOT NULL DEFAULT '1',
  `publish_time` int(11) DEFAULT NULL,
  `start_publishing` int(11) DEFAULT NULL,
  `stop_publishing` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  `meta_description` varchar(500) DEFAULT NULL,
  `tags` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_articles_categories`
--

CREATE TABLE `bgdy_articles_categories` (
  `id` int(11) NOT NULL,
  `title` varchar(500) DEFAULT NULL,
  `alias` varchar(500) NOT NULL,
  `description` text,
  `published` int(11) DEFAULT '1',
  `params` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_articles_comments`
--

CREATE TABLE `bgdy_articles_comments` (
  `id` int(11) NOT NULL,
  `article_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `post_time` int(11) DEFAULT NULL,
  `content` text,
  `published` int(11) DEFAULT '1',
  `reported` int(11) DEFAULT '0',
  `reported_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_components`
--

CREATE TABLE `bgdy_components` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `internal_name` varchar(255) DEFAULT NULL,
  `is_frontend` int(11) NOT NULL DEFAULT '0',
  `is_backend` int(11) NOT NULL DEFAULT '0',
  `is_locked` int(11) DEFAULT '0',
  `author_name` varchar(500) DEFAULT NULL,
  `author_url` varchar(2000) DEFAULT NULL,
  `version` varchar(255) DEFAULT '1.0.0',
  `params` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_components_modules`
--

CREATE TABLE `bgdy_components_modules` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `internal_name` varchar(255) DEFAULT NULL,
  `is_frontend` int(11) NOT NULL DEFAULT '0',
  `is_backend` int(11) NOT NULL DEFAULT '0',
  `is_locked` int(11) DEFAULT '0',
  `author_name` varchar(500) DEFAULT NULL,
  `author_url` varchar(2000) DEFAULT NULL,
  `version` varchar(255) DEFAULT '1.0.0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_menus`
--

CREATE TABLE `bgdy_menus` (
  `id` int(11) NOT NULL,
  `title` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_menus_items`
--

CREATE TABLE `bgdy_menus_items` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(500) DEFAULT NULL,
  `alias` varchar(500) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  `access_group` int(11) DEFAULT NULL,
  `component` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `content_id` varchar(255) DEFAULT NULL,
  `params` text,
  `is_home` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_modules`
--

CREATE TABLE `bgdy_modules` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `show_title` int(11) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `params` varchar(10000) DEFAULT NULL,
  `pages` varchar(255) DEFAULT NULL,
  `ordering` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_sessions`
--

CREATE TABLE `bgdy_sessions` (
  `id` int(11) NOT NULL,
  `php_session_id` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `last_action_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_usergroups`
--

CREATE TABLE `bgdy_usergroups` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `is_admin` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_users`
--

CREATE TABLE `bgdy_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `real_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `usergroup_id` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `activated` int(11) DEFAULT '0',
  `blocked` int(11) DEFAULT '0',
  `blocked_reason` text,
  `register_time` int(11) DEFAULT NULL,
  `last_action_time` int(11) DEFAULT NULL,
  `verify_token` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_users_recovery`
--

CREATE TABLE `bgdy_users_recovery` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reset_requested` int(11) DEFAULT NULL,
  `token` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bgdy_articles`
--
ALTER TABLE `bgdy_articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bgdy_articles_categories`
--
ALTER TABLE `bgdy_articles_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bgdy_articles_comments`
--
ALTER TABLE `bgdy_articles_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bgdy_components`
--
ALTER TABLE `bgdy_components`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bgdy_components_modules`
--
ALTER TABLE `bgdy_components_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bgdy_menus`
--
ALTER TABLE `bgdy_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bgdy_menus_items`
--
ALTER TABLE `bgdy_menus_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bgdy_modules`
--
ALTER TABLE `bgdy_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bgdy_sessions`
--
ALTER TABLE `bgdy_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bgdy_usergroups`
--
ALTER TABLE `bgdy_usergroups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bgdy_users`
--
ALTER TABLE `bgdy_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bgdy_users_recovery`
--
ALTER TABLE `bgdy_users_recovery`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bgdy_articles`
--
ALTER TABLE `bgdy_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bgdy_articles_categories`
--
ALTER TABLE `bgdy_articles_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bgdy_articles_comments`
--
ALTER TABLE `bgdy_articles_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bgdy_components`
--
ALTER TABLE `bgdy_components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bgdy_components_modules`
--
ALTER TABLE `bgdy_components_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bgdy_menus`
--
ALTER TABLE `bgdy_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bgdy_menus_items`
--
ALTER TABLE `bgdy_menus_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bgdy_modules`
--
ALTER TABLE `bgdy_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bgdy_sessions`
--
ALTER TABLE `bgdy_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `bgdy_usergroups`
--
ALTER TABLE `bgdy_usergroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bgdy_users`
--
ALTER TABLE `bgdy_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bgdy_users_recovery`
--
ALTER TABLE `bgdy_users_recovery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
