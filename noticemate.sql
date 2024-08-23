-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2024 at 08:16 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `noticemate`
--

-- --------------------------------------------------------

--
-- Table structure for table `nm_attachments`
--

CREATE TABLE `nm_attachments` (
  `attach_id` bigint(20) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `notice_id` bigint(20) NOT NULL,
  `file_name` varchar(60) NOT NULL,
  `or_file_name` varchar(100) NOT NULL,
  `file_size` float NOT NULL,
  `file_ext` varchar(10) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nm_attachments`
--

INSERT INTO `nm_attachments` (`attach_id`, `user_id`, `notice_id`, `file_name`, `or_file_name`, `file_size`, `file_ext`, `is_active`) VALUES
(77, '4856112499', 1, '3059f641a2603085dc112895a777e597ceb391e71461615961', '20151214114619.jpg', 0.27, 'jpg', 1),
(78, '4856112499', 4, 'a316bf1148871c83fb1478ac475eed3606bde3b81461744327', 'album2.jpg', 0.18, 'jpg', 1),
(79, '3557923742', 5, 'cdc7c2d5988137d36ea3758277f4e9e8278ec4111461746962', 'bad_browser.zip', 0.82, 'zip', 1),
(80, '3557923742', 0, '8edb4d476565e6413953eb8c797bbbc7352782361461747464', 'welcome.png', 0.08, 'png', 0),
(81, '3557923742', 7, '4ce3c548dc88a501f184fed1664ceba96eb52e221461749939', 'welcome.png', 0.08, 'png', 1),
(82, '3557923742', 8, '9b9aec5db3114f8308173cd001ac649564a0ed291461750054', 'gre_wordlist.pdf', 1.7, 'pdf', 1),
(83, '4856112499', 22, '4735284b6e0ac2a6e5bf5f5016d951db6cfe3ccd1488555104', '2016-09-23-2017-02-09_Invoice_summary.pdf', 0.02, 'pdf', 1),
(84, '4856112499', 22, 'ca639017d0be5db7e842616fead8a6951d58e02b1488555130', '300x300.jpg', 0.02, 'jpg', 1),
(85, '7177530576', 25, 'cddbba1ec604ed508c91a31b6b44e0bc2db0ae531643673597', 'Copy+of+Manohar+_Resume_v2+(7) (1).pdf', 0.08, 'pdf', 1),
(86, '7177530576', 25, '507df4ff106f6445ad3e8f666d619c2fdb31860b1643673602', 'profile-pic.png', 0.04, 'png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nm_board`
--

CREATE TABLE `nm_board` (
  `item_id` bigint(20) NOT NULL,
  `board_id` varchar(10) NOT NULL,
  `board_name` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL,
  `board_admin` varchar(10) NOT NULL,
  `board_dist_id` varchar(16) NOT NULL,
  `is_active` int(2) NOT NULL,
  `join_more` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nm_board`
--

INSERT INTO `nm_board` (`item_id`, `board_id`, `board_name`, `created_on`, `board_admin`, `board_dist_id`, `is_active`, `join_more`) VALUES
(1, '2299925047', 'NoticeMate', '2016-04-26 01:54:29', '4856112499', '7269188492144114', 0, 1),
(2, '1275092094', 'best friends', '2016-04-26 12:55:09', '3557923742', '5567506245460909', 1, 1),
(3, '4525872336', 'Testing Community', '2016-04-30 11:36:02', '4856112499', '6210778441448546', 1, 1),
(4, '7264099779', 'ABCBoard', '2016-05-02 09:45:11', '8155574376', '9164272053609002', 1, 1),
(5, '7776569264', 'qwerty', '2016-05-05 00:03:08', '5581426558', '6087948767043718', 1, 1),
(6, '7362883537', 'To-DO List', '2016-06-06 11:24:00', '1570989833', '7257669363601988', 1, 1),
(7, '6377121193', 'NoticeMate Team', '2016-07-25 23:41:53', '4856112499', '4945283702443046', 0, 0),
(8, '9915768591', 'Saurav', '2016-10-08 00:31:13', '4022292382', '8898309590902023', 1, 1),
(9, '1763344324', 'CSE group', '2016-10-18 17:02:18', '4911318806', '4132954225570917', 1, 1),
(10, '6601554308', 'Zara Team', '2017-03-03 20:59:09', '4856112499', '5607662242293339', 0, 1),
(11, '4058967187', 'Batch 2013', '2017-12-25 01:30:31', '7177530576', '0819843869938925', 1, 1),
(12, '', 'cb board', '2017-12-30 01:32:02', '4856112499', '4856018688984973', 1, 1),
(18, '2039455910', 'cb board 2', '2017-12-30 14:44:37', '4856112499', '3089879923573806', 0, 1),
(19, '1866100956', 'welcome 2', '2017-12-30 14:47:00', '4856112499', '4895243091583086', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `nm_boardconf`
--

CREATE TABLE `nm_boardconf` (
  `item_id` bigint(20) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `allowed_board` int(5) NOT NULL,
  `allowed_people` int(10) NOT NULL,
  `is_admin` int(1) NOT NULL,
  `plan_type` bigint(20) NOT NULL,
  `expire_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nm_boardconf`
--

INSERT INTO `nm_boardconf` (`item_id`, `user_id`, `allowed_board`, `allowed_people`, `is_admin`, `plan_type`, `expire_on`) VALUES
(1, '4856112499', 5, 100, 0, 2, '2016-04-26 01:43:10'),
(2, '3557923742', 5, 100, 0, 2, '2016-04-26 12:53:45'),
(3, '8165051353', 5, 100, 0, 2, '2016-04-26 16:30:24'),
(4, '7177530576', 5, 100, 0, 2, '2016-04-30 12:17:44'),
(5, '6412817620', 5, 100, 0, 2, '2016-04-30 12:29:15'),
(6, '2457214068', 5, 100, 0, 2, '2016-04-30 12:34:03'),
(7, '8102041449', 5, 100, 0, 2, '2016-04-30 12:46:32'),
(8, '9954164827', 5, 100, 0, 2, '2016-04-30 12:52:15'),
(9, '5354734104', 5, 100, 0, 2, '2016-04-30 13:07:55'),
(10, '7402611474', 5, 100, 0, 2, '2016-04-30 13:11:42'),
(11, '3085594330', 5, 100, 0, 2, '2016-04-30 13:13:59'),
(12, '9788619292', 5, 100, 0, 2, '2016-04-30 14:04:04'),
(13, '8155574376', 5, 100, 0, 2, '2016-05-02 09:43:27'),
(14, '5581426558', 5, 100, 0, 2, '2016-05-04 23:58:05'),
(15, '7281336925', 5, 100, 0, 2, '2016-05-08 22:50:54'),
(16, '1570989833', 5, 100, 0, 2, '2016-06-06 11:23:00'),
(17, '5855797247', 5, 100, 0, 2, '2016-06-26 16:33:37'),
(18, '4022292382', 5, 100, 0, 2, '2016-10-08 00:30:20'),
(19, '1639788494', 5, 100, 0, 2, '2016-10-08 00:31:44'),
(20, '4911318806', 5, 100, 0, 2, '2016-10-18 17:01:42'),
(21, '2017957609', 5, 100, 0, 2, '2017-03-03 21:05:45');

-- --------------------------------------------------------

--
-- Table structure for table `nm_boardcont`
--

CREATE TABLE `nm_boardcont` (
  `content_id` bigint(20) NOT NULL,
  `posted_by` varchar(10) NOT NULL,
  `posted_on` date NOT NULL,
  `posted_time` time NOT NULL,
  `board_id` varchar(10) NOT NULL,
  `content_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_forwarded` int(1) NOT NULL,
  `reply_allow` int(1) NOT NULL DEFAULT '1',
  `content_type` bigint(20) NOT NULL DEFAULT '12'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nm_boardcont`
--

INSERT INTO `nm_boardcont` (`content_id`, `posted_by`, `posted_on`, `posted_time`, `board_id`, `content_title`, `content`, `is_forwarded`, `reply_allow`, `content_type`) VALUES
(1, '4856112499', '2016-04-26', '01:57:15', '2299925047', 'welcome to the live', '<p>we are going to the live here...thanks..man..<img class=\"image-popup-no-margins content-image\" src=\"uploades/files/user-4856112499/6591461615966.jpg\" alt=\"\" data-mfp-img-src=\"http://uploades.noticemate.com/uploades/files/user-4856112499/6591461615966.jpg\" /></p>', 0, 1, 12),
(2, '4856112499', '2016-04-26', '08:41:27', '2299925047', 'welcome 2nd notice on the noticemate', '<p>it is must to see you that you have opted too good marks in your class...</p>\n<p>Thanks..dost..</p>', 0, 1, 12),
(3, '4856112499', '2016-04-26', '09:32:16', '2299925047', 'thired notice', '<p>welcome to the noticemate..</p>\n<p>&nbsp;</p>', 0, 1, 12),
(4, '4856112499', '2016-04-27', '13:35:31', '2299925047', 'welocjkjkljlkjkljd', '<p><img class=\"image-popup-no-margins content-image\" src=\"uploades/files/user-4856112499/8141461743938.jpg\" alt=\"\" data-mfp-img-src=\"http://web.noticemate.com/uploades/files/user-4856112499/8141461743938.jpg\" /></p>', 0, 1, 12),
(5, '3557923742', '2016-04-27', '14:19:45', '1275092094', 'file testing in notice ', '<p>file testing on notice ok</p>', 0, 1, 12),
(6, '3557923742', '2016-04-27', '15:08:24', '1275092094', 'attach image testing in notice', '<p><img class=\"image-popup-no-margins content-image\" src=\"uploades/files/user-3557923742/8211461749900.jpg\" alt=\"\" data-mfp-img-src=\"http://web.noticemate.com/uploades/files/user-3557923742/8211461749900.jpg\" /></p>\n<p>&nbsp;</p>', 0, 1, 12),
(7, '3557923742', '2016-04-27', '15:09:24', '1275092094', 'attach file  image testing in notice', '<p>this image is selected by attach button</p>\n<p>&nbsp;</p>', 0, 1, 12),
(8, '3557923742', '2016-04-27', '15:11:27', '1275092094', 'pdf sendig in notice', '<p>pdf file testing in notice&nbsp;</p>', 0, 1, 12),
(9, '4856112499', '2016-04-27', '15:13:03', '2299925047', 'welcome to thenotice', '<p>Hi..come and attend here....</p>', 0, 1, 11),
(12, '4856112499', '2016-04-30', '12:03:39', '4525872336', 'welcome to the noticemate', '<div class=\"wn_wrapper\" style=\"width: 500px; height: 400px; background-color: #fff; margin: 0 auto; overflow: hidden; border: 2px solid #ccc; border-radius: 5px;\" data-mce-style=\"width: 500px; height: 400px; background-color: #fff; margin: 0 auto; overflow: hidden; border: 2px solid #ccc; border-radius: 5px;\"><div class=\"wn_inner_left\" style=\"width: 65%; height: 370px; /*font-family: \'helvetica neue\',helvetica,arial,\'lucida grande\',sans-serif; -webkit-font-smoothing: antialiased; */font-family: Calibri; float: left;\" data-mce-style=\"width: 65%; height: 370px; /*font-family: \'helvetica neue\',helvetica,arial,\'lucida grande\',sans-serif; -webkit-font-smoothing: antialiased; */font-family: Calibri; float: left;\"><h1 style=\"font-size: 30px; color: #5890ff; font-weight: inherit; padding: 30px;\" data-mce-style=\"font-size: 30px; color: #5890ff; font-weight: inherit; padding: 30px;\">Hi welcome to <br><strong style=\"float: right;\" data-mce-style=\"float: right;\">NoticeMate</strong></h1><hr style=\"margin-top: 25px; background-color: #03a9f4; height: 1px; border: none; border-radius: 33px; margin-left: 30px;\" data-mce-style=\"margin-top: 25px; background-color: #03a9f4; height: 1px; border: none; border-radius: 33px; margin-left: 30px;\"><h2 style=\"font-size: 18px; color: #5890ff; padding: 20px 0px 0px 30px; font-weight: inherit;\" data-mce-style=\"font-size: 18px; color: #5890ff; padding: 20px 0px 0px 30px; font-weight: inherit;\">At <strong>NoticeMate</strong>, you\'re not just an<br> another user. You\'re a member</h2><p style=\"font-size: 16px; color: #607d8b; padding: 20px 0px 10px 30px; font-weight: inherit;\" data-mce-style=\"font-size: 16px; color: #607d8b; padding: 20px 0px 10px 30px; font-weight: inherit;\">As a member you get 3 Boards on <br>demo and purchase our lots of <br> premium plan, NoticeMate also give<br> unlimited follwed Board and also <br> purchase our unlimited plan</p><p style=\"font-size: 18px; margin-left: 30px;\" data-mce-style=\"font-size: 18px; margin-left: 30px;\">Thanks &amp; Regards<br> <strong>NoticeMate Team</strong></p></div><div class=\"wn_right\" style=\"position: relative; width: 35%; height: 370px; float: right;\" data-mce-style=\"position: relative; width: 35%; height: 370px; float: right;\"><img src=\"http://googledrive.com/host/0B4Ph2Cz5L9_pZndmZ1ZuUDR6aGs/sonu/Handshake.png\" width=\"270px\" height=\"auto\" style=\"position: absolute; right: -10px;\" alt=\"\" data-mce-src=\"http://googledrive.com/host/0B4Ph2Cz5L9_pZndmZ1ZuUDR6aGs/sonu/Handshake.png\" data-mce-style=\"position: absolute; right: -10px;\"></div><div class=\"wn_footer\" style=\"width: 100%; height: 15px; background-color: #2196f3; margin-top: 15px; box-shadow: 0px -2px 17px #525252; float: left; position: relative; border-radius: 0px 0px 5px 5px;\" data-mce-style=\"width: 100%; height: 15px; background-color: #2196f3; margin-top: 15px; box-shadow: 0px -2px 17px #525252; float: left; position: relative; border-radius: 0px 0px 5px 5px;\">&nbsp;<br></div></div>', 0, 1, 12),
(13, '3557923742', '2016-04-30', '12:43:55', '1275092094', 'error notice testing', '<p>notice testing</p>\n<p>&nbsp;</p>', 0, 1, 12),
(14, '4856112499', '2016-04-30', '13:43:25', '4525872336', 'Problems in finding popup height right side members', '<p>When scrolls content goes to filled and then sometime poups of the dots show to bottom it means that goes to hide in black widow..</p>\n<p>Try to resolve it also take a look out this screenshots....</p>', 0, 1, 12),
(15, '4856112499', '2016-04-30', '13:44:59', '4525872336', 'Problems in finding popup height right side members screenshot', '<p>When scrolls content goes to filled and then sometime poups of the dots show to bottom it means that goes to hide in black widow..</p>\n<p>Try to resolve it also take a look out this screenshots....</p>\n<p>&nbsp;</p>\n<p><img class=\"image-popup-no-margins content-image\" src=\"uploades/files/user-4856112499/3571462004090.jpg\" alt=\"\" data-mfp-img-src=\"http://web.noticemate.com/uploades/files/user-4856112499/3571462004090.jpg\" /></p>', 0, 1, 12),
(16, '4856112499', '2016-04-30', '13:44:59', '4525872336', 'Problems in finding popup height right side members screenshot', '<p>When scrolls content goes to filled and then sometime poups of the dots show to bottom it means that goes to hide in black widow..</p>\n<p>Try to resolve it also take a look out this screenshots....</p>\n<p>&nbsp;</p>\n<p><img class=\"image-popup-no-margins content-image\" src=\"uploades/files/user-4856112499/3571462004090.jpg\" alt=\"\" data-mfp-img-src=\"http://web.noticemate.com/uploades/files/user-4856112499/3571462004090.jpg\" /></p>', 0, 1, 12),
(17, '4856112499', '2016-04-30', '13:58:39', '4525872336', 'Must have to remove style tag', '<p>Sharing html template as a notice it creates styling error in application if template stylesheets is added externally.....</p>\n<p>So,, please make sure to remove <strong>style tag</strong> in&nbsp;html content at time of uploading.</p>', 0, 1, 12),
(18, '4856112499', '2016-04-30', '14:01:48', '4525872336', 'All member search is not working', '<p>The filtering of all members through his name is not working in all members section..</p>\n<p>It will be hard to find a particular member if there will be more than 20 or 30 members in a board or community</p>\n<p>&nbsp;</p>\n<p><img class=\"image-popup-no-margins content-image\" style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"uploades/files/user-4856112499/8671462005085.jpg\" alt=\"\" data-mfp-img-src=\"http://web.noticemate.com/uploades/files/user-4856112499/8671462005085.jpg\" /></p>', 0, 1, 12),
(19, '4856112499', '2016-05-01', '10:45:30', '4525872336', 'First step of putting the into the world', '<p><img class=\"image-popup-no-margins content-image\" style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"uploades/files/user-4856112499/9701462079695.jpg\" alt=\"\" data-mfp-img-src=\"http://web.noticemate.com/uploades/files/user-4856112499/9701462079695.jpg\" /></p>', 0, 1, 12),
(20, '8155574376', '2016-05-02', '09:46:20', '7264099779', 'Clean my desk', '<p>why dont you clean it.</p>\n<p>you are not dooing your job.</p>\n<p>please do your job</p>\n<p>&nbsp;</p>', 0, 1, 12),
(21, '4856112499', '2016-12-22', '16:06:20', '4525872336', 'jhuhuhuihuihiuhiu', '<p>hello every1</p>', 0, 1, 12),
(22, '4856112499', '2017-03-03', '21:02:17', '6601554308', 'Please, update the site', '<p>jdlkjkldjlkjdlk</p>\n<p>&nbsp;</p>\n<p>d<img class=\"image-popup-no-margins content-image\" src=\"uploades/files/user-4856112499/3931488555119.jpg\" alt=\"\" data-mfp-img-src=\"http://web.noticemate.com/uploades/files/user-4856112499/3931488555119.jpg\" /></p>', 0, 1, 12),
(23, '4856112499', '2017-09-26', '14:57:38', '4525872336', 'Planning again', '<p>Hey, lets plan again to make this software great, awesome and valuable as well. Okay ??</p>', 0, 1, 12),
(24, '4856112499', '2017-12-15', '03:55:10', '2299925047', 'tomorrow class will not be there', '<p>.Hi, students,</p>\n<p>This is going to be notified to our project that there will not be anything like t<img class=\"image-popup-no-margins content-image\" src=\"uploades/files/user-4856112499/3621513290306.jpg\" alt=\"\" data-mfp-img-src=\"http://web.noticemate.com/uploades/files/user-4856112499/3621513290306.jpg\" /><img class=\"image-popup-no-margins content-image\" src=\"uploades/files/user-4856112499/8391513290297.jpg\" alt=\"\" data-mfp-img-src=\"http://web.noticemate.com/uploades/files/user-4856112499/8391513290297.jpg\" /><img class=\"image-popup-no-margins content-image\" src=\"uploades/files/user-4856112499/9651513290295.jpg\" alt=\"\" data-mfp-img-src=\"http://web.noticemate.com/uploades/files/user-4856112499/9651513290295.jpg\" /></p>', 0, 1, 12),
(25, '7177530576', '2022-02-01', '05:30:13', '4058967187', 'Hello there', '<p>This is to notify that<img class=\"image-popup-no-margins content-image\" src=\"uploades/files/user-7177530576/5561643673582.jpg\" alt=\"\" data-mfp-img-src=\"http://web.noticemate.com/uploades/files/user-7177530576/5561643673582.jpg\" /></p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>', 0, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `nm_boarduser`
--

CREATE TABLE `nm_boarduser` (
  `item_id` bigint(20) NOT NULL,
  `board_id` varchar(10) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `joined_on` datetime NOT NULL,
  `is_admin` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nm_boarduser`
--

INSERT INTO `nm_boarduser` (`item_id`, `board_id`, `user_id`, `joined_on`, `is_admin`) VALUES
(1, '2299925047', '4856112499', '2016-04-26 01:54:29', 1),
(2, '1275092094', '3557923742', '2016-04-26 12:55:09', 1),
(3, '4525872336', '4856112499', '2016-04-30 11:36:02', 1),
(4, '4525872336', '7177530576', '2016-04-30 12:19:00', 0),
(5, '4525872336', '6412817620', '2016-04-30 12:29:52', 0),
(6, '4525872336', '2457214068', '2016-04-30 12:34:42', 0),
(7, '4525872336', '3557923742', '2016-04-30 12:40:21', 0),
(8, '4525872336', '8102041449', '2016-04-30 12:48:08', 0),
(9, '4525872336', '8165051353', '2016-04-30 12:52:35', 0),
(12, '4525872336', '9788619292', '2016-04-30 14:05:12', 0),
(13, '7264099779', '8155574376', '2016-05-02 09:45:11', 1),
(14, '7776569264', '5581426558', '2016-05-05 00:03:08', 1),
(15, '4525872336', '5581426558', '2016-05-05 00:08:09', 0),
(16, '7362883537', '1570989833', '2016-06-06 11:24:00', 1),
(17, '6377121193', '4856112499', '2016-07-25 23:41:53', 1),
(18, '9915768591', '4022292382', '2016-10-08 00:31:13', 1),
(19, '9915768591', '1639788494', '2016-10-08 00:32:59', 0),
(20, '1763344324', '4911318806', '2016-10-18 17:02:18', 1),
(21, '6601554308', '4856112499', '2017-03-03 20:59:09', 1),
(22, '6601554308', '2017957609', '2017-03-03 21:07:27', 0),
(23, '4058967187', '7177530576', '2017-12-25 01:30:31', 1),
(24, '', '4856112499', '2017-12-30 01:32:02', 1),
(25, '', '4856112499', '2017-12-30 01:32:36', 1),
(26, '', '4856112499', '2017-12-30 01:34:08', 1),
(27, '', '4856112499', '2017-12-30 01:37:18', 1),
(28, '', '4856112499', '2017-12-30 13:53:22', 1),
(29, '', '4856112499', '2017-12-30 14:14:20', 1),
(30, '', '4856112499', '2017-12-30 14:17:34', 1),
(31, '', '4856112499', '2017-12-30 14:34:27', 1),
(32, '', '4856112499', '2017-12-30 14:40:21', 1),
(33, '2039455910', '4856112499', '2017-12-30 14:44:37', 1),
(34, '1866100956', '4856112499', '2017-12-30 14:47:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nm_enterprise`
--

CREATE TABLE `nm_enterprise` (
  `ep_id` bigint(20) NOT NULL,
  `ep_name` varchar(200) NOT NULL,
  `ep_email` varchar(100) NOT NULL,
  `ep_location` text NOT NULL,
  `ep_admin` varchar(10) NOT NULL,
  `is_active` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nm_notification`
--

CREATE TABLE `nm_notification` (
  `item_id` bigint(20) NOT NULL,
  `recepient_id` varchar(10) NOT NULL,
  `sender_id` varchar(10) NOT NULL,
  `is_read` int(1) NOT NULL,
  `created_on` datetime NOT NULL,
  `url` varchar(200) NOT NULL,
  `notif_type` bigint(20) NOT NULL,
  `is_board` int(1) NOT NULL,
  `notice_id` bigint(20) DEFAULT NULL,
  `board_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nm_notification`
--

INSERT INTO `nm_notification` (`item_id`, `recepient_id`, `sender_id`, `is_read`, `created_on`, `url`, `notif_type`, `is_board`, `notice_id`, `board_id`) VALUES
(1, '4856112499', '7177530576', 1, '2016-04-30 12:19:00', 'mod=mjib&board_id=4525872336', 9, 0, NULL, '4525872336'),
(2, '4856112499', '6412817620', 1, '2016-04-30 12:29:52', 'mod=mjib&board_id=4525872336', 9, 0, NULL, '4525872336'),
(3, '4856112499', '2457214068', 1, '2016-04-30 12:34:42', 'mod=mjib&board_id=4525872336', 9, 0, NULL, '4525872336'),
(4, '4856112499', '3557923742', 1, '2016-04-30 12:40:21', 'mod=mjib&board_id=4525872336', 9, 0, NULL, '4525872336'),
(5, '4856112499', '8102041449', 1, '2016-04-30 12:48:08', 'mod=mjib&board_id=4525872336', 9, 0, NULL, '4525872336'),
(6, '4856112499', '8165051353', 1, '2016-04-30 12:52:35', 'mod=mjib&board_id=4525872336', 9, 0, NULL, '4525872336'),
(7, '4856112499', '8165051353', 1, '2016-04-30 12:53:58', 'mod=single_notice&notice_id=12', 6, 0, 12, NULL),
(8, '4856112499', '9954164827', 1, '2016-04-30 13:04:24', 'mod=mjib&board_id=4525872336', 9, 0, NULL, '4525872336'),
(9, '4856112499', '9954164827', 1, '2016-04-30 13:08:15', 'mod=mefb&board_id=4525872336', 10, 0, NULL, '4525872336'),
(10, '4856112499', '9954164827', 1, '2016-04-30 13:09:07', 'mod=mjib&board_id=4525872336', 9, 0, NULL, '4525872336'),
(11, '4856112499', '9788619292', 1, '2016-04-30 14:05:12', 'mod=mjib&board_id=4525872336', 9, 0, NULL, '4525872336'),
(12, '4856112499', '5581426558', 1, '2016-05-05 00:08:09', 'mod=mjib&board_id=4525872336', 9, 0, NULL, '4525872336'),
(13, '9954164827', '4856112499', 0, '2016-05-05 00:26:09', 'mod=urfb&board_id=4525872336', 7, 0, NULL, '4525872336'),
(14, '4022292382', '1639788494', 1, '2016-10-08 00:32:59', 'mod=mjib&board_id=9915768591', 9, 0, NULL, '9915768591'),
(15, '4856112499', '2017957609', 1, '2017-03-03 21:07:27', 'mod=mjib&board_id=6601554308', 9, 0, NULL, '6601554308'),
(16, '4856112499', '2017957609', 1, '2017-03-03 21:09:13', 'mod=single_notice&notice_id=22', 6, 0, 22, NULL),
(17, '4856112499', '7177530576', 0, '2022-02-01 05:31:44', 'mod=single_notice&notice_id=17', 6, 0, 17, NULL),
(18, '4856112499', '7177530576', 0, '2022-02-01 05:32:03', 'mod=single_notice&notice_id=16', 6, 0, 16, NULL),
(19, '4856112499', '7177530576', 0, '2022-02-01 05:32:20', 'mod=single_notice&notice_id=16', 6, 0, 16, NULL),
(20, '4856112499', '7177530576', 0, '2022-02-01 05:33:17', 'mod=single_notice&notice_id=16', 6, 0, 16, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nm_profile`
--

CREATE TABLE `nm_profile` (
  `item_id` bigint(20) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_img` varchar(20) NOT NULL,
  `is_board` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nm_profile`
--

INSERT INTO `nm_profile` (`item_id`, `user_id`, `status`, `profile_img`, `is_board`) VALUES
(1, '4856112499', 'We are targeting', '8571461995184', 0),
(2, '2299925047', 'No Status!', '3701461995111', 1),
(3, '3557923742', 'No Status', '6041462001925', 0),
(4, '1275092094', 'No Status!', '8831461741178', 1),
(5, '8165051353', 'No Status', '6501462001097', 0),
(6, '4525872336', 'No Status!', '5691461996385', 1),
(7, '7177530576', 'No Status', '8551461998884', 0),
(8, '6412817620', 'No Status', '', 0),
(9, '2457214068', 'No Status', '', 0),
(10, '8102041449', 'No Status', '', 0),
(11, '9954164827', 'No Status', '7741462001779', 0),
(12, '5354734104', 'No Status', '', 0),
(13, '7402611474', 'No Status', '', 0),
(14, '3085594330', 'No Status', '', 0),
(15, '9788619292', 'No Status', '5341462005343', 0),
(16, '8155574376', 'No Status', '', 0),
(17, '7264099779', 'No Status!', '', 1),
(18, '5581426558', 'No Status', '', 0),
(19, '7776569264', 'No Status!', '', 1),
(20, '7281336925', 'No Status', '', 0),
(21, '1570989833', 'No Status', '', 0),
(22, '7362883537', 'No Status!', '', 1),
(23, '5855797247', 'No Status', '', 0),
(24, '6377121193', 'No Status!', '', 1),
(25, '4022292382', 'No Status', '', 0),
(26, '9915768591', 'No Status!', '', 1),
(27, '1639788494', 'No Status', '', 0),
(28, '4911318806', 'No Status', '', 0),
(29, '1763344324', 'No Status!', '', 1),
(30, '6601554308', 'Please, update a status', '5541488555010', 1),
(31, '2017957609', 'No Status', '', 0),
(32, '4058967187', 'No Status!', '4161514469747', 1),
(33, '', 'No Status!', '', 1),
(34, '', 'No Status!', '', 1),
(35, '', 'No Status!', '', 1),
(36, '', 'No Status!', '', 1),
(37, '', 'No Status!', '', 1),
(38, '', 'No Status!', '', 1),
(39, '', 'No Status!', '', 1),
(40, '', 'No Status!', '', 1),
(41, '', 'No Status!', '', 1),
(42, '2039455910', 'No Status!', '', 1),
(43, '1866100956', 'No Status!', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nm_replies`
--

CREATE TABLE `nm_replies` (
  `reply_id` bigint(20) NOT NULL,
  `content_id` bigint(20) NOT NULL,
  `replied_by` varchar(10) NOT NULL,
  `replied_on` datetime NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply_location` varchar(30) DEFAULT NULL,
  `reply_type` bigint(20) NOT NULL DEFAULT '14'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nm_replies`
--

INSERT INTO `nm_replies` (`reply_id`, `content_id`, `replied_by`, `replied_on`, `content`, `reply_location`, `reply_type`) VALUES
(1, 4, '4856112499', '2016-04-27 15:10:34', 'welcome to the noticemate..', '', 14),
(2, 4, '4856112499', '2016-04-27 15:10:51', 'wonderful..thanks..', '26.2033052,78.2020541', 14),
(3, 9, '4856112499', '2016-04-27 15:13:12', 'yes', '', 13),
(4, 8, '3557923742', '2016-04-27 15:13:48', 'jjjjjjjjjjj', '26.203302599999997,78.20210689', 14),
(5, 12, '8165051353', '2016-04-30 12:53:58', 'here your html template  not showing  properly plz check css and html.', '', 14),
(6, 14, '4856112499', '2016-07-25 23:43:01', 'Hi.. we have resolved this issue.. thansk', '', 14),
(7, 9, '4856112499', '2016-12-06 14:00:10', 'Due to some reason, i could\'t be able to come out there. thanks.', '', 14),
(8, 21, '4856112499', '2016-12-22 16:06:50', 'hello\n', '', 14),
(9, 4, '4856112499', '2017-01-12 13:34:12', 'Please, check this also...', '', 14),
(10, 21, '4856112499', '2017-02-13 16:46:45', 'Correct !!', '', 14),
(11, 22, '4856112499', '2017-03-03 21:03:10', 'Already, update, please have a look...', '', 14),
(12, 22, '2017957609', '2017-03-03 21:09:13', 'hlo\n', '', 14),
(13, 19, '4856112499', '2017-03-16 14:03:59', 'wow....nice', '', 14),
(14, 24, '4856112499', '2017-12-15 03:55:40', 'okay, coming over there...', '', 14),
(15, 12, '4856112499', '2017-12-24 21:39:45', 'Yes, just checking and reverting you back..', '', 14),
(16, 12, '4856112499', '2017-12-24 21:40:08', 'can you please check again..', '', 14),
(17, 17, '7177530576', '2022-02-01 05:31:44', 'seems fine to me\n', '', 14),
(18, 16, '7177530576', '2022-02-01 05:32:03', 'Thanks', '', 14),
(19, 16, '7177530576', '2022-02-01 05:32:20', 'hello', '', 14),
(20, 16, '7177530576', '2022-02-01 05:33:17', 'test', '', 14);

-- --------------------------------------------------------

--
-- Table structure for table `nm_term`
--

CREATE TABLE `nm_term` (
  `term_id` bigint(20) NOT NULL,
  `term_name` varchar(100) NOT NULL,
  `term_slug` varchar(100) NOT NULL,
  `term_group` varchar(100) NOT NULL,
  `term_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nm_term`
--

INSERT INTO `nm_term` (`term_id`, `term_name`, `term_slug`, `term_group`, `term_description`) VALUES
(1, 'Content Seen', 'content_seen', 'content', 'this defines that a particular content is seen by user or not.'),
(2, 'Demo Plans', 'demo_plans', 'plan type', 'The Plan type defines that user is on demo plan or premium plan'),
(3, 'premium plans', 'premum_plans', 'play type', 'premium plan defines that is user purchased a noticemate plan or not'),
(4, 'Hide Notice', 'hide_notice', 'content', 'this defines that a particular user hides a notice from their timeline'),
(5, 'Board Delete', 'board_delete', 'notification type', '$user_name has been deleted $board_name board'),
(6, 'Notice Reply', 'notice_reply', 'notification type', '$user_name replied on your notice $notice_title'),
(7, 'User removed from board', 'user_removed_from_board', 'notification type', '$user_name removed you from board $board_name'),
(8, 'Board Name Change', 'board_name_change', 'notification type', '$user_name changed board name $board_name1 to $board_name2'),
(9, 'Member joined in board', 'member_joined_in_board', 'Notification Type', '$user_name joined in your board $board_name'),
(10, 'Member exited from board', 'member_exited_from_board', 'Notification Type', '$user_name exited from your board $board_name'),
(11, 'Event Attend', 'event_attend', 'Notice Type', 'This defines that notice is used for event and wants to get feedback that is he attending in the event or not'),
(12, 'Common', 'common', 'Notice Type', 'This defines that notice is simple and he would like to get or off reply in the notice.'),
(13, 'Event Attend', 'event_attend', 'Reply Type', 'This defines that reply is event attendable type like yes, no or can\'t say.'),
(14, 'Common', 'common', 'Reply Type', 'This defines that this reply is common type.');

-- --------------------------------------------------------

--
-- Table structure for table `nm_term_taxonomy`
--

CREATE TABLE `nm_term_taxonomy` (
  `item_id` bigint(20) NOT NULL,
  `term_id` bigint(20) NOT NULL,
  `taxonomy_id` varchar(20) NOT NULL,
  `data1` varchar(100) NOT NULL,
  `data2` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nm_term_taxonomy`
--

INSERT INTO `nm_term_taxonomy` (`item_id`, `term_id`, `taxonomy_id`, `data1`, `data2`) VALUES
(1, 1, '4856112499', '1', '2299925047'),
(2, 1, '4856112499', '2', '2299925047'),
(3, 1, '4856112499', '3', '2299925047'),
(4, 1, '4856112499', '4', '2299925047'),
(5, 1, '3557923742', '5', '1275092094'),
(6, 1, '3557923742', '7', '1275092094'),
(7, 1, '3557923742', '6', '1275092094'),
(8, 1, '3557923742', '8', '1275092094'),
(9, 1, '4856112499', '9', '2299925047'),
(10, 1, '4856112499', '10', '4525872336'),
(11, 4, '4856112499', '10', '4525872336'),
(12, 1, '4856112499', '11', '4525872336'),
(13, 1, '4856112499', '12', '4525872336'),
(14, 4, '4856112499', '11', '4525872336'),
(15, 1, '7177530576', '12', '4525872336'),
(16, 1, '7177530576', '11', '4525872336'),
(17, 1, '7177530576', '10', '4525872336'),
(18, 1, '2457214068', '12', '4525872336'),
(19, 1, '3557923742', '10', '4525872336'),
(20, 1, '3557923742', '11', '4525872336'),
(21, 1, '3557923742', '12', '4525872336'),
(22, 1, '8102041449', '12', '4525872336'),
(23, 1, '8165051353', '12', '4525872336'),
(24, 1, '9954164827', '12', '4525872336'),
(25, 1, '4856112499', '14', '4525872336'),
(26, 1, '4856112499', '15', '4525872336'),
(27, 1, '4856112499', '16', '4525872336'),
(28, 1, '8165051353', '15', '4525872336'),
(29, 1, '8165051353', '16', '4525872336'),
(30, 1, '8165051353', '14', '4525872336'),
(31, 1, '4856112499', '17', '4525872336'),
(32, 1, '4856112499', '18', '4525872336'),
(33, 1, '9788619292', '18', '4525872336'),
(34, 1, '9788619292', '17', '4525872336'),
(35, 1, '8165051353', '17', '4525872336'),
(36, 1, '8165051353', '18', '4525872336'),
(37, 1, '4856112499', '19', '4525872336'),
(38, 1, '5581426558', '19', '4525872336'),
(39, 1, '5581426558', '18', '4525872336'),
(40, 1, '5581426558', '17', '4525872336'),
(41, 1, '5581426558', '12', '4525872336'),
(42, 1, '8165051353', '19', '4525872336'),
(43, 1, '8102041449', '19', '4525872336'),
(44, 1, '4856112499', '21', '4525872336'),
(45, 1, '4856112499', '22', '6601554308'),
(46, 1, '2017957609', '22', '6601554308'),
(47, 1, '8165051353', '21', '4525872336'),
(48, 1, '4856112499', '23', '4525872336'),
(49, 1, '4856112499', '24', '2299925047'),
(50, 1, '7177530576', '17', '4525872336'),
(51, 1, '7177530576', '23', '4525872336'),
(52, 1, '7177530576', '21', '4525872336'),
(53, 1, '7177530576', '15', '4525872336'),
(54, 1, '7177530576', '16', '4525872336'),
(55, 1, '7177530576', '19', '4525872336'),
(56, 1, '7177530576', '18', '4525872336'),
(57, 1, '7177530576', '14', '4525872336'),
(58, 1, '7177530576', '25', '4058967187');

-- --------------------------------------------------------

--
-- Table structure for table `nm_transcation`
--

CREATE TABLE `nm_transcation` (
  `item_id` bigint(20) NOT NULL,
  `transcation_id` varchar(20) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `amount` int(10) NOT NULL,
  `paytime` datetime NOT NULL,
  `is_entp` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nm_user`
--

CREATE TABLE `nm_user` (
  `item_id` bigint(20) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `user_full_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `registered_on` datetime NOT NULL,
  `user_pass` varchar(50) NOT NULL,
  `user_mobile` bigint(10) NOT NULL,
  `entp_id` bigint(20) NOT NULL,
  `ver_code` varchar(50) NOT NULL,
  `fp_code` varchar(50) NOT NULL,
  `is_active` int(2) NOT NULL,
  `login_ip` varchar(45) NOT NULL,
  `last_login_on` datetime NOT NULL,
  `loggedin_key` varchar(40) NOT NULL DEFAULT '0',
  `is_fb` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nm_user`
--

INSERT INTO `nm_user` (`item_id`, `user_id`, `user_full_name`, `user_email`, `registered_on`, `user_pass`, `user_mobile`, `entp_id`, `ver_code`, `fp_code`, `is_active`, `login_ip`, `last_login_on`, `loggedin_key`, `is_fb`) VALUES
(1, '4856112499', 'Manohar Kumar', 'manohar@noticemate.com', '2016-04-26 01:33:27', '10b0d39da9d11f2f8389f3955d8d6428', 0, 0, '', '', 1, '127.0.0.1', '2018-03-22 15:33:46', '0', 0),
(5, '3557923742', 'pradeep jha', 'sonu@noticemate.com', '2016-04-26 12:51:59', '10b0d39da9d11f2f8389f3955d8d6428', 0, 0, '', '', 1, '122.168.71.208', '2016-04-30 13:04:35', '0', 0),
(6, '8165051353', 'Sonu jha', 'hi4sonu@gmail.com', '2016-04-26 16:29:33', '10b0d39da9d11f2f8389f3955d8d6428', 0, 0, '', '', 1, '110.224.203.208', '2017-03-05 12:31:49', 'f18bd0c7cc977380803e7e33a500e9a0', 0),
(7, '7177530576', 'Manohar Kumar', 'hi4manohar@gmail.com', '2016-04-30 12:17:44', 'e44b2b52735ad57e312a072f50b63a21', 0, 0, '', '', 1, '127.0.0.1', '2022-02-01 05:29:04', '0', 0),
(8, '6412817620', 'amit', 'amit@noticemate.com', '2016-04-30 12:24:30', 'a27d477e747327d2ef17e13307f19089', 0, 0, '', '', 1, '122.168.71.208', '2016-04-30 12:29:30', '0', 0),
(9, '9877290336', 'hirahul1995', 'hirahul1995@gmail.com', '2016-04-30 12:27:04', '86fbdd0b121fb6807092c60db0bf3e9f', 0, 0, 'LbRDk6H0EfuHXiRYQkycp3Il4q5nNdmzodcIkUJZ', '', 0, '', '0000-00-00 00:00:00', '0', 0),
(10, '2457214068', 'Rahul', 'hirahul195@gmail.com', '2016-04-30 12:31:17', '4a97829116ea444796e89a9c68a751f1', 0, 0, '', '', 1, '122.168.71.208', '2016-04-30 12:55:40', '0', 0),
(11, '8102041449', 'Pradeep Kumar Jha', 'pkjha7277343565@gmail.com', '2016-04-30 12:46:32', '374252696078460', 0, 0, '', '', 1, '122.168.223.67', '2016-05-10 20:22:14', 'ae9403e79366e3340905727f6f117a0d', 0),
(12, '9954164827', 'shivangisaraswat1', 'shivangisaraswat1@gmail.com', '2016-04-30 12:51:26', 'd86a357946562b3aec75769dc3c84641', 0, 0, '', '', 1, '202.134.173.137', '2016-04-30 13:10:27', '0', 0),
(15, '3085594330', 'Manohar Kumar', 'hi4manohar@ymail.com', '2016-04-30 13:13:59', '08a5bc5ef4fe99f7346d20a1df5a8d1c', 0, 0, '', '', 1, '47.29.69.169', '2017-07-26 09:53:02', '0', 1),
(16, '9788619292', 'manisha', 'manisha@noticemate.com', '2016-04-30 14:02:42', '82559e03fbab66e315bde3e65a8e4d34', 0, 0, '', '', 1, '122.168.71.208', '2016-04-30 14:04:30', '0', 0),
(17, '8155574376', 'jineshshah510', 'jineshshah510@gmail.com', '2016-05-02 09:42:58', 'f4e732953f2dd6756e3570df725b4f6a', 0, 0, '', '', 1, '120.138.117.226', '2016-05-02 09:43:42', '19ab301746120713b520de8a87115fba', 0),
(18, '7266101220', 'satyendra.kumar00000', 'satyendra.kumar00000@gmail.com', '2016-05-04 23:51:45', 'dd93fdf9515ed21a6d6099159cd6f65c', 0, 0, 'kUC1O7HudrEcD3de8tyvDgOok8yLqFrLz4MocuTp', '', 0, '', '0000-00-00 00:00:00', '0', 0),
(19, '5581426558', 'ksatyendra403', 'ksatyendra403@gmail.com', '2016-05-04 23:57:26', 'c8bd92d4f0863edf0bb88478d71f10cb', 0, 0, '', '', 1, '59.90.169.14', '2016-05-05 00:07:28', 'f51643bb9de25b86227e0b0a27eca2a0', 0),
(20, '7281336925', 'amitcreation7', 'amitcreation7@gmail.com', '2016-05-08 22:36:06', '2706de1ef17e6bfee6bb6eebf18402fe', 0, 0, '', '', 1, '59.88.23.84', '2016-05-09 16:51:48', '8deed0f3f6ae169092d333a8f65e91cc', 0),
(21, '1570989833', 'Nag Kiran', 'keenkiran@gmail.com', '2016-06-06 11:23:00', '10209568268422860', 0, 0, '', '', 1, '183.83.123.25', '2016-06-06 11:23:00', '94573257a9b4f09d525c635de6eadfdf', 1),
(22, '5855797247', 'Anand Jha', 'ajha008@gmail.com', '2016-06-26 16:33:37', '997285477056474', 0, 0, '', '', 1, '171.48.51.40', '2016-06-26 16:33:37', 'c699bfd473c6f6857c0e66fdeae12374', 1),
(23, '7293737758', 'shivangi', 'shivangi@noticemate.com', '2016-08-10 15:10:13', '5b386909e90bae86d2c9f7b15960ead1', 0, 0, 'HgkcOW3m1oQogVNYSitAWtgRHuuPGhwnxRzmNDIO', '', 0, '', '0000-00-00 00:00:00', '0', 0),
(24, '3228841436', 'advisor.anand1', 'advisor.anand1@gmail.com', '2016-08-10 19:36:21', 'a3a89902214623da275d25063f671b21', 0, 0, '1GN936PIukI4GnKxRaRMVH48LYem5hB6Ypg1w6K0', '', 0, '', '0000-00-00 00:00:00', '0', 0),
(25, '4022292382', 'Saurav Dwivedi', 'ineverroxxx@gmail.com', '2016-10-08 00:30:20', '913441582119233', 0, 0, '', '', 1, '47.247.167.135', '2016-10-08 00:30:20', '046b3b0b73525811e1ffdfea9c74d8de', 1),
(26, '1639788494', 'Mrinal Singh', 'mrinalkumar1239@gmail.com', '2016-10-08 00:31:44', '1110878165671027', 0, 0, '', '', 1, '47.247.167.135', '2016-10-08 00:31:44', '3930cfd89a4e03f3f121b7baa6ba38bb', 1),
(27, '4911318806', 'karnamit2105', 'karnamit2105@gmail.com', '2016-10-18 16:59:31', '1fe2ed4b99ecbacd85a6bb55d2e2187d', 0, 0, '', '', 1, '124.123.73.148', '2016-10-18 17:01:56', '0', 0),
(28, '2017957609', 'Gauhar Haque', 'gauharguru@gmail.com', '2017-03-03 21:05:45', '1363647750340675', 0, 0, '', '', 1, '171.61.57.238', '2017-03-03 21:05:45', '0', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nm_attachments`
--
ALTER TABLE `nm_attachments`
  ADD PRIMARY KEY (`attach_id`),
  ADD UNIQUE KEY `file_name` (`file_name`),
  ADD KEY `notice_id` (`notice_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `nm_board`
--
ALTER TABLE `nm_board`
  ADD PRIMARY KEY (`item_id`,`board_id`,`board_dist_id`),
  ADD UNIQUE KEY `board_id` (`board_id`),
  ADD UNIQUE KEY `board_dist_id` (`board_dist_id`),
  ADD KEY `board_admin` (`board_admin`);

--
-- Indexes for table `nm_boardconf`
--
ALTER TABLE `nm_boardconf`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `plan_type` (`plan_type`);

--
-- Indexes for table `nm_boardcont`
--
ALTER TABLE `nm_boardcont`
  ADD PRIMARY KEY (`content_id`),
  ADD KEY `posted_by` (`posted_by`),
  ADD KEY `board_id` (`board_id`),
  ADD KEY `content_type` (`content_type`);

--
-- Indexes for table `nm_boarduser`
--
ALTER TABLE `nm_boarduser`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `board_id` (`board_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `nm_enterprise`
--
ALTER TABLE `nm_enterprise`
  ADD PRIMARY KEY (`ep_id`,`ep_email`),
  ADD KEY `ep_admin` (`ep_admin`);

--
-- Indexes for table `nm_notification`
--
ALTER TABLE `nm_notification`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `notif_type` (`notif_type`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `nm_profile`
--
ALTER TABLE `nm_profile`
  ADD PRIMARY KEY (`item_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `nm_replies`
--
ALTER TABLE `nm_replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `content_id` (`content_id`,`replied_by`),
  ADD KEY `replied_by` (`replied_by`),
  ADD KEY `reply_type` (`reply_type`);

--
-- Indexes for table `nm_term`
--
ALTER TABLE `nm_term`
  ADD PRIMARY KEY (`term_id`,`term_name`,`term_slug`),
  ADD UNIQUE KEY `term_id` (`term_id`);

--
-- Indexes for table `nm_term_taxonomy`
--
ALTER TABLE `nm_term_taxonomy`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `term_id` (`term_id`);

--
-- Indexes for table `nm_transcation`
--
ALTER TABLE `nm_transcation`
  ADD PRIMARY KEY (`item_id`,`transcation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `nm_user`
--
ALTER TABLE `nm_user`
  ADD PRIMARY KEY (`item_id`,`user_id`,`user_email`,`user_mobile`,`entp_id`),
  ADD UNIQUE KEY `user_id_3` (`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nm_attachments`
--
ALTER TABLE `nm_attachments`
  MODIFY `attach_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `nm_board`
--
ALTER TABLE `nm_board`
  MODIFY `item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `nm_boardconf`
--
ALTER TABLE `nm_boardconf`
  MODIFY `item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `nm_boardcont`
--
ALTER TABLE `nm_boardcont`
  MODIFY `content_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `nm_boarduser`
--
ALTER TABLE `nm_boarduser`
  MODIFY `item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `nm_enterprise`
--
ALTER TABLE `nm_enterprise`
  MODIFY `ep_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nm_notification`
--
ALTER TABLE `nm_notification`
  MODIFY `item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `nm_profile`
--
ALTER TABLE `nm_profile`
  MODIFY `item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `nm_replies`
--
ALTER TABLE `nm_replies`
  MODIFY `reply_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `nm_term`
--
ALTER TABLE `nm_term`
  MODIFY `term_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `nm_term_taxonomy`
--
ALTER TABLE `nm_term_taxonomy`
  MODIFY `item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `nm_transcation`
--
ALTER TABLE `nm_transcation`
  MODIFY `item_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nm_user`
--
ALTER TABLE `nm_user`
  MODIFY `item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nm_attachments`
--
ALTER TABLE `nm_attachments`
  ADD CONSTRAINT `nm_attachments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `nm_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `nm_boardconf`
--
ALTER TABLE `nm_boardconf`
  ADD CONSTRAINT `nm_boardconf_ibfk_1` FOREIGN KEY (`plan_type`) REFERENCES `nm_term` (`term_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `nm_boardcont`
--
ALTER TABLE `nm_boardcont`
  ADD CONSTRAINT `nm_boardcont_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `nm_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nm_boardcont_ibfk_2` FOREIGN KEY (`board_id`) REFERENCES `nm_board` (`board_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nm_boardcont_ibfk_3` FOREIGN KEY (`content_type`) REFERENCES `nm_term` (`term_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `nm_boarduser`
--
ALTER TABLE `nm_boarduser`
  ADD CONSTRAINT `nm_boarduser_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `nm_board` (`board_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nm_boarduser_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `nm_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `nm_enterprise`
--
ALTER TABLE `nm_enterprise`
  ADD CONSTRAINT `nm_enterprise_ibfk_1` FOREIGN KEY (`ep_admin`) REFERENCES `nm_user` (`user_id`);

--
-- Constraints for table `nm_notification`
--
ALTER TABLE `nm_notification`
  ADD CONSTRAINT `nm_notification_ibfk_1` FOREIGN KEY (`notif_type`) REFERENCES `nm_term` (`term_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nm_notification_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `nm_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `nm_replies`
--
ALTER TABLE `nm_replies`
  ADD CONSTRAINT `nm_replies_ibfk_1` FOREIGN KEY (`content_id`) REFERENCES `nm_boardcont` (`content_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nm_replies_ibfk_2` FOREIGN KEY (`replied_by`) REFERENCES `nm_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nm_replies_ibfk_3` FOREIGN KEY (`reply_type`) REFERENCES `nm_term` (`term_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `nm_term_taxonomy`
--
ALTER TABLE `nm_term_taxonomy`
  ADD CONSTRAINT `nm_term_taxonomy_ibfk_1` FOREIGN KEY (`term_id`) REFERENCES `nm_term` (`term_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `nm_transcation`
--
ALTER TABLE `nm_transcation`
  ADD CONSTRAINT `nm_transcation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `nm_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
