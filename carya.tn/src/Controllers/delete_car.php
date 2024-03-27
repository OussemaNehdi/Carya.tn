<?php
    // deletes a car
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include 'connect.php';

    $car_id = $_GET['id'];
    $sql_select = "SELECT * FROM cars WHERE id=:car_id";
    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->bindParam(':car_id', $car_id);
    $stmt_select->execute();
    $car = $stmt_select->fetch(PDO::FETCH_ASSOC);

    $owner_id = $car['owner_id'];

    if ($_SESSION["role"] != "admin" && $owner_id != $_SESSION['user_id']) {
        header('Location: http://localhost/Mini-PHP-Project/index.php?message=You are not allowed to delete this car!');
        exit(); // Ensure script execution stops after redirect
    }

    $image_path = "../Resources/Images/car_images/{$car['image']}";

    $sql_delete = "DELETE FROM cars WHERE id=:car_id";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->bindParam(':car_id', $car_id);
    
    try {
        $stmt_delete->execute();
        
        // deletes the image file from the server
        unlink($image_path);
        
        header('Location: http://localhost/Mini-PHP-Project/index.php?message=Car deleted successfully!');
        exit(); // Ensure script execution stops after redirect
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
