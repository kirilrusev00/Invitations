CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `email` varchar(50) NOT NULL,
 `password` varchar(50) NOT NULL,
 `first_name` varchar(50) NOT NULL,
 `last_name` varchar(50) NOT NULL,
 `fn` int(10) NOT NULL,
 `course` int(2) NOT NULL,
 `specialty` varchar(50) NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `email_unique` (`email`),
 UNIQUE KEY `fn_unique` (`fn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

INSERT INTO `users` (`id`, `email`, `password`,`first_name`,`last_name`,`fn`,`course`,`specialty`) VALUES
(1254, 'denitsa.yolova99@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Denitsa','Yolova', 62287, 3, 'Software engineering');

INSERT INTO `users` (`id`, `email`, `password`,`first_name`,`last_name`,`fn`,`course`,`specialty`) VALUES
(1254, 'kiril.rusev2000@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Kiril','Rusev', 62309, 3, 'Software engineering');

INSERT INTO `users` (`id`, `email`, `password`,`first_name`,`last_name`,`fn`,`course`,`specialty`) VALUES
(1254, 'gerytsv@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Gergana','Tsvetkova', 62293, 3, 'Software engineering');


