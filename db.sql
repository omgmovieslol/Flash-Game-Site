
CREATE TABLE `games` (
  `id` int(11) NOT NULL auto_increment,
  `shortname` varchar(45) NOT NULL,
  `longname` varchar(120) NOT NULL,
  `thumbnailsmall` varchar(250) NOT NULL,
  `thumbnaillarge` varchar(250) NOT NULL,
  `swf` varchar(250) NOT NULL,
  `desc` text NOT NULL,
  `shortdesc` varchar(250) NOT NULL,
  `width` int(10) NOT NULL default '0',
  `height` int(10) NOT NULL default '0',
  `cat` varchar(255) NOT NULL default '',
  `type` enum('SWF','extlink','DCR','CustomCode') NOT NULL default 'SWF',
  `keywords` varchar(255) NOT NULL default '',
  `visible` enum('Yes','No') NOT NULL default 'Yes',
   
   PRIMARY KEY  (`id`)
)



-- --------------------------------------------------------



CREATE TABLE `categories` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default 'Games',
  `desc` varchar(255) NOT NULL default '',
  `keywords` varchar(255) NOT NULL default '',
  `order` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `categories`
-- 

INSERT INTO `categories` VALUES (13, 'Sports', 'Games', '', '', 6);
INSERT INTO `categories` VALUES (12, 'Shooting', 'Games', '', '', 5);
INSERT INTO `categories` VALUES (11, 'Puzzle', 'Games', '', '', 4);
INSERT INTO `categories` VALUES (10, 'Arcade', 'Games', '', '', 3);
INSERT INTO `categories` VALUES (14, 'Other', 'Media', '', '', 8);
INSERT INTO `categories` VALUES (18, 'Action', 'Games', '', '', 1);
INSERT INTO `categories` VALUES (20, 'Adventure', 'Games', '', '', 2);
INSERT INTO `categories` VALUES (21, 'Strategy', 'Games', '', '', 7);



-- --------------------------------------------------------



CREATE TABLE `news` (
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `date` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
