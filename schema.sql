CREATE TABLE `carrental`.`users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `firstName` VARCHAR(30) NOT NULL,
    `lastName` VARCHAR(30) NOT NULL,
    `password` CHAR(255) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `creation_date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `role` VARCHAR(30) NOT NULL,
    `command_id` INT NULL,
    `listings_id` INT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `carrental`.`cars` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `brand` VARCHAR(50) NOT NULL,
    `model` VARCHAR(50) NOT NULL,
    `color` VARCHAR(20) NOT NULL,
    `image` CHAR(255) NOT NULL,
    `km` INT NOT NULL,
    `price` DECIMAL NOT NULL,
    `owner_id` INT NOT NULL,
    `availability` BOOLEAN NOT NULL DEFAULT TRUE,
    `command_id` INT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `carrental`.`command` (
    `command_id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `car_id` INT NOT NULL,
    `rental_date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `rental_period` INT NOT NULL,
    PRIMARY KEY (`command_id`)
) ENGINE = InnoDB;

CREATE TABLE `carrental`.`listing` (
    `listing_id` INT NOT NULL,
    `seller_id` INT NOT NULL,
    `car_id` INT NOT NULL
) ENGINE = InnoDB;

ALTER TABLE `carrental`.`users` 
ADD CONSTRAINT `fk_users_command_id` 
FOREIGN KEY (`command_id`) 
REFERENCES `carrental`.`command` (`command_id`);

ALTER TABLE `carrental`.`users` 
ADD CONSTRAINT `fk_users_listings_id` 
FOREIGN KEY (`listings_id`) 
REFERENCES `carrental`.`listing` (`listing_id`);

ALTER TABLE `carrental`.`cars` 
ADD CONSTRAINT `fk_cars_owner_id` 
FOREIGN KEY (`owner_id`) 
REFERENCES `carrental`.`users` (`id`);

ALTER TABLE `carrental`.`cars` 
ADD CONSTRAINT `fk_cars_command_id` 
FOREIGN KEY (`command_id`) 
REFERENCES `carrental`.`command` (`command_id`);

ALTER TABLE `carrental`.`command` 
ADD CONSTRAINT `fk_command_user_id` 
FOREIGN KEY (`user_id`) 
REFERENCES `carrental`.`users` (`id`);

ALTER TABLE `carrental`.`command` 
ADD CONSTRAINT `fk_command_car_id` 
FOREIGN KEY (`car_id`) 
REFERENCES `carrental`.`cars` (`id`);

ALTER TABLE `carrental`.`listing` 
ADD CONSTRAINT `fk_listing_seller_id` 
FOREIGN KEY (`seller_id`) 
REFERENCES `carrental`.`users` (`id`);

ALTER TABLE `carrental`.`listing` 
ADD CONSTRAINT `fk_listing_car_id` 
FOREIGN KEY (`car_id`) 
REFERENCES `carrental`.`cars` (`id`);

