<?php
// Include necessary files
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';

class Car {
    // Properties
    public $id;
    public $brand;
    public $model;
    public $color;
    public $image;
    public $km;
    public $price;
    public $owner_id;

    // Constructor
    public function __construct($id, $brand, $model, $color, $image, $km, $price, $owner_id) {
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->color = $color;
        $this->image = $image;
        $this->km = $km;
        $this->price = $price;
        $this->owner_id = $owner_id;
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
            $row['owner_id']
        );
    }

    // Method to get all cars
    public static function getAllCars() {
        global $pdo;
        try {
            $sql = "SELECT * FROM cars";
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
                    echo " | <button onclick=\"document.getElementById('popup{$this->id}').style.display='block'\">Update Listing</button>";
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
    /////////// SERVICES : RENT A CAR SECTION

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

    public static function getFilteredCars($whereClause) {
        global $pdo;
        try {
            // Construct the SQL query to fetch cars with applied filters
            $sql = "SELECT * FROM cars";
            if (!empty($whereClause)) {
                $sql .= " WHERE $whereClause";
            }
            $stmt = $pdo->query($sql);

            // Fetch cars from the database
            $cars = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $car = new Car(
                    $row['id'],
                    $row['brand'],
                    $row['model'],
                    $row['color'],
                    $row['image'],
                    $row['km'],
                    $row['price'],
                    $row['owner_id']
                );
                $cars[] = $car;
            }
            return $cars;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching filtered cars: " . $e->getMessage());
            throw $e;
        }
    }





    /////////////// END SERVICES RENT A CAR SECTION
}
?>
