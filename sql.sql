CREATE TABLE IF NOT EXISTS users(
    `u_id` int(10) NOT NULL auto_increment,
    `username` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `joindate` datetime NOT NULL DEFAULT NOW(),
    `email` varchar(255) NOT NULL,
    `email_code` varchar(32) NOT NULL,
    `rank` int(10) DEFAULT '1',
    `active` BOOLEAN DEFAULT '0',
    `banned` BOOLEAN DEFAULT '0',
    PRIMARY KEY `u_id` (`u_id`),
    UNIQUE KEY (`username`),
    UNIQUE KEY (`email`)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS warnings(
    `w_id` int(10) NOT NULL auto_increment,
    `u_id` int(10) NOT NULL,
    `amount` int(10) NOT NULL,
    `reason` varchar(255),
    PRIMARY KEY `w_id` (`w_id`)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS messages(
    `m_id` int(10) NOT NULL auto_increment,
    `u_id_sender` int(10) NOT NULL,
    `u_id_recipient` int(10) NOT NULL,
    `sender_active` BOOLEAN DEFAULT '1',
    `recipient_active` BOOLEAN DEFAULT '1',
    `title` varchar(255) NOT NULL,
    `content` varchar(10000) NOT NULL,
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
    `postdate` datetime NOT NULL DEFAULT NOW(),
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
    `postdate` datetime NOT NULL DEFAULT NOW(),
    `editdate` datetime DEFAULT '1000-01-01 00:00:00',
    `archived` BOOLEAN DEFAULT '0',
    PRIMARY KEY `p_id` (`p_id`)
)Engine=InnoDB;
