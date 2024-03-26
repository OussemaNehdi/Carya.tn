<?php 
    include '../connect.php';

    $car_id = $_GET['id'];
    $sql_select = "SELECT * FROM cars WHERE id=$car_id";
    $result = mysqli_query($conn, $sql_select);
    $car = mysqli_fetch_assoc($result);
    $image_path = "../../Resources/Images/car_images/{$car['image']}";

    $sql_delete = "DELETE FROM cars WHERE id=$car_id";
    if (mysqli_query($conn, $sql_delete)) {
        
        unlink($image_path);
        
        header('Location: index.php');
    } else {
        echo "Error: " . $sql_delete . "<br>" . mysqli_error($conn);
    }
?>
