-- Users table
INSERT INTO users (firstName, lastName, password, email, creation_date, role, state, country, profile_image)
VALUES 
('John', 'Doe', 'password123', 'john@example.com', '2024-03-25', 'customer', 'California', 'United States', 'mezyen.jpg'),
('Alice', 'Smith', 'securepass', 'alice@example.com', '2024-03-25', 'admin', 'New York', 'United States', 'mezyena.jpg'),
('Bob', 'Johnson', 'bobspass', 'bob@example.com', '2024-03-25', 'customer', 'Texas', 'United States', null),
('Emily', 'Brown', 'emilypass', 'emily@example.com', '2024-03-26', 'seller', 'Florida', 'United States', null),
('David', 'Wilson', 'davidpass', 'david@example.com', '2024-03-27', 'banned', 'Washington', 'United States', null),
('Sophia', 'Taylor', 'sophiapass', 'sophia@example.com', '2024-03-27', 'customer', 'California', 'United States', null);

-- Cars table
INSERT INTO cars (brand, model, color, image, km, price, owner_id, available)
VALUES
('Toyota', 'Corolla', 'Red', 'corolla.jpg', 50000, 15000.00, 1, True),
('Honda', 'Civic', 'Blue', 'civic.jpg', 60000, 17000.00, 1, True),
('Ford', 'Fiesta', 'Silver', 'fiesta.jpg', 40000, 12000.00, 3, True),
('Tesla', 'Model S', 'Black', 'model_s.jpg', 20000, 60000.00, 4, False),
('Chevrolet', 'Camaro', 'Yellow', 'camaro.jpg', 30000, 35000.00, 4, True),
('BMW', '3 Series', 'White', '3_series.jpg', 45000, 25000.00, 2, False),
('Mercedes-Benz', 'E-Class', 'Gray', 'e_class.jpg', 55000, 30000.00, 2, True),
('Fiat', 'Punto', 'Red', 'punto.jpg', 30000, 10000.00, 3, True),
('Ferrari', 'F8', 'Red', 'F8.jpg', 10000, 200000.00, 4, True),
('Audi', 'R8', 'Blue', 'R8.jpg', 15000, 150000.00, 2, False),
('Lamborghini', 'Aventador', 'Yellow', 'aventador.jpg', 10000, 250000.00, 1, True),
('Bugatti', 'Veyron', 'Black', 'veyron.jpg', 5000, 1000000.00, 3, True),
('Porsche', '911', 'Silver', '911.jpg', 20000, 100000.00, 1, False),
('McLaren', '720S', 'Orange', '720S.jpg', 10000, 200000.00, 2, True),
('Koenigsegg', 'Agera', 'Blue', 'agera.jpg', 5000, 1000000.00, 4, True),
('Pagani', 'Huayra', 'Silver', 'huayra.jpg', 5000, 1000000.00, 3, True),
('Rolls-Royce', 'Phantom', 'Black', 'phantom.jpg', 20000, 500000.00, 2, False),
('Bentley', 'Continental GT', 'White', 'continental_gt.jpg', 20000, 300000.00, 1, True),
('Maserati', 'GranTurismo', 'Red', 'granturismo.jpg', 20000, 150000.00, 4, True),
('Lotus', 'Evora', 'Orange', 'evora.jpg', 20000, 50000.00, 3, True),
('Alfa Romeo', 'Giulia', 'Red', 'giulia.jpg', 20000, 50000.00, 2, True),
('Jaguar', 'F-Type', 'Blue', 'f_type.jpg', 20000, 100000.00, 1, False),
('Aston Martin', 'DB11', 'Silver', 'db11.jpg', 20000, 200000.00, 4, True),
('Volvo', 'XC90', 'Black', 'xc90.jpg', 20000, 60000.00, 3, True),
('Land Rover', 'Range Rover', 'White', 'range_rover.jpg', 20000, 80000.00, 2, True),
('Jeep', 'Wrangler', 'Green', 'wrangler.jpg', 20000, 40000.00, 1, False);

-- Commands table
INSERT INTO command (car_id, user_id, rental_date, start_date, end_date, rental_period,confirmed)
VALUES
(1, 2, '2024-03-25', '2024-04-01', '2024-04-08', 7, False),
(6, 1, '2024-03-25', '2024-04-05', '2024-04-10', 5, True),
(3, 3, '2024-03-25', '2024-04-02', '2024-04-07', 5 , True),
(4, 4, '2024-03-25', '2024-04-03', '2024-04-06', 3, True),
(5, 5, '2024-03-25', '2024-04-04', '2024-04-09', 5, null),
(2, 4, '2024-03-25', '2024-04-05', '2024-04-10', 5, False),
(7, 1, '2024-03-25', '2024-04-06', '2024-04-11', 5, True),
(8, 1, '2024-03-25', '2024-04-07', '2024-04-12', 5, False),
(9, 2, '2024-03-25', '2024-04-08', '2024-04-13', 5, null),
(10, 2, '2024-03-25', '2024-04-09', '2024-04-14', 5, null),
(11, 3, '2024-03-25', '2024-04-10', '2024-04-15', 5, null),
(12, 3, '2024-03-25', '2024-04-11', '2024-04-16', 5, True),
(13, 3, '2024-03-25', '2024-04-12', '2024-04-17', 5, False),
(14, 5, '2024-03-25', '2024-04-13', '2024-04-18', 5, null),
(15, 5, '2024-03-25', '2024-04-14', '2024-04-19', 5, null),
(16, 5, '2024-03-25', '2024-04-15', '2024-04-20', 5, null),
(17, 2, '2024-03-25', '2024-04-16', '2024-04-21', 5, False);
