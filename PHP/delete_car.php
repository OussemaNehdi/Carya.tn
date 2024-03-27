<?php 
    // deletes a car
    session_start();
    include 'connect.php';

    $car_id = $_GET['id'];
    $sql_select = "SELECT * FROM cars WHERE id=$car_id";
    $result = mysqli_query($conn, $sql_select);
    $car = mysqli_fetch_assoc($result);

    $owner_id = $car['owner_id'];

    if ($_SESSION["role"] != "admin" && $owner_id != $_SESSION['user_id']) {
        header('Location: http://localhost/Mini-PHP-Project/index.php?message=You are not allowed to delete this car!');
    }

    $image_path = "../Resources/Images/car_images/{$car['image']}";

    $sql_delete = "DELETE FROM cars WHERE id=$car_id";
    if (mysqli_query($conn, $sql_delete)) {
        // deletes the image file from the server
        unlink($image_path);
        
        header('Location: http://localhost/Mini-PHP-Project/index.php?message=Car deleted successfully!');
    } else {
        echo "Error: " . $sql_delete . "<br>" . mysqli_error($conn);
    }
?>
