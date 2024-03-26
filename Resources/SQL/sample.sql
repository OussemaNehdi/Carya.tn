-- Users table
INSERT INTO users (firstName, lastName, password, email, creation_date, role)
VALUES 
('John', 'Doe', 'password123', 'john@example.com', '2024-03-25', 'customer'),
('Alice', 'Smith', 'securepass', 'alice@example.com', '2024-03-25', 'admin'),
('Bob', 'Johnson', 'bobspass', 'bob@example.com', '2024-03-25', 'customer'),
('Emily', 'Brown', 'emilypass', 'emily@example.com', '2024-03-26', 'seller'),
('David', 'Wilson', 'davidpass', 'david@example.com', '2024-03-27', 'banned'),
('Sophia', 'Taylor', 'sophiapass', 'sophia@example.com', '2024-03-27', 'customer');

-- Cars table
INSERT INTO cars (brand, model, color, image, km, price, owner_id, availability)
VALUES
('Toyota', 'Corolla', 'Red', '/images/corolla.jpg', 50000, 15000.00, 1, true),
('Honda', 'Civic', 'Blue', '/images/civic.jpg', 60000, 17000.00, 1, false),
('Ford', 'Fiesta', 'Silver', '/images/fiesta.jpg', 40000, 12000.00, 3, true),
('Tesla', 'Model S', 'Black', '/images/model_s.jpg', 20000, 60000.00, 4, true),
('Chevrolet', 'Camaro', 'Yellow', '/images/camaro.jpg', 30000, 35000.00, 4, false),
('BMW', '3 Series', 'White', '/images/3_series.jpg', 45000, 25000.00, 2, true),
('Mercedes-Benz', 'E-Class', 'Gray', '/images/e_class.jpg', 55000, 30000.00, 2, true);

-- Commands table
INSERT INTO command (car_id, user_id, rental_date, start_date, end_date, rental_period)
VALUES
(1, 2, '2024-03-25', '2024-04-01', '2024-04-08', 7),
(6, 1, '2024-03-25', '2024-04-05', '2024-04-10', 5),
(3, 3, '2024-03-25', '2024-04-02', '2024-04-07', 5);
