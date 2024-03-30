-- Users table
INSERT INTO users (firstName, lastName, password, email, creation_date, role, state, country)
VALUES 
('John', 'Doe', 'password123', 'john@example.com', '2024-03-25', 'customer', 'California', 'United States'),
('Alice', 'Smith', 'securepass', 'alice@example.com', '2024-03-25', 'admin', 'New York', 'United States'),
('Bob', 'Johnson', 'bobspass', 'bob@example.com', '2024-03-25', 'customer', 'Texas', 'United States'),
('Emily', 'Brown', 'emilypass', 'emily@example.com', '2024-03-26', 'seller', 'Florida', 'United States'),
('David', 'Wilson', 'davidpass', 'david@example.com', '2024-03-27', 'banned', 'Washington', 'United States'),
('Sophia', 'Taylor', 'sophiapass', 'sophia@example.com', '2024-03-27', 'customer', 'California', 'United States');

-- Cars table
INSERT INTO cars (brand, model, color, image, km, price, owner_id, available)
VALUES
('Toyota', 'Corolla', 'Blue', 'corolla.jpg', 50000, 15000.00, 1, True),
('Honda', 'Civic', 'Red', 'civic.jpg', 60000, 17000.00, 1, True),
('Ford', 'Fiesta', 'Silver', 'fiesta.jpg', 40000, 12000.00, 3, True),
('Tesla', 'Model S', 'Black', 'model_s.jpg', 20000, 60000.00, 4, True),
('Chevrolet', 'Camaro', 'Yellow', 'camaro.jpg', 30000, 35000.00, 4, True),
('BMW', '3 Series', 'White', '3_series.jpg', 45000, 25000.00, 2, True),
('Mercedes-Benz', 'E-Class', 'Gray', 'e_class.jpg', 55000, 30000.00, 2, True);

-- Commands table
INSERT INTO command (car_id, user_id, rental_date, start_date, end_date, rental_period)
VALUES
(1, 2, '2024-03-25', '2024-04-01', '2024-04-08', 7),
(6, 1, '2024-03-25', '2024-04-05', '2024-04-10', 5),
(3, 3, '2024-03-25', '2024-04-02', '2024-04-07', 5);
