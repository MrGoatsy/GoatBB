CREATE TABLE IF NOT EXISTS users(
    `u_id` int(10) NOT NULL auto_increment,
    `username` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `joindate` datetime NOT NULL,
    `website` varchar(255),
    `signature` varchar(1000),
    `avatar` varchar(255),
    `email` varchar(255) NOT NULL,
    `email_code` varchar(32) NOT NULL,
    `rank` int(10) DEFAULT '1',
    `active` BOOLEAN DEFAULT '0',
    PRIMARY KEY `u_id` (`u_id`),
    UNIQUE KEY (`username`),
    UNIQUE KEY (`email`)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS reputation(
    `rep_id` int(10) NOT NULL auto_increment,
    `u_id_recipient` int(10) NOT NULL,
    `u_id_sender` int(10) NOT NULL,
    `repAmount` int(10) NOT NULL,
    `repDesc` varchar(255) NOT NULL,
    PRIMARY KEY (`rep_id`)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS ranks(
    `r_id` int(10) NOT NULL auto_increment,
    `rankName` varchar(255) NOT NULL,
    `rankValue` int(10),
    `maxRep` int(10),
    `minRep` int(10),
    `postTime` int(10),
    PRIMARY KEY (`r_id`),
    UNIQUE KEY (`rankValue`)
)Engine=InnoDB;

INSERT INTO `ranks` (`rankName`, `rankValue`, `maxRep`, `minRep`, `postTime`) VALUES
('Admin', 999, 10, -10, 0),
('Moderator', 950, 5, -5, 0),
('Premium', 100, 3, -3, 10),
('User', 1, 1, -1, 30),
('Banned', 0, NULL, NULL, NULL);

CREATE TABLE IF NOT EXISTS warnings(
    `w_id` int(10) NOT NULL auto_increment,
    `u_id` int(10) NOT NULL,
    `amount` int(10) NOT NULL,
    `reason` varchar(255) DEFAULT 'None',
    `warningDate` datetime NOT NULL,
    `archived` BOOLEAN DEFAULT '0',
    PRIMARY KEY `w_id` (`w_id`)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS messages(
    `m_id` int(10) NOT NULL auto_increment,
    `u_id_sender` int(10) NOT NULL,
    `u_id_recipient` int(10) NOT NULL,
    `subject` varchar(255) NOT NULL,
    `content` varchar(10000) NOT NULL,
    `messageDate` datetime NOT NULL,
    PRIMARY KEY `m_id` (`m_id`)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS category(
    `c_id` int(10) NOT NULL auto_increment,
    `categoryname` varchar(250) NOT NULL,
    `corder` int(10) NOT NULL,
    PRIMARY KEY `c_id` (`c_id`),
    UNIQUE KEY (`categoryname`)
)Engine=InnoDB;

INSERT INTO `category` (`categoryname`, `corder`) VALUES ('Home', '1');

CREATE TABLE IF NOT EXISTS section(
    `sc_id` int(10) NOT NULL auto_increment,
    `c_id` int(10) NOT NULL,
    `secname` varchar(250) NOT NULL,
    `secdesc` varchar(500),
    `secimage` varchar(500),
    `sorder` int(10) NOT NULL,
    PRIMARY KEY `sc_id` (`sc_id`),
    UNIQUE KEY (`secname`)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS thread(
    `t_id` int(10) NOT NULL auto_increment,
    `sc_id` int(10) NOT NULL,
    `u_id` int(10) NOT NULL,
    `title` varchar(255) NOT NULL,
    `content` varchar(10000) NOT NULL,
    `postdate` datetime NOT NULL,
    `editdate` datetime DEFAULT '1000-01-01 00:00:00',
    `stickied` BOOLEAN DEFAULT '0',
    `archived` BOOLEAN DEFAULT '0',
    PRIMARY KEY `t_id` (`t_id`)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS threadpost(
    `p_id` int(10) NOT NULL auto_increment,
    `t_id` int(10) NOT NULL,
    `u_id` int(10) NOT NULL,
    `content` varchar(10000) NOT NULL,
    `postdate` datetime NOT NULL,
    `editdate` datetime DEFAULT '1000-01-01 00:00:00',
    `archived` BOOLEAN DEFAULT '0',
    PRIMARY KEY `p_id` (`p_id`)
)Engine=InnoDB;
