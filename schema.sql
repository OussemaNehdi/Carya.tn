CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY,
    firstName VARCHAR(30),
    lastName VARCHAR(30),
    password CHAR(255),
    email VARCHAR(50),
    creation_date DATE,
    role VARCHAR(30),
    command_id INT,
    listings_id INT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS cars (
    id INT PRIMARY KEY,
    brand VARCHAR(50),
    model VARCHAR(50),
    color VARCHAR(20),
    image CHAR(255),
    km INT,
    price DECIMAL,
    owner_id INT,
    availability BOOLEAN,
    command_id INT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS command (
    command_id INT PRIMARY KEY,
    user_id INT,
    car_id INT,
    rental_date DATE,
    rental_period INT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS listing (
    listing_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT,
    car_id INT
) ENGINE=InnoDB;

ALTER TABLE users ADD CONSTRAINT fk_command_id FOREIGN KEY (command_id) REFERENCES command(command_id);
ALTER TABLE users ADD CONSTRAINT fk_listings_id FOREIGN KEY (listings_id) REFERENCES listing(listing_id);
ALTER TABLE cars ADD CONSTRAINT fk_owner_id FOREIGN KEY (owner_id) REFERENCES users(id);
ALTER TABLE cars ADD CONSTRAINT fk_cars_command_id FOREIGN KEY (command_id) REFERENCES command(command_id);
ALTER TABLE command ADD CONSTRAINT fk_command_user_id FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE command ADD CONSTRAINT fk_command_car_id FOREIGN KEY (car_id) REFERENCES cars(id);
ALTER TABLE listing ADD CONSTRAINT fk_seller_id FOREIGN KEY (seller_id) REFERENCES users(id);
ALTER TABLE listing ADD CONSTRAINT fk_listing_car_id FOREIGN KEY (car_id) REFERENCES cars(id);
