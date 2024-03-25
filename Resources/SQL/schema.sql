-- Create the users table
CREATE TABLE users (
    id INT PRIMARY KEY,
    firstName VARCHAR(30),
    lastName VARCHAR(30),
    password CHAR(255),
    email VARCHAR(50),
    creation_date DATE,
    role VARCHAR(30),
    command_id INT
) ENGINE=InnoDB;

-- Create the cars table
CREATE TABLE cars (
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

-- Create the command table
CREATE TABLE command (
    command_id INT PRIMARY KEY,
    user_id INT,
    car_id INT,
    rental_date DATE,
    start_date DATE,
    end_date DATE,
    rental_period INT
) ENGINE=InnoDB;

-- Add foreign key constraints
ALTER TABLE users ADD CONSTRAINT fk_user_command
    FOREIGN KEY (command_id)
    REFERENCES command(command_id);

ALTER TABLE cars ADD CONSTRAINT fk_car_owner
    FOREIGN KEY (owner_id)
    REFERENCES users(id);

ALTER TABLE cars ADD CONSTRAINT fk_car_command
    FOREIGN KEY (command_id)
    REFERENCES command(command_id);

ALTER TABLE command ADD CONSTRAINT fk_command_user
    FOREIGN KEY (user_id)
    REFERENCES users(id);

ALTER TABLE command ADD CONSTRAINT fk_command_car
    FOREIGN KEY (car_id)
    REFERENCES cars(id);
