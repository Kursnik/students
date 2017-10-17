SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `education`;

CREATE TABLE `education` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;



DROP TABLE IF EXISTS `user_education`;

CREATE TABLE `user_education` (
  `user_id` INT(11) NOT NULL,
  `education_id` INT(11) NOT NULL,
  PRIMARY KEY (`user_id`, `education_id`),
  UNIQUE `user_education_user` (`user_id`),
  INDEX `user_education_to_education_idx` (`education_id` ASC),
  CONSTRAINT `user_education_to_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `user_education_to_education`
  FOREIGN KEY (`education_id`)
  REFERENCES `education` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
) ENGINE = InnoDB;

DROP TABLE IF EXISTS user_city;

CREATE TABLE user_city (
  `user_id` INT(11) NOT NULL,
  `city_id` INT(11) NOT NULL,
  PRIMARY KEY (`user_id`, `city_id`),
  INDEX `user_city__to_city_idx` (`city_id` ASC),
  CONSTRAINT `user_city_to_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `user_city_to_city`
  FOREIGN KEY (`city_id`)
  REFERENCES `city` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
) ENGINE = InnoDB;

SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
