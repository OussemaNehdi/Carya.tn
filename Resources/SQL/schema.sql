-- Create users table
CREATE TABLE users (
    id INT PRIMARY KEY,
    firstName VARCHAR(30),
    lastName VARCHAR(30),
    password CHAR(255),
    email VARCHAR(50),
    creation_date DATE,
    role VARCHAR(30)
);

-- Create cars table
CREATE TABLE cars (
    id INT PRIMARY KEY,
    brand VARCHAR(50),
    model VARCHAR(50),
    color VARCHAR(20),
    image CHAR(255),
    km INT,
    price DECIMAL,
    owner_id INT,
    availability BOOLEAN
);

-- Create command table
CREATE TABLE command (
    command_id INT PRIMARY KEY,
    car_id INT,
    rental_date DATE,
    start_date DATE,
    end_date DATE,
    rental_period INT
);

-- Create user_command table
CREATE TABLE user_command (
    user_id INT,
    command_id INT
);

-- Add foreign keys
ALTER TABLE cars ADD FOREIGN KEY (owner_id) REFERENCES users(id);
ALTER TABLE command ADD FOREIGN KEY (car_id) REFERENCES cars(id);
ALTER TABLE user_command ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE user_command ADD FOREIGN KEY (command_id) REFERENCES command(command_id);