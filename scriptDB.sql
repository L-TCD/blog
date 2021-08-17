CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `admin` TINYINT(1) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `post` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `content` TEXT(10000) NOT NULL,
  `description` TEXT(3500) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `update_at` DATETIME NULL,
  `author` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `comment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content` TEXT(3500) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `valid` TINYINT(1) NULL,
  `rejected` TINYINT(1) NULL,
  `user_id` INT NOT NULL,
  `post_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FK_comment_user FOREIGN KEY (user_id) REFERENCES user(id),
  CONSTRAINT FK_comment_post FOREIGN KEY (post_id) REFERENCES post(id)
);