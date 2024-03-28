<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php'; // Include the file with database connection

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

    // Method to get all cars
    public static function getAllCars() {
        global $pdo; // Use the database connection from connect.php
        $sql = "SELECT * FROM cars";
        $stmt = $pdo->query($sql);
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
            $cars[] = $car; // Store each Car object
        }
        return $cars;
    }
    

    // Method to delete a car by ID
    public static function deleteCarById($carId) {
        global $pdo; // Use the database connection from connect.php
        $sql = "DELETE FROM cars WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$carId]);
        // Check if any rows were affected (car deleted)
        return $stmt->rowCount() > 0;
    }

    public static function getCarById($car_id) {
        global $pdo;
        $sql = "SELECT * FROM cars WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$car_id]);
        $car_data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($car_data) {
            $car = new Car(
                $car_data['id'],
                $car_data['brand'],
                $car_data['model'],
                $car_data['color'],
                $car_data['image'],
                $car_data['km'],
                $car_data['price'],
                $car_data['owner_id']
            );
            return $car;
        } else {
            return null; // Return null if no car found with the given ID
        }
    }
    public static function getCarsByOwnerId($owner_id) {
        global $pdo; // Use the database connection from connect.php
        $sql = "SELECT * FROM cars WHERE owner_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$owner_id]);
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
    }
    
    
}

?>
