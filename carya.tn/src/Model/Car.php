<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Lib/connect.php'; // Include the file with database connection

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
            $cars[] = new Car($row['id'], $row['brand'], $row['model'], $row['color'], $row['image'], $row['km'], $row['price'], $row['owner_id']);
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

}

?>
