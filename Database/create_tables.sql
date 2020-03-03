CREATE TABLE `people` (
  `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `first_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `gender` ENUM("Muž", "Žena") NOT NULL,
  `birthday` DATE NOT NULL,
  `tel` VARCHAR(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARSET=utf8;