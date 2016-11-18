CREATE TABLE `blog_users` (
 `id` int NOT NULL AUTO_INCREMENT,
 `username` varchar(255) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sessions` (
 `id` int NOT NULL AUTO_INCREMENT,
 `blog_user_id` int NOT NULL,
 `start` datetime NOT NULL,
 `stop` datetime NOT NULL,
 PRIMARY KEY (`id`),
 CONSTRAINT `FK_sessions_users` FOREIGN KEY (`user_id`) REFERENCES `blog_users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `static_session_datas` (
 `session_id` int NOT NULL,
 `os` varchar(255) NOT NULL,
 `lang` varchar(255) NOT NULL,
 `browser` varchar(255) NOT NULL,
 `location` varchar(255) NOT NULL,
 `referrer` varchar(255) NOT NULL,
 PRIMARY KEY (`session_id`),
 CONSTRAINT `FK_static_session_data_session` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `action_types` (
 `id` int NOT NULL AUTO_INCREMENT,
 `title` varchar(255) NOT NULL,
 `description` TEXT NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `resources` (
 `id` int NOT NULL AUTO_INCREMENT,
 `url` varchar(1000) NOT NULL,
 `content` TEXT NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tags` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `title` varchar(255) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

CREATE TABLE `actions` (
 `id` int NOT NULL AUTO_INCREMENT,
 `session_id` int NOT NULL,
 `action_type_id` int NOT NULL,
 `resource_id` int NOT NULL,
 `time_stamp` datetime NOT NULL,
 PRIMARY KEY (`id`),
 CONSTRAINT `FK_actions_sessions` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`),
 CONSTRAINT `FK_actions_action_types` FOREIGN KEY (`action_type_id`) REFERENCES `action_types` (`id`),
 CONSTRAINT `FK_actions_resources` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `classifications` (
 `resource_id` int NOT NULL,
 `tag_id` int NOT NULL,
 PRIMARY KEY (`resource_id`,`tag_id`),
 CONSTRAINT `FK_classifications_resources` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`),
 CONSTRAINT `FK_classifications_tags` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;


