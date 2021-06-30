INSERT INTO `users` (`id`, `email`, `password`,`first_name`,`last_name`,`fn`,`course`,`specialty`) VALUES
(1254, 'denitsa.yolova99@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Деница','Йолова', 62287, 3, 'Софтуерно инженерство');

INSERT INTO `users` (`id`, `email`, `password`,`first_name`,`last_name`,`fn`,`course`,`specialty`) VALUES
(1255, 'kiril.rusev2000@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Кирил','Русев', 62309, 3, 'Софтуерно инженерство');

INSERT INTO `users` (`id`, `email`, `password`,`first_name`,`last_name`,`fn`,`course`,`specialty`) VALUES
(1256, 'gerytsv@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Гергана','Цветкова', 62293, 3, 'Софтуерно инженерство');


INSERT INTO `events` (`id`, `start_time`, `end_time`,`venue`,`name`,`meeting_link`,`meeting_password`,`created_by`) VALUES
(31, '2021-07-06 12:00:00', '2021-07-06 12:20:00', 'Онлайн', 'Презентация "3D в Уеб','https://meet.google.com/apr-csoe-ynd', 1254);

INSERT INTO `events` (`id`, `start_time`, `end_time`,`venue`,`name`,`created_by`) VALUES
(32, '2021-07-07 12:30:00', '2021-07-07 12:50:00', 'ФМИ', 'Презентация "React.JS"', 1255);

INSERT INTO `events` (`id`, `start_time`, `end_time`,`venue`,`name`,`created_by`) VALUES
(33, '2021-07-07 13:00:00', '2021-07-07 13:20:00', 'ФМИ','Презентация "Imba"', 1256);


INSERT INTO `resources` (`id`, `file_name`, `status`,`uploaded_at`,`event_id`) VALUES
(53, '62287_invite.jpg', 1, '2021-06-30 12:24:54',31);

INSERT INTO `resources` (`id`, `file_name`, `status`,`uploaded_at`,`event_id`) VALUES
(54, 'rotate3d.png', 1, '2021-06-30 12:25:12',31);

INSERT INTO `resources` (`id`, `file_name`, `status`,`uploaded_at`,`event_id`) VALUES
(55, 'scale3d.png', 1, '2021-06-30 12:25:20',31);

INSERT INTO `resources` (`id`, `file_name`, `status`,`uploaded_at`,`event_id`) VALUES
(56, '62287.pdf', 1, '2021-06-30 12:26:26',31);

INSERT INTO `resources` (`id`, `file_name`, `status`,`uploaded_at`,`event_id`) VALUES
(57, 'React.js.png', 1, '2021-06-30 12:59:47',32);

INSERT INTO `resources` (`id`, `file_name`, `status`,`uploaded_at`,`event_id`) VALUES
(58, 'Blue React.js.jpg', 1, '2021-06-30 13:01:56',32);

INSERT INTO `resources` (`id`, `file_name`, `status`,`uploaded_at`,`event_id`) VALUES
(59, 'React.js 62309.pdf', 1, '2021-06-30 13:04:34',32);

INSERT INTO `resources` (`id`, `file_name`, `status`,`uploaded_at`,`event_id`) VALUES
(60, 'imba-web-logo.png', 1, '2021-06-30 13:07:31',33);


INSERT INTO `responses` (`id`, `user_id`, `event_id`,`status`,`created_at`,`updated_at`) VALUES
(37, 1255, 31, 'invited','2021-06-30 12:03:22','2021-06-30 12:03:22');

INSERT INTO `responses` (`id`, `user_id`, `event_id`,`status`,`created_at`,`updated_at`) VALUES
(38, 1256, 31, 'invited','2021-06-30 12:03:22','2021-06-30 12:03:22');

INSERT INTO `responses` (`id`, `user_id`, `event_id`,`status`,`created_at`,`updated_at`) VALUES
(39, 1254, 32, 'going','2021-06-30 12:52:23','2021-06-30 12:56:00');

INSERT INTO `responses` (`id`, `user_id`, `event_id`,`status`,`created_at`,`updated_at`) VALUES
(40, 1256, 32, 'invited','2021-06-30 12:52:23','2021-06-30 12:52:23');

INSERT INTO `responses` (`id`, `user_id`, `event_id`,`status`,`created_at`,`updated_at`) VALUES
(41, 1254, 33, 'going','2021-06-30 12:55:34','2021-06-30 13:43:18');

INSERT INTO `responses` (`id`, `user_id`, `event_id`,`status`,`created_at`,`updated_at`) VALUES
(42, 1255, 33, 'invited','2021-06-30 12:55:34','2021-06-30 12:55:34');
