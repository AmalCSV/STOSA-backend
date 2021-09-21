CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `member`  
(  
`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
`firstName` varchar(50),  
`lastName` varchar(255),  
`email` varchar(255),  
`addressLine` varchar(255),  
`city` varchar(255)  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;