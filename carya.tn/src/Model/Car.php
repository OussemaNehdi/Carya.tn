<?php
// This PHP file defines a class 'Car' and related methods to manage car data in a database.

// Include necessary files
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';

class Car {
    // Properties
    public $id;          // The ID of the car.
    public $brand;       // The brand of the car.
    public $model;       // The model of the car.
    public $color;       // The color of the car.
    public $image;       // The image URL of the car.
    public $km;          // The kilometers traveled by the car.
    public $price;       // The price of the car.
    public $owner_id;    // The ID of the owner of the car.
    public $available;   // Indicates whether the car is available for rent.

    // Constructor
    public function __construct($id, $brand, $model, $color, $image, $km, $price, $owner_id, $available) {
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->color = $color;
        $this->image = $image;
        $this->km = $km;
        $this->price = $price;
        $this->owner_id = $owner_id;
        $this->available = $available;
    }

    // Get a car object from the sql result
    public static function getCarFromRow($row) {
        return new Car(
            $row['id'],
            $row['brand'],
            $row['model'],
            $row['color'],
            $row['image'],
            $row['km'],
            $row['price'],
            $row['owner_id'],
            $row['available']
        );
    }

    // Method to get all cars
    public static function getAllCars($available = null, $owner = null) {
        global $pdo;
        try {
            if ($available === 1) {
                $sql = "SELECT * FROM cars WHERE available = 1";
            } else {
                $sql = "SELECT * FROM cars WHERE 1";
            }

            if ($owner !== null) {
                $sql .= " AND owner_id != $owner";
            }

            $stmt = $pdo->query($sql);
            $cars = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $car = Car::getCarFromRow($row);
                $cars[] = $car;
            }
            return $cars;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching cars: " . $e->getMessage());
            throw $e;
        }
    }
    
    // Method to delete a car by ID
    public function deleteCarById() {
        $carId = $this->id;
        global $pdo;
        try {
            $sql = "DELETE FROM cars WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$carId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error deleting car: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to get a car by ID
    public static function getCarById($car_id) {
        global $pdo;
        try {
            $sql = "SELECT * FROM cars WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$car_id]);
            $car_data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($car_data) {
                $car = Car::getCarFromRow($car_data);
                return $car;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching car details: " . $e->getMessage());
            throw $e;
        }
    }
    
    // Method to update car details
    public function updateCar($brand, $model, $color, $image, $km, $price) {
        global $pdo;
        try {
            $sql = "UPDATE cars SET brand = ?, model = ?, color = ?, image = ?, km = ?, price = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$brand, $model, $color, $image, $km, $price, $this->id]);
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error updating car details: " . $e->getMessage());
            throw $e;
        }
    }
    
    // Method to add a new car
    public static function addCar($brand, $model, $color, $image, $km, $price, $owner_id) {
        global $pdo;
        try {
            $sql = "INSERT INTO cars (brand, model, color, image, km, price, owner_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$brand, $model, $color, $image, $km, $price, $owner_id]);
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error adding new car: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to check if car is marked unavailable by owner
    public function isCarMarkedUnavailable() {
        global $pdo;
        try {
            $sql = "SELECT * FROM cars WHERE id = ? AND available = 0";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$this->id]);
            $car = $stmt->fetch(PDO::FETCH_ASSOC);
            return $car ? true : false;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error checking if car is marked unavailable: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to check if car is in use
    public function isCarInUse() {
        global $pdo;
        try {
            $current_date = date('Y-m-d');
            $sql = "SELECT * FROM command WHERE car_id = ? AND start_date <= ? AND end_date >= ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$this->id, $current_date, $current_date]);
            $car_commanded = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return count($car_commanded) > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error checking if car is in use: " . $e->getMessage());
            throw $e;
        }
    }
    
    // Method to check if the car is available for renting
    public function isCarAvailable() {
        try {
            return !$this->isCarMarkedUnavailable() && !$this->isCarInUse();
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error checking car availability: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to display car availability actions
    public function displayCarAvailabilityActions() {
        try {
            if ($this->isCarAvailable()) {
                echo "<a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/delete_car.php?id={$this->id}'>Delete</a>";
                if ($this->owner_id == $_SESSION['user_id']) {
                    echo " | <button id='UpdateCarBtn$this->id'>Update Listing</button>";
                }
            } else {
                echo "Car unavailable";
            }
        } catch (Exception $e) {
            // Log error and rethrow the exception
            error_log("Error displaying car availability actions: " . $e->getMessage());
            throw $e;
        }
    }

    // Mark the car as unavailable
    public function markCarUnavailable() {
        global $pdo;
        try {
            $sql = "UPDATE cars SET available = 0 WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$this->id]);
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error marking car as unavailable: " . $e->getMessage());
            throw $e;
        }
    }

    // Mark the car as available
    public function markCarAvailable() {
        global $pdo;
        try {
            $sql = "UPDATE cars SET available = 1 WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$this->id]);
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error marking car as available: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to get the unavailable start and end dates of the car
    public function getUnavailableDates() {
        global $pdo;
        try {
            $sql = "SELECT start_date, end_date FROM command WHERE car_id = ? AND confirmed = True";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$this->id]);
            $commands = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $unavailableDates = [];
            foreach ($commands as $command) {
                $start_date = $command['start_date'];
                $end_date = $command['end_date'];
                $current_date = $start_date;
                $unavailableDates[] = $current_date . " --> " . $end_date;
            }
            return $unavailableDates;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching unavailable dates: " . $e->getMessage());
            throw $e;
        }
    }

    // These methosd are for the filter menu 
    // Static method to get the maximum value of a column from the cars table
    public static function getMaxValue($column) {
        global $pdo;
        try {
            $sql = "SELECT MAX($column) AS max_value FROM cars";
            $stmt = $pdo->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['max_value'];
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching maximum value: " . $e->getMessage());
            throw $e;
        }
    }

    // Static method to get distinct values from the cars table
    public static function getDistinctValues($column) {
        global $pdo;
        try {
            $sql = "SELECT DISTINCT $column FROM cars";
            $stmt = $pdo->query($sql);
            $values = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $values[] = $row[$column];
            }
            return $values;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching distinct values: " . $e->getMessage());
            throw $e;
        }
    }

    public static function constructFilterQuery($filters) {
        // Check if $filters is an array
        if (!is_array($filters)) {
            throw new InvalidArgumentException("Invalid filters provided. Expected an array.");
        }
    
        $params = [];
    
        foreach ($filters as $key => $value) {
            if (!is_array($value)) {
                // If the value is not an array, split it into an array using comma as delimiter
                $params[$key] = explode(',', $value);
            } else {
                // If the value is already an array, keep it as is
                $params[$key] = $value;
            }
        }
    
        return $params;
    }
    
    public static function getFilteredCars($filters, $id = null, $available = null) {
        global $pdo;
        try {
            // Construct the SQL query to fetch cars with applied filters
            if ($id === null) {
                $sql = "SELECT * FROM cars WHERE 1";
            } else {
                $sql = "SELECT * FROM cars WHERE owner_id = $id";
            }

            if ($available === 1) {
                $sql .= " AND available = 1";
            }
    
            $conditions = [];
            $params = [];
    
            // Construct conditions for each filter parameter
            if (isset($filters['brand'])) {
                $conditions[] = "brand IN (" . rtrim(str_repeat("?,", count($filters['brand'])), ',') . ")";
                $params = array_merge($params, $filters['brand']);
            }
            if (isset($filters['model'])) {
                $conditions[] = "model IN (" . rtrim(str_repeat("?,", count($filters['model'])), ',') . ")";
                $params = array_merge($params, $filters['model']);
            }
            if (isset($filters['color'])) {
                $conditions[] = "color IN (" . rtrim(str_repeat("?,", count($filters['color'])), ',') . ")";
                $params = array_merge($params, $filters['color']);
            }
            if (isset($filters['km_min']) && isset($filters['km_max'])) {
                $conditions[] = "km BETWEEN ? AND ?";
                $params[] = $filters['km_min'][0];
                $params[] = $filters['km_max'][0];
            }
            if (isset($filters['price_min']) && isset($filters['price_max'])) {
                $conditions[] = "price BETWEEN ? AND ?";
                $params[] = $filters['price_min'][0];
                $params[] = $filters['price_max'][0];
            }
    
            // Append conditions to the query if any
            if (!empty($conditions)) {
                $sql .= " AND " . implode(" AND ", $conditions);
            }
    
            // Prepare and execute the statement
            $stmt = $pdo->prepare($sql);
    
            
            $stmt->execute($params);
    
            // Fetch cars from the database
            $cars = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $car = Car::getCarFromRow($row);
                $cars[] = $car;
            }
    
            return $cars;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching filtered cars: " . $e->getMessage());
            throw $e;
        }
    }
    
    // Method to check if the car is rented on the dates specified
    public static function isCarRented($car_id, $start_date, $end_date) {
        global $pdo;
        try {
            $sql = "SELECT * FROM command WHERE car_id = ? AND ((start_date <= ? AND end_date >= ?) OR (start_date <= ? AND end_date >= ?)) AND confirmed = True";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$car_id, $start_date, $start_date, $end_date, $end_date]);
            $car_commanded = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return count($car_commanded) > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error checking if car is rented: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
