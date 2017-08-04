-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2017 at 04:03 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

--
-- Dumping data for table `bgdy_articles`
--

INSERT INTO `bgdy_articles` (`id`, `title`, `alias`, `category_id`, `content`, `published`, `publish_time`, `start_publishing`, `stop_publishing`, `author_id`, `hits`, `meta_description`, `tags`) VALUES
(3, 'Test Article', 'test-article', 2, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean in sem sit amet est tristique hendrerit in sit amet nulla. Duis pellentesque ipsum sed mattis maximus. Suspendisse imperdiet lectus at sapien tempor, sed laoreet purus cursus. Sed molestie nunc tortor, sit amet malesuada augue pulvinar sit amet. In accumsan euismod dui quis finibus. Quisque sed nisl urna. Phasellus dui magna, fermentum vitae porta non, dignissim ut lorem. Vestibulum vel tincidunt leo. Suspendisse eget risus blandit lacus malesuada volutpat eget nec ante. Nulla mi eros, luctus quis rutrum ut, maximus id nisl. Etiam ultrices ac metus id convallis. Curabitur eu nibh non purus tincidunt efficitur. Aliquam sed fermentum velit. Maecenas consequat augue sit amet pharetra laoreet. Cras vitae nisl in libero ultricies volutpat.</p>\r\n<p>Praesent viverra, odio cursus hendrerit porttitor, est ligula accumsan turpis, vel mattis purus neque quis lorem. Aliquam erat volutpat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed felis sem, congue vitae mattis vel, scelerisque vitae ligula. Vestibulum viverra quam vel ex eleifend, quis maximus massa accumsan. Nulla facilisi. Fusce varius in nisi nec consequat. Nullam imperdiet, arcu non tempor pulvinar, ipsum felis eleifend mi, a molestie eros libero at ligula. Morbi nec lorem quis metus dignissim cursus sit amet sit amet eros. Fusce tincidunt lorem a eleifend mattis. Sed eu luctus augue. Etiam sagittis sem vitae eros tempus, a suscipit metus faucibus. Etiam commodo venenatis ipsum et pellentesque. Maecenas elementum ultrices neque, eget mollis ipsum pulvinar et. Quisque euismod dui ipsum. Suspendisse egestas mi sed orci aliquet maximus.</p>\r\n<p>Ut vel vestibulum risus, at hendrerit nisl. Aenean tristique in massa eget iaculis. Aliquam ac feugiat nunc. Morbi pellentesque venenatis nisi, quis imperdiet leo congue et. Morbi tempus laoreet erat, id fringilla dolor finibus at. Ut non diam nec arcu efficitur dignissim. Morbi ac orci nunc. Sed lobortis ligula feugiat, fringilla lorem a, sagittis odio. Quisque cursus sapien velit, vitae aliquet ipsum luctus sed. Vestibulum quis sodales orci, a lobortis lorem. Cras quis orci a libero fringilla scelerisque. Curabitur ornare lorem purus, non tincidunt velit porta eu. Morbi suscipit nulla neque, blandit cursus risus dictum eget. Curabitur viverra convallis iaculis. Nunc venenatis est et diam mattis euismod.</p>\r\n<p>Integer vehicula, elit sed rutrum ultrices, ante dolor posuere turpis, ultricies commodo nibh ante eu justo. Sed feugiat hendrerit ligula, ut tincidunt lorem iaculis quis. Donec tristique purus leo, quis blandit odio iaculis vel. Sed nec magna non velit malesuada commodo vitae vel leo. Duis ut eros vel felis sodales dignissim. Donec pellentesque vel libero non eleifend. Sed ullamcorper, magna ultricies sagittis posuere, purus nibh placerat ante, nec mollis velit quam a felis.</p>\r\n<p>Aliquam erat volutpat. Donec vitae lacus quis nisi pharetra rutrum et sed sapien. Etiam augue massa, convallis a efficitur nec, porttitor at ligula. Nullam luctus elit id sapien elementum, a placerat quam porta. Curabitur mattis purus in fermentum consectetur. Curabitur interdum nulla ligula, non pulvinar magna molestie eu. Fusce id leo a velit faucibus suscipit. Donec tincidunt leo ac vehicula volutpat. Vestibulum leo tellus, laoreet vel efficitur eget, aliquet sit amet libero. Nulla facilisi. Duis malesuada consequat cursus.</p>', 1, 1487514022, 0, 0, 5, 4, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_articles_categories`
--

CREATE TABLE `bgdy_articles_categories` (
  `id` int(11) NOT NULL,
  `title` varchar(500) DEFAULT NULL,
  `description` text NOT NULL,
  `published` int(11) DEFAULT '1',
  `params` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bgdy_articles_categories`
--

INSERT INTO `bgdy_articles_categories` (`id`, `title`, `description`, `published`, `params`) VALUES
(2, 'Site Pages', '', 1, 'N;');

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

--
-- Dumping data for table `bgdy_components`
--

INSERT INTO `bgdy_components` (`id`, `title`, `description`, `internal_name`, `is_frontend`, `is_backend`, `is_locked`, `author_name`, `author_url`, `version`, `params`) VALUES
(3, 'Content', 'Article category, and detail view. Includes comments.', 'content', 1, 1, 1, 'Chris Smith', 'https://github.com/Smith0r', '1.0.0-alpha', NULL),
(4, 'User', 'Provides functions for account management, and profile views.', 'user', 1, 1, 1, 'Chris Smith', 'https://github.com/Smith0r', '1.0.0-alpha', NULL);

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

--
-- Dumping data for table `bgdy_components_modules`
--

INSERT INTO `bgdy_components_modules` (`id`, `title`, `description`, `internal_name`, `is_frontend`, `is_backend`, `is_locked`, `author_name`, `author_url`, `version`) VALUES
(1, 'Latest News', 'Show the latest news in a list.', 'latestnews', 1, 0, 1, 'Chris Smith', 'https://github.com/Smith0r', '1.0.0-alpha'),
(2, 'Menu', 'Show menu items in a menu format', 'menu', 1, 0, 1, 'Chris Smith', 'https://github.com/Smith0r', '1.0.0-alpha');

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_menus`
--

CREATE TABLE `bgdy_menus` (
  `id` int(11) NOT NULL,
  `title` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bgdy_menus`
--

INSERT INTO `bgdy_menus` (`id`, `title`) VALUES
(2, 'Main Menu');

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_menus_items`
--

CREATE TABLE `bgdy_menus_items` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
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

--
-- Dumping data for table `bgdy_menus_items`
--

INSERT INTO `bgdy_menus_items` (`id`, `menu_id`, `title`, `alias`, `published`, `access_group`, `component`, `controller`, `content_id`, `params`, `is_home`) VALUES
(6, 2, 'Home', 'home', 1, NULL, 'content', 'category', '2', 'N;', 1);

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

--
-- Dumping data for table `bgdy_modules`
--

INSERT INTO `bgdy_modules` (`id`, `title`, `type`, `show_title`, `published`, `position`, `params`, `pages`, `ordering`) VALUES
(1, 'Latest News', 'latestnews', 1, 1, 'sidebar', 'a:1:{s:11:"category_id";s:1:"2";}', '6', 0);

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

--
-- Dumping data for table `bgdy_sessions`
--

INSERT INTO `bgdy_sessions` (`id`, `php_session_id`, `user_id`, `last_action_time`) VALUES
(1, 'q28r0ia3lp2lvnm16e9653r043', 5, 1501855367);

-- --------------------------------------------------------

--
-- Table structure for table `bgdy_usergroups`
--

CREATE TABLE `bgdy_usergroups` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `colour` varchar(255) DEFAULT NULL,
  `is_admin` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bgdy_usergroups`
--

INSERT INTO `bgdy_usergroups` (`id`, `title`, `colour`, `is_admin`) VALUES
(1, 'Administrators', '#000000', 1);

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

--
-- Dumping data for table `bgdy_users`
--

INSERT INTO `bgdy_users` (`id`, `username`, `real_name`, `email`, `usergroup_id`, `password`, `activated`, `blocked`, `blocked_reason`, `register_time`, `last_action_time`, `verify_token`) VALUES
(5, 'Smith0r', 'Chris Smith', 'smith0r54@gmail.com', 1, '$2y$10$wXWSowM2xqTR.bxIgwDKoO0fq1GX8/iqDatJEJaL.v0NAtM902IU.', 1, 0, NULL, 1487513679, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bgdy_components_modules`
--
ALTER TABLE `bgdy_components_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bgdy_menus`
--
ALTER TABLE `bgdy_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bgdy_menus_items`
--
ALTER TABLE `bgdy_menus_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `bgdy_modules`
--
ALTER TABLE `bgdy_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bgdy_sessions`
--
ALTER TABLE `bgdy_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
